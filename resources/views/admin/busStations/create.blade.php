@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.busStation.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.bus-stations.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.busStation.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.busStation.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="bus_id">{{ trans('cruds.busStation.fields.bus') }}</label>
                <select class="form-control select2 {{ $errors->has('bus') ? 'is-invalid' : '' }}" name="bus_id" id="bus_id" required>
                    @foreach($buses as $id => $entry)
                        <option value="{{ $id }}" {{ old('bus_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('bus'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bus') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.busStation.fields.bus_helper') }}</span>
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