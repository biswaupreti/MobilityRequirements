@extends('layout')

@section('content')

    <h1>Edit Context</h1>

    <hr/>

    @include('errors.list')

    {!! Form::model($context, ['method' => 'PATCH', 'action' => ['ContextController@update', $context->id]]) !!}

        @include('context._form', ['submitButtonText' => 'Update', 'requirement_id' => $requirement_id])

    {!! Form::close() !!}

@stop