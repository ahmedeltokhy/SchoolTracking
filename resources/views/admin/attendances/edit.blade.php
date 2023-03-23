@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.attendance.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.attendances.update", [$attendance->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="classsection_id">{{ trans('cruds.attendance.fields.classsection') }}</label>
                <select class="form-control select2 {{ $errors->has('classsection') ? 'is-invalid' : '' }}" name="classsection_id" id="classsection_id" required>
                    @foreach($classsections as $id => $entry)
                        <option value="{{ $id }}" {{ (old('classsection_id') ? old('classsection_id') : $attendance->classsection->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('classsection'))
                    <div class="invalid-feedback">
                        {{ $errors->first('classsection') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.attendance.fields.classsection_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="date">{{ trans('cruds.attendance.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date', $attendance->date) }}" required>
                @if($errors->has('date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.attendance.fields.date_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="teacher_id">{{ trans('cruds.attendance.fields.teacher') }}</label>
                <select class="form-control select2 {{ $errors->has('teacher') ? 'is-invalid' : '' }}" name="teacher_id" id="teacher_id" required>
                    @foreach($teachers as $id => $entry)
                        <option value="{{ $id }}" {{ (old('teacher_id') ? old('teacher_id') : $attendance->teacher->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('teacher'))
                    <div class="invalid-feedback">
                        {{ $errors->first('teacher') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.attendance.fields.teacher_helper') }}</span>
            </div>
            <div class="attendance-container">
                <div class="form-group">
                    <h6>student attendance</h6>
                    @foreach($attendance->classsection->students as $std)
                        <div class="container">
                            <div class="row">
                                <div class="col-3">
                                    <p>{{$std->name}}</p>
                                </div>
                                <div class="col-9">
                                    <label class="switch" for="{{$std->id}}">
                                        <input type="checkbox" id="{{$std->id}}"  class="attendance-toggle"  value="1" name="students[{{$std->id}}]" @if(in_array($std->id,$student_attendance)) checked @endif  />
                                        <div class="slider round"></div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
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