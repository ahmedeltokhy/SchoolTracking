<?php

namespace App\Http\Requests;

use App\Models\Homework;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyHomeworkRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('homework_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:homeworks,id',
        ];
    }
}
