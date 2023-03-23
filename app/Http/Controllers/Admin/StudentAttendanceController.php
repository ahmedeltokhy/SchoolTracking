<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyStudentAttendanceRequest;
use App\Http\Requests\StoreStudentAttendanceRequest;
use App\Http\Requests\UpdateStudentAttendanceRequest;
use App\Models\Attendance;
use App\Models\Client;
use App\Models\StudentAttendance;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentAttendanceController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('student_attendance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $studentAttendances = StudentAttendance::with(['student', 'attendance'])->get();

        return view('admin.studentAttendances.index', compact('studentAttendances'));
    }

    public function create()
    {
        abort_if(Gate::denies('student_attendance_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $students = Client::where("type","student")->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $attendances = Attendance::pluck('date', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.studentAttendances.create', compact('attendances', 'students'));
    }

    public function store(StoreStudentAttendanceRequest $request)
    {
        $studentAttendance = StudentAttendance::create($request->all());

        return redirect()->route('admin.student-attendances.index');
    }

    public function edit(StudentAttendance $studentAttendance)
    {
        abort_if(Gate::denies('student_attendance_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $students = Client::where("type","student")->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $attendances = Attendance::pluck('date', 'id')->prepend(trans('global.pleaseSelect'), '');

        $studentAttendance->load('student', 'attendance');

        return view('admin.studentAttendances.edit', compact('attendances', 'studentAttendance', 'students'));
    }

    public function update(UpdateStudentAttendanceRequest $request, StudentAttendance $studentAttendance)
    {
        $studentAttendance->update($request->all());

        return redirect()->route('admin.student-attendances.index');
    }

    public function show(StudentAttendance $studentAttendance)
    {
        abort_if(Gate::denies('student_attendance_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $studentAttendance->load('student', 'attendance');

        return view('admin.studentAttendances.show', compact('studentAttendance'));
    }

    public function destroy(StudentAttendance $studentAttendance)
    {
        abort_if(Gate::denies('student_attendance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $studentAttendance->delete();

        return back();
    }

    public function massDestroy(MassDestroyStudentAttendanceRequest $request)
    {
        $studentAttendances = StudentAttendance::find(request('ids'));

        foreach ($studentAttendances as $studentAttendance) {
            $studentAttendance->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
