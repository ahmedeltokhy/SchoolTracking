@extends('layouts.client')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('cruds.message.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Message">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.message.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.message.fields.teacher') }}
                        </th>
                        <th>
                            {{ trans('cruds.message.fields.student') }}
                        </th>
                        <th>
                            {{ trans('cruds.message.fields.classsection') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($messages as $key => $message)
                        <tr data-entry-id="{{ $message->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $message->id ?? '' }}
                            </td>
                            <td>
                                {{ $message->teacher->name ?? '' }}
                            </td>
                            <td>
                                {{ $message->student->name ?? '' }}
                            </td>
                            <td>
                                {{ $message->classsection->subject ?? '' }}
                            </td>
                            <td>
                                
                                <a class="btn btn-xs btn-primary" href="{{ route('parent.message.show', $message->id) }}">
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
  let table = $('.datatable-Message:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection