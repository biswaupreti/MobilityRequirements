@extends('layout')

@section('content')

    <div class="row">
        <div class="col-md-10">
            <h3>All Users</h3>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary"  style="margin-top: 20px;">
                <a href="{{ url('users/create') }}"  style="color: #ffffff;">Create New</a>
            </button>
        </div>
    </div>

    <hr/>

    <table class="table table-striped" width="100%">
        <thead>
        <tr>
            <th width="5%">#</th>
            <th width="20%">User Name</th>
            <th width="25%">Email</th>
            <th width="15%">Role</th>
            <th width="20%">Created On</th>
            <th width="15%">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 1; ?>
        @foreach($users as $user)
            <tr>
                <th scope="row">{{ $i }}</th>
                <td><a href="{{ url('/users', [$user->id, 'edit']) }}">{{ $user->name }}</a></td>
                <td>{{ $user->email }}</td>
                <td>
                    @if($user->role == '2')
                        Project Manager
                    @elseif($user->role == '3')
                        Developer / Designer
                    @else
                        Administrator
                    @endif
                </td>
                <td>{{ $user->created_at }}</td>
                <td>
                    <a href="{{ url('/users', [$user->id, 'edit']) }}" title="Edit User Information!" class="btn btn-info btn-sm" style="float: left; margin-right: 5px;">
                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit
                    </a>
                    {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id], 'onsubmit' => 'return confirm("Are you sure you want to delete?")']) !!}
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