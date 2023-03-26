@extends('layouts.client')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('cruds.homeworkSolution.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-HomeworkSolution">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.homeworkSolution.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.homeworkSolution.fields.student') }}
                        </th>
                        <th>
                            {{ trans('cruds.homeworkSolution.fields.homework') }}
                        </th>
                        <th>
                            {{ trans('cruds.homework.fields.title') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($homeworkSolutions as $key => $homeworkSolution)
                        <tr data-entry-id="{{ $homeworkSolution->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $homeworkSolution->id ?? '' }}
                            </td>
                            <td>
                                {{ $homeworkSolution->student->name ?? '' }}
                            </td>
                            <td>
                                {{ $homeworkSolution->homework->title ?? '' }}
                            </td>
                            <td>
                                {{ $homeworkSolution->homework->title ?? '' }}
                            </td>
                            <td>
                                    <a class="btn btn-xs btn-primary" href="{{ route('student.solution.show',$homeworkSolution->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                

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
@can('homework_solution_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.homework-solutions.massDestroy') }}",
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
  let table = $('.datatable-HomeworkSolution:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection