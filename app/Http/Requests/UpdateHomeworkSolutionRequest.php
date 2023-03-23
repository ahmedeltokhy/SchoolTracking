<?php

namespace App\Http\Requests;

use App\Models\HomeworkSolution;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateHomeworkSolutionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('homework_solution_edit');
    }

    public function rules()
    {
        return [
            'student_id' => [
                'required',
                'integer',
            ],
            'homework_id' => [
                'required',
                'integer',
            ],
            'attachments' => [
                'array',
            ],
        ];
    }
}
