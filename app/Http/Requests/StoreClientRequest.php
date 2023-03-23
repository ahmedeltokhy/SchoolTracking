<?php

namespace App\Http\Requests;

use App\Models\Client;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreClientRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('client_create');
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
                'unique:clients',
            ],
            'mobile' => [
                'string',
                'required',
                'unique:clients',
            ],
            'password' => [
                'required',
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
