@extends('layouts.app')
@section('title')
<title>V-Tutor  | Tutor public profile</title>
@endsection
@section('left_part')
{{-- @include('include.left_part') --}}
@include('include.header_menu_part')
<style>
    .jqx-menu-ul{
        display: none !important;
    }
    #legendbarbottomscheduler{
         display: none !important;
    }
    #scheduler{
            height: 456px !important;

    },,
    .jqx-scheduler .jqx-cell{
       height: 30px !important;
    }
    #id1{
        background-color: black !important;
    }
    .jqx-grid-table tr:nth-child(2), .jqx-grid-table tr:nth-child(3), .jqx-grid-table tr:nth-child(4), .jqx-grid-table tr:nth-child(5), .jqx-grid-table tr:nth-child(6), .jqx-grid-table tr:nth-child(7), .jqx-grid-table tr:nth-child(8), .jqx-grid-table tr:nth-child(9), .jqx-grid-table tr:nth-child(10), .jqx-grid-table tr:nth-child(11), .jqx-grid-table tr:nth-child(12), .jqx-grid-table tr:nth-child(13), .jqx-grid-table tr:nth-child(43), .jqx-grid-table tr:nth-child(44), .jqx-grid-table tr:nth-child(45), .jqx-grid-table tr:nth-child(46), .jqx-grid-table tr:nth-child(47), .jqx-grid-table tr:nth-child(48) {
        display: none !important;
    }
   /* .jqx-grid-table tr:nth-child(1) td{
        height: 35px !important;

    }*/
       .jqx-grid-table tr:nth-child(14) td{ position: static !important;}

       /*.jqx-cell.jqx-grid-cell.jqx-item.jqx-grid-cell-alt.jqx-center-align.jqx-top-align.jqx-scheduler-all-day-cell{
         height: 35px !important;

       }*/
  /* .jqx-scheduler-appointment.jqx-rc-all{
      border-color: red !important;
      background-color: red !important;
    }
    .jqx-scheduler-appointment.jqx-rc-all.jqx-scheduler-selected-appointment{
      border-color: green !important;
      background-color: green !important;
    }*/
/*jqx-scheduler-appointment jqx-rc-all

jqx-scheduler-appointment jqx-rc-all jqx-scheduler-selected-appointment*/







    .jqx-scheduler-cell-selected {
        background:#000000 !important;
    }
    .jqx-scheduler-cell-focus {
        background:#000000 !important;
    }
</style>
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
                			<a href="#" class="wish-list"><img src="{{ public_asset('assets/images/wish.png')}}"></a>
                			<div class="profile-top text-center">
                				<em>
                					{{-- <img src="{{ public_asset('assets/images/profile-img.png')}}" alt="profile_img"> --}}
                                    @if(@$userDetails->profile_pic)
                                    <img src="{{url('/')}}/storage/teacher_profile_pic/{{@$userDetails->profile_pic}}" alt="profile_img" >
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
                					<a href="#">Book a session</a>
                					<a href="#">Send a message</a>
                				</div>
                			</div>
                		</div>

                		<div class="share-info">
                			<div class="social_iic01">
			                	<img src="{{ public_asset('assets/images/share.png')}}" alt=""> <strong>Share</strong>
			                    <a href="#"><img src="{{ public_asset('assets/images/sc1.png')}}" alt=""></a>
			                    <a href="#"><img src="{{ public_asset('assets/images/sc2.png')}}" alt=""></a>
			                    <a href="#"><img src="{{ public_asset('assets/images/sc3.png')}}" alt=""></a>
			                    <a href="#"><img src="{{ public_asset('assets/images/sc4.png')}}" alt=""></a>
			                </div>
                		</div>
                    </div>

                    <div class="profile_right_panel">
                    	<div class="profile_body">
                    		<div class="skill">
                    			<h2 class="profile-heading">Meet your Tutor</h2>
                    			<ul class="skill_tutor">
                                    @if(count(@$subject)>0)
                                    @foreach(@$subject as $val)
                    				<li>{{$val->subject}}</li>
                                    @endforeach
                                    @else
                                    <li>No data</li>

                                    @endif
                    				{{-- <li>Computer Science</li>
                    				<li>Economics</li>
                    				<li>Accounting</li>
                    				<li>Business</li>
                    				<li>Macroeconomics</li> --}}
                    				<div class="clearfix"></div>
                    			</ul>
                    		</div>

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
                    			<h2 class="profile-heading">Achievements</h2>
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
                                <h2 class="profile-heading">My Availibility</h2>
                                <div class="my-calander">
                                    <p>Lorem ipsum dolor is amet, consectetur</p>
                                    <div class="calander-box">
                                        <ul>
                                            <li>
                                                <em class="c1"></em>
                                                <span>abcd</span>
                                            </li>

                                            <li>
                                                <em class="c2"></em>
                                                <span>abcd</span>
                                            </li>

                                            <li>
                                                <em class="c3"></em>
                                                <span>abcd</span>
                                            </li>
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

                    			<div class="testi-details">
                    				<div class="testimonail-user-sec">
                    					<p><span><img src="{{ public_asset('assets/images/by.png')}}"></span> By : John Decosmo</p>
                    					<ul class="user-rating">
		                					<li><img src="{{ public_asset('assets/images/star.png')}}"></li>
		                					<li><img src="{{ public_asset('assets/images/star.png')}}"></li>
		                					<li><img src="{{ public_asset('assets/images/star.png')}}"></li>
		                					<li><img src="{{ public_asset('assets/images/star.png')}}"></li>
		                					<li><img src="{{ public_asset('assets/images/star.png')}}"></li>
		                				</ul>
                    				</div>
                    				<div class="testimonail-heading-part">
                    					<h3>Excellent Teacher</h3>
                    					<p>10th may, 2021, 10:00 am</p>
                    				</div>
                    				<p>Lorem ipsum dolor is amet, consectetur adipiscing eiusmod incididunt labor aibore et dolore magna aliqua.labor consectetur is adipiscing eiusmod tempor incididunt ut labore et dolore magna aliqua eiusmod tempor incididunt</p>
                    			</div>

                    			<div class="testi-details">
                    				<div class="testimonail-user-sec">
                    					<p><span><img src="{{ public_asset('assets/images/by.png')}}"></span> By : John Decosmo</p>
                    					<ul class="user-rating">
		                					<li><img src="{{ public_asset('assets/images/star.png')}}"></li>
		                					<li><img src="{{ public_asset('assets/images/star.png')}}"></li>
		                					<li><img src="{{ public_asset('assets/images/star.png')}}"></li>
		                					<li><img src="{{ public_asset('assets/images/star.png')}}"></li>
		                					<li><img src="{{ public_asset('assets/images/star.png')}}"></li>
		                				</ul>
                    				</div>
                    				<div class="testimonail-heading-part">
                    					<h3>Excellent Teacher / this is a simply dummy heading</h3>
                    					<p>10th may, 2021, 10:00 am</p>
                    				</div>
                    				<p>Lorem ipsum dolor is amet, consectetur adipiscing eiusmod incididunt labor aibore et dolore magna aliqua.labor consectetur is adipiscing eiusmod tempor incididunt ut labore et dolore magna aliqua eiusmod tempor incididunt</p>
                    			</div>
                    			<div class="testi-details">
                    				<div class="testimonail-user-sec">
                    					<p><span><img src="{{ public_asset('assets/images/by.png')}}"></span> By : John Decosmo</p>
                    					<ul class="user-rating">
		                					<li><img src="{{ public_asset('assets/images/star.png')}}"></li>
		                					<li><img src="{{ public_asset('assets/images/star.png')}}"></li>
		                					<li><img src="{{ public_asset('assets/images/star.png')}}"></li>
		                					<li><img src="{{ public_asset('assets/images/star.png')}}"></li>
		                					<li><img src="{{ public_asset('assets/images/star.png')}}"></li>
		                				</ul>
                    				</div>
                    				<div class="testimonail-heading-part">
                    					<h3>Graph Theory / dummy review heading</h3>
                    					<p>10th may, 2021, 10:00 am</p>
                    				</div>
                    				<p>Lorem ipsum dolor is amet, consectetur adipiscing eiusmod incididunt labor aibore et dolore magna aliqua.labor consectetur is adipiscing eiusmod tempor incididunt ut labore et dolore magna aliqua eiusmod tempor incididunt</p>
                    			</div>
                    			<div class="testi-details">
                    				<div class="testimonail-user-sec">
                    					<p><span><img src="{{ public_asset('assets/images/by.png')}}"></span> By : John Decosmo</p>
                    					<ul class="user-rating">
		                					<li><img src="{{ public_asset('assets/images/star.png')}}"></li>
		                					<li><img src="{{ public_asset('assets/images/star.png')}}"></li>
		                					<li><img src="{{ public_asset('assets/images/star.png')}}"></li>
		                					<li><img src="{{ public_asset('assets/images/star.png')}}"></li>
		                					<li><img src="{{ public_asset('assets/images/star.png')}}"></li>
		                				</ul>
                    				</div>
                    				<div class="testimonail-heading-part">
                    					<h3>Excellent Teacher</h3>
                    					<p>10th may, 2021, 10:00 am</p>
                    				</div>
                    				<p>Lorem ipsum dolor is amet, consectetur adipiscing eiusmod incididunt labor aibore et dolore magna aliqua.labor consectetur is adipiscing eiusmod tempor incididunt ut labore et dolore magna aliqua eiusmod tempor incididunt</p>
                    			</div>

                    			<div class="more-text5" style="display: none;">
                    				<div class="testi-details">
                    				<div class="testimonail-user-sec">
                    					<p><span><img src="{{ public_asset('assets/images/by.png')}}"></span> By : John Decosmo</p>
                    					<ul class="user-rating">
		                					<li><img src="{{ public_asset('assets/images/star.png')}}"></li>
		                					<li><img src="{{ public_asset('assets/images/star.png')}}"></li>
		                					<li><img src="{{ public_asset('assets/images/star.png')}}"></li>
		                					<li><img src="{{ public_asset('assets/images/star.png')}}"></li>
		                					<li><img src="{{ public_asset('assets/images/star.png')}}"></li>
		                				</ul>
                    				</div>
                    				<div class="testimonail-heading-part">
                    					<h3>Graph Theory / dummy review heading</h3>
                    					<p>10th may, 2021, 10:00 am</p>
                    				</div>
                    				<p>Lorem ipsum dolor is amet, consectetur adipiscing eiusmod incididunt labor aibore et dolore magna aliqua.labor consectetur is adipiscing eiusmod tempor incididunt ut labore et dolore magna aliqua eiusmod tempor incididunt</p>
                    			</div>
                    			<div class="testi-details">
                    				<div class="testimonail-user-sec">
                    					<p><span><img src="{{ public_asset('assets/images/by.png')}}"></span> By : John Decosmo</p>
                    					<ul class="user-rating">
		                					<li><img src="{{ public_asset('assets/images/star.png')}}"></li>
		                					<li><img src="{{ public_asset('assets/images/star.png')}}"></li>
		                					<li><img src="{{ public_asset('assets/images/star.png')}}"></li>
		                					<li><img src="{{ public_asset('assets/images/star.png')}}"></li>
		                					<li><img src="{{ public_asset('assets/images/star.png')}}"></li>
		                				</ul>
                    				</div>
                    				<div class="testimonail-heading-part">
                    					<h3>Excellent Teacher</h3>
                    					<p>10th may, 2021, 10:00 am</p>
                    				</div>
                    				<p>Lorem ipsum dolor is amet, consectetur adipiscing eiusmod incididunt labor aibore et dolore magna aliqua.labor consectetur is adipiscing eiusmod tempor incididunt ut labore et dolore magna aliqua eiusmod tempor incididunt</p>
                    			</div>
                    			</div>

                    			<a class="moreless-button5 allread">Load More +</a>

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








 @for($i=94;$i>=0;$i--)

      //   echo date('Y-m-d', strtotime("+".$i." days")) .'<br>';
      //   echo date('d', strtotime("+".$i." days")) .'<br>';
      // }
      @if(date('w', strtotime("+".$i."days"))=="1")

@foreach($availability_mon as $val)

@php
$chkMon=1;
@endphp

@foreach(@$val->getBook as $item)
  @if( $item->booking_date==date('Y-m-d', strtotime("+".$i."days")) )
      @php
       $chkMon=0;
      @endphp
  @endif
@endforeach

@if($chkMon==1)
@php
$from=explode(":",$val->from_time);
$to=explode(":",$val->to_time);
//dd($from,$to);
$val['av_from_hour']=$from[0];
$val['av_from_min']=$from[1];

$val['av_to_hour']=$to[0];
$val['av_to_min']=$to[1];
@endphp


        var monday{{$i}} = {
        id: "id1",
        description: "Mondays",
        location: "",
        subject: "Monday",
        calendar: "Room 2",

        start: new Date({{date('Y', strtotime("+".$i." days"))}}, {{date('m', strtotime("+".$i." days"))-1}}, {{date('d', strtotime("+".$i." days"))}},{{(int)($val['av_from_hour'])}}, {{(int)($val['av_from_min'])}}, 0),
        end: new Date({{date('Y', strtotime("+".$i." days"))}}, {{date('m', strtotime("+".$i." days"))-1}}, {{date('d', strtotime("+".$i." days"))}}, {{(int)($val['av_to_hour'])}},{{(int)($val['av_to_min'])}}, 0),
         background: '#7db343'
         }
      appointments.push(monday{{$i}});
      @endif
@endforeach
     @endif






     @if(date('w', strtotime("+".$i."days"))=="2")
 @foreach($availability_tues as $val)
    @php
        $chk=1;
    @endphp
     @foreach(@$val->getBook? @$val->getBook:[] as$item)
     // console.log( {{date('Y-m-d', strtotime(date('Y-m-d')."+".$i."days"))}} ,{{$item->booking_date}});
        @if(date('Y-m-d', strtotime("+".$i."days"))==$item->booking_date)

            @php
            $chk=0;
            @endphp

        @endif
     @endforeach

     @if($chk==1)
     @php

            $from=explode(":",$val->from_time);
            $to=explode(":",$val->to_time);
            //dd($from,$to);
            $val['av_from_hour']=$from[0];
            $val['av_from_min']=$from[1];

            $val['av_to_hour']=$to[0];
            $val['av_to_min']=$to[1];
    @endphp

        var tues{{$i}} = {
        id: "id1",
        description: "Tuesday",
        location: "",
        subject: "Tuesday",
      calendar: "Room 2",
         start: new Date({{date('Y', strtotime("+".$i." days"))}}, {{date('m', strtotime("+".$i." days"))-1}}, {{date('d', strtotime("+".$i." days"))}},{{(int)($val['av_from_hour'])}}, {{(int)($val['av_from_min'])}}, 0),
        end: new Date({{date('Y', strtotime("+".$i." days"))}}, {{date('m', strtotime("+".$i." days"))-1}}, {{date('d', strtotime("+".$i." days"))}}, {{(int)($val['av_to_hour'])}},{{(int)($val['av_to_min'])}}, 0),
          background: '#7db343'
         }
      appointments.push(tues{{$i}});
      @endif
@endforeach
     @endif












