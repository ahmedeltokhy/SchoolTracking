<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyMessageRequest;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\UpdateMessageRequest;
use App\Models\ClassSection;
use App\Models\Client;
use App\Models\Message;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MessageController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('message_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $messages = Message::with(['teacher', 'student', 'classsection'])->get();

        return view('admin.messages.index', compact('messages'));
    }

    public function create()
    {
        abort_if(Gate::denies('message_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $teachers = Client::where("type","teacher")->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $students = Client::where("type","student")->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $classsections = ClassSection::pluck('subject', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.messages.create', compact('classsections', 'students', 'teachers'));
    }

    public function store(StoreMessageRequest $request)
    {
        $message = Message::create($request->all());

        return redirect()->route('admin.messages.index');
    }

    public function edit(Message $message)
    {
        abort_if(Gate::denies('message_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $teachers = Client::where("type","teacher")->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $students = Client::where("type","student")->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $classsections = ClassSection::pluck('subject', 'id')->prepend(trans('global.pleaseSelect'), '');

        $message->load('teacher', 'student', 'classsection');

        return view('admin.messages.edit', compact('classsections', 'message', 'students', 'teachers'));
    }

    public function update(UpdateMessageRequest $request, Message $message)
    {
        $message->update($request->all());

        return redirect()->route('admin.messages.index');
    }

    public function show(Message $message)
    {
        abort_if(Gate::denies('message_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $message->load('teacher', 'student', 'classsection');

        return view('admin.messages.show', compact('message'));
    }

    public function destroy(Message $message)
    {
        abort_if(Gate::denies('message_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $message->delete();

        return back();
    }

    public function massDestroy(MassDestroyMessageRequest $request)
    {
        $messages = Message::find(request('ids'));

        foreach ($messages as $message) {
            $message->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
