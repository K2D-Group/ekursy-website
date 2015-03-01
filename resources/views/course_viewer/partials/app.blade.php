<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="shortcut icon" href="{{ asset('/favicon.ico') }}" type="image/x-icon">
        <link rel="icon" href="{{ asset('/favicon.ico') }}" type="image/x-icon">

        @if (isset($title))
            <title>{{ $title }} - {{ Config::get('app.name.full') }}</title>
        @else
            <title>{{ Config::get('app.name.full') }}</title>
        @endif

        {{--<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Varela+Round">--}}
        {{--<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Crete+Round">--}}
        {{--<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Source+Code+Pro">--}}
        {{--<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Lato:400,700,400italic">--}}
        <link rel="stylesheet" href="{{ asset('/assets/codex/css/bootswatch/flatly.min.css') }}">
        <link rel="stylesheet" href="{{ asset('/assets/codex/css/prettify/freshcut.css') }}">
        <link rel="stylesheet" href="{{ asset('/assets/codex/css/nano.css') }}">
        <link rel="stylesheet" href="{{ asset('/assets/codex/css/codex.css') }}">


    </head>
    <body>
        {{--@include('partials.analytics_tracking')--}}
        @include('course_viewer.partials.navbar')
        <div id="wrapper">
            @include('course_viewer.partials.sidebar')

            <div id="page-content-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
        <!-- Javascript -->
        <script src="{{ asset('/assets/codex/js/jquery-2.1.1.min.js') }}"></script>
        <script src="{{ asset('/assets/codex/js/jquery.nanoscroller.min.js') }}"></script>
        <script src="{{ asset('/assets/codex/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('/assets/codex/js/prettify/run_prettify.js') }}"></script>
        <script src="{{ asset('/assets/codex/js/codex.js') }}"></script>
    </body>
</html>





{{--<!DOCTYPE html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
	{{--<meta charset="utf-8">--}}
	{{--<meta http-equiv="X-UA-Compatible" content="IE=edge">--}}
	{{--<meta name="viewport" content="width=device-width, initial-scale=1">--}}
	{{--<title>Laravel</title>--}}

	{{--<link href="/css/app.css" rel="stylesheet">--}}

	{{--<!-- Fonts -->--}}
	{{--<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>--}}

	{{--<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->--}}
	{{--<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->--}}
	{{--<!--[if lt IE 9]>--}}
		{{--<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>--}}
		{{--<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>--}}
	{{--<![endif]-->--}}
{{--</head>--}}
{{--<body>--}}
	{{--<nav class="navbar navbar-default">--}}
		{{--<div class="container-fluid">--}}
			{{--<div class="navbar-header">--}}
				{{--<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">--}}
					{{--<span class="sr-only">Toggle Navigation</span>--}}
					{{--<span class="icon-bar"></span>--}}
					{{--<span class="icon-bar"></span>--}}
					{{--<span class="icon-bar"></span>--}}
				{{--</button>--}}
				{{--<a class="navbar-brand" href="#">Laravel</a>--}}
			{{--</div>--}}

			{{--<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">--}}
				{{--<ul class="nav navbar-nav">--}}
					{{--<li><a href="/">Home</a></li>--}}
				{{--</ul>--}}

				{{--<ul class="nav navbar-nav navbar-right">--}}
					{{--@if (Auth::guest())--}}
						{{--<li><a href="/auth/login">Login</a></li>--}}
						{{--<li><a href="/auth/register">Register</a></li>--}}
					{{--@else--}}
						{{--<li class="dropdown">--}}
							{{--<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>--}}
							{{--<ul class="dropdown-menu" role="menu">--}}
								{{--<li><a href="/auth/logout">Logout</a></li>--}}
							{{--</ul>--}}
						{{--</li>--}}
					{{--@endif--}}
				{{--</ul>--}}
			{{--</div>--}}
		{{--</div>--}}
	{{--</nav>--}}

	{{--@yield('content')--}}

	{{--<!-- Scripts -->--}}
	{{--<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>--}}
	{{--<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>--}}
{{--</body>--}}
{{--</html>--}}
