@extends('layouts.client')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.homework.title') }}
    </div>
    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('teacher.homeworks.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
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
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>
                            {{ trans('cruds.homework.fields.id') }}
                        </th>
                        <th>
                            student
                        </th>
                        <th>
                            {{ trans('cruds.homeworkSolution.fields.notes') }}
                        </th>
                        <th>
                            {{ trans('cruds.homeworkSolution.fields.created_at') }}
                        </th>
                        
                        <td>
                             {{ trans('global.action') }}

                        </td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($solutions as $row)
                    <tr>
                        <th>
                            {{ $row->id }}
                        </th>
                        <th>
                            {{ optional($row->student)->name }}
                        </th>
                        <th>
                            {{ $row->notes }}
                        </th>
                        <th>
                            {{ $row->created_at }}
                        </th>
                        
                        <td>
                        <a class="btn btn-xs btn-primary" href=" {{ route('teacher.solution.show',$row->id) }}">
                                    {{ trans('global.view') }}
                                </a>
                           
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('teacher.homeworks.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection