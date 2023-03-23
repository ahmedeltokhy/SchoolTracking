<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyHomeworkSolutionRequest;
use App\Http\Requests\StoreHomeworkSolutionRequest;
use App\Http\Requests\UpdateHomeworkSolutionRequest;
use App\Models\Client;
use App\Models\Homework;
use App\Models\HomeworkSolution;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class HomeworkSolutionController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('homework_solution_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $homeworkSolutions = HomeworkSolution::with(['student', 'homework', 'media'])->get();

        return view('admin.homeworkSolutions.index', compact('homeworkSolutions'));
    }

    public function create()
    {
        abort_if(Gate::denies('homework_solution_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $students = Client::where("type","student")->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $homework = Homework::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.homeworkSolutions.create', compact('homework', 'students'));
    }

    public function store(StoreHomeworkSolutionRequest $request)
    {
        $homeworkSolution = HomeworkSolution::create($request->all());

        foreach ($request->input('attachments', []) as $file) {
            $homeworkSolution->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('attachments');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $homeworkSolution->id]);
        }

        return redirect()->route('admin.homework-solutions.index');
    }

    public function edit(HomeworkSolution $homeworkSolution)
    {
        abort_if(Gate::denies('homework_solution_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $students = Client::where("type","student")->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $homework = Homework::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $homeworkSolution->load('student', 'homework');

        return view('admin.homeworkSolutions.edit', compact('homework', 'homeworkSolution', 'students'));
    }

    public function update(UpdateHomeworkSolutionRequest $request, HomeworkSolution $homeworkSolution)
    {
        $homeworkSolution->update($request->all());

        if (count($homeworkSolution->attachments) > 0) {
            foreach ($homeworkSolution->attachments as $media) {
                if (! in_array($media->file_name, $request->input('attachments', []))) {
                    $media->delete();
                }
            }
        }
        $media = $homeworkSolution->attachments->pluck('file_name')->toArray();
        foreach ($request->input('attachments', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $homeworkSolution->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('attachments');
            }
        }

        return redirect()->route('admin.homework-solutions.index');
    }

    public function show(HomeworkSolution $homeworkSolution)
    {
        abort_if(Gate::denies('homework_solution_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $homeworkSolution->load('student', 'homework');

        return view('admin.homeworkSolutions.show', compact('homeworkSolution'));
    }

    public function destroy(HomeworkSolution $homeworkSolution)
    {
        abort_if(Gate::denies('homework_solution_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $homeworkSolution->delete();

        return back();
    }

    public function massDestroy(MassDestroyHomeworkSolutionRequest $request)
    {
        $homeworkSolutions = HomeworkSolution::find(request('ids'));

        foreach ($homeworkSolutions as $homeworkSolution) {
            $homeworkSolution->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('homework_solution_create') && Gate::denies('homework_solution_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new HomeworkSolution();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
