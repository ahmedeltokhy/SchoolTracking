<?php

namespace App\Http\Requests;

use App\Models\HomeworkSolution;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyHomeworkSolutionRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('homework_solution_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:homework_solutions,id',
        ];
    }
}
