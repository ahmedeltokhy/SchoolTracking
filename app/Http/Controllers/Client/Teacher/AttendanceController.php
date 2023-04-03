<?php

namespace App\Http\Controllers\Client\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use auth;
use App\Models\{ClassSection,Attendance,Message};
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
        $all_students=$classsection->students;//->pluck("id")->toArray();
        $arr=[];
        $attendance_arr=isset($request->students)? $request->students :[];
        foreach($all_students as $std){
            $arr[$std->id]["status"]=(int)in_array($std->id,array_keys($attendance_arr));
            if((int)in_array($std->id,array_keys($attendance_arr))==0){
                $content="your student ".$std->name." is Missed attendance in class section ".$classsection->subject." at ".$request->date;
                $content_ar="لقد تغيب الطالب  ".$std->name." عن حضور الصف الخاص ب ".$classsection->subject." فى يوم" .$request->date ;
                Message::create(["teacher_id"=>auth('client')->id(),"student_id"=>$std->id,"classsection_id"=>$request->classsection_id,"content"=>$content_ar]);
                $mail_arr["std_name"]=$std->name;
                $mail_arr["subject"]=$classsection->subject;
                $mail_arr["date"]=$request->date;
                \Mail::to($std->parent->email)->send(new \App\Mail\AttendanceMail($mail_arr));

            }
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

    public function destroy( $attendance_id)
    {
        $attendance=auth("client")->user()->attendances()->where("attendances.id",$attendance_id)->firstOrFail();
        $attendance->students()->detach();
        $attendance->delete();
        return back();
    }

    public function massDestroy(Request $request)
    {
        $attendances=auth("client")->user()->attendances()->whereIn("attendances.id",request('ids'))->get();
        foreach ($attendances as $attendance) {
        $attendance->students()->detach();
            $attendance->delete();
        }
        return response(null, Response::HTTP_NO_CONTENT);
    }
   
}
