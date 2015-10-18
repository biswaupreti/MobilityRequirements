@extends('layout')

@section('content')

    <div class="row" style="margin-top: 200px;">
        <div class="col-md-6" style="text-align: center;">
            <h1 class="title" style="">
                Mobility Requirements Tool <br/>for <br/>Mobile Apps.
            </h1>
        </div>
        <div class="col-md-6" style="border-left: 1px solid #777777;">

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="form-signin" role="form" method="POST" action="{{ url('/auth/login') }}">
                <h2 class="form-signin-heading">Please sign in</h2>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                    <label class="sr-only">E-Mail Address</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                </div>

                <div class="form-group">
                    <label class="sr-only">Password</label>
                    <input type="password" class="form-control" name="password">
                </div>

                {{--<div class="form-group">--}}
                    {{--<div class="checkbox">--}}
                        {{--<label>--}}
                            {{--<input type="checkbox" name="remember"> Remember Me--}}
                        {{--</label>--}}
                    {{--</div>--}}
                {{--</div>--}}

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Login</button>
                    <a class="btn btn-link" href="{{ url('/password/email') }}">Forgot Your Password?</a>
                </div>
            </form>
        </div>
    </div>
@endsection