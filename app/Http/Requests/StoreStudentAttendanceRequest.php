<?php

namespace App\Http\Requests;

use App\Models\StudentAttendance;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreStudentAttendanceRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('student_attendance_create');
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
