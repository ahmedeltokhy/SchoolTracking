@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.bus.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.buses.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.bus.fields.id') }}
                        </th>
                        <td>
                            {{ $bus->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bus.fields.description') }}
                        </th>
                        <td>
                            {{ $bus->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bus.fields.number') }}
                        </th>
                        <td>
                            {{ $bus->number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bus.fields.driver') }}
                        </th>
                        <td>
                            {{ $bus->driver->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bus.fields.students') }}
                        </th>
                        <td>
                            @foreach($bus->students as $key => $students)
                                <span class="label label-info">{{ $students->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.buses.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection