@extends('layouts.client')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('cruds.classSection.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-ClassSection">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.classSection.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.classSection.fields.subject') }}
                        </th>
                        <th>
                            {{ trans('cruds.classSection.fields.teacher') }}
                        </th>
                        <th>
                            {{ trans('cruds.classSection.fields.students') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($classSections as $key => $classSection)
                        <tr data-entry-id="{{ $classSection->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $classSection->id ?? '' }}
                            </td>
                            <td>
                                {{ $classSection->subject ?? '' }}
                            </td>
                            <td>
                                {{ $classSection->teacher->name ?? '' }}
                            </td>
                            <td>
                                @foreach($classSection->students as $key => $item)
                                    <span class="badge badge-info">{{ $item->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                <a class="btn btn-xs btn-primary" href="{{ route('student.view_section', $classSection->id) }}">
                                        {{ trans('global.view') }}
                                </a>
                                <a class="btn btn-xs btn-warning" href="{{ route('student.classsection.homeworks', $classSection->id) }}">
                                        {{ trans('global.homeworks') }}
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
  let table = $('.datatable-ClassSection:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection