@extends('layout')

@section('content')

    <h1>Edit Requirement :: {{ $requirement->title }}</h1>

    <hr/>

    @include('errors.list')

    {!! Form::model($requirement, ['method' => 'PATCH', 'action' => ['RequirementsController@update', $requirement->id]]) !!}

        @include('requirements._form', ['submitButtonText' => 'Update', 'project_id' => $project_id])

    {!! Form::close() !!}

@stop