@if(date('w', strtotime("+".$i."days"))=="3")
 @foreach($availability_wed as $val)
 /*here we get the availability id ($val->id  mention in relation) as primary key ad this has relation with below getBook and getBook has date .. now we need to chk that the date of getBook is equal to which date. and that date will not gonna push to arry as available date...*/

 @php
$chkWed=1;
 @endphp

@foreach($val->getBook as $item)
  @if( $item->booking_date==date('Y-m-d', strtotime("+".$i."days")) )
     @php
      $chkWed=0;
     @endphp
  @endif
@endforeach

@if($chkWed==1)
@php
 $from=explode(":",$val->from_time);
            $to=explode(":",$val->to_time);
            //dd($from,$to);
            $val['av_from_hour']=$from[0];
            $val['av_from_min']=$from[1];

            $val['av_to_hour']=$to[0];
            $val['av_to_min']=$to[1];

@endphp
        var wed{{$i}} = {
        id: "id1",
        description: "Wednesday",
        location: "",
        subject: "Wednesday",
       calendar: "Room 2",
        start: new Date({{date('Y', strtotime("+".$i." days"))}}, {{date('m', strtotime("+".$i." days"))-1}}, {{date('d', strtotime("+".$i." days"))}},{{(int)($val['av_from_hour'])}}, {{(int)($val['av_from_min'])}}, 0),
        end: new Date({{date('Y', strtotime("+".$i." days"))}}, {{date('m', strtotime("+".$i." days"))-1}}, {{date('d', strtotime("+".$i." days"))}}, {{(int)($val['av_to_hour'])}},{{(int)($val['av_to_min'])}}, 0),
          background: '#7db343'
         }
      appointments.push(wed{{$i}});
      @endif
@endforeach
     @endif









@if(date('w', strtotime("+".$i."days"))=="4")
 @foreach($availability_thurs as $val)

@php
$chkThurs=1;
@endphp

@foreach($val->getBook as $item)
  @if( $item->booking_date==date('Y-m-d', strtotime("+".$i."days")) )
     @php
      $chkThurs=0;
     @endphp
  @endif
@endforeach

@if($chkThurs==1)
@php
 $from=explode(":",$val->from_time);
            $to=explode(":",$val->to_time);
            //dd($from,$to);
            $val['av_from_hour']=$from[0];
            $val['av_from_min']=$from[1];

            $val['av_to_hour']=$to[0];
            $val['av_to_min']=$to[1];

@endphp
        var thurs{{$i}} = {
        id: "id1",
        description: "Thuesday",
        location: "",
        subject: "Thuesday",
       calendar: "Room 2",
        start: new Date({{date('Y', strtotime("+".$i." days"))}}, {{date('m', strtotime("+".$i." days"))-1}}, {{date('d', strtotime("+".$i." days"))}},{{(int)($val['av_from_hour'])}}, {{(int)($val['av_from_min'])}}, 0),
        end: new Date({{date('Y', strtotime("+".$i." days"))}}, {{date('m', strtotime("+".$i." days"))-1}}, {{date('d', strtotime("+".$i." days"))}}, {{(int)($val['av_to_hour'])}},{{(int)($val['av_to_min'])}}, 0),
          background: '#7db343'
         }
      appointments.push(thurs{{$i}});
      @endif
@endforeach
     @endif









@if(date('w', strtotime("+".$i."days"))=="5")
 @foreach($availability_fri as $val)


@php
$chkFri=1;
@endphp

@foreach($val->getBook as $item)
  @if( $item->booking_date==date('Y-m-d', strtotime("+".$i."days")) )
     @php
      $chkFri=0;
     @endphp
  @endif
@endforeach

@if($chkFri==1)
@php
 $from=explode(":",$val->from_time);
            $to=explode(":",$val->to_time);
            //dd($from,$to);
            $val['av_from_hour']=$from[0];
            $val['av_from_min']=$from[1];

            $val['av_to_hour']=$to[0];
            $val['av_to_min']=$to[1];

