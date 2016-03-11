@extends('layout')

@section('content')

    <div class="row">
        <div class="col-md-10">
            <h3>All Projects</h3>
        </div>
        <div class="col-md-2">
            <a href="{{ url('projects/create') }}" class="btn btn-primary"  style=" margin-top: 20px; color: #ffffff;">Create New</a>
        </div>
    </div>

    <hr/>
    <table class="table table-striped" width="100%">
        <thead>
        <tr>
            <th width="5%">#</th>
            <th width="12%">Project Title</th>
            <th width="30%">Description</th>
            <th width="30%">Scenarios</th>
            <th width="8%">Status</th>
            <th width="15%">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
            $i = 1;
            $is_disabled = '';
        ?>
        @foreach($projects as $project)
            <tr>
                <th scope="row">{{ $i }}</th>
                <td><a href="{{ url('/projects', [$project->id]) }}">{{ $project->title }}</a></td>
                <td>{{ str_limit($project->description, 150) }}</td>
                <td>{!! nl2br($project->scenario) !!} </td>
                <td>
                    @if($project->status == '1')
                        <span class="green">{{ 'Open' }}</span>
                    @else
                        <span class="red">{{ 'Closed' }}</span>
                    @endif
                </td>
                <td>
                    @if($project->project_owner === $authUser->id)
                        <a href="{{ url('/projects', [$project->id, 'edit']) }}" title="Edit User Information!" class="btn btn-info btn-sm" style="float: left; margin-right: 5px;">
                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit
                        </a>
                        {!! Form::open(['method' => 'DELETE', 'route' => ['projects.destroy', $project->id], 'onsubmit' => 'return confirm("Are you sure you want to delete?")']) !!}
                        <button type="submit" class="btn btn-danger btn-sm">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete
                        </button>
                        {!! Form::close() !!}
                    @else
                        <span>--</span>
                    @endif
                </td>
            </tr>
            <?php $i++; ?>
        @endforeach
        </tbody>
    </table>
@stop