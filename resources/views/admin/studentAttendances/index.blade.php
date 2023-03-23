@extends('layouts.admin')
@section('content')
@can('student_attendance_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.student-attendances.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.studentAttendance.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.studentAttendance.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-StudentAttendance">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.studentAttendance.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.studentAttendance.fields.student') }}
                        </th>
                        <th>
                            {{ trans('cruds.studentAttendance.fields.attendance') }}
                        </th>
                        <th>
                            {{ trans('cruds.studentAttendance.fields.status') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($studentAttendances as $key => $studentAttendance)
                        <tr data-entry-id="{{ $studentAttendance->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $studentAttendance->id ?? '' }}
                            </td>
                            <td>
                                {{ $studentAttendance->student->name ?? '' }}
                            </td>
                            <td>
                                {{ $studentAttendance->attendance->date ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $studentAttendance->status ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $studentAttendance->status ? 'checked' : '' }}>
                            </td>
                            <td>
                                @can('student_attendance_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.student-attendances.show', $studentAttendance->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('student_attendance_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.student-attendances.edit', $studentAttendance->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('student_attendance_delete')
                                    <form action="{{ route('admin.student-attendances.destroy', $studentAttendance->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('student_attendance_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.student-attendances.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-StudentAttendance:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection