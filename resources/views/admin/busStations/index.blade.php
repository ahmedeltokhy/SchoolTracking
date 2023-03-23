@extends('layouts.admin')
@section('content')
@can('bus_station_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.bus-stations.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.busStation.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.busStation.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-BusStation">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.busStation.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.busStation.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.busStation.fields.bus') }}
                        </th>
                        <th>
                            {{ trans('cruds.bus.fields.number') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($busStations as $key => $busStation)
                        <tr data-entry-id="{{ $busStation->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $busStation->id ?? '' }}
                            </td>
                            <td>
                                {{ $busStation->name ?? '' }}
                            </td>
                            <td>
                                {{ $busStation->bus->number ?? '' }}
                            </td>
                            <td>
                                {{ $busStation->bus->number ?? '' }}
                            </td>
                            <td>
                                @can('bus_station_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.bus-stations.show', $busStation->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('bus_station_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.bus-stations.edit', $busStation->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('bus_station_delete')
                                    <form action="{{ route('admin.bus-stations.destroy', $busStation->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('bus_station_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.bus-stations.massDestroy') }}",
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
  let table = $('.datatable-BusStation:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection