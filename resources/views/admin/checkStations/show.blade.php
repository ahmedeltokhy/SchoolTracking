@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.checkStation.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.check-stations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.checkStation.fields.id') }}
                        </th>
                        <td>
                            {{ $checkStation->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.checkStation.fields.bus') }}
                        </th>
                        <td>
                            {{ $checkStation->bus->number ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.checkStation.fields.driver') }}
                        </th>
                        <td>
                            {{ $checkStation->driver->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.checkStation.fields.bus_station') }}
                        </th>
                        <td>
                            {{ $checkStation->bus_station->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.checkStation.fields.date') }}
                        </th>
                        <td>
                            {{ $checkStation->date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.checkStation.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\CheckStation::STATUS_RADIO[$checkStation->status] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.check-stations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection