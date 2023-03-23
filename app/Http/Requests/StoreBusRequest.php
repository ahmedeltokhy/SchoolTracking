<?php

namespace App\Http\Requests;

use App\Models\Bus;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreBusRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('bus_create');
    }

    public function rules()
    {
        return [
            'description' => [
                'string',
                'nullable',
            ],
            'number' => [
                'string',
                'required',
            ],
            'driver_id' => [
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
