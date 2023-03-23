<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyBusStationRequest;
use App\Http\Requests\StoreBusStationRequest;
use App\Http\Requests\UpdateBusStationRequest;
use App\Models\Bus;
use App\Models\BusStation;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BusStationController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('bus_station_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $busStations = BusStation::with(['bus'])->get();

        return view('admin.busStations.index', compact('busStations'));
    }

    public function create()
    {
        abort_if(Gate::denies('bus_station_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $buses = Bus::pluck('number', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.busStations.create', compact('buses'));
    }

    public function store(StoreBusStationRequest $request)
    {
        $busStation = BusStation::create($request->all());

        return redirect()->route('admin.bus-stations.index');
    }

    public function edit(BusStation $busStation)
    {
        abort_if(Gate::denies('bus_station_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $buses = Bus::pluck('number', 'id')->prepend(trans('global.pleaseSelect'), '');

        $busStation->load('bus');

        return view('admin.busStations.edit', compact('busStation', 'buses'));
    }

    public function update(UpdateBusStationRequest $request, BusStation $busStation)
    {
        $busStation->update($request->all());

        return redirect()->route('admin.bus-stations.index');
    }

    public function show(BusStation $busStation)
    {
        abort_if(Gate::denies('bus_station_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $busStation->load('bus');

        return view('admin.busStations.show', compact('busStation'));
    }

    public function destroy(BusStation $busStation)
    {
        abort_if(Gate::denies('bus_station_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $busStation->delete();

        return back();
    }

    public function massDestroy(MassDestroyBusStationRequest $request)
    {
        $busStations = BusStation::find(request('ids'));

        foreach ($busStations as $busStation) {
            $busStation->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
