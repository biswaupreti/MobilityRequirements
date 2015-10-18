@extends('layout')

@section('content')

    <div class="row">

        <h1>Dashboard</h1>
        <hr/>

        <div class="row">

            @if($authUser->role == '1')
            <div class="col-md-3 dashboard-menu">
                <ul>
                    <li><a href="javascript:;" class="btn btn-primary">Project Management</a> </li>
                    <li><a href="javascript:;" class="btn btn-primary">Requirement Management</a> </li>
                    <li><a href="javascript:;" class="btn btn-primary">Context Management</a> </li>
                    <li><a href="javascript:;" class="btn btn-primary">Scenario Management</a> </li>
                    <li><a href="{{ url('/users') }}" class="btn btn-primary">User Management</a> </li>
                </ul>
            </div>
            @endif

            <div class="col-md-9 dashboard-content">
                <h3>User Information</h3>
                <div class="bs-example" data-example-id="horizontal-dl">
                    <dl class="dl-horizontal">
                        <dt>Name: </dt>
                        <dd>{{ $authUser->name }}</dd>
                        <dt>Email: </dt>
                        <dd>{{ $authUser->email }}</dd>
                        <dt>User Role: </dt>
                        <dd>{{ $authUser->role }}</dd>
                        <dt>Created On</dt>
                        <dd>{{ $authUser->created_at }}</dd>
                    </dl>
                </div>
                <a href="{{ url('/users', [$authUser->id, 'edit']) }}" title="Edit User Information!" class="btn btn-info btn-sm" style="float: left; margin-right: 5px;">
                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit Profile
                </a>
            </div>

        </div>

    </div>

@stop