@endphp
        var fri{{$i}} = {
        id: "id1",
        description: "Friday",
        location: "",
        subject: "Friday",
      calendar: "Room 2",
       start: new Date({{date('Y', strtotime("+".$i." days"))}}, {{date('m', strtotime("+".$i." days"))-1}}, {{date('d', strtotime("+".$i." days"))}},{{(int)($val['av_from_hour'])}}, {{(int)($val['av_from_min'])}}, 0),
        end: new Date({{date('Y', strtotime("+".$i." days"))}}, {{date('m', strtotime("+".$i." days"))-1}}, {{date('d', strtotime("+".$i." days"))}}, {{(int)($val['av_to_hour'])}},{{(int)($val['av_to_min'])}}, 0),
          background: '#7db343'
         }
      appointments.push(fri{{$i}});
      @endif
@endforeach
     @endif











     @if(date('w', strtotime("+".$i."days"))=="6")
@foreach($availability_sat as $val)

@php
$chkSat=1;
@endphp

@foreach($val->getBook as $item)
  @if( $item->booking_date==date('Y-m-d', strtotime("+".$i."days")) )
     @php
      $chkSat=0;
     @endphp
  @endif
@endforeach

@if($chkSat==1)
@php
 $from=explode(":",$val->from_time);
            $to=explode(":",$val->to_time);
            //dd($from,$to);
            $val['av_from_hour']=$from[0];
            $val['av_from_min']=$from[1];

            $val['av_to_hour']=$to[0];
            $val['av_to_min']=$to[1];

@endphp
        var sat{{$i}} = {
        id: "id1",
        description: "Sat",
        location: "",
        subject: "Sat",
      calendar: "Room 2",
        start: new Date({{date('Y', strtotime("+".$i." days"))}}, {{date('m', strtotime("+".$i." days"))-1}}, {{date('d', strtotime("+".$i." days"))}},{{(int)($val['av_from_hour'])}}, {{(int)($val['av_from_min'])}}, 0),
        end: new Date({{date('Y', strtotime("+".$i." days"))}}, {{date('m', strtotime("+".$i." days"))-1}}, {{date('d', strtotime("+".$i." days"))}}, {{(int)($val['av_to_hour'])}},{{(int)($val['av_to_min'])}}, 0),
          background: '#7db343'
         }
      appointments.push(sat{{$i}});
@endif
@endforeach
     @endif

@endfor















// var appointment3 = {
//     id: "id3",
//     description: "",
//     location: "",
//     subject: "Course Social Media",
//     calendar: "Room 3",
//     start: new Date(2015, 10, 27, 11, 0, 0),
//     end: new Date(2015, 10, 27, 13, 0, 0)
// }

// var appointment4 = {
//     id: "id4",
//     description: "",
//     location: "",
//     subject: "New Projects Planning",
//     calendar: "Room 6",
//     start: new Date(2015, 10, 23, 10, 0, 0),
//     end: new Date(2015, 10, 23, 12, 0, 0)
// }

// var appointment5 = {
//     id: "id5",
//     description: "",
//     location: "",
//     subject: "Interview with James",
//     calendar: "Room 1",
//     start: new Date(2015, 10, 25, 11, 0, 0),
//     end: new Date(2015, 10, 25, 17, 0, 0)
// }

// var appointment6 = {
//     id: "id6",
//     description: "",
//     location: "",
//     subject: "Interview with Nancy",
//     calendar: "Room 4",
//     start: new Date(2015, 10, 26, 14, 0, 0),
//     end: new Date(2015, 10, 26, 16, 0, 0)
// }
// //appointments.push(appointment1);
// appointments.push(appointment2);
// appointments.push(appointment3);
// appointments.push(appointment4);
// appointments.push(appointment5);
// appointments.push(appointment6);


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
                width: 750,
                height: 500,
                source: adapter,
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



	@endsection
