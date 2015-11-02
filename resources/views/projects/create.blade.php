@extends('layout')

@section('content')

    <h1>Create a New Project</h1>

    <hr/>

    @include('errors.list')

    {!! Form::open(['url' => 'projects']) !!}

        @include('projects._form', ['submitButtonText' => 'Add Project', 'owners' => $owners, 'members' => $members])

    {!! Form::close() !!}

@stop