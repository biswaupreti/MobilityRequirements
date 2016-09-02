@extends('layout')

@section('content')
    <h3>Scenario Details</h3>
    <hr/>

    <div class="bs-example" data-example-id="horizontal-dl">
        <dl class="dl-horizontal">
            <dt>Scene: </dt>
            <dd>{{ $scenario->scene }}</dd>
            <dt>Situational Context: </dt>
            <dd>{{ $scenario->context_name . ': ' . $scenario->full_name }}</dd>
            <dt>User Group: </dt>
            <dd>{{ $scenario->user_group }}</dd>
            <dt>Action Info: </dt>
            <dd>{{ $scenario->action_info }}</dd>
            <dt>Created On</dt>
            <dd>{{ $scenario->created_at }}</dd>
        </dl>
    </div>

    @include('requirements.index', array($requirements, $scenario->id))
@stop