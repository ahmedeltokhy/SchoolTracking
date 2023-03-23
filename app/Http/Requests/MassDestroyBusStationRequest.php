<?php

namespace App\Http\Requests;

use App\Models\BusStation;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyBusStationRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('bus_station_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:bus_stations,id',
        ];
    }
}
