@extends('layouts.client')
@section('content')
@can('bus_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.buses.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.bus.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.bus.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Bus">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.bus.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.bus.fields.number') }}
                        </th>
                        <th>
                            {{ trans('cruds.bus.fields.driver') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($buses as $key => $bus)
                        <tr data-entry-id="{{ $bus->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $bus->id ?? '' }}
                            </td>
                            <td>
                                {{ $bus->number ?? '' }}
                            </td>
                            <td>
                                {{ $bus->driver->name ?? '' }}
                            </td>
                            <td>
                            <a class="btn btn-xs btn-primary" href="{{ route('parent.buses.show', $bus->id) }}">
                                        {{ trans('global.track_station') }}
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
  let table = $('.datatable-Bus:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection