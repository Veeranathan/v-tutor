@extends('layouts.app')
@section('title')
<title>V-Tutor </title>
@endsection

@section('left_part')
{{-- @include('include.left_part') --}}
@include('include.header_menu_part')
@endsection
@section('content')
<!-- bannersec -->
<div class="top_mar"></div>
<div class="bannersec">
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleControls" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleControls" data-slide-to="1"></li>
            <li data-target="#carouselExampleControls" data-slide-to="2"></li>
        </ol>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <div class="banner_box">
            <img src="{{ public_asset('assets/images/ban1.jpg')}}" alt="">
            <div class="banner_tex_box">
                <div class="container">
                    <div class="banner_tex">
                        <strong>Offers & Benefits Related text</strong>
                        <b>Online face-to-face support</b>
                        <a href="#url" class="ler_mor">Learn more</a>
                    </div>
                </div>
            </div>
          </div>
        </div>
        <div class="carousel-item">
          <div class="banner_box">
            <img src="{{ public_asset('assets/images/ban1.jpg')}}" alt="">
            <div class="banner_tex_box">
                <div class="container">
                    <div class="banner_tex">
                        <strong>Offers & Benefits Related text</strong>
                        <b>Online face-to-face support</b>
                        <a href="#url" class="ler_mor">Learn more</a>
                    </div>
                </div>
            </div>
          </div>
        </div>
        <div class="carousel-item">
          <div class="banner_box">
            <img src="{{ public_asset('assets/images/ban1.jpg')}}" alt="">
            <div class="banner_tex_box">
                <div class="container">
                    <div class="banner_tex">
                        <strong>Offers & Benefits Related text</strong>
                        <b>Online face-to-face support</b>
                        <a href="#url" class="ler_mor">Learn more</a>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>

</div>
<!-- Find Tutors -->

<div class="find_tutors_sec">
    <div class="container">
        <div class="find_tutors_inr">
            <form method="get" action="{{ url('tutor-search-result') }}">
            <div class="row">
                <div class="col-sm-3">
                    <div class="find_drop">
                        <ul>
                            <li>
                                <span>I'm a </span>
                            </li>
                            <li>
                                <strong class="find_select">
                                    <select id="user_type" name="user_type">
                                        <option value="S">Student</option>
                                        <option value="P">Parent</option>
                                    </select>
                                </strong>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="find_drop">
                        <ul>
                            <li>
                                <span>Looking for</span>
                            </li>
                            <li>
                                <strong class="find_select">
                                    <select id="grade" name="grade">

                                        @if(@$grades)
                                        @foreach(@$grades as $grade)
                                        <option value="{{ @$grade->slug }}">{{ @$grade->grade_name }}</option>
                                        @endforeach
                                        @endif
                                        {{-- <option>Grade-2</option> --}}
                                        {{-- <option>Grade-1</option> --}}
                                    </select>
                                </strong>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="find_drop">
                        <ul>
                            <li>
                                <span>Tutor in</span>
                            </li>
                            <li>
                                <strong class="find_select">
                                    <select id="state" name="state">
                                        @if(@$states)
                                        @foreach(@$states as $state)
                                        <option value="{{ @$state->slug }}">{{ @$state->state_name }}</option>
                                        @endforeach
                                        @endif
                                        {{-- <option>NSW</option>
                                        <option>NSW-2</option>
                                        <option>NSW-1</option> --}}
                                    </select>
                                </strong>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="find_btn">
                        <input type="submit" value="Find Tutors" class="pg_btn" />
                        <em class="ser_icon"><img src="{{ public_asset('assets/images/search.png')}}" alt="" /></em>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

<!-- How does it work? -->

<section class="how_work_sec">
    <div class="container">
        <div class="page_hed">
            <h1>How does it work?</h1>
            <p>Get going in no time with 3 simple 's'teps...</p>
        </div>
        <div class="how_work_inr">
            <div class="row">
                <div class="col-sm-4">
                    <div class="how_work_box">
                        <div class="how_work_img">
                             <img src="{{ public_asset('assets/images/how_work1.png')}}" alt="">
                        </div>
                        <h4><span>01.</span> Search</h4>
                        <p>Choose a subject, topic, homework, project <br> you need help with</p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="how_work_box">
                        <div class="how_work_img">
                             <img src="{{ public_asset('assets/images/how_work3.png')}}" alt="">
                        </div>
                        <h4><span>02.</span> Select</h4>
                        <p>Pick from our list of safe and friendly <br> tutors using custom filters</p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="how_work_box">
                        <div class="how_work_img">
                             <img src="{{ public_asset('assets/images/how_work2.png')}}" alt="">
                        </div>
                        <h4><span>03.</span> Schedule</h4>
                        <p>Book sessions  with your choice of date, <br>  time and availability</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- What makes V-Tutor special? -->

<section class="makes_special_sec">
    <span class="bg_makes"><img src="{{ public_asset('assets/images/special_bg2.png')}}" alt="" /></span>
    <div class="container">
        <div class="makes_special_inr">
            <div class="row">
                <div class="col-sm-6">
                    <div class="makes_special_img">
                        <div class="special_img_bx">
                            <img src="{{ public_asset('assets/images/special_img1.jpg')}}" alt="">
                        </div>
                        <div class="special_img_bx">
                            <img src="{{ public_asset('assets/images/special_img2.jpg')}}" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="makes_faq">
                        <h5>What makes V-Tutor special?<!--  What makes V-Tutor special? --></h5>
                        <div class="makes_faq_bx">
                            <div class="accordion" id="accordionExample">
                              <div class="card">
                                <div class="card-header" id="headingOne">
                                  <h2 class="mb-0">
                                    <a class="btn btn-link btn-block text-left"  data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                      01. Improve your grades
                                    </a>
                                  </h2>
                                </div>

                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                  <div class="card-body">
                                    <p>Our friendly tutors are focused to improve school grades by matching your learning pace to achieve best results</p>
                                  </div>
                                </div>
                              </div>
                              <div class="card">
                                <div class="card-header" id="headingTwo">
                                  <h2 class="mb-0">
                                    <a class="btn btn-link btn-block text-left" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                     02. Improve your skills
                                    </a>
                                  </h2>
                                </div>
                                <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                  <div class="card-body">
                                   <p>Our experienced and knowledgeable tutors help improve your skills and understanding on subjects or topics</p>
                                  </div>
                                </div>
                              </div>
                              <div class="card">
                                <div class="card-header" id="headingThree">
                                  <h2 class="mb-0">
                                    <a class="btn btn-link btn-block text-left" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                     03. Improve your learning
                                    </a>
                                  </h2>
                                </div>
                                <div id="collapseThree" class="collapse show" aria-labelledby="headingThree" data-parent="#accordionExample">
                                  <div class="card-body">
                                    <p>Our objective tutorship with one-to-one attention will improve your learning for better outcome</p>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Top reasons to choose V-Tutor -->
<section class="top_reasons_sec">
    <div class="container">
        <div class="page_hed">
            <h2>Top reasons to choose V-Tutor</h2>
            <p>We are no-nonsense online tutoring platform and here are the reasons why...</p>
        </div>
        <div class="top_reasons_inr">
            <div class="row">
                <div class="col-sm-4">
                    <div class="top_reasons_box">
                        <span><img src="{{ public_asset('assets/images/top_re_icoin1.png')}}" alt="" /></span>
                        <h5>Tutors of your choice</h5>
                        <p>Filter and choose tutors based on subjects, experience, ratings etc.</p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="top_reasons_box">
                        <span><img src="{{ public_asset('assets/images/top_re_icoin2.png')}}" alt="" /></span>
                        <h5>No monthly commitments</h5>
                        <p>Pay-as-you-go only for sessions you book with no monthly commitments</p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="top_reasons_box">
                        <span><img src="{{ public_asset('assets/images/top_re_icoin3.png')}}" alt="" /></span>
                        <h5>Flexible booking options</h5>
                        <p>Book sessions  with flexibility based on your choice of days and time</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Meet our tutors -->

