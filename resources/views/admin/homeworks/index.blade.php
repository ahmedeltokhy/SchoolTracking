@extends('layouts.admin')
@section('content')
@can('homework_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.homeworks.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.homework.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.homework.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Homework">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.homework.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.homework.fields.teacher') }}
                        </th>
                        <th>
                            {{ trans('cruds.homework.fields.title') }}
                        </th>
                        <th>
                            {{ trans('cruds.homework.fields.content') }}
                        </th>
                        <th>
                            {{ trans('cruds.homework.fields.class_section') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($homeworks as $key => $homework)
                        <tr data-entry-id="{{ $homework->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $homework->id ?? '' }}
                            </td>
                            <td>
                                {{ $homework->teacher->name ?? '' }}
                            </td>
                            <td>
                                {{ $homework->title ?? '' }}
                            </td>
                            <td>
                                {{ $homework->content ?? '' }}
                            </td>
                            <td>
                                {{ $homework->class_section->subject ?? '' }}
                            </td>
                            <td>
                                @can('homework_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.homeworks.show', $homework->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('homework_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.homeworks.edit', $homework->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('homework_delete')
                                    <form action="{{ route('admin.homeworks.destroy', $homework->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('homework_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.homeworks.massDestroy') }}",
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
  let table = $('.datatable-Homework:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection