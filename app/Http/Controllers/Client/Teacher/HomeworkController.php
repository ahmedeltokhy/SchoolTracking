<?php

namespace App\Http\Controllers\Client\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use auth;
use App\Models\{ClassSection,Attendance,Homework,HomeworkSolution};
use App\Http\Controllers\Traits\MediaUploadingTrait;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Http\Requests\MassDestroyHomeworkRequest;
use App\Http\Requests\StoreHomeworkRequest;
use App\Http\Requests\UpdateHomeworkRequest;
class HomeworkController extends Controller
{
    use MediaUploadingTrait;
    public function index()
    {
        $homeworks = auth('client')->user()->homeworks;
        return view('teacher.homeworks.index', compact('homeworks'));
    }

    public function create()
    {
        // $teachers = Client::where("type","teacher")->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $class_sections = auth('client')->user()->classsections->pluck("subject","id")->prepend(trans('global.pleaseSelect'), '');
        return view('teacher.homeworks.create', compact('class_sections'));
    }

    public function store(StoreHomeworkRequest $request)
    {
        $data=$request->all();
        $data["teacher_id"]=auth('client')->id();
        $homework = Homework::create($data);
        foreach ($request->input('attachment', []) as $file) {
            $homework->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('attachment');
        }
        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $homework->id]);
        }
        return redirect()->route('teacher.homeworks.index');
    }

    public function edit(Homework $homework)
    {
        $class_sections = auth('client')->user()->classsections->pluck("subject","id")->prepend(trans('global.pleaseSelect'), '');
        $homework->load('teacher', 'class_section');
        return view('teacher.homeworks.edit', compact('class_sections', 'homework'));
    }

    public function update(UpdateHomeworkRequest $request, Homework $homework)
    {
        $data=$request->all();
        $data["teacher_id"]=auth('client')->id();
        $homework->update($data);

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

        return redirect()->route('teacher.homeworks.index');
    }

    public function show(Homework $homework)
    {
        $homework->load('teacher', 'class_section');
        // dd("ss");
        $solutions=$homework->solutions()->orderBy("student_id")->orderByDesc("created_at")->get();
        return view('teacher.homeworks.show', compact('homework','solutions'));
    }

    public function destroy(Homework $homework)
    {
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
        $model         = new Homework();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');
        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
    public function show_solution($solution_id){
        $homeworkSolution=HomeworkSolution::findOrFail($solution_id);
        if(isset($homeworkSolution->homework->teacher->id)&& $homeworkSolution->homework->teacher->id==auth('client')->id()){
            return view('student.homework_solutions.show', compact('homeworkSolution'));
        }
        abort(403, 'Access denied');
    }
}
