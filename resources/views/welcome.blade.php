@extends('layout')

@section('content')

    <div class="row" style="margin-top: 200px;">
        <div class="col-md-6" style="text-align: center;">
            <h1 class="title" style="">
                Mobility Requirements Tool <br/>for <br/>Mobile Apps.
            </h1>
        </div>
        <div class="col-md-6" style="border-left: 1px solid #777777;">
            {!! Form::open(['url' => '/auth/login', 'class' => 'form-signin']) !!}

            <h2 class="form-signin-heading">Please sign in</h2>

            {!! Form::label('email', 'Email Address', ['class' => 'sr-only']) !!}
            {!! Form::email('email', null, ['class' => 'form-control', 'required' => 'required', 'autofocus', 'placeholder' => 'Email Address']) !!}

            {!! Form::label('password', 'Password', ['class' => 'sr-only']) !!}
            {!! Form::password('password', ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Password']) !!}

            {!! Form::submit('Sign In', ['class' => 'btn btn-primary']) !!}

            <a href="#" style="float: right; line-height: 40px;">Forgot password?</a>

            {!! Form::close() !!}
        </div>
    </div>

@stop