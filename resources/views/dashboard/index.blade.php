@extends('layout')

@section('content')

    <div class="row">

        <h1>Dashboard</h1>
        <hr/>

        <div class="row">

            <div class="col-md-3 dashboard-menu">
                <ul>
                    @if($authUser->role == '1')
                        <li><a href="{{ url('/users') }}" class="btn btn-primary">User Management</a> </li>
                    @endif
                    @if($authUser->role == '1' || $authUser->role == '2')
                        <li><a href="{{ url('/projects') }}" class="btn btn-primary">Project Management</a> </li>
                    @endif
                    <li><a href="{{ url('/context-ideal-way') }}" class="btn btn-primary">Situational Context - Ideal Way</a> </li>
                </ul>
            </div>

            <div class="col-md-9 dashboard-content">
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">User Information</div>
                            <div class="panel-body">
                                <div class="bs-example" data-example-id="horizontal-dl">
                                    <dl class="dl-horizontal">
                                        <dt>Name: </dt>
                                        <dd>{{ $authUser->name }}</dd>
                                        <dt>Email: </dt>
                                        <dd>{{ $authUser->email }}</dd>
                                        <dt>User Role: </dt>
                                        <dd>
                                            @if($authUser->role == '1')
                                                Administrator
                                            @elseif($authUser->role == '2')
                                                Project Manager
                                            @else
                                                Developer / Designer
                                            @endif
                                        </dd>
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
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">Current Projects</div>
                            <div class="panel-body">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active">
                                        <a href="#owner" aria-controls="owner" role="tab" data-toggle="tab">As a Owner</a>
                                    </li>
                                    <li role="presentation">
                                        <a href="#member" aria-controls="member" role="tab" data-toggle="tab">As a Member</a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="owner">
                                        <ul class="list-group margin-top-20">
                                            @if($ownership)
                                                @foreach($ownership as $owner)
                                                    <li class="list-group-item">
                                                        <a href="{{ url('/projects', [$owner['id']]) }}">{{ $owner['title'] }}</a></li>
                                                @endforeach
                                            @else
                                                <li class="list-group-item">No records' found!</li>
                                            @endif
                                        </ul>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="member">
                                        <ul class="list-group margin-top-20">
                                            @if($membership)
                                                @foreach($membership as $member)
                                                    <li class="list-group-item">
                                                        <a href="{{ url('/projects', [$member->id]) }}">{{ $member->title }}</a></li>
                                                @endforeach
                                            @else
                                                <li class="list-group-item">No records' found!</li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

@stop