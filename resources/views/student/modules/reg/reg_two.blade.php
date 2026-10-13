@extends('layouts.app')



@section('title')
<title>V-tutor | User | Registration</title>
@endsection

@section('left_part')
{{-- @include('include.left_part') --}}
@include('include.header_menu_part')
@endsection




@section('content')
<!-- bannersec -->

<div class="top_mar"></div>


<section class="login-body studant-body">

    <div class="login-info">
        <div class="login-details">
            <div class="upper-login">
                <h2>Student Sign Up</h2>
                <p>Please fill in the below fields to continue</p>
            </div>
             @include('include.errors')
            <div class="login-from">
                <form method="post" action="{{route('user.reg.two')}}" id="frm">
                    @csrf
                    <input type="hidden" name="student_id" value="{{@$user_details->id}}">
                    <div class="im-sec">
                        <h3>I'm a </h3>
                        <ul>
                            <li>
                                <input type="radio" id="radio1" name="radios" value="P" checked="">
                                <label for="radio1">Parent </label>
                            </li>
                            <li>
                                <input type="radio" id="radio2" name="radios" value="G">
                                <label for="radio2">Guardian</label>
                            </li>
                           {{--  <li>
                                <input type="radio" id="radio3" name="radios" value="S" checked="">
                                <label for="radio3">Student</label>
                            </li> --}}
                        </ul>
                    </div>
                    <div class="double-from">
                        <div class="form_area">
                            <input type="text" class="texxt_box" placeholder="First Name" name="f_name" value="{{@$user_details->f_name}}" disabled>
                        </div>
                        <div class="form_area">
                            <input type="text" class="texxt_box" placeholder="Last Name" name="l_name" value="{{@$user_details->l_name}}" disabled>
                        </div>
                    </div>
                    <div class="form_area">
                            <input type="email" class="texxt_box" placeholder="Email address" name="email" value="{{@$user_details->email}}"
                            @if(@$user_details->email) disabled @endif >
                        </div>
                    <div class="form_area">
                            <input type="tel" class="texxt_box" placeholder="Mobile Number " name="ph" id="ph">
                        </div>
                   {{--  <div class="double-from">
                        <div class="form_area">
                            <div class="password-in">
                                <input id="password-field" type="password" class="texxt_box" name="password" placeholder="Password">
                                <div class="clearfix"></div>
                                <span toggle="#password-field" class="field-icon fa fa-fw fa-eye toggle-password"></span>
                            </div>
                        </div>
                        <div class="form_area">
                            <div class="password-in">
                                <input id="password-field2" type="password" class="texxt_box" name="con_password" placeholder="Password">
                                <div class="clearfix"></div>
                                <span toggle="#password-field2" class="field-icon fa fa-fw fa-eye toggle-password"></span>
                            </div>
                        </div>
                    </div> --}}
                     <div class="check-box">
                        <input type="checkbox" id="checkbox1" name="checkbox1" value="all" >
                        <label for="checkbox1" class="checklabeel">I have read and agree to V-Tutor <a href="{{ url('privacy-policy') }}" target="_blank"> Privacy Policy </a> and <a href="{{ url('terms-conditions') }}" target="_blank"> Terms & Conditions </a></label>
                    </div>
                    <div class="check-box">
                        <input type="checkbox" id="checkbox2" name="checkbox2" value="all">
                        <label for="checkbox2" class="checklabeel">I confirm that I’m over 18 years of age. I’m a parent / guardian for the student and consent to operate this account legally on  behalf of my ward</label>
                    </div>
                    <input type="submit" name="" value="Sign me up" class="submit-login disable-input" disabled="">
                </form>
                   {{-- <div class="or-area">
                        <span>or continue with</span>
                     </div>

                    <div class="socials-btns">
                        <a href="{{route('login.social',['user_type'=>'student','provider_type'=>'google'])}}" class="common-btns  google-btn">
                           <img src="{{ public_asset('assets/images/login-google.png')}}" alt=""> Google
                        </a>
                        <a href="{{route('login.social',['user_type'=>'student','provider_type'=>'facebook'])}}" class="common-btns facebook-btn">
                           <img src="{{ public_asset('assets/images/login-facebook.png')}}" alt=""> Facebook
                        </a>

                     </div> --}}
                    {{--  <div class="fort-pass">
                        <a href="#">Forgot password?</a>
                     </div>
                     <div class="bottom-account-div">
                     <p>Already have an account? <a href="{{route('login')}}">Log in</a></p>
                  </div> --}}
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

                jQuery.validator.addMethod("mobileonly", function(value, element) {
    return this.optional(element) ||  /^[+]?\d+$/.test(value.toLowerCase());
    }, "Enter valid number");


                $('#frm').validate({

                    rules:{
                        f_name:{
                            required:true,
                            minlength:3,
                        },
                        l_name:{
                            required:true,
                            minlength:3,
                        },
                        email:{
                            required:true,
                            emailonly: true,
                        },
                        //  password:{
                        //     required:true,
                        //     minlength:6

                        // },
                        // con_password:{
                        //     required:true,
                        //     minlength:6,
                        //      equalTo : '[name="password"]'
                        // },
                         ph:{
                             required:true,
                            mobileonly:true,
                            minlength:10,
                            maxlength:10,
                             remote: {
                          url:  '{{route('check.mobile')}}',
                          type: "get",
                          data: {
                            ph: function() {
                              return $( "#ph" ).val();
                            }
                          }
                        }

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

                    }



                });

            });
        </script>
        <script>
  $('#checkbox1').change(function(){
    if ($(this).prop('checked')==true && $('#checkbox2').prop('checked')==true){
      $('.disable-input').prop("disabled",false);
      $('.submit-login').removeClass('disable-input');
      $('.submit-social').removeClass('disable-input');
    }else{
      // $('.disable-input').Attr('disabled');
      // $('.submit-login').addClass('disable-input');
      $('.submit-login').addClass('disable-input');
      $('.disable-input').prop("disabled",true);
       $('.submit-social').addClass('disable-input');
    }
  });
  $('#checkbox2').change(function(){
    if ($(this).prop('checked')==true && $('#checkbox1').prop('checked')==true){
      $('.disable-input').prop("disabled",false);
      $('.submit-login').removeClass('disable-input');
      $('.submit-social').removeClass('disable-input');
    }else{
      // $('.disable-input').Attr('disabled');
      // $('.submit-login').addClass('disable-input');
      $('.submit-login').addClass('disable-input');
      $('.disable-input').prop("disabled",true);
       $('.submit-social').addClass('disable-input');
    }
  });
</script>

@endsection
