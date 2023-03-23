@extends('layouts.client')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.classSection.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('teacher.list_sections') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.classSection.fields.id') }}
                        </th>
                        <td>
                            {{ $classSection->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.classSection.fields.subject') }}
                        </th>
                        <td>
                            {{ $classSection->subject }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.classSection.fields.teacher') }}
                        </th>
                        <td>
                            {{ $classSection->teacher->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.classSection.fields.students') }}
                        </th>
                        <td>
                            @foreach($classSection->students as $key => $students)
                                <span class="label label-info">{{ $students->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.classSection.fields.notes') }}
                        </th>
                        <td>
                            {{ $classSection->notes }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('teacher.list_sections') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection