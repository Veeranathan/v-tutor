@if(@Auth::user()->id)
<script>window.location = "{{url('/')}}/tutor/home";</script>
@else
@extends('layouts.app')
@section('title')
<title>V-Tutor  | Tutor | Registration | Step 2 </title>
@endsection
@section('left_part')
{{-- @include('include.left_part') --}}
@include('include.header_menu_part')
@endsection
@section('content')
<!-- bannersec -->
<div class="top_mar"></div>
<section class="login-body tutor-body">

	<div class="login-info">
		<div class="login-details">
			<div class="upper-login">
				<h2>Tutor Sign Up</h2>
				<p>Please fill in the below fields to continue</p>
			</div>
			@include('include.errors')
			<div class="login-from">
				<form method="POST" action="{{ route('teacher.custom.register.two') }}" id="frm">
					@csrf
					 <input type="hidden" name="tutor_id" value="{{@$user_details->id}}">
					<div class="double-from">
						<div class="form_area">
							<input type="text" class="texxt_box" placeholder="First Name" name="f_name" value="{{@$user_details->f_name}}" disabled>
						</div>
						<div class="form_area">
							<input type="text" class="texxt_box" placeholder="Last Name" name="l_name" value="{{@$user_details->l_name}}" disabled>
						</div>
					</div>
					<div class="form_area">
						<input type="email" class="texxt_box" placeholder="Email address" name="email" id="email">
					</div>

					<div class="check-box">
						<input type="checkbox" id="checkbox1" name="checkbox1" value="all" >
						<label for="checkbox1" class="checklabeel">I have read and agree to V-Tutor <a href="{{ url('privacy-policy') }}" target="_blank"> Privacy Policy </a> and <a href="{{ url('terms-conditions') }}" target="_blank"> Terms & Conditions </a></label>
					</div>
					<div class="check-box">
              <input type="checkbox" id="checkbox2" name="checkbox2" value="all" >
              <label for="checkbox2" class="checklabeel">Sign me up for regular updates and periodical promotional material from V-Tutor</label>
          </div>
					<input type="submit" name="" value="Sign me up" class="submit-login disable-input" disabled="">
				</form>

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
remote: {
url:  '{{route('check.email')}}',
type: "get",
data: {
email: function() {
return $( "#email" ).val();
}
}
}
},

},
messages:{
email:{
remote:"This email address is used by some one else. Please use another email address.!",
},

}
});
});
</script>
<script>
  $('#checkbox1').change(function(){
    if ($(this).prop('checked')==true){
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
@endif
