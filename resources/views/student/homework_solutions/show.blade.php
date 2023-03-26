@extends('layouts.client')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.homeworkSolution.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.homeworkSolution.fields.id') }}
                        </th>
                        <td>
                            {{ $homeworkSolution->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.homeworkSolution.fields.student') }}
                        </th>
                        <td>
                            {{ $homeworkSolution->student->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.homeworkSolution.fields.homework') }}
                        </th>
                        <td>
                            {{ $homeworkSolution->homework->title ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.homeworkSolution.fields.notes') }}
                        </th>
                        <td>
                            {{ $homeworkSolution->notes }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.homeworkSolution.fields.attachments') }}
                        </th>
                        <td>
                            @foreach($homeworkSolution->attachments as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            
        </div>
    </div>
</div>



@endsection