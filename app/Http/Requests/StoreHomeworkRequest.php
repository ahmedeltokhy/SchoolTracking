<?php

namespace App\Http\Requests;

use App\Models\Homework;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreHomeworkRequest extends FormRequest
{
    public function authorize()
    {
        return auth('client')->check()? true : Gate::allows('homework_create');
    }

    public function rules()
    {
        return [
            'teacher_id' => [
                'required',
                'integer',
            ],
            'title' => [
                'string',
                'required',
            ],
            'content' => [
                'string',
                'nullable',
            ],
            'class_section_id' => [
                'required',
                'integer',
            ],
            'attachment' => [
                'array',
            ],
        ];
    }
}
