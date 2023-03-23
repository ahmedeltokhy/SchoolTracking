<?php

namespace App\Http\Requests;

use App\Models\BusStation;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateBusStationRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('bus_station_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'bus_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
