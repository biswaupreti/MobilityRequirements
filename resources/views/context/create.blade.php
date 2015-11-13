@extends('layout')

@section('content')

    <h1>Create New Context</h1>

    <hr/>

    @include('errors.list')

    {!! Form::open(['url' => 'context']) !!}

        @include('context._form', ['submitButtonText' => 'Add New', 'requirement_id' => $requirement_id])

    {!! Form::close() !!}

@stop