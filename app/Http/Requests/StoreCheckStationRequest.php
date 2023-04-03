<?php

namespace App\Http\Requests;

use App\Models\CheckStation;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCheckStationRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('check_station_create');
    }

    public function rules()
    {
        return [
            'bus_id' => [
                'required',
                'integer',
            ],
            'driver_id' => [
                'required',
                'integer',
            ],
            'bus_station_id' => [
                'required',
                'integer',
            ],
            'date' => [
                'required',
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
            ],
        ];
    }
}