<section class="meet_tutors_sec">
    <em class="meet_tutors_bg"><img src="{{ public_asset('assets/images/meet_4.png')}}" alt="" /></em>
    <div class="container">
        <div class="page_hed">
            <h2>Meet our Tutors</h2>
            <p>Our safe and friendly tutors are chosen based on specific onboarding criteria...</p>
        </div>
        <div class="meet_tutors_inr">
            <div class="meet_tutors_panel">
                <div class="meet_tutors_slid">
                    <div class="owl-carousel">
                        @if(@$tutors)
                    @foreach(@$tutors as $tutor)
                    <div class="items">
                            <div class="meet_tutors_items">
                                <div class="meet_tutors_img">
                                    <span>
                                        @if(@$tutor->profile_pic)

                                            <img src="{{env('STORAGE_URL') . '/teacher_profile_pic/'.@$user->profile_pic}}" alt="">

                                    @else
                                        @if(@$tutor->avatar)
                                            <img src="{{@$user->avatar}}" alt="">
                                        @else
                                        <img src="{{ public_asset('assets/images/searchimg1.jpg') }}" alt="" />
                                        @endif
                                    @endif
                                        {{-- <img src="{{ public_asset('assets/images/meetimg1.png')}}" alt="" /> --}}
                                    </span>
                                </div>
                                <div class="meet_tutors_text">
                                    <h4> <a href="{{ url('tutor-public-profile') }}/{{ @$tutor->id }}/{{ @$tutor->slug }}" target="_blank">{{ @$tutor->f_name }} {{ @$tutor->l_name }}</a></h4>
                                    <p class="textLimit">{!! strip_tags(@$tutor->about_me) !!}</p>
                                    <ul class="ret_ul">
                                        @if(@$tutor->avg_review == 5)
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        @elseif(@$tutor->avg_review >= 4)
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <i class="fa fa-star rre_star"></i>
                                        @elseif(@$tutor->avg_review >= 3)
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <i class="fa fa-star rre_star"></i>
                                        <i class="fa fa-star rre_star"></i>
                                        @elseif(@$tutor->avg_review >= 2)
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <i class="fa fa-star rre_star"></i>
                                        <i class="fa fa-star rre_star"></i>
                                        <i class="fa fa-star rre_star"></i>
                                        @elseif(@$tutor->avg_review >= 1)
                                        <li><i class="fa fa-star"></i></li>
                                        <i class="fa fa-star rre_star"></i>
                                        <i class="fa fa-star rre_star"></i>
                                        <i class="fa fa-star rre_star"></i>
                                        <i class="fa fa-star rre_star"></i>
                                        @else
                                        <i class="fa fa-star rre_star"></i>
                                        <i class="fa fa-star rre_star"></i>
                                        <i class="fa fa-star rre_star"></i>
                                        <i class="fa fa-star rre_star"></i>
                                        <i class="fa fa-star rre_star"></i>
                                        @endif
                                        <li><b>{{ @$tutor->avg_review }}<strong> ({{ @$tutor->total_no_of_reviews }})</strong></b></li>
                                    </ul>
                                    <ul class="subj_ul">
                                        @if(@$tutor->getTutorShipPlan)
                                        @foreach(@$tutor->getTutorShipPlan as $plan)
                                        <li><b>{{ @$plan->getSubject->subject }}</b></li>
                                        @endforeach
                                        @endif
                                        {{-- <li class="sub_last"><b>+3</b></li> --}}
                                    </ul>
                                    <small>From $ {{ @$tutor->getTutorShipPlan->min('hourly_rate') ? @$tutor->getTutorShipPlan->min('hourly_rate') :0 }}/hr</small>
                                </div>
                            </div>
                        </div>

                    @endforeach
                    @endif

                        {{-- <div class="items">
                            <div class="meet_tutors_items">
                                <div class="meet_tutors_img">
                                    <span><img src="{{ public_asset('assets/images/meetimg2.png')}}" alt="" /></span>
                                </div>
                                <div class="meet_tutors_text">
                                    <h4> <a href="tutor-public-profile.html">Tanmay S.</a></h4>
                                    <p>Lorem ipsum dolor amet aconsectetur adipiscing caption here</p>
                                    <ul class="ret_ul">
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><b>4.6<strong> (102)</strong></b></li>
                                    </ul>
                                    <ul class="subj_ul">
                                        <li><b>Trigonometry</b></li>
                                        <li><b>Physics</b></li>
                                        <li class="sub_last"><b>+3</b></li>
                                    </ul>
                                    <small>From A$40/hr</small>
                                </div>
                            </div>
                        </div>
                        <div class="items">
                            <div class="meet_tutors_items">
                                <div class="meet_tutors_img">
                                    <span><img src="{{ public_asset('assets/images/meetimg3.png')}}" alt="" /></span>
                                </div>
                                <div class="meet_tutors_text">
                                    <h4> <a href="tutor-public-profile.html">Tanmay S.</a></h4>
                                    <p>Lorem ipsum dolor amet aconsectetur adipiscing caption here</p>
                                    <ul class="ret_ul">
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><b>4.6<strong> (102)</strong></b></li>
                                    </ul>
                                    <ul class="subj_ul">
                                        <li><b>Trigonometry</b></li>
                                        <li><b>Physics</b></li>
                                        <li class="sub_last"><b>+3</b></li>
                                    </ul>
                                    <small>From A$40/hr</small>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <em class="meet_bg_3"><img src="{{ public_asset('assets/images/meet_bg3.png')}}" alt="" /></em>
</section>

<!-- Tutors - Why you should join our team? -->

<section class="team_sec">
    <div class="container">
        <div class="page_hed">
            <h2>Tutors – Why should you join us?</h2>
            <p>Our dynamic and friendly platform will get your tutoring journey started in no time...</p>
        </div>
        <div class="team_inr">
            <div class="row">
                <div class="col-sm-4">
                    <div class="team_box">
                        <span>1</span>
                        <h5><a href="#url">Choose your time</a></h5>
                        <p>Lock in with flexible time slots and hours that suit you any day</p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="team_box">
                        <span>2</span>
                        <h5><a href="#url">Earn more money</a></h5>
                        <p>Opt for full-time, part-time, off work or during semester holidays</p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="team_box">
                        <span>3</span>
                        <h5><a href="#url">Be the difference</a></h5>
                        <p>Influence and impart learning by sharing your knowledge</p>
                    </div>
                </div>
            </div>
            <div class="team_btn">
                <a href="{{route('reg.home')}}" class="pg_btn">Join our team</a>
            </div>
        </div>
    </div>
</section>

<!-- How did we do? -->
<section class="how_did_we_do">
    <div class="container">
        <div class="page_hed">
            <h3>How did we do?</h3>
            <p>Testimonials for our esteemed clients on how we made a difference...</p>
        </div>
        <div class="how_did_we_do_inr">
            <div class="how_did_inr_lid">
                <div class="owl-carousel">

                    <div class="item">
                        <div class="how_did_inr_item">
                            <div class="how_did_inr_box">
                                <div class="how_did_inr_top">
                                    <ul class="testi_star">
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                    </ul>
                                </div>
                                <p>Lorem ipsum dolor sit amet consectetur the adipiscing elit. Suspendisse vitae the  pharetra erat fusce quis sucipit leo nulla dummy text scelerisque vitae pharetra fusce.</p>
                            </div>
                            <div class="how_did_inr_img">
                                <div class="media">
                                    <span><img src="{{ public_asset('assets/images/testi_img1.png')}}" alt="" /></span>
                                    <div class="media-body">
                                        <h6>John Dacascos</h6>
                                        <p>Australia</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="how_did_inr_item">
                            <div class="how_did_inr_box">
                                <div class="how_did_inr_top">
                                    <ul class="testi_star">
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                    </ul>
                                </div>
                                <p>Lorem ipsum dolor sit amet consectetur the adipiscing elit. Suspendisse vitae the  pharetra erat fusce quis sucipit leo nulla dummy text scelerisque vitae pharetra fusce.</p>
                            </div>
                            <div class="how_did_inr_img">
                                <div class="media">
                                    <span><img src="{{ public_asset('assets/images/testi_img1.png')}}" alt="" /></span>
                                    <div class="media-body">
                                        <h6>John Dacascos</h6>
                                        <p>Australia</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<!-- class_time -->

<section class="class_time">
    <div class="container">
        <div class="class_time_iner">
            <div class="row">
                <div class="col-sm-4">
                    <div class="class_time_bx">
                        <img src="{{ public_asset('assets/images/time_img3.png')}}" alt="">
                        <h5>10,000 sessions</h5>
                        <p>and counting, more sessions everyday</p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="class_time_bx">
                        <img src="{{ public_asset('assets/images/time_img1.png')}}" alt="">
                        <h5>50,461 Hours</h5>
                        <p>of productive time spent on site</p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="class_time_bx">
                        <img src="{{ public_asset('assets/images/time_img2.png')}}" alt="">
                        <h5>1600+ Topics</h5>
                        <p>handled by our experienced tutors</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('footer')
    @include('include.footer')


</div>
@endsection

@section('script')
    {{-- @include('include.script') --}}
<script src="{{ url('/') }}/assets/js/jquerymin.js"></script>
    <script src="{{ url('/') }}/assets/js/bootstrap.js"></script>
    <script src="{{ url('/') }}/assets/js/carouselscript.js"></script>
    <script src="{{ url('/') }}/assets/js/owl.carousel.js"></script>
    <script src="{{ url('/') }}/assets/js/moment.js"></script>
    <script src="{{ url('/') }}/assets/js/jquery-ui.js"></script>
    <script src="{{ url('/') }}/assets/js/semantic.min.js"></script>
    <script src="{{ url('/') }}/assets/js/custom.js"></script>
@endsection

