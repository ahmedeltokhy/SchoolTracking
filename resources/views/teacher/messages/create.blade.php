@extends('layouts.client')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.message.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("teacher.messages.store") }}" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label class="required" for="classsection_id">{{ trans('cruds.message.fields.classsection') }}</label>
                <select class="form-control select2 {{ $errors->has('classsection') ? 'is-invalid' : '' }}" name="classsection_id" id="classsection_id" required>
                    @foreach($classsections as $id => $entry)
                        <option value="{{ $id }}" {{ old('classsection_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('classsection'))
                    <div class="invalid-feedback">
                        {{ $errors->first('classsection') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.message.fields.classsection_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="student_id">{{ trans('cruds.message.fields.student') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('student') ? 'is-invalid' : '' }}" name="student_id[]" id="student_id" required multiple>
                    {{--
                    @foreach($students as $id => $entry)
                        <option value="{{ $id }}" {{ old('student_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                    --}}
                </select>
                @if($errors->has('student'))
                    <div class="invalid-feedback">
                        {{ $errors->first('student') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.message.fields.student_helper') }}</span>
            </div>
            
            <div class="form-group">
                <label class="required" for="content">{{ trans('cruds.message.fields.content') }}</label>
                <textarea class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }}" name="content" id="content" required>{{ old('content') }}</textarea>
                @if($errors->has('content'))
                    <div class="invalid-feedback">
                        {{ $errors->first('content') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.message.fields.content_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="teacher_id">{{ trans('cruds.message.fields.teacher') }}</label>
                <select class="form-control  {{ $errors->has('teacher') ? 'is-invalid' : '' }}" name="teacher_id" id="teacher_id" readonly="readonly">
                    <option value="{{ auth('client')->id() }}" >{{  auth('client')->user()->name }}</option>
                </select>
                
                <span class="help-block">{{ trans('cruds.message.fields.teacher_helper') }}</span>
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
@section('scripts')
<script>
$( document ).ready(function() {
    $('#classsection_id').on('change', function() {
        var val =this.value;
        // console.log(val);
        studentSelect=$("#student_id");
        $.ajax({
            type: 'GET',
            url: '/teacher/section/'+val+'/list_students' 
        }).then(function (data) {
            studentSelect.empty().trigger("change");
            // create the option and append to Select2

            $.each(data.data, function( index, value ) {
                var option = new Option(value.name, value.id, true, true);
                studentSelect.append(option).trigger('change');
            });
            studentSelect.val(null).trigger('change');

            // data.each(function(row){
            //     console.log(row);
            //     // alert($(this).text())
            //     var option = new Option(row.name, row.id, true, true);
            //     studentSelect.append(option).trigger('change');
            // });
        });
    });
});


</script>
@endsection