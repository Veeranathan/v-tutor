<!-- footer -->
<footer class="footer_section">
	<div class="foot_top">
		<div class="container">
			<div class="foot_top_div">
				<div class="row">
					<div class="col-lg-2 col-md-3 col-sm-12 col-12">
						<div class="foot_logo">
							<a class="foot_logo_a" href="{{ url('/') }}"><img src="{{ public_asset('assets/tutor_landing/v-tutor-footer-logo.svg') }}" alt="Footer-logo" /></a>
						</div>
					</div>
					<div class="col-lg-5 col-md-9 col-sm-12 col-12">
						<div class="foot_social_div">
							<div class="foot_email_div">
								{{-- <a href="mailto:be-a-tutor@v-tutor.com.au">be-a-tutor@v-tutor.com.au</a> --}}
								<a href="https://mail.google.com/mail/?view=cm&fs=1&to=be-a-tutor@vtutor.zohodesk.com.au&cc=academics.admin@v-tutor.com.au" target="_blank">  be-a-tutor@v-tutor.com.au</a>
                            </div>

                            <div class="foot_si_div">
                                <div class="br_line"></div>

                                <ul>
                                    <li><a href="https://www.facebook.com/v.tutor.fb" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                    {{-- <li><a href="#" target="_blank"><i class="fa-brands fa-linkedin"></i></a></li> --}}
                                    <li><a href="https://x.com/my_vtutor" target="_blank"><i class="fa-brands fa-x-twitter"></i></a></li>
                                    <li><a href="https://www.instagram.com/v.tutor.insta/" target="_blank"><i class="fa-brands fa-instagram"></i></a></li>
                                    <li><a href="https://pin.it/3WclFYmYj" target="_blank"><i class="fa-brands fa-pinterest"></i></a></li>
                                    <li><a href="https://www.youtube.com/@v-tutor" target="_blank"><i class="fa-brands fa-youtube"></i></a></li>
                                </ul>
                            </div>
						</div>
					</div>

					<div class="col-lg-5 col-md-12 col-sm-12 col-12">
						<div class="foot_policy_div">
							<ul>
                                <li><a href="{{ url('privacy-policy') }}" target="_blank">Privacy Policy</a></li>
                                <li><a href="{{ url('terms-conditions') }}" target="_blank">Terms & Conditions </a> </li>
                                <li>Copyright © {{ date('Y') }} <a href="{{ url('/') }}">v-tutor.com.au</a>
                            </ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>

<div class="foot_arw fixed">
	<a href="javascript:" id="return-to-top"><img src="{{ public_asset('assets/images/foot_ar_bot.png')}}" alt=""></a>
