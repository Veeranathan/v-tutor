@extends('layouts.app')
@section('title')
<title>V-Tutor  | Tutor public profile</title>
@endsection
@section('left_part')
{{-- @include('include.left_part') --}}
@include('include.header_menu_part')
<link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials.css" />

<link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials-theme-flat.css" />
<style>
    .jqx-scheduler-appointment-resize-indicator {
        display: none !important;
    }
  /*  .jqx-scheduler-not-work-time-cell {
    background: #eee0 !important;
}*/
.jqx-scheduler-work-time-cell {
    background: #EEEEEE !important;
}
.pointerEventsNone{
    pointer-events: none !important;
}
.addDisable{
    opacity: 0.5 !important;
}
.jssocials-share-link { border-radius: 50%; }
.jssocials-share-facebook .jssocials-share-link {
    background: #3b5998;
    font-size: 12px;
}
.jssocials-share-twitter .jssocials-share-link {
    background: #00aced;
     font-size: 12px;
}
.jssocials-share-googleplus .jssocials-share-link {
    background: #dd4b39;
     font-size: 12px;
}
.jssocials-share-linkedin .jssocials-share-link {
    background: #007bb6;
     font-size: 12px;
}

</style>
{{-- jayatri for user favourite 12-10-2021  --}}
<link href="{{ public_asset('assets/toastr/build/toastr.min.css') }}" rel="stylesheet">
@endsection
<body class="after-user">
	@section('content')
  <div class="top_mar"></div>

<!--- profile --->

