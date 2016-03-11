<!DOCTYPE html>
<html>
    <head>
        <meta name="csrf-token" content="{{ Session::token() }}">
        <title>Mobility Requirement Analysis Tool</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-MfvZlkHCEqatNoGiOXveE8FIwMzZg4W85qfrfIFBfYc= sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ URL::asset('css/custom.css') }}" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="{{ URL::asset('dist/themes/bootstrap-stars.css') }}" />
        <script src="{{ URL::asset('js/jquery.barrating.js') }}"></script>
        <script src="{{ URL::asset('js/examples.js') }}"></script>
        <script src="{{ URL::asset('js/jquery.blockUI.js') }}"></script>
    </head>
    <body>
        <div class="container">
            <div class="content">

                @if(isset($authUser) && !empty($authUser->name))
                    <div class="row">
                        <div class="logo">
                            <h1><a href="{{ url('/') }}"> MoRE</a></h1>
                        </div>
                        <div class="user-info">
                            <a href="{{ url('/') }}">Dashboard </a>
                            | Welcome {{ $authUser->name }},
                            <a href="{{ url('/auth/logout') }}">Logout</a>
                        </div>
                    </div>
                @endif

                @if(isset($breadcrumbs))
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/') }}">Dashboard</a></li>
                        @foreach($breadcrumbs as $key => $url)
                            <li><a href="{{ url($url) }}">{{ $key }}</a></li>
                        @endforeach
                    </ol>
                @endif

                @if(Session::has('flash_message'))
                    <div class="alert alert-success">
                        {{ Session::get('flash_message') }}
                    </div>
                @endif

                @if(Session::has('flash_message_warning'))
                    <div class="alert alert-warning">
                        {{ Session::get('flash_message_warning') }}
                    </div>
                @endif

                @yield('content')

            </div>
        </div>
        @yield('footer')

        <script type="text/javascript">
            $(document).ready(function(){
                $('.alert').click(function(){
                    $(this).fadeOut('slow');
                });
            });
        </script>

    </body>
</html>
