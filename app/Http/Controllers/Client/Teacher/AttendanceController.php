<?php

namespace App\Http\Controllers\Client\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use auth;
use App\Models\{ClassSection,Attendance};
use App\Http\Requests\MassDestroyAttendanceRequest;
use App\Http\Requests\StoreAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;
use Symfony\Component\HttpFoundation\Response;
class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = auth('client')->user()->attendances;
        return view('teacher.attendance.index', compact('attendances'));
    }

    public function create(Request $request)
    {
        $classsection="";
        if(isset($request->classsection)){
            $classsection=ClassSection::where(["id"=>$request->classsection,"teacher_id"=>auth("client")->id()])->first();
        }
        // dd($classsection);
        $classsections = auth('client')->user()->classsections->pluck("subject","id")->prepend(trans('global.pleaseSelect'), '');
        return view('teacher.attendance.form', compact('classsections','classsection'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'classsection_id' => 'required|exists:class_sections,id',
            'date' => 'required',
            // 'students.*' => 'integer',
            'students' => 'array',
        ]);
        $data=$request->all();
        $data["teacher_id"]=auth('client')->id();
        $attendance = Attendance::create($data);
        $this->sync_student_attendance($request,$attendance);
        return redirect()->route('teacher.attendances.index');
    }
    public function sync_student_attendance($request,$attendance){
        $classsection = ClassSection::find($request->classsection_id);
        $all_students=$classsection->students->pluck("id")->toArray();
        $arr=[];
        $attendance_arr=isset($request->students)? $request->students :[];
        foreach($all_students as $std){
            $arr[$std]["status"]=(int)in_array($std,array_keys($attendance_arr));
        }
        $attendance->students()->sync($arr);
    }
    
    public function get_student_in_class_section($classsection_id){
        $classsection = ClassSection::find($classsection_id);
        // dd($classsection);
        if(!empty($classsection)){
            $view = view('admin.classSections.students_form', compact('classsection'))->render();
            return response()->json(['error'=>false,'html' => $view]);
        }
        return response()->json(['error'=>true,'html' => ""]);
    }
    public function edit(Attendance $attendance)
    {
        $classsections = auth('client')->user()->classsections->pluck("subject","id")->prepend(trans('global.pleaseSelect'), '');
        // $teachers = Client::where("type","teacher")->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $student_attendance=$attendance->students()->wherePivot("status",1)->pluck("clients.id")->toArray();
        $attendance->load('classsection', 'teacher');

        return view('teacher.attendance.form', compact('attendance','student_attendance', 'classsections'));
    }

    public function update(Request $request,  $attendance_id)
    {
        $request->validate([
            'classsection_id' => 'required|exists:class_sections,id',
            'date' => 'required',
            // 'students.*' => 'integer',
            'students' => 'array',
        ]);
        $data=$request->all();
        $data["teacher_id"]=auth('client')->id();
        $attendance=auth("client")->user()->attendances()->where("attendances.id",$attendance_id)->firstOrFail();
        $attendance->update($data);
        $this->sync_student_attendance($request,$attendance);

        return redirect()->route('teacher.attendances.index');
    }

    public function show(Attendance $attendance)
    {

        $attendance->load('classsection', 'teacher');

        return view('teacher.attendance.show', compact('attendance'));
    }

    public function destroy(Attendance $attendance)
    {

        $attendance->delete();

        return back();
    }

    public function massDestroy(MassDestroyAttendanceRequest $request)
    {
        $attendances = Attendance::find(request('ids'));

        foreach ($attendances as $attendance) {
            $attendance->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
   
}
