<!-- footer -->
<footer class="container footer-custom ">
    <div class="footer-sec-div">
        <div class="footer-sec-subdiv row g-4">
            <div class=" col-lg-3 col-md-6 mb-4 mb-md-0">
                <h5 class=" mb-2"> <a class="" href="{{ url('/') }}"><img
                            src="{{ public_asset('assets/tutor_landing/v-tutor-footer-logo.svg') }}" alt="V-Tutor online tutoring Australia logo"
                            class="footer-logo" /></a></h5>
                <p class="">Learning Without Limits</p>
            </div>

            <div class="col-6 col-lg-2 col-md-6 ">
                <h6 class="">Quick Links</h6>
                <ul class="list-unstyled ">
                    <li><a href="{{ url('/') }}" class="footer-link">Home</a></li>
                    <li><a href="{{ route('products', ['type' => 'learning']) }}" class="footer-link">Our Programs</a></li>
                    <li><a href="{{ route('about.us') }}" class="footer-link">About Us</a></li>
                    <li><a href="{{ url('tutor-search-result') }}" class="footer-link">Find Tutors</a></li>
                    <li><a href="{{ route('tutor_landing') }}" class="footer-link">Be a V-Tutor</a></li>
                    <li><a href="{{ route('home.blog') }}" class="footer-link">Blogs</a></li>
                </ul>
            </div>

            <div class="col-6 col-lg-2 col-md-6">
                <h6 class="">Resources</h6>
                <ul class="list-unstyled ">
                    <li><a href="{{ url('faq') }}" class="footer-link">FAQ</a></li>
                    <li><a href="{{ url('privacy-policy') }}" class="footer-link">Terms of Service</a></li>
                    <li><a href="{{ url('privacy-policy') }}" class="footer-link">Privacy Policy</a></li>
                    <li><a href="{{ url('terms-conditions') }}" class="footer-link">Terms & Conditions</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-6 mt-4 mt-md-0">
                <h6 class="">Contact Us</h6>
                <p class=" msg-us"><a href="{{ route('contact.us') }}" class="footer-link ">Message Us</a>
                </p>
                <p class="gmail-link footer-link">
                    <a href="mailto:support@v-tutor.com.au">support@v-tutor.com.au</a>
                </p>
                 <p class="mt-3">478 George St<br>Sydney 2000<br>New South Wales                  
                </p>
            </div>

            <div class="col-lg-3 col-md-6 mt-4 mt-md-0">
                @php
                    $followUsDetails = \App\Models\FollowUsDetails::first();
                @endphp

                <h6 class="">Follow</h6>
                <div class="d-flex">
                    <a href="{{ @$followUsDetails->facebook_link }}" target="_blank" class="social-icon"> <img
                            src="{{ public_asset('assets/images/landing_tutor/facebook.svg') }}" alt="Facebook - V-Tutor online tutors Australia" /></a>
                    <a href="{{ @$followUsDetails->twitter_link }}" target="_blank" class="social-icon"><img
                            src="{{ public_asset('assets/images/landing_tutor/twitter.svg') }}" alt="Twitter - V-Tutor online tutoring Australia" /></a>
                    <a href="{{ @$followUsDetails->instagram_link }}" target="_blank" class="social-icon"><img
                            src="{{ public_asset('assets/images/landing_tutor/instagram.svg') }}"
                            alt="Instagram - qualified tutors Australia" /></a>
                    <a href="{{ @$followUsDetails->p_interest_link }}" target="_blank" class="social-icon"><img
                            src="{{ public_asset('assets/images/landing_tutor/pinterest.svg') }}"
                            alt="Pinterest - online learning Australia" /></a>
                    <a href="{{ @$followUsDetails->youtube_link }}" class="social-icon"><img
                            src="{{ public_asset('assets/images/landing_tutor/youtube.svg') }}" alt="YouTube – ACARA-aligned and WWCC-verified online tutors Australia" /></a>
                </div>
            </div>

        </div>
        <div class=" text-start copywrite">
            Copyright © {{ date('Y') }} <a href="{{ url('/') }}" class="site_link">v-tutor.com.au</a>
        </div>

    </div>
