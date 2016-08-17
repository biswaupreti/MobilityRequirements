@extends('layout')

@section('content')

    <h1>Edit Project :: {{ $project->title }}</h1>

    <hr/>

    @include('errors.list')

    {!! Form::model($project, ['method' => 'PATCH', 'action' => ['ProjectsController@update', $project->id]]) !!}

        @include('projects._form', ['submitButtonText' => 'Update Project'])

    {!! Form::close() !!}

@stop