@extends('layout')

@section('content')

    <div class="row">
        <div class="col-md-10">
            <h3>All Projects</h3>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary"  style="margin-top: 20px;">
                <a href="{{ url('projects/create') }}"  style="color: #ffffff;">Create New</a>
            </button>
        </div>
    </div>

    <hr/>
    <table class="table table-striped" width="100%">
        <thead>
        <tr>
            <th width="5%">#</th>
            <th width="20%">Project Title</th>
            <th width="30%">Description</th>
            <th width="15%">Project Owner</th>
            <th width="15%">Created On</th>
            <th width="15%">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 1; ?>
        @foreach($projects as $project)
            <tr>
                <th scope="row">{{ $i }}</th>
                <td><a href="{{ url('/projects', [$project->id]) }}">{{ $project->title }}</a></td>
                <td>{{ $project->description }}</td>
                <td>{{ $project->project_owner }}</td>
                <td>{{ $project->created_at }}</td>
                <td>
                    <a href="{{ url('/projects', [$project->id, 'edit']) }}" title="Edit User Information!" class="btn btn-info btn-sm" style="float: left; margin-right: 5px;">
                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit
                    </a>
                    {!! Form::open(['method' => 'DELETE', 'route' => ['projects.destroy', $project->id], 'onsubmit' => 'return confirm("Are you sure you want to delete?")']) !!}
                    <button type="submit" class="btn btn-danger btn-sm">
                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete
                    </button>
                    {!! Form::close() !!}
                </td>
            </tr>
            <?php $i++; ?>
        @endforeach
        </tbody>
    </table>
@stop