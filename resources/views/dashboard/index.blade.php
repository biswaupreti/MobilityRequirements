@extends('layout')

@section('content')

    <div class="row">

        @if(isset($user))
            <div class="user-info">Welcome {{ $user }}, <a href="{{ url('/auth/logout') }}">Logout</a></div>
        @endif

        <h1>Dashboard</h1>
        <hr/>

        <div class="row">

            <div class="col-md-12 dashboard-menu">
                <ul>
                    <li><a href="javascript:;" class="btn btn-primary">Project Management</a> </li>
                    <li><a href="javascript:;" class="btn btn-primary">Requirement Management</a> </li>
                    <li><a href="javascript:;" class="btn btn-primary">Context Management</a> </li>
                    <li><a href="javascript:;" class="btn btn-primary">Scenario Management</a> </li>
                    <li><a href="javascript:;" class="btn btn-primary">User Management</a> </li>
                </ul>
            </div>

        </div>

    </div>

@stop