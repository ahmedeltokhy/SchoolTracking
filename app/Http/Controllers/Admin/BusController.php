<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyBusRequest;
use App\Http\Requests\StoreBusRequest;
use App\Http\Requests\UpdateBusRequest;
use App\Models\Bus;
use App\Models\Client;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BusController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('bus_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $buses = Bus::with(['driver', 'students'])->get();

        return view('admin.buses.index', compact('buses'));
    }

    public function create()
    {
        abort_if(Gate::denies('bus_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $drivers = Client::where("type","driver")->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $students = Client::where("type","student")->pluck('name', 'id');

        return view('admin.buses.create', compact('drivers', 'students'));
    }

    public function store(StoreBusRequest $request)
    {
        $bus = Bus::create($request->all());
        $bus->students()->sync($request->input('students', []));

        return redirect()->route('admin.buses.index');
    }

    public function edit(Bus $bus)
    {
        abort_if(Gate::denies('bus_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $drivers = Client::where("type","driver")->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $students = Client::where("type","student")->pluck('name', 'id');

        $bus->load('driver', 'students');

        return view('admin.buses.edit', compact('bus', 'drivers', 'students'));
    }

    public function update(UpdateBusRequest $request, Bus $bus)
    {
        $bus->update($request->all());
        $bus->students()->sync($request->input('students', []));

        return redirect()->route('admin.buses.index');
    }

    public function show(Bus $bus)
    {
        abort_if(Gate::denies('bus_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bus->load('driver', 'students');

        return view('admin.buses.show', compact('bus'));
    }

    public function destroy(Bus $bus)
    {
        abort_if(Gate::denies('bus_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bus->delete();

        return back();
    }

    public function massDestroy(MassDestroyBusRequest $request)
    {
        $buses = Bus::find(request('ids'));

        foreach ($buses as $bus) {
            $bus->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