</div>
<div class="modal res-modal newqusmo  @if(Session::get('success') == 'A verification link has been sent to your email address. Please check and click on the link to complete the sign up.') @else @if(@$errors->all())
				       			@foreach(@$errors->all() as $error)
					       		@if(@$error == 'These credentials do not match our records.')
					       			smallPopupInvalidCreden
					       		@endif
					       		@endforeach
					       		@else
				       			studentUpdatePopupModal
				       			@endif  @endif " id="popupModal">
    @if(Session::get('success') == 'A verification link has been sent to your email address. Please check and click on the link to complete the sign up.')
    	<div class="modal-dialog modal-dialog-centered divPoMW">
        	<div class="modal-content">
            <div class="dvpro">
                <!-- Modal Header -->
                <div class="modal-header messageDivTxt">
                  <h4 class="modal-title">Email Verification</h4>
                  <button type="button" class="close" id="popupModalclose1Upd" data-dismiss="modal" onclick="modalHide1Upd()">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body ">
                    <div class="testPro">
                        <div class="proDiv messageDivTxt">
                            <p class="leftAlginText">A verification link has been sent to your email address. Please check and click on the link to complete the sign up.</p>
                            <p class="leftAlginText">You will be able to login after the email is verified.</p>
                            {{-- <p class="academic_team_bold">Academics Team</p> --}}
                        </div>
                    </div>

                    </div>
                </div>
            </div>
        	</div>
    	</div>
    @else
    	<div class="modal-dialog modal-dialog-centered divPoMW " @if(Session::get('success') == 'Your email address has been successfully verified. You may now log in using your credentials.') style="max-width: 429px !important;"  @endif>
	      	<div class="modal-content">
	      		<div class="dvpro">
		        	<!-- Modal Header -->
			        <div class="modal-header messageDivTxt">
			          	<h4 class="modal-title">
				          	@if(Session::get('success') == 'A verification link has been sent to your email address. Please check and click on the link to complete the sign up.')
				           		Email Verification
				       		@elseif(Session::get('success') == 'Your email address has been successfully verified. You may now log in using your credentials.')
				       			{{-- User Verified --}}
								{{-- Email Verification Successful --}}
								Verification Successful
				       		@elseif(Session::get('success') == 'Your V-Tutor account is closed!')
				       			Account Closed
				       		@elseif(Session::get('success') == 'Your profile is now updated.')
				       			Profile Update
				       		@elseif(Session::get('success') == 'Your profile is updated')
				       			Profile Update
				       		@elseif(Session::get('success') == 'Tutor profile updated')
				       			Profile Update
				       		@elseif(Session::get('error') == 'Password is not correct. Try again or reset the password')
				       			Invalid Password
				       		@else
				       			@if(@$errors->all())
				       			@foreach(@$errors->all() as $error)
					       		@if($error == 'These credentials do not match our records.')
					       			Invalid Credentials
					       		@endif
					       		@endforeach
					       		@else
				       			Message
				       			@endif
				       		@endif
			       		</h4>
			          <button type="button" class="close" id="popupModalclose" data-dismiss="modal" onclick="modalHide()">&times;</button>
			        </div>

		        	<!-- Modal body -->
			        <div class="modal-body ">
			        	@if(Session::get('success') == 'Your V-Tutor account is closed!')
			            	<div class="testPro">
			                	<div class="proDiv messageDivTxt">
						        	{{-- <h6>Your V-Tutor account is closed!</h6> --}}
					                <p class="leftAlginText">Your V-Tutor account is closed!</p>
					                <p></p>
					                <p class="leftAlginText">Closed incorrectly or by accident?<a href="{{ route('contact.us') }}"> Message us.</a></p>
				                </div>
				            </div>
				        @elseif(Session::get('success') == 'A verification link has been sent to your email address. Please check and click on the link to complete the sign up.')
			            	<div class="testPro">
			                	<div class="proDiv messageDivTxt">
						        	<h6>A verification link has been sent to your email address. Please check and click on the link to complete the sign up.</h6>
					                <p></p>
					                <p></p>
					                <p class="leftAlginText">You will be able to login after the email is verified.</p>
				                </div>
				            </div>
			        	@else
				        	<div class="divs">
				            	@if(Session::has('success') == "Link can be accessed only 5 minutes before the session")
				            	<label class="leftAlginText">{!!Session::get('success')!!} </label>
				            	@elseif(Session::has('success'))

				                <label class="leftAlginText">{!!Session::get('success')!!} </label>
				                @elseif(Session::has('error'))
				                <label class="leftAlginText">{!!Session::get('error')!!} </label>
				                @elseif ($errors->any())
				                <label class="leftAlginText">
				                @foreach ($errors->all() as $error)
				            	{{ $error }}<br/>
				            	@endforeach
				            	</label>

				                @endif

				            </div>
			        	@endif



			        </div>
	    		</div>
	      	</div>
    	</div>
    @endif
</div>
</div>

{{-- restric if disable_bookings BB BD --}}
<div class="modal " id="admin_disabled_bookings_popup">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title bb_disabled_booking_u">Message</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="">
                    <div class=" ">
                        <div class="meass-popup">
                            <ul class="">
                                <li class="">
                                    You cannot make bookings at this time. Please contact support
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal res-modal newqusmo studentUpdatePopupModal loader-modal" id="waitFor1">
   <div class="modal-dialog modal-dialog-centered divPoMW tapDiv proClose">
      <div class="modal-content">

         {{-- <div class="modal-header">
            <h4 class="modal-title">Please wait</h4>
		</div> --}}
		{{-- <button type="button" class="close" data-dismiss="modal">&times;</button> --}}

         <div class="modal-body ">
            <div class="testPro">
               <div class="proDiv d-flex justify-content-center align-items-center" id="warningTextDi">
				<img src="{{ public_asset('assets/images/loader.gif') }}" alt="">
				{{-- <img src="images/funny-cat.gif" alt="Funny cat dancing"> --}}
                  {{-- <span class="proclosespan">Please wait for the page to load</span> --}}
                  <div class=" newst_btn-pop">

                     <div class="clearfix"></div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>


<script type="text/javascript">
	function modalHide(){
		$("#popupModal").hide();
	}
</script>

