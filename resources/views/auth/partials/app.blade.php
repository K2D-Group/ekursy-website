<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">

    @if (isset($title))
        <title>{{ $title }} - K2D</title>
    @else
        <title>K2D</title>
    @endif

    <meta name="robots" content="noindex, nofollow">

    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0">

    {{--<!-- Icons -->--}}
    {{--<!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->--}}
    {{--<link rel="shortcut icon" href="img/favicon.png">--}}
    {{--<link rel="apple-touch-icon" href="img/icon57.png" sizes="57x57">--}}
    {{--<link rel="apple-touch-icon" href="img/icon72.png" sizes="72x72">--}}
    {{--<link rel="apple-touch-icon" href="img/icon76.png" sizes="76x76">--}}
    {{--<link rel="apple-touch-icon" href="img/icon114.png" sizes="114x114">--}}
    {{--<link rel="apple-touch-icon" href="img/icon120.png" sizes="120x120">--}}
    {{--<link rel="apple-touch-icon" href="img/icon144.png" sizes="144x144">--}}
    {{--<link rel="apple-touch-icon" href="img/icon152.png" sizes="152x152">--}}
    {{--<link rel="apple-touch-icon" href="img/icon180.png" sizes="180x180">--}}
    {{--<!-- END Icons -->--}}


    <link rel="stylesheet" href="{{ elixir('assets/backend.css') }}">

    <!-- Modernizr (browser feature detection library) & Respond.js (enables responsive CSS code on browsers that don't support it, eg IE8) -->
    <script src="{{ asset('assets/backend-js/vendor/modernizr-respond.min.js') }}"></script>
</head>
<body>
<!-- Login Alternative Row -->
<div class="container">
    <div class="row">
        <div class="col-md-5 col-md-offset-1">
            <div id="login-alt-container">
                <!-- Title -->
                <h1 class="push-top-bottom">
                    <strong>LOGO K2D</strong><br>
                    <small>TU SLOGAN ORAZ CO OFERUJEMY</small>
                </h1>
                <!-- END Title -->

                <!-- Key Features -->
                <ul class="fa-ul text-muted">
                    <li><i class="fa fa-check fa-li text-success"></i> AAAAA</li>
                    <li><i class="fa fa-check fa-li text-success"></i> AAAAA</li>
                    <li><i class="fa fa-check fa-li text-success"></i> AAAAA</li>
                    <li><i class="fa fa-check fa-li text-success"></i> AAAAA</li>
                    <li><i class="fa fa-check fa-li text-success"></i> AAAAA</li>
                    <li><i class="fa fa-check fa-li text-success"></i> AAAAA</li>
                    <li><i class="fa fa-check fa-li text-success"></i> AAAAA</li>
                    <li><i class="fa fa-check fa-li text-success"></i> AAAAA</li>
                    <li><i class="fa fa-check fa-li text-success"></i> AAAAA</li>
                    <li><i class="fa fa-check fa-li text-success"></i> AAAAA</li>
                </ul>
                <!-- END Key Features -->

                <!-- Footer -->
                <footer class="text-muted push-top-bottom">
                    <small>2015&copy; <a href="http://ekursy.cf/k2d" target="_blank">K2D</a></small>
                </footer>
                <!-- END Footer -->
            </div>
        </div>
        @yield('content')
    </div>
</div>
<!-- END Login Alternative Row -->

{{--<!-- Modal Terms -->--}}
{{--<div id="modal-terms" class="modal" tabindex="-1" role="dialog" aria-hidden="true">--}}
    {{--<div class="modal-dialog">--}}
        {{--<div class="modal-content">--}}
            {{--<div class="modal-header">--}}
                {{--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>--}}
                {{--<h4 class="modal-title">Terms &amp; Conditions</h4>--}}
            {{--</div>--}}
            {{--<div class="modal-body">--}}
                {{--<h4>Title</h4>--}}
                {{--<p>Donec lacinia venenatis metus at bibendum? In hac habitasse platea dictumst. Proin ac nibh rutrum lectus rhoncus eleifend. Sed porttitor pretium venenatis. Suspendisse potenti. Aliquam quis ligula elit. Aliquam at orci ac neque semper dictum. Sed tincidunt scelerisque ligula, et facilisis nulla hendrerit non. Suspendisse potenti. Pellentesque non accumsan orci. Praesent at lacinia dolor. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>--}}
                {{--<p>Donec lacinia venenatis metus at bibendum? In hac habitasse platea dictumst. Proin ac nibh rutrum lectus rhoncus eleifend. Sed porttitor pretium venenatis. Suspendisse potenti. Aliquam quis ligula elit. Aliquam at orci ac neque semper dictum. Sed tincidunt scelerisque ligula, et facilisis nulla hendrerit non. Suspendisse potenti. Pellentesque non accumsan orci. Praesent at lacinia dolor. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>--}}
                {{--<h4>Title</h4>--}}
                {{--<p>Donec lacinia venenatis metus at bibendum? In hac habitasse platea dictumst. Proin ac nibh rutrum lectus rhoncus eleifend. Sed porttitor pretium venenatis. Suspendisse potenti. Aliquam quis ligula elit. Aliquam at orci ac neque semper dictum. Sed tincidunt scelerisque ligula, et facilisis nulla hendrerit non. Suspendisse potenti. Pellentesque non accumsan orci. Praesent at lacinia dolor. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>--}}
                {{--<p>Donec lacinia venenatis metus at bibendum? In hac habitasse platea dictumst. Proin ac nibh rutrum lectus rhoncus eleifend. Sed porttitor pretium venenatis. Suspendisse potenti. Aliquam quis ligula elit. Aliquam at orci ac neque semper dictum. Sed tincidunt scelerisque ligula, et facilisis nulla hendrerit non. Suspendisse potenti. Pellentesque non accumsan orci. Praesent at lacinia dolor. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>--}}
                {{--<h4>Title</h4>--}}
                {{--<p>Donec lacinia venenatis metus at bibendum? In hac habitasse platea dictumst. Proin ac nibh rutrum lectus rhoncus eleifend. Sed porttitor pretium venenatis. Suspendisse potenti. Aliquam quis ligula elit. Aliquam at orci ac neque semper dictum. Sed tincidunt scelerisque ligula, et facilisis nulla hendrerit non. Suspendisse potenti. Pellentesque non accumsan orci. Praesent at lacinia dolor. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>--}}
                {{--<p>Donec lacinia venenatis metus at bibendum? In hac habitasse platea dictumst. Proin ac nibh rutrum lectus rhoncus eleifend. Sed porttitor pretium venenatis. Suspendisse potenti. Aliquam quis ligula elit. Aliquam at orci ac neque semper dictum. Sed tincidunt scelerisque ligula, et facilisis nulla hendrerit non. Suspendisse potenti. Pellentesque non accumsan orci. Praesent at lacinia dolor. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}
{{--<!-- END Modal Terms -->--}}


<script src="{{ elixir('assets/backend-js/all.js') }}"></script>

<!-- Load and execute javascript code used only in this page -->
<script src="{{ asset('assets/backend-js/pages/login.js') }}"></script>
<script>$(function(){ Login.init(); });</script>
</body>
</html>