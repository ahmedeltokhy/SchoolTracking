@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.studentAttendance.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.student-attendances.update", [$studentAttendance->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="student_id">{{ trans('cruds.studentAttendance.fields.student') }}</label>
                <select class="form-control select2 {{ $errors->has('student') ? 'is-invalid' : '' }}" name="student_id" id="student_id" required>
                    @foreach($students as $id => $entry)
                        <option value="{{ $id }}" {{ (old('student_id') ? old('student_id') : $studentAttendance->student->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('student'))
                    <div class="invalid-feedback">
                        {{ $errors->first('student') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentAttendance.fields.student_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="attendance_id">{{ trans('cruds.studentAttendance.fields.attendance') }}</label>
                <select class="form-control select2 {{ $errors->has('attendance') ? 'is-invalid' : '' }}" name="attendance_id" id="attendance_id" required>
                    @foreach($attendances as $id => $entry)
                        <option value="{{ $id }}" {{ (old('attendance_id') ? old('attendance_id') : $studentAttendance->attendance->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('attendance'))
                    <div class="invalid-feedback">
                        {{ $errors->first('attendance') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentAttendance.fields.attendance_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('status') ? 'is-invalid' : '' }}">
                    <input class="form-check-input" type="checkbox" name="status" id="status" value="1" {{ $studentAttendance->status || old('status', 0) === 1 ? 'checked' : '' }} required>
                    <label class="required form-check-label" for="status">{{ trans('cruds.studentAttendance.fields.status') }}</label>
                </div>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentAttendance.fields.status_helper') }}</span>
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