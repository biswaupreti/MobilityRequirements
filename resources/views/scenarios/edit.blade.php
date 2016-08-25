@extends('layout')

@section('content')

    <h1>Edit Scenario :: {{ $scenario->title }}</h1>

    <hr/>

    @include('errors.list')

    {!! Form::model($scenario, ['method' => 'PATCH', 'action' => ['ScenariosController@update', $scenario->id]]) !!}

        @include('scenarios._form', ['submitButtonText' => 'Update', 'project_id' => $project_id])

    {!! Form::close() !!}

@stop