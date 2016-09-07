@extends('layout')

@section('content')
    <h3>Project Details</h3>
    <hr/>

    <div class="bs-example" data-example-id="horizontal-dl">
        <dl class="dl-horizontal">
            <dt>Project Title: </dt>
            <dd>{{ $project->title }}</dd>
            <dt>Description: </dt>
            <dd>{{ $project->description }}</dd>
            <dt>Project Owner: </dt>
            <dd>{{ $project->owner }}</dd>
            <dt>Created On</dt>
            <dd>{{ $project->created_at }}</dd>
            <dt>Status</dt>
            <dd>
                @if($project->status == '1')
                    <span class="green">{{ 'Open' }}</span>
                @else
                    <span class="red">{{ 'Closed' }}</span>
                @endif
            </dd>
        </dl>
        <div class="btn btn-info"><a href="{{ url('/scenarios?project='. $project->id) }}">Manage scenarios for this project</a></div>
    </div>

{{--    @include('scenarios.index', array($scenarios, $project->id))--}}

    @include('requirements.index', array($requirements, $project->id))

@stop