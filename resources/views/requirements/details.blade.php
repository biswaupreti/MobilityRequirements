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
    </dl>
</div>

@stop