@extends('layout')

@section('content')

    <div class="info">Welcome {{ $user }}, <a href="{{ url('/auth/logout') }}">Logout</a></div>

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
    <table class="table table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>Project Title</th>
            <th>Description</th>
            <th>Project Owner</th>
            <th>Created On</th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 1; ?>
        @foreach($projects as $project)
            <tr>
                <th scope="row">{{ $i }}</th>
                <td><a href="{{ url('/projects', [$project->id, 'edit']) }}">{{ $project->title }}</a></td>
                <td>{{ $project->description }}</td>
                <td>{{ $project->project_owner }}</td>
                <td>{{ $project->created_at }}</td>
            </tr>
            <?php $i++; ?>
        @endforeach
        </tbody>
    </table>
@stop