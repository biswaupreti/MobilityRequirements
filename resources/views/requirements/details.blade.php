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
            <hr/>
            <dt>Ways of Interactions</dt>
            <dd>
                @if($requirement->accompanying)
                    Accompanying<br/>
                @endif
                @if($requirement->intermittent)
                    Intermittent<br/>
                @endif
                @if($requirement->interrupting)
                    Interrupting
                @endif
            </dd>
        </dl>
    </div>

    @include('context.index', array($context, $requirement->id))
@stop