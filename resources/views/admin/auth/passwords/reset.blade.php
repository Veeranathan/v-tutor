<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="description" content="Vtutor Admin Reset Password">
<meta name="author" content="Vtutor Admin Reset Password">
{{-- <link rel="shortcut icon" href="{{public_asset('admin/assets/images/favicon_1.png')}}"> --}}
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
<style type="text/css">
    .alert-success {
    color: #fff;
    background-color: #b80f0a;
    border-color: #b80f0a;
}
.alert .close{color: #fff;}
.toast-container{
  background-color: #d73c5e;
}
.toast-success{
  background-color: #d73c5e;
}
</style>
<title>Admin::Reset Password</title>
@include('admin.includes.links')
</head>
<body>
    <div class="wrapper-page">
        <div class="panel panel-color panel-primary panel-pages">
            <div class="panel-heading rm08">
                <img src="{{public_asset('admin/assets/images/Logo.png')}}" alt="">
            </div>
            <div class="panel-body">
                @include('admin.includes.message')
                <form method="POST" action="{{route('admin.password.update') }}" id="Reset">
                @csrf
                <input type="hidden" name="id" value="{{@$token}}">
                <div class="form-group">
                    <div class="col-xs-12">
                        <input class="form-control form-control-lg" id="password" type="password" name="password" placeholder="Password">
                        <label id="password-error" class="error"></label>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <input class="form-control form-control-lg required" id="confirm_password" type="password" placeholder="confirm password" name="confirm_password">
                        <label id="confirm_password-error" class="error"></label>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group text-center m-t-40">
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-primary btn-lg btn-block">Reset Password</button>
                    </div>
                    <div class="clearfix"></div>
                </div>
                    <div class="form-group m-t-30">
                        <div class="col-sm-12">
                            <a href="{{ route('admin.login')}}" class="rm01">Login</a>
                        </div>
                        <div class="clearfix"></div>

                    </div>
                </form>

                </div>
            </div>
        </div>
@include('admin.includes.script')
<script>
$(document).ready(function(){
    validator = $('#Reset').validate({
        rules:{
        password: { required: true,minlength:8},
        confirm_password : {equalTo : "#password",minlength:8}
       },
       messages:{

            con_password:{
                equalTo:"Passwords do not match"
            },
        },
       submitHandler:function(form){
            var password = $("#password").val();
            var conf_password = $("#confirm_password").val();
            if(password == conf_password && password != "" && conf_password != ""){
                if(password != ""){
                    var pattern = /^.*(?=.{8,})(?=.*\d)(?=.*[A-Z])(?=.*[@#$%&?!*]).*$/;
                    if(pattern.test(password) && pattern.test(conf_password)){
                        $('#password-error').html('');
                        form.submit();
                    }else{
                        $('#password-error').html('Password must be at least 8 characters long and include at least 1 uppercase letter, 1 number, and 1 special character from the following: @, #, $, %, &, ? or !');
                        $('#password-error').css('display','block');
                        $("#password").val('');
                        $('#confirm_password-error').html('Password must be at least 8 characters long and include at least 1 uppercase letter, 1 number, and 1 special character from the following: @, #, $, %, &, ? or !');
                        $('#confirm_password-error').css('display','block');
                        $("#confirm_password").val('');
                        return false;
                    }
                }
                else if(conf_password != ""){
                    var pattern = /^.*(?=.{8,})(?=.*\d)(?=.*[A-Z])(?=.*[@#$%&?!*]).*$/;
                    if(pattern.test(conf_password)){
                        $('#confirm_password-error').html('');
                        form.submit();
                    }else{
                        $('#password-error').html('Password must be at least 8 characters long and include at least 1 uppercase letter, 1 number, and 1 special character from the following: @, #, $, %, &, ? or !');
                        $('#password-error').css('display','block');
                        $("#password").val('');
                        $('#confirm_password-error').html('Password must be at least 8 characters long and include at least 1 uppercase letter, 1 number, and 1 special character from the following: @, #, $, %, &, ? or !');
                        $('#confirm_password-error').css('display','block');
                        $("#confirm_password").val('');
                        return false;
                    }
                }else{
                    form.submit();
                }
            }
            else if(password != conf_password && password != "" && conf_password != ""){
                $('#password-error').html('Passwords do not match');
                $('#password-error').css('display','block');
                $("#confirm_password").val('');
                return false;
            }
            else if(password == ""){
                $('#password-error').html('This field is required');
                $('#password-error').css('display','block');
                $("#password").val('');
                return false;
            }
            else if(conf_password == ""){

                    $('#confirm_password-error').html('This field is required');
                    $('#confirm_password-error').css('display','block');
                    $("#confirm_password").val('');
                    return false;

            }
           // form.submit();
        },
    });

});
</script>
</body>
</html>
