@extends('layouts.app')



@section('title')
<title>V-Tutor  | New Password</title>
@endsection

@section('left_part')
{{-- @include('include.left_part') --}}
@include('include.header_menu_part')
@endsection




@section('content')
<!-- bannersec -->

<div class="top_mar"></div>


<section class="login-body">

	<div class="login-info">
		<div class="login-details">
			<div class="upper-login">

				<h2>Forgot Password</h2>
				<p>Please enter your new password</p>
                <br>
				@include('include.errors')
			</div>
			<div class="login-from">
				<form action="{{route('user.new.password')}}" method="post" id="frm">
					@csrf
					 <input type="hidden" name="id" value="{{@$data->id}}">
					<div class="form_area">
                        <input type="password" id="password" class="texxt_box" placeholder="Password" name="password">
                        <div class="error_password error"></div>
                    </div>
                    <div class="form_area">
                        <input type="password" id="con_password" class="texxt_box" placeholder="Confirm password" name="con_password">
                        <div class="error_confirm_password error"></div>
                    </div>
                    <input type="submit" name="" value="Submit" class="submit-login">

			</div>
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
                jQuery.validator.addMethod("emailonly", function(value, element) {
    return this.optional(element) || /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/.test(value.toLowerCase());
    }, "Enter valid email");



                $('#frm').validate({

                    rules:{


                         password:{
                            required:true,
                            minlength:8

                        },
                        con_password:{
                            required:true,
                           minlength:8,
                             equalTo : '[name="password"]'
                        },



                    },
                    messages:{
                        ph:{
                        required:'Please enter the mobile number',
                        minlength:'Mobile number can have minimum 10 digits',
                        maxlength:'Mobile number can have maximum 10 digits',
                        mobileonly:'enter valid mobile number',
                         remote:"This mobile number already exists.!",
                        },
                        con_password:{
                             equalTo : 'Password donot match'
                        },

                    },
                    submitHandler:function(form){
                        var password = $("#password").val();
                        var conf_password = $("#confirm_password").val();
                        if(password != ""){
                            var pattern = /^.*(?=.{8,})(?=.*\d)(?=.*[A-Z])(?=.*[@#$%&?!*]).*$/;
                            if(pattern.test(password)){
                                $('.error_password').html('');
                                form.submit();
                            }else{
                                $('.error_password').html('Password must be at least 8 characters long and include at least 1 uppercase letter, 1 number, and 1 special character from the following: @, #, $, %, &, ? or !');
                                $('.error_password').css('display','block');
                                $(".error_password").val('');
                                return false
                            }
                        }
                        if(conf_password != ""){
                            var pattern = /^.*(?=.{8,})(?=.*\d)(?=.*[A-Z])(?=.*[@#$%&?!*]).*$/;
                            if(pattern.test(conf_password)){
                                $('.error_confirm_password').html('');
                                form.submit();
                            }else{
                                $('.error_confirm_password').html(' Password must be at least 8 characters long and include at least 1 uppercase letter, 1 number, and 1 special character from the following: @, #, $, %, &, ? or !');
                                $('.error_confirm_password').css('display','block');
                                $(".error_confirm_password").val('');
                                return false;
                            }
                        }
                    }
                });
                $(document).on("blur","#password",function(){
                    var password = $("#password").val();
                    var conf_password = $("#confirm_password").val();
                    if(password != ""){
                        var pattern = /^.*(?=.{8,})(?=.*\d)(?=.*[A-Z])(?=.*[@#$%&?!*]).*$/;
                        if(pattern.test(password)){
                            $('.error_password').html('');

                        }else{
                            $('.error_password').html('Password must be at least 8 characters long and include at least 1 uppercase letter, 1 number, and 1 special character from the following: @, #, $, %, &, ? or !');
                            $('.error_password').css('display','block');
                            $(".error_password").val('');

                        }
                    }
                    if(conf_password != ""){
                        var pattern = /^.*(?=.{8,})(?=.*\d)(?=.*[A-Z])(?=.*[@#$%&?!*]).*$/;
                        if(pattern.test(conf_password)){
                            $('.error_confirm_password').html('');
                        }else{
                            $('.error_confirm_password').html(' Password must be at least 8 characters long and include at least 1 uppercase letter, 1 number, and 1 special character from the following: @, #, $, %, &, ? or !');
                            $('.error_confirm_password').css('display','block');
                            $(".error_confirm_password").val('');

                        }
                    }
                });
                $(document).on("blur","#confirm_password",function(){
                    var password = $("#password").val();
                    var conf_password = $("#confirm_password").val();
                    if(password != ""){
                        var pattern = /^.*(?=.{8,})(?=.*\d)(?=.*[A-Z])(?=.*[@#$%&?!*]).*$/;
                        if(pattern.test(password)){
                            $('.error_password').html('');

                        }else{
                            $('.error_password').html('Password must be at least 8 characters long and include at least 1 uppercase letter, 1 number, and 1 special character from the following: @, #, $, %, &, ? or !');
                            $('.error_password').css('display','block');
                            $(".error_password").val('');

                        }
                    }
                    if(conf_password != ""){
                        var pattern = /^.*(?=.{8,})(?=.*\d)(?=.*[A-Z])(?=.*[@#$%&?!*]).*$/;
                        if(pattern.test(conf_password)){
                            $('.error_confirm_password').html('');

                        }else{
                            $('.error_confirm_password').html(' Password must be at least 8 characters long and include at least 1 uppercase letter, 1 number, and 1 special character from the following: @, #, $, %, &, ? or !');
                            $('.error_confirm_password').css('display','block');
                            $(".error_confirm_password").val('');

                        }
                    }
                });
            });
        </script>
@endsection

