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
                            {{ trans('cruds.homeworkSolution.fields.created_at') }}
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
                                {{ $homeworkSolution->created_at }}
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