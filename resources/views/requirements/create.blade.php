@extends('layout')

@section('content')

    <h1>Create a New Requirement</h1>

    <hr/>

    @include('errors.list')

    {!! Form::open(['url' => 'requirements']) !!}

        @include('requirements._form', ['submitButtonText' => 'Add New', 'project_id' => $project_id])

    {!! Form::close() !!}

@stop