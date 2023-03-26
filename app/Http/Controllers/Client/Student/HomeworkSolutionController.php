<?php

namespace App\Http\Controllers\Client\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyHomeworkSolutionRequest;
use App\Http\Requests\StoreHomeworkSolutionRequest;
use App\Http\Requests\UpdateHomeworkSolutionRequest;
use App\Models\Client;
use App\Models\Homework;
use App\Models\HomeworkSolution;
use Gate;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
class HomeworkSolutionController extends Controller
{
    use MediaUploadingTrait;

    public function index(){
        $homeworkSolutions=HomeworkSolution::where(["student_id"=>auth('client')->id()])
        ->get();
        return view('student.homework_solutions.index', compact('homeworkSolutions'));
    }
    public function create($homework_id)
    {
        $homework=Homework::where(["id"=>$homework_id])->whereHas("class_section",function($qu){
            $qu->whereHas("students",function($q){
                $q->where("client_id",auth('client')->id());
            });
        })
        ->firstOrFail();
        return view('student.homework_solutions.form', compact('homework'));
    }
    public function show($id)
    {
        $homeworkSolution=HomeworkSolution::where(["id"=>$id,"student_id"=>auth('client')->id()])
        ->firstOrFail();
        return view('student.homework_solutions.show', compact('homeworkSolution'));
    }

    public function form(Request $request,$homework_id)
    {
        $request->validate([
            'notes' => 'required_without:attachments',
            'attachments' => 'required_without:notes',
        ]);
        $homework=Homework::where(["id"=>$homework_id])->whereHas("class_section",function($qu){
            $qu->whereHas("students",function($q){
                $q->where("client_id",auth('client')->id());
            });
        })
        ->firstOrFail();
        $data=$request->all();
        $data["student_id"]=auth('client')->id();
        $data["homework_id"]=$homework->id;
        $homeworkSolution = HomeworkSolution::create($data);
        foreach ($request->input('attachments', []) as $file) {
            $homeworkSolution->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('attachments');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $homeworkSolution->id]);
        }

        return redirect()->route('student.homeworks.show',$homework->id);
    }

    


    // public function destroy(HomeworkSolution $homeworkSolution)
    // {
    //     abort_if(Gate::denies('homework_solution_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    //     $homeworkSolution->delete();

    //     return back();
    // }

    // public function massDestroy(MassDestroyHomeworkSolutionRequest $request)
    // {
    //     $homeworkSolutions = HomeworkSolution::find(request('ids'));

    //     foreach ($homeworkSolutions as $homeworkSolution) {
    //         $homeworkSolution->delete();
    //     }

    //     return response(null, Response::HTTP_NO_CONTENT);
    // }

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
