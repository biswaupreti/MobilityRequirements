@extends('layout')

@section('content')

    <h1>Create a New Scenario</h1>

    <hr/>

    @include('errors.list')

    {!! Form::open(['url' => 'scenarios']) !!}

        @include('scenarios._form', ['submitButtonText' => 'Add New', 'project_id' => $project_id])

    {!! Form::close() !!}

@stop