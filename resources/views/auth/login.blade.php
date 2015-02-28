@extends('auth.partials.app')

@section('content')
<div class="col-md-5">
    <!-- Login Container -->
    <div id="login-container">
        <!-- Login Title -->
        <div class="login-title text-center">
            <h1><strong>Login</strong> or <strong>Register</strong></h1>
        </div>
        <!-- END Login Title -->

        <!-- Login Block -->
        <div class="block push-bit">
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
            <!-- Login Form -->
            <form class="form-horizontal" role="form" method="POST" action="{{ route('auth.login') }}" id="form-login">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <div class="col-xs-12">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="gi gi-envelope"></i></span>
                            <input type="email" id="login-email" class="form-control input-lg" name="email" value="{{ old('email') }}" placeholder="Email">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="gi gi-asterisk"></i></span>
                            <input type="password" id="login-password" name="password" class="form-control input-lg" placeholder="Password">
                        </div>
                    </div>
                </div>
                <div class="form-group form-actions">
                    <div class="col-xs-4">
                        <label class="switch switch-primary" data-toggle="tooltip" title="Remember Me?">
                            <input type="checkbox" id="login-remember-me" name="remember" checked>
                            <span></span>
                        </label>
                    </div>
                    <div class="col-xs-8 text-right">
                        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> Login to Dashboard</button>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12 text-center">
                        <a href="javascript:void(0)" id="link-reminder-login"><small>Forgot password?</small></a> -
                        <a href="javascript:void(0)" id="link-register-login"><small>Create a new account</small></a>
                    </div>
                </div>
            </form>
            <!-- END Login Form -->

            {{--<!-- Reminder Form -->--}}
            {{--<form action="login_alt.html#reminder" method="post" id="form-reminder" class="form-horizontal display-none">--}}
                {{--<div class="form-group">--}}
                    {{--<div class="col-xs-12">--}}
                        {{--<div class="input-group">--}}
                            {{--<span class="input-group-addon"><i class="gi gi-envelope"></i></span>--}}
                            {{--<input type="text" id="reminder-email" name="reminder-email" class="form-control input-lg" placeholder="Email">--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="form-group form-actions">--}}
                    {{--<div class="col-xs-12 text-right">--}}
                        {{--<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> Reset Password</button>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="form-group">--}}
                    {{--<div class="col-xs-12 text-center">--}}
                        {{--<small>Did you remember your password?</small> <a href="javascript:void(0)" id="link-reminder"><small>Login</small></a>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</form>--}}
            {{--<!-- END Reminder Form -->--}}

            {{--<!-- Register Form -->--}}
            {{--<form action="login_alt.html#register" method="post" id="form-register" class="form-horizontal display-none">--}}
                {{--<div class="form-group">--}}
                    {{--<div class="col-xs-6">--}}
                        {{--<div class="input-group">--}}
                            {{--<span class="input-group-addon"><i class="gi gi-user"></i></span>--}}
                            {{--<input type="text" id="register-firstname" name="register-firstname" class="form-control input-lg" placeholder="Firstname">--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="col-xs-6">--}}
                        {{--<input type="text" id="register-lastname" name="register-lastname" class="form-control input-lg" placeholder="Lastname">--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="form-group">--}}
                    {{--<div class="col-xs-12">--}}
                        {{--<div class="input-group">--}}
                            {{--<span class="input-group-addon"><i class="gi gi-envelope"></i></span>--}}
                            {{--<input type="text" id="register-email" name="register-email" class="form-control input-lg" placeholder="Email">--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="form-group">--}}
                    {{--<div class="col-xs-12">--}}
                        {{--<div class="input-group">--}}
                            {{--<span class="input-group-addon"><i class="gi gi-asterisk"></i></span>--}}
                            {{--<input type="password" id="register-password" name="register-password" class="form-control input-lg" placeholder="Password">--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="form-group">--}}
                    {{--<div class="col-xs-12">--}}
                        {{--<div class="input-group">--}}
                            {{--<span class="input-group-addon"><i class="gi gi-asterisk"></i></span>--}}
                            {{--<input type="password" id="register-password-verify" name="register-password-verify" class="form-control input-lg" placeholder="Verify Password">--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="form-group form-actions">--}}
                    {{--<div class="col-xs-6">--}}
                        {{--<a href="#modal-terms" data-toggle="modal" class="register-terms">Terms</a>--}}
                        {{--<label class="switch switch-primary" data-toggle="tooltip" title="Agree to the terms">--}}
                            {{--<input type="checkbox" id="register-terms" name="register-terms">--}}
                            {{--<span></span>--}}
                        {{--</label>--}}
                    {{--</div>--}}
                    {{--<div class="col-xs-6 text-right">--}}
                        {{--<button type="submit" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Register Account</button>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="form-group">--}}
                    {{--<div class="col-xs-12 text-center">--}}
                        {{--<small>Do you have an account?</small> <a href="javascript:void(0)" id="link-register"><small>Login</small></a>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</form>--}}
            {{--<!-- END Register Form -->--}}
        </div>
        <!-- END Login Block -->
    </div>
    <!-- END Login Container -->
</div>
@endsection
