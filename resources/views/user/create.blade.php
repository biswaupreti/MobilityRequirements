@extends('layout')

@section('content')

    <h1>User Registration</h1>

    <hr/>

    @include('errors.list')

    {!! Form::open(['url' => 'users']) !!}

        @include('user._form', ['submitButtonText' => 'Add User', 'mode' => 'create'])

    {!! Form::close() !!}

@stop