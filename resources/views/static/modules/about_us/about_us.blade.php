@extends('layouts.app')

@section('page_title', 'V-Tutor | About Our Online Tutoring Platform Australia')
@section('meta_description', 'Learn about V-Tutor, Australia’s trusted online tutoring platform. Connect with qualified Maths, Science, and English tutors for online tutoring and personalised learning.')
@section('meta_keywords', 'online tutoring Australia, online tutors, qualified tutors, Maths tutors, Science tutors, English tutors, tutoring platform Australia')

@section('left_part')
@include('include.header_menu_part')
@endsection

@section('content')
@php
$title = 'About Us';
@endphp
<!-- ================= HERO (Modern Card Header) ================= -->
@include('include.page_hero', [
    'title' => $title,
    'showBreadcrumb' => true
])

<section class="bannertext-sec">
	<div class="container">
		<div class="row align">
			<div class="col-md-4 col-xl-5">
				<div class="about-wrapper">

                    <div class="about__thumb ml-100">
						<img src="{{ public_asset('assets/images/About_Us_Image_1.svg')}}" alt="V-Tutor About Us – online tutoring Australia with qualified English, Maths and Science tutors">
					</div>
                    {{-- <div class="about__banner mt--210">
						<img src="{{ public_asset('assets/images/About_Us_Image_2.svg')}}" alt="">
					</div> --}}
                    <!---<div class="about__student ml-270 mt--80">
                           <a href="#">
                              <img src="{{ public_asset('assets/images/meeting8.png')}}" alt="">
                              <img src="{{ public_asset('assets/images/meeting7.png')}}" alt="">
                              <img src="{{ public_asset('assets/images/meeting6.png')}}" alt="">
                              <img src="{{ public_asset('assets/images/meeting5.png')}}" alt="">
                           </a>
                           <p>Join over <span>4,000+</span> students</p>
                        </div>-->
				</div>
			</div>

			<div class="col-md-8 col-xl-7">
				<div class="about-text">
					<p>V-Tutor is a modern, dynamic online learning platform created by educators and technologists who share a passion for making quality education accessible across Australia. We believe every child deserves uninterrupted, personalised learning, and we use technology as the bridge that connects tutors and students in a seamless, secure, and engaging way.</p>

					<p>Our platform is designed for simplicity, flexibility, and choice. With just a few clicks, parents and students can browse, filter, and book sessions with qualified tutors across a wide range of subjects aligned to the Australian curriculum. Whether it’s primary or secondary school support, V-Tutor ensures learning is personalised, effective, and convenient.</p>

					<p>We go beyond being just another tutoring service — we are building a nationwide community of passionate educators and motivated learners. Our tutors bring not only subject expertise but also the skills to make learning interactive, outcome-focused, and enjoyable.</p>

					{{-- <h2>Who is V-Tutor?</h2>
					<p>V-Tutor is a young and dynamic learning platform created and promoted by teachers and technologists who are passionate about learning and online tutoring. With most of us impacted by lockdown or restricted schooling, it is important to ensure children  get uninterrupted learning. Our children have the right to get the best education and we at V-Tutor believe in using technology as the most efficient and effective tool to impart learning. We also believe in a simple and easy booking process in which to schedule and even cancel sessions without hassle. Here at V-Tutor, you will also get the best possible choices of excellent tutors and a wide range of subjects under the Australian curriculum. </p>
					<p> We have conceived and designed a responsive online platform to give you the best possible and hassle-free experience to filter, choose and Book sessions  on the go. Our V-Tutors are committed to make your learning interesting and interactive with focus on best outcome from sessions. We have kept our costs low by charging per class, not by the hour, so you can benefit economically, and so we can ensure efficiency. We are committed to learn on how we can improve by taking your feedback seriously. We can assure a secure platform with strict onboarding measures for tutors with all classroom sessions recorded for quality.</p> --}}

					{{-- <h3>Why should you V-Tutor?</h3>
					<p>Here are the top reasons why you should tutor with us:</p> --}}
					{{-- <div class="about__list mb-35">
						<ul>
							<li class="d-flex align-items-center"> <img src="{{ public_asset('assets/images/tick.png')}}"> Best choice of tutors with flexible and easy booking</li>
							<li class="d-flex align-items-center"> <img src="{{ public_asset('assets/images/tick.png')}}">  Pay as you book with lowest rates in the tutoring industry</li>
							<li class="d-flex align-items-center">  <img src="{{ public_asset('assets/images/tick.png')}}">  30-minute quality classroom sessions both economic & efficient</li>
							<li class="d-flex align-items-center"> <img src="{{ public_asset('assets/images/tick.png')}}"> Safe platform for children with quality tutors and all sessions recorded</li>
							<li class="d-flex align-items-center">  <img src="{{ public_asset('assets/images/tick.png')}}">Responsive team of tutors focusing on best outcome for your children</li>
						</ul>
					</div> --}}

					{{-- <p>At V-Tutor, we combine technology with human connection to give families and tutors a unique advantage:</p>
					<div class="about__list mb-35">
						<ul>
							<li> <b>Nationwide Reach</b> – Tutors and students can connect across all Australian states and territories.</li>
							<li>  <b>Flexible Booking</b> – Easy scheduling, rescheduling, and cancellation at your convenience.</li>
							<li>   <b>Transparent Pricing</b> – Pay per session with flexible tutor-set rates, giving parents choice and tutors control.</li>
							<li> <b>Interactive 30–60 Minute Sessions</b> – Designed for efficiency, engagement, and maximum impact.</li>
							<li> <b>Tutor Independence</b> – Tutors choose their hours, subjects, and rates, creating true flexibility.</li>
							<li> <b>Safety First</b> – Every tutor is verified through Working With Children Checks, with strict onboarding standards.</li>
							<li> <b>Secure & Recorded Sessions</b> – All classes are hosted on a safe platform, with recordings available for quality and feedback.</li>
							<li> <b>Continuous Improvement</b> – We value feedback from parents, students, and tutors to keep evolving our platform.</li>
						</ul>
					</div>

					<h2>Why choose V-Tutor?</h2>
					<p>For parents and students:</p>
					<div class="about__list mb-35">
						<ul class="gj_y_ps">
							<li class=""> Access to a wide choice of experienced, trusted tutors.</li>
							<li class=""> Flexible, convenient booking and scheduling.</li>
							<li class="">  Safe, transparent, and affordable online tutoring aligned with the Australian curriculum.</li>
						</ul>
					</div>

					<p>For tutors:</p>
					<div class="about__list mb-35">
						<ul class="gj_y_tut">
							<li class=""> Freedom to choose your hours, subjects, and rates.</li>
							<li class=""> Nationwide reach to connect with students across Australia.</li>
							<li class="">  Supportive, independent teaching environment with no micromanagement.</li>
						</ul>
					</div> --}}
				</div>
			</div>
		</div>
	</div>
</section>



{{-- <section class="how_did_we_do misssec">
	<div class="container">
		<div class="page_hed">
			<h3>Where are we headed?</h3>
			<p>we would like to be your most preferred online learning partner...</p>
		</div>
		<div class="row">

			<div class="col-md-6">
				<div class="mis_cont">
					<div class="media_img">
						<img src="{{ public_asset('assets/images/vis.png')}}">
					</div>
					<div class="media-body">
						<h6>Our Vision</h6>
						<p>Be the most preferred online platform of private tutoring for students and tutors to interact, schedule sessions for academic and non-academic learning using virtual classrooms empowered by technology.</p>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="mis_cont">
					<div class="media_img">
						<img src="{{ public_asset('assets/images/mis.png')}}">
					</div>
					<div class="media-body">
						<h6>Our Mission</h6>
						<p>To be the best web portal for remote online learning by providing technology powered platform for tutors to impart learning, an asset for students and parents for academic and non-academic learning.</p>
					</div>
				</div>
			</div>
		</div>

	</div>
</section> --}}






@endsection

@section('footer')
    @include('include.footer')
@endsection

@section('script')
    @include('include.script')

@endsection

