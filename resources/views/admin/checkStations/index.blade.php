@extends('layouts.admin')
@section('content')
@can('check_station_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.check-stations.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.checkStation.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.checkStation.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-CheckStation">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.checkStation.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.checkStation.fields.bus') }}
                        </th>
                        <th>
                            {{ trans('cruds.checkStation.fields.driver') }}
                        </th>
                        <th>
                            {{ trans('cruds.checkStation.fields.bus_station') }}
                        </th>
                        <th>
                            {{ trans('cruds.checkStation.fields.date') }}
                        </th>
                        <th>
                            {{ trans('cruds.checkStation.fields.status') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($checkStations as $key => $checkStation)
                        <tr data-entry-id="{{ $checkStation->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $checkStation->id ?? '' }}
                            </td>
                            <td>
                                {{ $checkStation->bus->number ?? '' }}
                            </td>
                            <td>
                                {{ $checkStation->driver->name ?? '' }}
                            </td>
                            <td>
                                {{ $checkStation->bus_station->name ?? '' }}
                            </td>
                            <td>
                                {{ $checkStation->date ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\CheckStation::STATUS_RADIO[$checkStation->status] ?? '' }}
                            </td>
                            <td>
                                @can('check_station_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.check-stations.show', $checkStation->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('check_station_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.check-stations.edit', $checkStation->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('check_station_delete')
                                    <form action="{{ route('admin.check-stations.destroy', $checkStation->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('check_station_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.check-stations.massDestroy') }}",
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
  let table = $('.datatable-CheckStation:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection