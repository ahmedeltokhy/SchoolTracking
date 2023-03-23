<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyAttendanceRequest;
use App\Http\Requests\StoreAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;
use App\Models\Attendance;
use App\Models\ClassSection;
use App\Models\Client;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AttendanceController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('attendance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attendances = Attendance::with(['classsection', 'teacher'])->get();

        return view('admin.attendances.index', compact('attendances'));
    }

    public function create()
    {
        abort_if(Gate::denies('attendance_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $classsections = ClassSection::pluck('subject', 'id')->prepend(trans('global.pleaseSelect'), '');

        $teachers = Client::where("type","teacher")->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.attendances.create', compact('classsections', 'teachers'));
    }

    public function store(StoreAttendanceRequest $request)
    {
        // dd($request->all());
        $attendance = Attendance::create($request->all());
        // $attendance->students()->sync($request->input('students', []));

        $this->sync_student_attendance($request,$attendance);
        return redirect()->route('admin.attendances.index');
    }
    public function sync_student_attendance($request,$attendance){
        $classsection = ClassSection::find($request->classsection_id);
        $all_students=$classsection->students->pluck("id")->toArray();
        $arr=[];
        $attendance_arr=isset($request->students)? $request->students :[];
        foreach($all_students as $std){
            $arr[$std]["status"]=in_array($std,array_keys($attendance_arr));
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
        abort_if(Gate::denies('attendance_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $classsections = ClassSection::pluck('subject', 'id')->prepend(trans('global.pleaseSelect'), '');

        $teachers = Client::where("type","teacher")->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $student_attendance=$attendance->students()->wherePivot("status",1)->pluck("clients.id")->toArray();
        $attendance->load('classsection', 'teacher');

        return view('admin.attendances.edit', compact('attendance','student_attendance', 'classsections', 'teachers'));
    }

    public function update(UpdateAttendanceRequest $request, Attendance $attendance)
    {
        $attendance->update($request->all());
        $this->sync_student_attendance($request,$attendance);

        return redirect()->route('admin.attendances.index');
    }

    public function show(Attendance $attendance)
    {
        abort_if(Gate::denies('attendance_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attendance->load('classsection', 'teacher');

        return view('admin.attendances.show', compact('attendance'));
    }

    public function destroy(Attendance $attendance)
    {
        abort_if(Gate::denies('attendance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
