@extends('layouts.client')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('cruds.bus.title_singular') }} {{ trans('global.list') }}
    </div>
    <form method="post" action="{{route('driver.buses.update_stations',$bus->id)}}">
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
                            {{ trans('cruds.checkStation.fields.status') }}
                        </th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach($stations as $key => $station)
                        <tr data-entry-id="{{ $station->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $station->id ?? '' }}
                            </td>
                            <td>
                                {{ $station->name ?? '' }}
                            </td>
                            <td>
                            @if(isset($check_station[$station->id])&&$check_station[$station->id]==1)  <span  class="badge badge-success">arrive</span> @else  <span  class="badge badge-secondary">waitting</span> @endif
                            </td>
                            

                        </tr>
                    @endforeach
                </tbody>
            </table>
            <button type="submit" class="btn btn-primary">save</button>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
//     $(function () {
//   let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)


//   $.extend(true, $.fn.dataTable.defaults, {
//     orderCellsTop: true,
//     order: [[ 1, 'desc' ]],
//     pageLength: 100,
//   });
//   let table = $('.datatable-Bus:not(.ajaxTable)').DataTable({ buttons: dtButtons })
//   $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
//       $($.fn.dataTable.tables(true)).DataTable()
//           .columns.adjust();
//   });
  
// })

</script>
@endsection