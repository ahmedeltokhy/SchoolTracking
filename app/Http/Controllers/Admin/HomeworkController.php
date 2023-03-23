<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyHomeworkRequest;
use App\Http\Requests\StoreHomeworkRequest;
use App\Http\Requests\UpdateHomeworkRequest;
use App\Models\ClassSection;
use App\Models\Client;
use App\Models\Homework;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class HomeworkController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('homework_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $homeworks = Homework::with(['teacher', 'class_section', 'media'])->get();

        return view('admin.homeworks.index', compact('homeworks'));
    }

    public function create()
    {
        abort_if(Gate::denies('homework_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $teachers = Client::where("type","teacher")->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $class_sections = ClassSection::pluck('subject', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.homeworks.create', compact('class_sections', 'teachers'));
    }

    public function store(StoreHomeworkRequest $request)
    {
        $homework = Homework::create($request->all());

        foreach ($request->input('attachment', []) as $file) {
            $homework->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('attachment');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $homework->id]);
        }

        return redirect()->route('admin.homeworks.index');
    }

    public function edit(Homework $homework)
    {
        abort_if(Gate::denies('homework_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $teachers = Client::where("type","teacher")->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $class_sections = ClassSection::pluck('subject', 'id')->prepend(trans('global.pleaseSelect'), '');

        $homework->load('teacher', 'class_section');

        return view('admin.homeworks.edit', compact('class_sections', 'homework', 'teachers'));
    }

    public function update(UpdateHomeworkRequest $request, Homework $homework)
    {
        $homework->update($request->all());

        if (count($homework->attachment) > 0) {
            foreach ($homework->attachment as $media) {
                if (! in_array($media->file_name, $request->input('attachment', []))) {
                    $media->delete();
                }
            }
        }
        $media = $homework->attachment->pluck('file_name')->toArray();
        foreach ($request->input('attachment', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $homework->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('attachment');
            }
        }

        return redirect()->route('admin.homeworks.index');
    }

    public function show(Homework $homework)
    {
        abort_if(Gate::denies('homework_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $homework->load('teacher', 'class_section');

        return view('admin.homeworks.show', compact('homework'));
    }

    public function destroy(Homework $homework)
    {
        abort_if(Gate::denies('homework_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $homework->delete();

        return back();
    }

    public function massDestroy(MassDestroyHomeworkRequest $request)
    {
        $homeworks = Homework::find(request('ids'));

        foreach ($homeworks as $homework) {
            $homework->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('homework_create') && Gate::denies('homework_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Homework();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
