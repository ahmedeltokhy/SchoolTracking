<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCheckStationRequest;
use App\Http\Requests\StoreCheckStationRequest;
use App\Http\Requests\UpdateCheckStationRequest;
use App\Models\Bus;
use App\Models\BusStation;
use App\Models\CheckStation;
use App\Models\Client;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckStationController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('check_station_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $checkStations = CheckStation::with(['bus', 'driver', 'bus_station'])->get();

        return view('admin.checkStations.index', compact('checkStations'));
    }

    public function create()
    {
        abort_if(Gate::denies('check_station_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $buses = Bus::pluck('number', 'id')->prepend(trans('global.pleaseSelect'), '');

        $drivers = Client::where("type","driver")->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $bus_stations = BusStation::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.checkStations.create', compact('bus_stations', 'buses', 'drivers'));
    }

    public function store(StoreCheckStationRequest $request)
    {
        $checkStation = CheckStation::create($request->all());

        return redirect()->route('admin.check-stations.index');
    }

    public function edit(CheckStation $checkStation)
    {
        abort_if(Gate::denies('check_station_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $buses = Bus::pluck('number', 'id')->prepend(trans('global.pleaseSelect'), '');

        $drivers = Client::where("type","driver")->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $bus_stations = BusStation::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $checkStation->load('bus', 'driver', 'bus_station');

        return view('admin.checkStations.edit', compact('bus_stations', 'buses', 'checkStation', 'drivers'));
    }

    public function update(UpdateCheckStationRequest $request, CheckStation $checkStation)
    {
        $checkStation->update($request->all());

        return redirect()->route('admin.check-stations.index');
    }

    public function show(CheckStation $checkStation)
    {
        abort_if(Gate::denies('check_station_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $checkStation->load('bus', 'driver', 'bus_station');

        return view('admin.checkStations.show', compact('checkStation'));
    }

    public function destroy(CheckStation $checkStation)
    {
        abort_if(Gate::denies('check_station_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $checkStation->delete();

        return back();
    }

    public function massDestroy(MassDestroyCheckStationRequest $request)
    {
        $checkStations = CheckStation::find(request('ids'));

        foreach ($checkStations as $checkStation) {
            $checkStation->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
