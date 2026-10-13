<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="V-Tutor Admin Login">
    <meta name="author" content="V-Tutor Admin Login">
    {{-- <link rel="icon" href="{{ public_asset('admin/assets/images/favicon.ico') }}" type="image/x-icon" />
    <link rel="shortcut icon" href="{{ public_asset('admin/assets/images/favicon.ico') }}" type="image/x-icon" /> --}}
    <link rel="icon" href="{{ public_asset('assets/images/favicon.ico')}}" type="image/x-icon" />
    <link rel="shortcut icon" href="{{ public_asset('assets/images/favicon.ico')}}" type="image/x-icon" />
    <link rel="icon" href="{{ public_asset('assets/images/favicon.png') }}" sizes="32x32">
    <link rel="icon" href="{{ public_asset('assets/images/favicon.png') }}" sizes="96x96">
    <link rel="icon" href="{{ public_asset('assets/images/favicon.png') }}" sizes="192x192">
    <link rel="apple-touch-icon" href="{{ public_asset('assets/images/favicon.png') }}">
    <meta name="msapplication-TileImage" content="{{ public_asset('assets/images/favicon.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ public_asset('assets/images/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ public_asset('assets/images/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ public_asset('assets/images/favicon-16x16.png') }}">
    <title>V-Tutor </title>
    <link href="{{ public_asset('admin/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ public_asset('admin/assets/css/core.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ public_asset('admin/assets/css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ public_asset('admin/assets/css/responsive.css') }}" rel="stylesheet" type="text/css">
    <style type="text/css">
    .alert-success {
    color: #fff;
    background-color: #d73c5e;
    border-color: #d73c5e;
}
.alert .close{color: #fff;}
.toast-container{
  background-color: #d73c5e;
}
.toast-success{
  background-color: #d73c5e;
}
</style>
</head>
    <body>


        <div class="wrapper-page">
            <div class="panel panel-color panel-primary panel-pages">
                <div class="panel-heading rm08">
                    <a href="{{ route('admin.login') }}"><img src="{{ public_asset('admin/assets/images/v_tutor_admin_logo.svg') }}" alt=""></a>
                    {{-- <a href="{{ route('admin.login') }}"><img src="{{ public_asset('admin/assets/images/logo.png') }}" alt=""></a> --}}
                </div>
                <div class="panel-body">
                    @include('admin.includes.message')
                <form class="form-horizontal m-t-20" id="loginForm" method="POST" action="{{ route('admin.login') }}" autocomplete="off">
                    @csrf
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control input-lg {{ $errors->has('email') ? ' is-invalid' : '' }} required" name="email" id="email" type="text" placeholder="Email" value="{{ @$email }}" autocomplete="false" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control input-lg {{ $errors->has('password') ? ' is-invalid' : '' }} required" id="password" name="password" type="password"  placeholder="Password" value="{{@$password}}" autosave="off" autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="checkbox checkbox-primary">
                                <input id="checkbox-signup" type="checkbox" name="remember" {{ @$remember ? 'checked' : '' }} value="on" autosave="off" autocomplete="false" >
                                <label for="checkbox-signup">
                                    Remember me
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center m-t-40">
                        <div class="col-xs-12">
                            <input type="submit" class="btn btn-primary btn-lg w-lg waves-effect waves-light rm01" value="Log In">
                           {{-- <a href="{{ route('admin.login') }}" class="btn btn-primary btn-lg w-lg waves-effect waves-light rm01" type="submit">Log In</a> --}}
                        </div>
                    </div>

                    {{-- <div class="form-group m-t-30">
                        <div class="col-sm-12">
                            <a href="{{ route('admin.password.request') }}" class="rm01"><i class="fa fa-lock m-r-5"></i> Forgot your password?</a>
                        </div>
                    </div> --}}
                </form>
                </div>

            </div>
        </div>

        <!-- Main  -->
        <script src="{{ public_asset('admin/assets/js/jquery.min.js') }}"></script>
        <script src="{{ public_asset('admin/assets/js/bootstrap.min.js') }}"></script>
        <script src="{{public_asset('admin/assets/js/jquery.validate.js')}}"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $('#loginForm').validate({
                    rules: {
                        email: { required: true,email:true},
                        password: { required: true},
                    },
                    submitHandler:function(form){

                       form.submit();

                    },
                });
            });
        </script>
    </body>
</html>
