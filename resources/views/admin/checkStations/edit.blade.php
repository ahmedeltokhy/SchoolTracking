@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.checkStation.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.check-stations.update", [$checkStation->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="bus_id">{{ trans('cruds.checkStation.fields.bus') }}</label>
                <select class="form-control select2 {{ $errors->has('bus') ? 'is-invalid' : '' }}" name="bus_id" id="bus_id" required>
                    @foreach($buses as $id => $entry)
                        <option value="{{ $id }}" {{ (old('bus_id') ? old('bus_id') : $checkStation->bus->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('bus'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bus') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.checkStation.fields.bus_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="driver_id">{{ trans('cruds.checkStation.fields.driver') }}</label>
                <select class="form-control select2 {{ $errors->has('driver') ? 'is-invalid' : '' }}" name="driver_id" id="driver_id" required>
                    @foreach($drivers as $id => $entry)
                        <option value="{{ $id }}" {{ (old('driver_id') ? old('driver_id') : $checkStation->driver->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('driver'))
                    <div class="invalid-feedback">
                        {{ $errors->first('driver') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.checkStation.fields.driver_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="bus_station_id">{{ trans('cruds.checkStation.fields.bus_station') }}</label>
                <select class="form-control select2 {{ $errors->has('bus_station') ? 'is-invalid' : '' }}" name="bus_station_id" id="bus_station_id" required>
                    @foreach($bus_stations as $id => $entry)
                        <option value="{{ $id }}" {{ (old('bus_station_id') ? old('bus_station_id') : $checkStation->bus_station->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('bus_station'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bus_station') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.checkStation.fields.bus_station_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="date">{{ trans('cruds.checkStation.fields.date') }}</label>
                <input class="form-control datetime {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date', $checkStation->date) }}" required>
                @if($errors->has('date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.checkStation.fields.date_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.checkStation.fields.status') }}</label>
                @foreach(App\Models\CheckStation::STATUS_RADIO as $key => $label)
                    <div class="form-check {{ $errors->has('status') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="radio" id="status_{{ $key }}" name="status" value="{{ $key }}" {{ old('status', $checkStation->status) === (string) $key ? 'checked' : '' }}>
                        <label class="form-check-label" for="status_{{ $key }}">{{ $label }}</label>
                    </div>
                @endforeach
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.checkStation.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection