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
            <dt>Scenarios: </dt>
            <dd>{!! nl2br($project->scenario) !!}</dd>
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
    </div>

    @include('requirements.index', array($requirements, $project->id))

@stop