<section class="profile-section">
	<div class="top-profile">
		<div class="dark-area"></div>
		<div class="container">
			<div class="row">
                <div class="zin">
                	<div class="profile_left_panel sticky_left">
                		<div class="profile-left-info">
                            {{-- jayatri user favourite --}}
                			<a href="#" class="heart_cc @if(@Auth::user()->user_type == 'U') @if(@$userDetails->getuserToFavourite) heart_cc_act @endif wish-list saveUsertoFavourite @else pointerEventsNone addDisable @endif" data-saveUsertoFavourite="{{ @$userDetails->id }}"><img src="{{ public_asset('assets/images/wish.png')}}"></a>
                            {{--  --}}
                			<div class="profile-top text-center">
                				<em>
                					{{-- <img src="{{ public_asset('assets/images/profile-img.png')}}" alt="profile_img"> --}}
                                    @if(@$userDetails->profile_pic)
                                    @php
                                            $image_path = 'assets/images/all_avatars/'.@$tutor->profile_pic;
                                            @endphp
                                            @if(file_exists(@$image_path))
                                                <img src="{{ public_asset('assets/images/all_avatars/' . @userDetails->profile_pic) }}" alt="profile_img">
                                            @else
                                                <img src="{{env('STORAGE_URL') . '/teacher_profile_pic/'.@$userDetails->profile_pic}}" alt="">
                                            @endif
                                    {{-- <img src="{{url('/')}}/storage/teacher_profile_pic/{{@$userDetails->profile_pic}}" alt="profile_img" > --}}
                                    @elseif(!@$userDetails->profile_pic && @$userDetails->avatar)
                                    <img src="{{@$userDetails->avatar}}" alt="profile_img" style="width: 100%">
                                    @else
                                    <img src="{{ public_asset('assets/images/user-pro.png')}}" alt="profile_img" style="width: 100%">
                                    @endif
                				</em>
                				<h2>{{@$userDetails->f_name." ".@$userDetails->l_name }}</h2>
                				<p class="addr"><span><img src="{{ public_asset('assets/images/map.png')}}"></span> {{@$userDetails->city}}, {{@$userDetails->getState->state_name}}, Australia</p>
                				<ul class="profile-rating">

                                     @if($userDetails->avg_review>=0 && $userDetails->avg_review<=0.24)
                                    <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                    <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                    <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                    <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                    <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                    @endif

                                    @if($userDetails->avg_review>=0.25 && $userDetails->avg_review<=0.74)
                                    <li><a href="#"><img src="{{ public_asset('assets/images/halfstar.png')}}" alt=""></a></li>
                                    <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                    <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                    <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                    <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                    @endif


                                     @if($userDetails->avg_review>=0.75 && $userDetails->avg_review<=1.24)
                                    <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                    <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                    <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                    <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                    <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                    @endif



                                    @if($userDetails->avg_review>=1.25 && $userDetails->avg_review<=1.74)
                                    <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                    <li><a href="#"><img src="{{ public_asset('assets/images/halfstar.png')}}" alt=""></a></li>
                                    <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                    <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                    <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                    @endif



                                     @if($userDetails->avg_review>=1.75 && $userDetails->avg_review<=2.24)
                                    <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                    <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                    <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                    <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                    <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                    @endif




                                     @if($userDetails->avg_review>=2.25 && $userDetails->avg_review<=2.74)
                                    <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                    <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                    <li><a href="#"><img src="{{ public_asset('assets/images/halfstar.png')}}" alt=""></a></li>
                                    <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                    <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                    @endif




                                    @if($userDetails->avg_review>=2.75 && $userDetails->avg_review<=3.24)
                                    <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                    <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                    <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                    <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                    <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                    @endif




                                    @if($userDetails->avg_review>=3.25 && $userDetails->avg_review<=3.74)
                                    <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                    <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                    <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                    <li><a href="#"><img src="{{ public_asset('assets/images/halfstar.png')}}" alt=""></a></li>
                                    <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                    @endif




                                    @if($userDetails->avg_review>=3.75 && $userDetails->avg_review<=4.24)
                                    <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                    <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                    <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                    <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                    <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                    @endif





                                      @if($userDetails->avg_review>=4.25 && $userDetails->avg_review<=4.74)
                                    <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                    <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                    <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                    <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                    <li><a href="#"><img src="{{ public_asset('assets/images/halfstar.png')}}" alt=""></a></li>
                                    @endif



                                      @if($userDetails->avg_review>=4.75 && $userDetails->avg_review<=5)
                                    <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                    <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                    <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                    <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                    <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                    @endif

            {{--
                					<li><img src="{{ public_asset('assets/images/star1.png')}}"></li>
                					<li><img src="{{ public_asset('assets/images/star.png')}}"></li>
                					<li><img src="{{ public_asset('assets/images/star.png')}}"></li>
                					<li><img src="{{ public_asset('assets/images/star.png')}}"></li>
                					<li><img src="{{ public_asset('assets/images/star.png')}}"></li> --}}
                					<li><p>{{@$userDetails->avg_review}} <span>{{@$userDetails->total_no_of_reviews}}</span></p></li>
                				</ul>
                               {{--  @php
                                $exp=DB::table('teacher_experience')->where('teacher_id',$id)->where('status','A')->sum('year_of_exp');

                                @endphp --}}
                				<p class="exp">Total years of experience  - <span> {{@$userDetails->total_experience}}</span></p>
                			</div>
                			<div class="border-shadow"></div>
                			<div class="profile-bottom">
                				<p><span><img src="{{ public_asset('assets/images/edu.png')}}"></span> {{-- B.A. English --}} {{$qualifications}}</p>

                				<p><span><img src="{{ public_asset('assets/images/world.png')}}"></span> Speaks :  {{@$languages}}</p>

                                @if(@$hourly_rate->hourly_rate)
                				<h6>From {{-- A --}}${{@$hourly_rate->hourly_rate}} /hr</h6>
                                @else
                                <h6>From {{-- A --}}$0 /hr</h6>
                                @endif

                				<div class="pub_btns">
                                    @if(@Auth::user()->user_type == 'U')
                                        @if(@$admin_disable_bookings_values->disable_booking == 'Y')
                                            <a class="open_popup_g" data-toggle="modal" data-target="#admin_disabled_bookings_popup" href="javascript:void(0);">Book a session</a>

                                        @else
                                            <a href="{{ url('studentbook-class?search_tutor_slug_studentclass='.@$userDetails->slug.'&search_tutor_id_studentclass='.@$userDetails->id) }}">Book a session</a>
                                        @endif
                					@else
                                        <a href="javascript:void(0);" class="pointerEventsNone addDisable">Book a session</a>
                                    @endif
                                    @if(@Auth::user()->user_type == 'U')
                					<a href="{{route('student.my.review',@$userDetails->slug)}}">Post a Review</a>
                                    @else
                                    <a href="javascript:void(0);" class="pointerEventsNone addDisable">Post a Review</a>
                                    @endif
                				</div>
                			</div>
                		</div>

                		<div class="share-info">
                			<div class="social_iic01">
			                	<img src="{{ public_asset('assets/images/share.png')}}" alt=""> <strong>Share</strong>
			                   {{--  <a href="#"><img src="{{ public_asset('assets/images/sc1.png')}}" alt=""></a>
			                    <a href="#"><img src="{{ public_asset('assets/images/sc2.png')}}" alt=""></a>
			                    <a href="#"><img src="{{ public_asset('assets/images/sc3.png')}}" alt=""></a>
			                    <a href="#"><img src="{{ public_asset('assets/images/sc4.png')}}" alt=""></a>
                                --}}
                               {{--  {{url('/')}}/tutor-public-profile/{{$userDetails->slug}} --}}
                                 <div id="share"></div>

			                </div>
                		</div>
                    </div>

                    <div class="profile_right_panel">
                    	<div class="profile_body">
                    		<div class="skill">
                    			<h2 class="profile-heading">Meet your Tutor</h2>
                    			<ul class="skill_tutor">
                                    {{-- @if(count(@$subject)>0)
                                    @foreach(@$subject as $val)
                    				<li>{{$val->subject}}</li>
                                    @endforeach
                                    @else
                                    <li>No data</li>

                                    @endif --}}

                    				@if(@$userDetails->getTutorShipPlan)
                                    @foreach(@$userDetails->getTutorShipPlan as $val)
                                    <li>{{$val->getGrade->grade_name}} - {{$val->getSubject->subject}}</li>
                                    @endforeach
                                    @else
                                    <li>No data</li>

                                    @endif

                    				<div class="clearfix"></div>
                    			</ul>
                    		</div>
                         {{--    <div class="skill">
                                <h2 class="profile-heading">Meet your Tutor</h2>
                                <ul class="skill_tutor">


                                    <li>Computer Science</li>
                                    <li>Economics</li>
                                    <li>Accounting</li>
                                    <li>Business</li>
                                    <li>Macroeconomics</li>
                                    <div class="clearfix"></div>
                                </ul>
                            </div> --}}

                    		<div class="about-pro">
                    			<h2 class="profile-heading">About me</h2>
                    			<p>{{substr(@$userDetails->about_me,0,500)}} </p>
                    				<p class="moretext4" style="display: none;">{{substr(@$userDetails->about_me,500)}}</p>
                    				<a class="moreless-button4 allread">Read More +</a>

                    		</div>
                    	</div>


                       {{-- video --}}
                       @if(@$userDetails->profile_video || @$userDetails->video_short_url)
                    	<div class="profile_body">
                            <iframe  src="https://www.youtube.com/embed/{{@$userDetails->video_short_url}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    	</div>
                        @endif

                       <!--- <div class="profile_body">
                            <h2 class="profile-heading">My Academic Qualification</h2>
                            <div >
                              <h2 class="mb-4">Full Calendar</h2>
                              <div class="card">
                                <div class="card-body p-0">
                                  <div id="calendar"></div>
                                </div>
                              </div>
                            </div>

                        </div> --->

                    	<div class="profile_body">
                    		<div class="academic">
                    			<h2 class="profile-heading">Academics</h2>
                                @if(count(@$userDetails->getTutorAcademic)>0)
                                @foreach(@$userDetails->getTutorAcademic as $val)
                    			<div class="aca_qua">
                    				<img src="{{ public_asset('assets/images/academic.png')}}">
                    				<div class="academic-details">
                    					<h3>{{@$val->getUniversity->university_name}} </h3>
										<h4>{{@$val->getFieldStudy->field_of_study}}
                                            @if(@$val->qualification=="1")
                                               ( Doctoral Degree )
                                            @elseif(@$val->qualification=="2")
                                            ( Postgraduate )

                                            @elseif(@$val->qualification=="3")
                                            ( Master's Degree (Research) )

                                            @elseif(@$val->qualification=="4")
                                            ( Master's Degree )

                                            @elseif(@$val->qualification=="5")
                                            ( Bachelor Honours Degree )

                                            @elseif(@$val->qualification=="6")
                                            ( Bachelor’s Degree )

                                            @elseif(@$val->qualification=="7")
                                            ( Associate Degree )

                                            @elseif(@$val->qualification=="8")
                                            ( Advanced Diploma )

                                            @else
                                            ( Diploma )

                                            @endif
                                        </h4>
										<h5>{{@$val->effective_date}}</h5>
                    				</div>
                    			</div>
                                @endforeach
                                 @else
                                <div class="aca_qua">
                                <div class="academic-details">
                               <h5>No data</h5>
                           </div>
                            </div>

                                @endif
                    			{{-- <div class="aca_qua mbr-0">
                    				<img src="{{ public_asset('assets/images/academic.png')}}">
                    				<div class="academic-details">
                    					<h3>University of Manitoba </h3>
										<h4>Master degree, Pure Math (Functional Analysis)</h4>
										<h5>2012 - 2014</h5>
                    				</div>
                    			</div> --}}
                    		</div>
                    	</div>

                    	<div class="profile_body">
                    		<div class="academic">
                    			<h2 class="profile-heading">My Experience</h2>
                                @if(count(@$userDetails->getTutorExperience)>0)
                                @foreach(@$userDetails->getTutorExperience as $val)
                    			<div class="aca_qua">
                    				<img src="{{ public_asset('assets/images/work.png')}}">
                    				<div class="academic-details">
                    					<h3>{{@$val->organization}} </h3>
										<h4>{{@$val->job_title}}</h4>
										<h5>{{@$val->from_year}} - {{@$val->to_year}}</h5>
										<p>{{@$val->description}}</p>
                    				</div>
                    			</div>
                                @endforeach
                                 @else
                                <div class="aca_qua">
                                <div class="academic-details">
                               <h5>No data</h5>
                           </div>
                            </div>

                                @endif
                    			{{-- <div class="aca_qua mbr-0">
                    				<img src="{{ public_asset('assets/images/work.png')}}">
                    				<div class="academic-details">
                    					<h3>University of New Brunswick </h3>
										<h4>Teaching assistant</h4>
										<h5>September 2009 - July 2010</h5>
										<p>Lorem ipsum dolor is amet, consectetur adipiscing eiusmod incididunt labor aibore et dolore magna aliqua.labor consectetur is adipiscing eiusmod tempor incididunt ut labore et dolore magna aliqua eiusmod.</p>
                    				</div>
                    			</div> --}}
                    		</div>
                    	</div>

                    	<div class="profile_body">
                    		<div class="academic">
                    			<h2 class="profile-heading">My Recognitions</h2>
                                @if(count(@$userDetails->getTutorRecognision)>0)
                                @foreach(@$userDetails->getTutorRecognision as $val)
                    			<div class="aca_qua">
                    				<img src="{{ public_asset('assets/images/recoc.png')}}">
                    				<div class="academic-details">
                    					<h3>{{$val->recg_title}}</h3>
										<h4>{{$val->organization}}</h4>
										<h5>{{$val->year_of_recg}}</h5>
										<p>{{$val->description}}</p>
                    				</div>
                    			</div>
                                @endforeach
                                @else
                                <div class="aca_qua">
                                <div class="academic-details">
                               <h5>No data</h5>
                           </div>
                            </div>

                                @endif

                    		</div>
                    	</div>



                        {{-- <div class="profile_body">
                            <div class="academic">
                                <h2 class="profile-heading">My Tutorship plan</h2>
                                @if(count(@$userDetails->getTutorShipPlan)>0)
                                @php
                                $plan=[];
                                @endphp

                                @foreach(@$userDetails->getTutorShipPlan as $val)
                                @php
                                if(!in_array($val->getGrade->grade_name, $plan)){
                                         array_push($plan, $val->getGrade->grade_name);
                                    }

                                @endphp
                                @endforeach

                                @foreach($plan as $val)

                                <div class="aca_qua">
                                    <img src="{{ public_asset('assets/images/recoc.png')}}">
                                    <div class="academic-details">
                                        <h3>{{$val->getGrade->grade_name}}</h3>
                                        <h4>{{$val->getSubject->subject}}</h4>
                                        <h5>{{@$val->year_of_recg}}</h5>
                                        <p>{{$val}}</p>
                                        @foreach(@$userDetails->getTutorShipPlan as $val2)
                                        @if($val2->getGrade->grade_name==$val)

                                           <h4>{{$val2->getSubject->subject}} ( ${{@$val2->hourly_rate}}/h )</h4>

                                        @endif
                                        @endforeach
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <div class="aca_qua">
                                <div class="academic-details">
                               <h5>No data</h5>
                           </div>
                            </div>

                                @endif

                            </div>
                        </div> --}}



                        <div class="profile_body">
                            <div class="academic">
                                <h2 class="profile-heading">Schedule</h2>
                                <div class="skill">

                                <ul class="skill_tutor">
                                    @if(@$t_my_av_show)
                                        @foreach(@$t_my_av_show->unique('day') as $t)
                                        <li>
                                            @if(@$t->day == 1)
                                            Monday
                                            @elseif(@$t->day == 2)
                                            Tuesday
                                            @elseif(@$t->day == 3)
                                            Wednesday
                                            @elseif(@$t->day == 4)
                                            Thursday
                                            @elseif(@$t->day == 5)
                                            Friday
                                            @elseif(@$t->day == 6)
                                            Saturday
                                            @elseif(@$t->day == 7)
                                            Sunday
                                            @endif

                                        </li>
                                        @endforeach
                                    @endif
                                    <div class="clearfix"></div>
                                </ul>
                            </div>
                                <div class="my-calander">
                                    <p>Schedule</p>
                                    <div class="calander-box">
                                        <ul>
                                            <li>
                                                <em class="c1"></em>
                                                <span>Booked</span>
                                            </li>

                                            <li>
                                                <em class="c2"></em>
                                                <span>Available</span>
                                            </li>

                                           {{--  <li>
                                                <em class="c3"></em>
                                                <span>abcd</span>
                                            </li> --}}
                                        </ul>
                                    </div>

                                </div>

                                <div id="scheduler">

                                </div>

                            </div>
                        </div>














                    	<div class="profile_body">
                    		<div class="academic">
                    			<div class="test-heading">
                    				<h2 class="profile-heading">My Testimonials</h2>
                    				<div class="rating-overview">
                    					<span><img src="{{ public_asset('assets/images/white-star.png')}}"> {{@$userDetails->avg_review}}</span>
                    					<p>{{@$userDetails->total_no_of_reviews}}</p>
                    				</div>
                    			</div>


                                     {{-- review part start --}}
                                     @if(count($reviews)>0)
                                @foreach($reviews as $key=> $val)
                                @if($key==0 || $key==1  )
                    			<div class="testi-details">
                    				<div class="testimonail-user-sec">
                    					<p><span><img src="{{ public_asset('assets/images/by.png')}}"></span> By : {{@$val->student->f_name}} {{@$val->student->l_name}}</p>
                    				@for($i=0;$i<=(@$val->ratting-1);$i++)

                                        <a href="#url"><img src="{{ public_asset('assets/images/star.png')}}"></a>

                                    @endfor
                                    {{-- blank --}}
                                         @for($i=0;$i<(5-@$val->ratting);$i++)

                                        <a href="#url"><img src="{{ public_asset('assets/images/star1.png')}}"></a>

                                    @endfor
                    				</div>
                    				<div class="testimonail-heading-part">
                    					<h3>Excellent Teacher</h3>
                    					<p>{{date('d/M/y', strtotime(@$val->created_at))}} , {{date('h:i A', strtotime(@$val->created_at))}} </p>
                    				</div>
                    				<p>{{@$val->message}}</p>
                    			</div>
                                 @endif
                                @endforeach


                    			<div class="more-text5" style="display: none;">

                    			 @foreach($reviews as $key=> $val)
                                @if($key==0 || $key==1 )
                                @else
                                <div class="testi-details">
                                    <div class="testimonail-user-sec">
                                        <p><span><img src="{{ public_asset('assets/images/by.png')}}"></span> By : {{@$val->student->f_name}} {{@$val->student->l_name}}</p>
                                    @for($i=0;$i<=(@$val->ratting-1);$i++)

                                        <a href="#url"><img src="{{ public_asset('assets/images/star.png')}}"></a>

                                    @endfor
                                    {{-- blank --}}
                                         @for($i=0;$i<(5-@$val->ratting);$i++)

                                        <a href="#url"><img src="{{ public_asset('assets/images/star1.png')}}"></a>

                                    @endfor
                                    </div>
                                    <div class="testimonail-heading-part">
                                        <h3>Excellent Teacher</h3>
                                        <p>{{date('d/M/y', strtotime(@$val->created_at))}} , {{date('h:i A', strtotime(@$val->created_at))}} </p>
                                    </div>
                                    <p>{{@$val->message}}</p>
                                </div>
                                 @endif
                                @endforeach
                    			</div>
                                {{-- if more than 3 data then show this --}}
                                 @if(count($reviews)>2)
                    			<a class="moreless-button5 allread">Load More +</a>
                                @endif
                                @else

                                <div class="aca_qua">
                                <div class="academic-details">
                               <h5>No data</h5>
                           </div>
                            </div>

                                @endif


                                 {{-- review part end --}}

                    		</div>
                    	</div>

                    </div>
                </div>
            </div>
		</div>
	</div>
</section>

	@endsection
	@section('footer')
	@include('include.footer')
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
	@endsection
	@section('script')
	@include('include.script')
     <script src="https://jqwidgets.com/public/jqwidgets/jqx-all.js"></script>
    <link rel="stylesheet" type="text/css" href="https://jqwidgets.com/public/jqwidgets/styles/jqx.base.css">

	 <script type="text/javascript">
        $(document).ready(function () {

           var d = new Date();
           var n = d.getDay();
          //console.log(n);//5=friday

// var date = new Date();
// var k=date. setDate(date. getDate() + 7);
// console. log(date);


   var appointments = new Array();





   /*booked days*/

@foreach($booked as $key=> $val)
//console.log({{(int)($val['year'])}}, {{(int)($val['month'])}},{{(int)($val['day'])}} , {{(int)($val['from_hour'])}}, {{(int)($val['from_min'])}}, 0);
var appointmentbooked{{$key}} = {
    id: "id2",
    description: "",
    location: "",
    subject: "Booked",
    calendar: "Room 1",

     start: new Date({{(int)($val['year'])}}, {{(int)($val['month'])-1}},{{(int)($val['day'])}} , {{(int)($val['from_hour'])}}, {{(int)($val['from_min'])}}, 0),
    end: new Date({{(int)($val['year'])}}, {{(int)($val['month'])-1}},{{(int)($val['day'])}} , {{(int)($val['to_hour'])}}, {{(int)(@$val['to_min'])}}, 0),
    background:"#b8110b"
}
appointments.push(appointmentbooked{{$key}});

@endforeach





   /*available days*/

@foreach($notbook as $key=> $val)
//console.log({{(int)($val['year'])}}, {{(int)($val['month'])}},{{(int)($val['day'])}} , {{(int)($val['from_hour'])}}, {{(int)($val['from_min'])}}, 0);
var appointmentaval{{$key}} = {
    id: "id2",
    description: "",
    location: "",
    subject: "available",
    calendar: "Room 1",

     start: new Date({{(int)($val['year'])}}, {{(int)($val['month'])-1}},{{(int)($val['day'])}} , {{(int)($val['from_hour'])}}, {{(int)($val['from_min'])}}, 0),
    end: new Date({{(int)($val['year'])}}, {{(int)($val['month'])-1}},{{(int)($val['day'])}} , {{(int)($val['to_hour'])}}, {{(int)(@$val['to_min'])}}, 0),
    background:"#7db343"
}
appointments.push(appointmentaval{{$key}});

@endforeach











   /*booked days*/

{{--
@foreach($booked as $key=> $val)
//console.log({{(int)($val['year'])}}, {{(int)($val['month'])}},{{(int)($val['day'])}} , {{(int)($val['from_hour'])}}, {{(int)($val['from_min'])}}, 0);
var appointment{{$key}} = {
    id: "id2",
    description: "",
    location: "",
    subject: "Booked",
    calendar: "Room 2",

     start: new Date({{(int)($val['year'])}}, {{(int)($val['month'])-1}},{{(int)($val['day'])}} , {{(int)($val['from_hour'])}}, {{(int)($val['from_min'])}}, 0),
    end: new Date({{(int)($val['year'])}}, {{(int)($val['month'])-1}},{{(int)($val['day'])}} , {{(int)($val['to_hour'])}}, {{(int)(@$val['to_min'])}}, 0),
    background:"#b8110b"
}
appointments.push(appointment{{$key}});

@endforeach
--}}











// prepare the data
 var source =
            {
                dataType: "array",
                dataFields: [
                    { name: 'id', type: 'string' },
                    { name: 'description', type: 'string' },
                    { name: 'location', type: 'string' },
                    { name: 'subject', type: 'string' },
                    { name: 'calendar', type: 'string' },
                    { name: 'start', type: 'date' },
                    { name: 'end', type: 'date' },
                    { name: 'background', type: 'string' }
                ],
                id: 'id',
                localData: appointments
            };
         var adapter = new $.jqx.dataAdapter(source);
            $("#scheduler").jqxScheduler({
                 date: new $.jqx.date({{date('Y')}}, {{date('m')}}, {{date('d')}}),
                width: 650,
                height: 400,
                source: adapter,
                editDialog: false,
                view: 'weekView',
                showLegend: true,
                ready: function () {
                    $("#scheduler").jqxScheduler('ensureAppointmentVisible', 'id1');
                },
                resources:
                {
                    colorScheme: "scheme05",
                    dataField: "calendar",
                    //orientation: "vertical",
                    source: new $.jqx.dataAdapter(source)
                },
                appointmentDataFields:
                {
                    from: "start",
                    to: "end",
                    id: "id",
                    description: "description",
                    location: "place",
                    subject: "subject",
                    resourceId: "calendar",
                    background: 'background'
                },
                appointmentsMinHeight: 20,
                views:
    [
        //'dayView',
        'weekView',
        //'monthView'
    ]

            });
        });
    </script>
{{-- jayatri 12-10-2021 favourite ajax call --}}
<script src="{{ public_asset('assets/toastr/build/toastr.min.js') }}"></script>
<script type="text/javascript">
    $(document).on("click",".saveUsertoFavourite",function(e){

            // alert("sfjhahs");

            var favourite_user_id = $(this).attr("data-saveUsertoFavourite"),

            obj = $(this),

            reqData = {

                'jsonrpc' : '2.0',

                '_token'  : '{{csrf_token()}}',

                'data'    : {

                    'favourite_user_id'    : favourite_user_id

                }

            };

            // alert(favourite_user_id);





                $.ajax({

                    url:"{{ route('save.user.to.favourite') }}",

                    dataType: 'json',

                    data: reqData,

                    type: 'post',

                    success:function(resp){

                        if(resp.result.status == 'Added'){

                            obj.addClass("heart_cc_act");

                        }else{

                            obj.removeClass("heart_cc_act");

                        }

                        toastr.success(resp.result.message);

                    },

                    error:function(){

                        toastr.error("Please refresh the page!");

                    }

                });



        });
</script>


  <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials.min.js"></script>

<script>
        $("#share").jsSocials({
          url:"{{url('/')}}/tutor-public-profile/{{$userDetails->slug}}",
              showLabel: false,
    showCount: false,


            shares: [{
        share: "facebook",
        logo: "{{url('/')}}/assets/images/sc1.png"
    }, {
        share: "twitter",
        logo: "{{url('/')}}/assets/images/sc2.png"
    },
    {
        share: "googleplus",
        logo: "{{url('/')}}/assets/images/sc3.png"
    },
    {
        share: "linkedin",
        logo: "{{url('/')}}/assets/images/sc4.png"
    }]
        });
    </script>
	@endsection
