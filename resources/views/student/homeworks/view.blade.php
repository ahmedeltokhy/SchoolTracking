@extends('layouts.client')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.homework.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.homework.fields.id') }}
                        </th>
                        <td>
                            {{ $homework->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.homework.fields.teacher') }}
                        </th>
                        <td>
                            {{ $homework->teacher->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.homework.fields.title') }}
                        </th>
                        <td>
                            {{ $homework->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.homework.fields.content') }}
                        </th>
                        <td>
                            {!! $homework->content !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.homework.fields.class_section') }}
                        </th>
                        <td>
                            {{ $homework->class_section->subject ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.homework.fields.attachment') }}
                        </th>
                        <td>
                            @foreach($homework->attachment as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <h3>My Solutions</h3>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>
                            {{ trans('cruds.homework.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.homeworkSolution.fields.notes') }}
                        </th>
                        
                        <td>
                             {{ trans('global.action') }}

                        </td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($my_solutions as $row)
                    <tr>
                        <th>
                            {{ $row->id }}
                        </th>
                        <th>
                            {{ $row->notes }}
                        </th>
                        
                        <td>
                        <a class="btn btn-xs btn-primary" href=" {{ route('student.solution.show',$row->id) }}">
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