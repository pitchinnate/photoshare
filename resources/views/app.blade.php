<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Kid Sport Pictures</title>

        <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/style.css') }}" rel="stylesheet">

        <!-- Fonts -->
        <link href='https://fonts.googleapis.com/css?family=Lato:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
                <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        @yield('header')
    </head>
    <body>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Kid Sport Pictures</a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        @if(Auth::guest())
                            <li><a href="/auth/login">Login</a></li>
                            <li><a href="/auth/register">Register</a></li>
                        @else
                            <li><a href="/albums">Albums</a></li>
                            @if(Request::user()->is_admin == 1)
                                <li><a href='/user'>Users</a></li>
                                <li><a href='/user/invite'>Invite User</a></li>
                            @endif
                            <li><a href="/password/update">Update Password</a></li>
                            <li><a href="/auth/logout">Logout</a></li>
                        @endif
                    </ul>

                    <ul class="nav navbar-nav navbar-right">

                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid">
            @if(Session::has('status'))
            <div class='alert alert-dismissable alert-info' role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {{Session::get('status')}}
            </div>
            @endif

            @if(Session::has('error'))
            <div class='alert alert-dismissable alert-error' role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {{Session::get('error')}}
            </div>
            @endif

            @if(Session::has('success'))
            <div class='alert alert-dismissable alert-success' role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {{Session::get('success')}}
            </div>
            @endif

            @yield('content')
        </div>

        <!-- Scripts -->
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>

        @yield('javascript')
    </body>
</html>
