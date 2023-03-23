<?php

namespace App\Http\Requests;

use App\Models\StudentAttendance;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateStudentAttendanceRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('student_attendance_edit');
    }

    public function rules()
    {
        return [
            'student_id' => [
                'required',
                'integer',
            ],
            'attendance_id' => [
                'required',
                'integer',
            ],
            'status' => [
                'required',
            ],
        ];
    }
}
