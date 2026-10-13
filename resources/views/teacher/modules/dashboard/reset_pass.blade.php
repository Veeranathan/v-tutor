@extends('layouts.app')
@section('title')
<title>V-Tutor  | Tutor | Reset password</title>
@endsection
@section('left_part')
@include('include.header_menu_part')
@endsection
<body class="after-user">
	@section('content')
    <section class="makes_special_sec faq-sec">
        <div>
            <div class="makes_special_inr">
                 <!-- bannersec -->
                <div class="top_mar"></div>
                <!--- profile --->
                <section class="user-account">
                    <div class="container">
                        <div class="row">
                            <div class="zin">
                                    @include('include.teacher_left_common'){{-- left common part --}}

                                <div class="user-right-panel tutor-right">



                                    <div class="turo-edit">

                                    <div class="user-right-top">
                                        <h2 class="profile-heading d-flex align-items-center"> Reset Password <span><img src="{{ public_asset('assets/images/pencil.png')}}"></span></h2>
                                        <p>You can change your password in this section</p>
                                        <br>
                                        @include('include.errors')

                                        <form id="frm" method="post" action="{{route('tutor.update.password')}}">
                                        @csrf
                                        <div class="user-account-info">

                                                <div class="row new_rows no-gutters">
                                                    <div class="col-md-5 col-sm-6">
                                                        <div class="form_box_area">
                                                            <label>Current Password</label>
                                                            <input type="password" placeholder="Enter your current password "  name="old_password" id="old_password"> </div>
                                                            <span class="old_password-error error"></span>
                                                    </div>
                                                </div>
                                                <div class="row new_rows no-gutters">
                                                    <div class="col-md-5 col-sm-6">
                                                        <div class="form_box_area">
                                                            <label>New Password</label>
                                                            <input type="password" id="new_password" placeholder="Enter your new password" name="newPassword" >
                                                            <span class="new_password-error error"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row new_rows no-gutters">
                                                    <div class="col-md-5 col-sm-6">
                                                        <div class="form_box_area">
                                                            <label>Re-enter New Password</label>
                                                            <input type="password" id="confirm_password" placeholder="Confirm your new password" name="confirm">
                                                            <span class="confirm_password-error error"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row new_rows no-gutters">
                                                    <div class="col-md-12 col-sm-12 mt-5">
                                                        <hr class="das-hr">
                                                        <div class="footdashSec">
                                                            <input type="submit" name="" value="Reset Password" class="sub_btn2 text-center">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
	@endsection
	@section('footer')
	@include('include.footer')
	@endsection
	@section('script')
	@include('include.script')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js" integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg==" crossorigin="anonymous"></script>
         <script>
            $(document).ready(function(){
                $('#frm').validate({

                    rules:{
                        old_password:{
                            required:true,
                            minlength:6,
                        },
                        newPassword:{
                            required:true,
                            minlength:8,
                        },
                        confirm:{
                            required:true,
                            minlength:8,
                             equalTo : '[name="newPassword"]'
                        },

                    },
                    messages:{
                         old_password:{
                            required:" Old password is mandatory",
                            min:"Enter minimum 8 characters"
                        },
                         newPassword:{
                            required:" New password is mandatory",
                            min:"Enter minimum 8 characters"
                        },
                         confirm:{
                            required:" Confirm password is mandatory",
                            min:"Enter minimum 8 characters",
                            equalTo :"Passwords do not match"
                        },

                    },
                    submitHandler:function(form){
                        var old_password = $(this).val(),
                    reqData = {
                        'jsonrpc' : '2.0',
                        '_token'  : '{{csrf_token()}}',
                        'data'    :
                        {
                            'old_password'    : old_password
                        }
                    };
                    $.ajax({
                        url:"{{ route('tutor.check.old.password') }}",
                        dataType: 'json',
                        data: reqData,
                        type: 'post',
                        success:function(resp){
                            if(resp == false){

                                $(".old_password-error").html("Please provide correct password");
                                return false;
                            }else{
                                $(".old_password-error").html("");
                            }
                        }
                    });
                        var password = $("#new_password").val();
                        var conf_password = $("#confirm_password").val();
                        if(password != ""){
                            var pattern = /^.*(?=.{8,})(?=.*\d)(?=.*[A-Z])(?=.*[@#$%&?!*]).*$/;
                            if(pattern.test(password)){
                                $('#new_password-error').html('');
                                form.submit();
                            }else{
                                $('#new_password-error').html('Password must be at least 8 characters long and include at least 1 uppercase letter, 1 number, and 1 special character from the following: @, #, $, %, &, ? or !');
                                $('#new_password-error').css('display','block');
                                $("#new_password").val('');
                                return false;
                            }
                        }
                        if(conf_password != ""){
                            var pattern = /^.*(?=.{8,})(?=.*\d)(?=.*[A-Z])(?=.*[@#$%&?!*]).*$/;
                            if(pattern.test(conf_password)){
                                $('#confirm_password-error').html('');
                                form.submit();
                            }else{
                                $('#confirm_password-error').html('Password must be at least 8 characters long and include at least 1 uppercase letter, 1 number, and 1 special character from the following: @, #, $, %, &, ? or !');
                                $('#confirm_password-error').css('display','block');
                                $("#confirm_password").val('');
                                return false;
                            }
                        }
                    }
                });
                $(document).on("blur","#old_password",function(){
                    var old_password = $(this).val(),
                    reqData = {
                        'jsonrpc' : '2.0',
                        '_token'  : '{{csrf_token()}}',
                        'data'    :
                        {
                            'old_password'    : old_password
                        }
                    };
                    $.ajax({
                        url:"{{ route('tutor.check.old.password') }}",
                        dataType: 'json',
                        data: reqData,
                        type: 'post',
                        success:function(resp){
                            if(resp == false){
                                $(this).val("");
                                $(".old_password-error").html("Please provide correct password");
                            }else{
                                $(".old_password-error").html("");
                            }
                        }
                    });
                });
                $(document).on("blur","#new_password",function(){
                    var old_password = $(this).val(),
                    reqData = {
                        'jsonrpc' : '2.0',
                        '_token'  : '{{csrf_token()}}',
                        'data'    :
                        {
                            'old_password'    : old_password
                        }
                    };
                    $.ajax({
                        url:"{{ route('tutor.check.old.password') }}",
                        dataType: 'json',
                        data: reqData,
                        type: 'post',
                        success:function(resp){
                            if(resp == false){
                                $(this).val("");
                                $(".old_password-error").html("Please provide correct password");
                            }else{
                                $(".old_password-error").html("");
                            }
                        }
                    });
                    var password = $("#new_password").val();
                    var conf_password = $("#confirm_password").val();
                        if(password != ""){
                            var pattern = /^.*(?=.{8,})(?=.*\d)(?=.*[A-Z])(?=.*[@#$%&?!*]).*$/;
                            if(pattern.test(password)){
                                $('.new_password-error').html('');
                                form.submit();
                            }else{
                                $('.new_password-error').html('Password must be at least 8 characters long and include at least 1 uppercase letter, 1 number, and 1 special character from the following: @, #, $, %, &, ? or !');
                                $('.new_password-error').css('display','block');
                                $("#new_password").val('');
                                return false;
                            }
                        }
                        if(conf_password != ""){
                            var pattern = /^.*(?=.{8,})(?=.*\d)(?=.*[A-Z])(?=.*[@#$%&?!*]).*$/;
                            if(pattern.test(conf_password)){
                                $('.confirm_password-error').html('');
                                form.submit();
                            }else{
                                $('.confirm_password-error').html('Password must be at least 8 characters long and include at least 1 uppercase letter, 1 number, and 1 special character from the following: @, #, $, %, &, ? or !');
                                $('.confirm_password-error').css('display','block');
                                $("#confirm_password").val('');
                                return false;
                            }
                        }
                        if(password == conf_password && password != "" && conf_password != ""){
                            if(password != ""){
                                var pattern = /^.*(?=.{8,})(?=.*\d)(?=.*[A-Z])(?=.*[@#$%&?!*]).*$/;
                                if(pattern.test(password)){
                                    $('#new_password-error').html('');
                                    form.submit();
                                }else{
                                    $('#confirm_password-error').html('Password must be at least 8 characters long and include at least 1 uppercase letter, 1 number, and 1 special character from the following: @, #, $, %, &, ? or !');
                                    $('#confirm_password-error').css('display','block');
                                    $("#confirm_password").val('');
                                    $('#new_password-error').html('Password must be at least 8 characters long and include at least 1 uppercase letter, 1 number, and 1 special character from the following: @, #, $, %, &, ? or !');
                                    $('#new_password-error').css('display','block');
                                    $("#new_password").val('');
                                    return false;
                                }
                            }
                            else if(conf_password != ""){
                                var pattern = /^.*(?=.{8,})(?=.*\d)(?=.*[A-Z])(?=.*[@#$%&?!*]).*$/;
                                if(pattern.test(conf_password)){
                                    $('#confirm_password-error').html('');
                                    form.submit();
                                }else{
                                    $('#confirm_password-error').html('Password must be at least 8 characters long and include at least 1 uppercase letter, 1 number, and 1 special character from the following: @, #, $, %, &, ? or !');
                                    $('#confirm_password-error').css('display','block');
                                    $("#confirm_password").val('');
                                    $('#new_password-error').html('Password must be at least 8 characters long and include at least 1 uppercase letter, 1 number, and 1 special character from the following: @, #, $, %, &, ? or !');
                                    $('#new_password-error').css('display','block');
                                    $("#new_password").val('');
                                    return false;
                                }
                            }else{
                                form.submit();
                            }
                        }
                    else if(password != conf_password && password != "" && conf_password != ""){
                        $('#new_password-error').html('Passwords do not match');
                        $('#new_password-error').css('display','block');
                        $("#confirm_password").val('');
                        return false;
                    }
                    else if(password == ""){

                            $('#new_password-error').html('This field is required');
                            $('#new_password-error').css('display','block');
                            $("#new_password").val('');
                            return false;

                    }
                    else if(conf_password == ""){

                            $('#confirm_password-error').html('This field is required');
                            $('#confirm_password-error').css('display','block');
                            $("#confirm_password").val('');
                            return false;

                    }

                });
                $(document).on("blur","#confirm_password",function(){
                    var password = $("#new_password").val();
                    var conf_password = $("#confirm_password").val();
                    if(password != ""){
                        var pattern = /^.*(?=.{8,})(?=.*\d)(?=.*[A-Z])(?=.*[@#$%&?!*]).*$/;
                        if(pattern.test(password)){
                            $('.new_password-error').html('');

                        }else{
                            $('.new_password-error').html('Password must be at least 8 characters long and include at least 1 uppercase letter, 1 number, and 1 special character from the following: @, #, $, %, &, ? or !');
                            $('.new_password-error').css('display','block');
                            $("#new_password").val('');

                        }
                    }
                    if(conf_password != ""){
                        var pattern = /^.*(?=.{8,})(?=.*\d)(?=.*[A-Z])(?=.*[@#$%&?!*]).*$/;
                        if(pattern.test(conf_password)){
                            $('.confirm_password-error').html('');

                        }else{
                            $('.confirm_password-error').html('Password must be at least 8 characters long and include at least 1 uppercase letter, 1 number, and 1 special character from the following: @, #, $, %, &, ? or !');
                            $('.confirm_password-error').css('display','block');
                            $("#confirm_password").val('');

                        }
                    }
                    if(password == conf_password && password != "" && conf_password != ""){
                        if(password != ""){
                            var pattern = /^.*(?=.{8,})(?=.*\d)(?=.*[A-Z])(?=.*[@#$%&?!*]).*$/;
                            if(pattern.test(password)){
                                $('#new_password-error').html('');
                                form.submit();
                            }else{
                                $('#confirm_password-error').html('Password must be at least 8 characters long and include at least 1 uppercase letter, 1 number, and 1 special character from the following: @, #, $, %, &, ? or !');
                                $('#confirm_password-error').css('display','block');
                                $("#confirm_password").val('');
                                $('#new_password-error').html('Password must be at least 8 characters long and include at least 1 uppercase letter, 1 number, and 1 special character from the following: @, #, $, %, &, ? or !');
                                $('#new_password-error').css('display','block');
                                $("#new_password").val('');
                                return false;
                            }
                        }
                        else if(conf_password != ""){
                            var pattern = /^.*(?=.{8,})(?=.*\d)(?=.*[A-Z])(?=.*[@#$%&?!*]).*$/;
                            if(pattern.test(conf_password)){
                                $('#confirm_password-error').html('');
                                form.submit();
                            }else{
                                $('#confirm_password-error').html('Password must be at least 8 characters long and include at least 1 uppercase letter, 1 number, and 1 special character from the following: @, #, $, %, &, ? or !');
                                $('#confirm_password-error').css('display','block');
                                $("#confirm_password").val('');
                                $('#new_password-error').html('Password must be at least 8 characters long and include at least 1 uppercase letter, 1 number, and 1 special character from the following: @, #, $, %, &, ? or !');
                                $('#new_password-error').css('display','block');
                                $("#new_password").val('');
                                return false;
                            }
                        }else{
                            form.submit();
                        }
                    }
                    else if(password != conf_password && password != "" && conf_password != ""){
                        $('#new_password-error').html('Passwords do not match');
                        $('#new_password-error').css('display','block');
                        $("#confirm_password").val('');
                        return false;
                    }
                    else if(password == ""){

                            $('#new_password-error').html('This field is required');
                            $('#new_password-error').css('display','block');
                            $("#new_password").val('');
                            return false;

                    }
                    else if(conf_password == ""){

                            $('#confirm_password-error').html('This field is required');
                            $('#confirm_password-error').css('display','block');
                            $("#confirm_password").val('');
                            return false;

                    }
                });

            });
        </script>


	@endsection