</footer>
{{-- <footer class="footer_sec login-footer">
	<div class="foot_top">
		<div class="container">
			<div class="foot_top_inr">
				<div class="row">
					<div class="col-sm-3">
						<div class="foot_bx">
							<h4>Quick links</h4>
							<ul>
								<li><a href="{{route('landing.page')}}">Home</a></li>
								<li><a href="{{ route('about.us') }}">About us</a></li>
								<li><a href="{{ route('contact.us') }}">Message us</a></li>

							</ul>
						</div>
					</div>
					<div class="col-sm-3">

						<div class="foot_bx" style="">
							<h4>For Students</h4>
							<ul>
								@if (!@Auth::check())
								<li><a href="{{route('login')}}">Log me in</a></li>
									@php
										$disable_booking_details = \App\Models\AdminDisableBookings::first();
										$all_disabled_booking_dates = \App\Models\AdminDisableBookingDates::where('status','A')->pluck('disable_booking_date')->toArray();
									@endphp
									@if (@$disable_booking_details->disable_booking == 'Y' && @Auth::user()->user_type == 'U')
						  				<li><a data-toggle="modal" data-target="#admin_disabled_bookings_popup" class="">Book a session</a></li>
						  			@elseif(@Auth::user()->user_type == 'U')
							  			<li><a   data-toggle="modal" data-target="#myModal">Book a session</a></li>
							  		@else
							  			<li><a   href="{{ url('tutor-search-result') }}">Book  a session</a></li>
							  			<li><a href="{{ url('tutor-search-result') }}">Find a Tutor</a></li>
							  			<li><a href="{{ url('tutor-search-result') }}">Sessions</a></li>
						  			@endif
								@if (@Auth::user()->user_type == 'U')
								<li><a href="{{ url('tutor-search-result') }}">Find a Tutor</a></li>
								@endif
								@if (@Auth::user()->user_type == 'U' && @Auth::user()->status == 'A')
								<li><a href="{{route('student.my.classes')}}">Sessions</a></li>
								@endif
								@if (@Auth::user()->user_type == 'T' && @Auth::user()->status == 'A')
								<li><a href="{{route('tutor.myclass')}}">Sessions</a></li>
								@endif
								<li><a href="{{ route('my.profile') }}">Profile</a></li>
								@else
										@if (@Auth::user()->user_type == 'U')
										<li><a href="{{ url('tutor-search-result') }}">Book a session</a></li>
										@endif
										@if (@Auth::user()->user_type == 'U')
											<li><a href="{{ url('tutor-search-result') }}">Find a Tutor</a></li>
										@endif
										@if (@Auth::user()->user_type == 'U' && @Auth::user()->status == 'A')
										<li><a href="{{route('student.my.classes')}}">Sessions</a></li>
										@endif
										@if (@Auth::user()->user_type == 'T' && @Auth::user()->status == 'A')
										<li><a href="{{route('tutor.myclass')}}">Sessions</a></li>
										@endif
										@if (@Auth::user()->user_type == 'T')
										<li><a href="{{ route('teacher.profile') }}">Profile</a></li>
										@else
										<li><a href="{{ route('my.profile') }}">Profile</a></li>
										@endif


								@endif
							</ul>
						</div>

					</div>
					<div class="col-sm-3">
						<div class="foot_bx">
							<h4>For Tutors</h4>
							<ul>
								@if (!@Auth::check())
									<li><a href="{{route('login')}}">Log me in</a></li>
									<li><a href="{{route('reg.home')}}">Sign me up</a></li>

									@if (@Auth::user()->user_type == 'U' && @Auth::user()->status == 'A')
									<li><a href="{{route('student.my.classes')}}">Sessions</a></li>
									@endif
									@if (@Auth::user()->user_type == 'T' && @Auth::user()->status == 'A')
									<li><a href="{{route('tutor.myclass')}}">Sessions</a></li>
									@endif
									<li><a href="{{route('tutor.myclass')}}">My  sessions</a></li>
									<li><a href="{{route('teacher.profile')}}">Profile</a></li>
									<li><a href="{{route('tutor.availability')}}">Schedule</a></li>
								@else

									<li><a href="{{route('tutor.myclass')}}">Sessions</a></li>



									<li><a href="{{route('teacher.profile')}}">Profile</a></li>



									<li><a href="{{route('tutor.availability')}}">Schedule</a></li>

								@endif
							</ul>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="foot_bx">
							<h4>Follow us</h4>
							@php
							$followUsDetails = \App\Models\FollowUsDetails::first();
							@endphp
							<ul>
								<li>Email :  <a href="mailto:{{ @$followUsDetails->email }}">{{ @$followUsDetails->email }}</a></li>
							</ul>
							</div>
							<div class="foot_sos_box">
							<ul>
								<li>
									<a href="{{ @$followUsDetails->facebook_link }}" target="_blank">
									<i class="foot_sos"><img src="{{ public_asset('assets/images/footsos1.png')}}" alt="" /></i>
									<i class="foot_sos_hov"><img src="{{ public_asset('assets/images/footsos11.png')}}" alt="" /></i>
									</a>
								</li>
								<li>
									<a href="{{ @$followUsDetails->twitter_link }}" target="_blank">
									<i class="foot_sos"><img src="{{ public_asset('assets/images/footsos2.png')}}" alt="" /></i>
									<i class="foot_sos_hov"><img src="{{ public_asset('assets/images/footsos22.png')}}" alt="" /></i>
									</a>
								</li>
								<li>
									<a href="{{ @$followUsDetails->instagram_link }}" target="_blank">
									<i class="foot_sos"><img src="{{ public_asset('assets/images/footsos3.png')}}" alt="" /></i>
									<i class="foot_sos_hov"><img src="{{ public_asset('assets/images/footsos33.png')}}" alt="" /></i>
									</a>
								</li>
								<li>
									<a href="{{ @$followUsDetails->youtube_link }}" target="_blank">
									<i class="foot_sos"><img src="{{ public_asset('assets/images/footsos4.png')}}" alt="" /></i>
									<i class="foot_sos_hov"><img src="{{ public_asset('assets/images/footsos44.png')}}" alt="" /></i>
									</a>
								</li>
								<li>
									<a href="{{ @$followUsDetails->p_interest_link }}" target="_blank">
									<i class="foot_sos"><img src="{{ public_asset('assets/images/footsos5.png')}}" alt="" /></i>
									<i class="foot_sos_hov"><img src="{{ public_asset('assets/images/footsos55.png')}}" alt="" /></i>
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="foot_botm">
		<div class="container">
			<div class="foot_botm_inr">
				<div class="foot_botm_left">
					<ul>
						<li>Copyright © {{ date('Y') }} <a href="{{ url('/') }}">V-Tutor.com.au</a>   <span>|</span> All Rights Reserved </li>
					</ul>
				</div>
				<div class="foot_botm_right">
					<ul>
						<li><a href="{{ url('terms-conditions') }}">Terms & Conditions </a> <span class="shal">/</span></li>
						<li><a href="{{ url('privacy-policy') }}">Privacy Policy</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>

</footer> --}}

