@extends('layouts.client')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.homeworkSolution.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action=" {{ route("student.solution.form", [$homework->id])  }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="homework_id">{{ trans('cruds.homeworkSolution.fields.homework') }}</label>
                <select class="form-control  {{ $errors->has('homework') ? 'is-invalid' : '' }}" name="homework_id" id="homework_id" required readonly="readonly">
                        <option value="{{ $homework->id }}"  'selected' >{{ $homework->title }}</option>
                </select>

                @if($errors->has('homework'))
                    <div class="invalid-feedback">
                        {{ $errors->first('homework') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.homeworkSolution.fields.homework_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="notes">{{ trans('cruds.homeworkSolution.fields.notes') }}</label>
                <textarea class="form-control {{ $errors->has('notes') ? 'is-invalid' : '' }}" name="notes" id="notes">{{ old('notes') }}</textarea>
                @if($errors->has('notes'))
                    <div class="invalid-feedback">
                        {{ $errors->first('notes') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.homeworkSolution.fields.notes_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="attachments">{{ trans('cruds.homeworkSolution.fields.attachments') }}</label>
                <div class="needsclick dropzone {{ $errors->has('attachments') ? 'is-invalid' : '' }}" id="attachments-dropzone">
                </div>
                @if($errors->has('attachments'))
                    <div class="invalid-feedback">
                        {{ $errors->first('attachments') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.homeworkSolution.fields.attachments_helper') }}</span>
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
    var uploadedAttachmentsMap = {}
Dropzone.options.attachmentsDropzone = {
    url: '{{ route('student.homework-solutions.storeMedia') }}',
    maxFilesize: 20, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 20
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="attachments[]" value="' + response.name + '">')
      uploadedAttachmentsMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedAttachmentsMap[file.name]
      }
      $('form').find('input[name="attachments[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($homeworkSolution) && $homeworkSolution->attachments)
          var files =
            {!! json_encode($homeworkSolution->attachments) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="attachments[]" value="' + file.file_name + '">')
            }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
@endsection