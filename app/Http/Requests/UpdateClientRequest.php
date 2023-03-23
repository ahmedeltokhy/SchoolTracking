<?php

namespace App\Http\Requests;

use App\Models\Client;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateClientRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('client_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'email' => [
                'required',
                'unique:clients,email,' . request()->route('client')->id,
            ],
            'mobile' => [
                'string',
                'required',
                'unique:clients,mobile,' . request()->route('client')->id,
            ],
            'type' => [
                'required',
            ],
            'nationalid' => [
                'string',
                'nullable',
            ],
        ];
    }
}
