@extends('layout')

@section('content')

    <h1>Edit User :: {{ $user->name }}</h1>

    <hr/>

    @include('errors.list')

    {!! Form::model($user, ['method' => 'PATCH', 'action' => ['UserController@update', $user->id]]) !!}

        @include('user._form', ['submitButtonText' => 'Update User', 'mode' => 'edit'])

    {!! Form::close() !!}

@stop