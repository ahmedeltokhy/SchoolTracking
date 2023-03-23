<?php

namespace App\Http\Requests;

use App\Models\ClassSection;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreClassSectionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('class_section_create');
    }

    public function rules()
    {
        return [
            'subject' => [
                'string',
                'required',
            ],
            'teacher_id' => [
                'required',
                'integer',
            ],
            'students.*' => [
                'integer',
            ],
            'students' => [
                'required',
                'array',
            ],
        ];
    }
}
