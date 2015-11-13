@extends('layout')

@section('content')
    <h3>Requirement Details</h3>
    <hr/>

    <div class="bs-example" data-example-id="horizontal-dl">
        <dl class="dl-horizontal">
            <dt>Title: </dt>
            <dd>{{ $requirement->title }}</dd>
            <dt>Description: </dt>
            <dd>{{ $requirement->description }}</dd>
            <dt>Created On</dt>
            <dd>{{ $requirement->created_at }}</dd>
        </dl>
    </div>

    @include('context.index', array($context, $requirement->id))
@stop