<!DOCTYPE html>
<html>
    <head>
        <title>Mobility Requirement Analysis Tool</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-MfvZlkHCEqatNoGiOXveE8FIwMzZg4W85qfrfIFBfYc= sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ URL::asset('css/custom.css') }}" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="content">

                @if(isset($authUser) && !empty($authUser->name))
                    <div class="user-info">Welcome {{ $authUser->name }}, <a href="{{ url('/auth/logout') }}">Logout</a></div>
                @endif

                @yield('content')
            </div>
        </div>
        @yield('footer')
    </body>
</html>
