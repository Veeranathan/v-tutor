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
				</div>
			</div>

			<div class="col-md-8 col-xl-7">
				<div class="about-text">
					
				<div class="about-text">
    				<div class="about-intro">
        				<h1>More tutoring isn't always the answer</h1>
       					<p>
            				Sometimes, the most important step isn't doing more.
            				It's understanding what your child needs and finding
            				the right support.
        				</p>
    				</div>
    				<p>V-Tutor is a modern, dynamic online learning platform created by educators and technologists who share a passion for making quality education accessible across Australia. We believe every child deserves uninterrupted, personalised learning, and we use technology as the bridge that connects tutors and students in a seamless, secure, and engaging way.</p>
    				<p>Our platform is designed for simplicity, flexibility, and choice. With just a few clicks, parents and students can browse, filter, and book sessions with qualified tutors across a wide range of subjects aligned to the Australian curriculum. Whether it’s primary or secondary school support, V-Tutor ensures learning is personalised, effective, and convenient.</p>
    				<p>We go beyond being just another tutoring service — we are building a nationwide community of passionate educators and motivated learners. Our tutors bring not only subject expertise but also the skills to make learning interactive, outcome-focused, and enjoyable.</p>
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
<style>
	
.about-intro {
    margin-bottom: 25px;
}

.about-intro h1 {
    font-size: 24px;
    line-height: 1.3;
    font-weight: 700;
    margin-bottom: 15px;
}

.about-intro p {
    font-size: 16px;
    line-height: 1.7;
    color: #555;
}

@media (max-width: 767px) {
    .about-intro h1 {
        font-size: 28px;
    }
}

</style>
@endsection

