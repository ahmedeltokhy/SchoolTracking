@extends('layouts.client')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.attendance.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST"  action="@if(isset($attendance)) {{ route("teacher.attendances.updatee",$attendance->id) }} @else {{ route("teacher.attendances.store") }} @endif" enctype="multipart/form-data">
            
            @csrf
            <div class="form-group">
                <label class="required" for="classsection_id">{{ trans('cruds.attendance.fields.classsection') }}</label>
                <select class="form-control select2 {{ $errors->has('classsection') ? 'is-invalid' : '' }}" name="classsection_id" onchange="reload_students(this)" id="classsection_id" required>
                    @foreach($classsections as $id => $entry)
                        <option value="{{ $id }}" {{ old('classsection_id',(isset($attendance)? $attendance->classsection_id : (isset($classsection) && !empty($classsection) ? $classsection->id : ""))) == $id ? 'selected' : '' }}>{{ $entry }}</option>
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
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date',isset($attendance)? $attendance->date :today()) }}" required>
                @if($errors->has('date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.attendance.fields.date_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="teacher_id">{{ trans('cruds.attendance.fields.teacher') }}</label>
                <select class="form-control  {{ $errors->has('teacher') ? 'is-invalid' : '' }}" name="teacher_id" id="teacher_id" readonly="readonly">
                        <option value="{{  auth("client")->id() }}" {{ auth("client")->id() == $id ? 'selected' : '' }}>{{  auth("client")->user()->name }}</option>
                </select>
                @if($errors->has('teacher'))
                    <div class="invalid-feedback">
                        {{ $errors->first('teacher') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.attendance.fields.teacher_helper') }}</span>
            </div>
            <div class="attendance-container">
                @if(isset($attendance)&& !empty($attendance))
                <div class="form-group">
                    <h6>student attendance</h6>
                    @foreach($attendance->students as $std)
                        <div class="container">
                            <div class="row">
                                <div class="col-3">
                                    <p>{{$std->name}}</p>
                                </div>
                                <div class="col-9">
                                    <label class="switch" for="{{$std->id}}">
                                        <input type="checkbox" id="{{$std->id}}"  class="attendance-toggle" name="students[{{$std->id}}]" value="1" @if($std->pivot->status==1) checked @endif />
                                        <div class="slider round"></div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @elseif(isset($classsection) && !empty($classsection))
                <div class="form-group">
                    <h6>student attendance</h6>
                    @foreach($classsection->students as $std)
                        <div class="container">
                            <div class="row">
                                <div class="col-3">
                                    <p>{{$std->name}}</p>
                                </div>
                                <div class="col-9">
                                    <label class="switch" for="{{$std->id}}">
                                        <input type="checkbox" id="{{$std->id}}"  class="attendance-toggle" name="students[{{$std->id}}]"  value="1" checked  />
                                        <div class="slider round"></div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @endif
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