<div class="foot_arw fixed">
    <a href="javascript:" id="return-to-top"><img src="{{ public_asset('assets/images/foot_ar_bot.png') }}"
            alt=""></a>
</div>
<div class="modal res-modal newqusmo  @if (Session::get('success') ==
        'A verification link has been sent to your email address. Please check and click on the link to complete the sign up.') @else @if (@$errors->all())
				       			@foreach (@$errors->all() as $error)
					       		@if (@$error == 'These credentials do not match our records.')
					       			smallPopupInvalidCreden @endif
					       		@endforeach
@else
studentUpdatePopupModal
				       			@endif  @endif "
    id="popupModal">
    @if (Session::get('success') ==
            'A verification link has been sent to your email address. Please check and click on the link to complete the sign up.')
        <div class="modal-dialog modal-dialog-centered divPoMW">
            <div class="modal-content">
                <div class="dvpro">
                    <!-- Modal Header -->
                    <div class="modal-header messageDivTxt">
                        <h4 class="modal-title">Verify Email</h4>
                        <button type="button" class="close" id="popupModalclose1Upd" data-dismiss="modal"
                            onclick="modalHide1Upd()">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body ">
                        <div class="testPro">
                            <div class="proDiv messageDivTxt">
                                <p class="leftAlginText">A verification link has been sent to your email address. Please
                                    check and click on the link to complete the sign up.</p>
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
<div class="modal-dialog modal-dialog-centered divPoMW "
    @if (Session::get('success') ==
            'Your email address has been successfully verified. You may now log in using your credentials.') style="max-width: 429px !important;" @endif>
    <div class="modal-content ml-0">
        <div class="dvpro">
            <!-- Modal Header -->
            <div class="modal-header messageDivTxt">
                <h4 class="modal-title">
                    @if (Session::get('success') ==
                            'A verification link has been sent to your email address. Please check and click on the link to complete the sign up.')
                        Verify Email
                    @elseif(Session::get('error') == 'Your account is inactive. Please contact support.')
                        Account not active
                    @elseif(Session::get('error') ==
                            'A verification link has been sent to your email address. Please check and click on the link to complete the sign up.')
                        Verify Email
                    @elseif(Session::get('success') ==
                            'Your email address has been successfully verified. You may now log in using your credentials.')
                        <div class="mt-3 mb-3 p-2">
                            {{ Session::get('success') }} 
                        </div>

                        {{-- User Verified --}}
                        {{-- Email Verification Successful --}}
                        Verification Successful
                    @elseif(Session::get('success') == 'Your V-Tutor account is closed!')
                        Account Closed
                    @elseif(Session::get('success') == 'Your profile is now updated.')
                        Profile Update
                        {{-- Updated --}}
                    @elseif(Session::get('success') == 'Your profile is updated')
                        Profile Update
                        {{-- Updated --}}
                    @elseif(Session::get('success') == 'Tutor profile updated')
                        Profile Update
                        {{-- Updated --}}
                    @elseif(Session::get('error') == 'Password is not correct. Try again or reset the password')
                        Invalid Password
                    @else
                        @if (@$errors->all())
                            @foreach (@$errors->all() as $error)
                                @if ($error == 'These credentials do not match our records.')
                                    Invalid Credentials
                                @endif
                            @endforeach
                        @else
                            Message
                        @endif
                    @endif
                </h4>
                <button type="button" class="close" id="popupModalclose" data-dismiss="modal"
                    onclick="modalHide()">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body ">
                @if (Session::get('success') == 'Your V-Tutor account is closed!')
                    <div class="testPro">
                        <div class="proDiv messageDivTxt">
                            {{-- <h6>Your V-Tutor account is closed!</h6> --}}
                            <p class="leftAlginText">Your V-Tutor account is closed!</p>
                            <p></p>
                            <p class="leftAlginText">Closed incorrectly or by accident?<a
                                    href="{{ route('contact.us') }}"> Message us.</a></p>
                        </div>
                    </div>
                @elseif(Session::get('success') == 'Your profile is now updated.')
                    <label class="leftAlginText">Your profile has been successfully updated. </label>
                @elseif(Session::get('success') ==
                        'A verification link has been sent to your email address. Please check and click on the link to complete the sign up.')
                    <div class="testPro">
                        <div class="proDiv messageDivTxt">
                            <h6>A verification link has been sent to your email address. Please check and click on the
                                link to complete the sign up.</h6>
                            <p></p>
                            <p></p>
                            <p class="leftAlginText">You will be able to login after the email is verified.</p>
                        </div>
                    </div>
                @else
                    <div class="divs">
                        @if (Session::has('success') == 'Link can be accessed only 5 minutes before the session')
                            <label class="leftAlginText">{!! Session::get('success') !!} </label>
                        @elseif(Session::has('success'))
                            <label class="leftAlginText">{!! Session::get('success') !!} </label>
                        @elseif(Session::has('error'))
                            <label class="leftAlginText">{!! Session::get('error') !!} </label>
                        @elseif ($errors->any())
                            <label class="leftAlginText">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}<br />
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

                        <div class=" newst_btn-pop">

                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- <div class="modal res-modal newqusmo instructionModal" id="myProfileClosePopup">
    <div class="modal-dialog modal-dialog-centered instructionModal">
        <div class="modal-content instructionModal">
            <!-- Modal Header -->
            <div class="modal-header instructionModal">
                <h4 class="modal-title">Password</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body instructionModal">
                <form action="{{ route('teacher.close.account') }}" id="checkPassword">
                    @csrf
                    <div class="divs">
                        <div class="appome_input form_box_area cls1 ">
                <label> Password </label>

                <div class="checkBox new-cus  b-block">
                                            <ul class="submn">
                                                <li class="one_li_check">
                                                    <input id="mypassword" type="password" name="mypassword" placeholder="Password" autocomplete="off" required="" class="required">

                                                </li>

                                            </ul>
                                        </div>

                <div class="next-btn1">
                     <button id="checkPro" type="button" class="btn btn-new btn-danger" onclick="return confirm('We find that you have decided to close the account and we are sorry to see you go! We may need your account password to validate closure! If you have any issues / concerns that you would like to share, kindly use the Complaints link . Please be aware that this process is irreversible. Any data on this account will be retained as per our privacy policy and purged after a certain time.)">Submit</button>
                 </div>
            </div>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> --}}


<script type="text/javascript">
    function modalHide() {
        // alert();
        $('.modal-backdrop').remove();
        // $('body').removeClass('modal-open').css('padding-right', '');
        $('body').removeClass('modal-open')
        .css({
            'padding-right': '',
            'overflow': ''
        });
        $("#popupModal").hide();
    }
</script>
