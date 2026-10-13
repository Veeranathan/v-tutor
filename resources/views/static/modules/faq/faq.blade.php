@extends('layouts.app')

@section('page_title', 'V-Tutor | Online Tutors & Tutoring Platform Australia – FAQ')
@section('meta_description', 'Find answers to the most common questions about V-Tutor, including how online tutoring works, booking sessions, tutor verification, payments, free trial details, and more across Australia.')
@section('meta_keywords', 'V-Tutor FAQ, online tutoring FAQ, Australia tutors help, student FAQ, tutor FAQ, V-Tutor support, ACARA tutoring FAQ, WWCC tutors Australia')

@section('og_title', 'FAQ V-Tutor | Online Tutoring Platform Australia')
@section('og_description', 'Get answers to popular questions about online tutoring, booking, tutor verification, payments, and other V-Tutor services in Australia.')
@section('og_image', asset('images/vtutor-og-image.jpg'))

@section('twitter_title', 'FAQ V-Tutor | Online Tutoring Platform Australia')
@section('twitter_description', 'Find answers to common questions about V-Tutor’s tutoring services, booking system, tutor verification, and more.')
@section('twitter_image', asset('images/vtutor-og-image.jpg'))

@section('canonical', url()->current())
@section('language', 'en-au')

@section('left_part')
{{-- @include('include.left_part') --}}
@include('include.header_menu_part')
@endsection
@section('content')
<!-- bannersec -->
<div class="top_mar"></div>
<section class="about-banner" style="background-image: url({{url('/')}}/assets/images/faq-banner.jpg);">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
						<li class="breadcrumb-item active" aria-current="page">FAQ</li>
					</ol>
				</nav>
				<div class="inner-banner-title">
					<h1 class="title">
						Frequently Asked Questions (FAQ)
					</h1>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="makes_special_sec faq-sec">
	<div class="container">
		<div class="makes_special_inr">
			<div class="row">
				<div class="col-md-12 col-xl-10 offset-xl-1">
					<div class="makes_faq p-0">
						<div class="page_hed">
							<h3>Frequently Asked Questions?</h3>
							<p>Get answers to your most common queries here...</p>
						</div>
						<div class="text-center">
							<ul class="nav nav-tabs faq-tabs">
								<li class=""><a data-toggle="tab" href="#home" class="active">Students</a></li>
								<li><a data-toggle="tab" href="#menu1">Tutors</a></li>

							</ul>
						</div>
						<div class="tab-content">
							<div id="home" class="tab-pane fade show in active">
								<div class="makes_faq_bx newfaq">
									<div class="accordion" id="accordionExample">
										@if(@$StudentFaqModel)
										@foreach(@$StudentFaqModel as $faq)
										<div class="card">
											<div class="card-header" id="headingOne">
												<h2 class="mb-0">
													<a class="btn-link btn-block text-left"  data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
														{{ @$faq->question }}
													</a>
												</h2>
											</div>
											<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
												<div class="card-body">
													<p>{!! strip_tags(@$faq->answer) !!}</p>
												</div>
											</div>
										</div>
										@endforeach
										@endif

									</div>
								</div>
							</div>
							<div id="menu1" class="tab-pane fade in">
								<div class="makes_faq_bx newfaq">
									<div class="accordion" id="accordionExample2">
										@if(@$TutorFaqModel)
										@foreach(@$TutorFaqModel as $key=>$faq)
										<div class="card">
											<div class="card-header" id="headingOne{{ $key }}">
												<h2 class="mb-0">
													<a class="btn-link btn-block text-left"  data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
														{{ @$faq->question }}
													</a>
												</h2>
											</div>
											<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
												<div class="card-body">
													<p>{{ @$faq->answer }}</p>
												</div>
											</div>
										</div>
										@endforeach
										@endif
										<div class="card">
											<div class="card-header" id="headingnewOne">
												<h2 class="mb-0">
													<a class=" btn-link btn-block text-left"  data-toggle="collapse" data-target="#collapsenewOne" aria-expanded="true" aria-controls="collapsenewOne">
													01. How do I sign up as a V-Tutor?
													</a>
												</h2>
											</div>
											<div id="collapsenewOne" class="collapse show" aria-labelledby="headingnewOne" data-parent="#accordionExample2">
												<div class="card-body">
													<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,</p>
												</div>
											</div>
										</div>
										{{-- <div class="card">
											<div class="card-header" id="headingnewTwo">
												<h2 class="mb-0">
													<a class="btn-link btn-block text-left collapsed" data-toggle="collapse" data-target="#collapsenewTwo" aria-expanded="false" aria-controls="collapsenewTwo">
													02. What is the process to onboard as V-Tutor?
													</a>
												</h2>
											</div>
											<div id="collapsenewTwo" class="collapse " aria-labelledby="headingnewTwo" data-parent="#accordionExample2">
												<div class="card-body">
													<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
												</div>
											</div>
										</div>
										<div class="card">
											<div class="card-header" id="headingnewThree">
												<h2 class="mb-0">
													<a class="btn-link btn-block text-left collapsed" data-toggle="collapse" data-target="#collapsenewThree" aria-expanded="false" aria-controls="collapsenewThree">
													03. How long does it take to onboard?
													</a>
												</h2>
											</div>
											<div id="collapsenewThree" class="collapse " aria-labelledby="headingnewThree" data-parent="#accordionExample2">
												<div class="card-body">
													<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,</p>
												</div>
											</div>
										</div>
										<div class="card">
											<div class="card-header" id="headingnewfour">
												<h2 class="mb-0">
													<a class="btn-link btn-block text-left collapsed" data-toggle="collapse" data-target="#collapsenewfour" aria-expanded="false" aria-controls="collapsenewfour">
													04. Where can I update my profile?
													</a>
												</h2>
											</div>
											<div id="collapsenewfour" class="collapse " aria-labelledby="headingnewfour" data-parent="#accordionExample2">
												<div class="card-body">
													<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,</p>
												</div>
											</div>
										</div>
										<div class="card">
											<div class="card-header" id="headingnewfive">
												<h2 class="mb-0">
													<a class="btn-link btn-block text-left collapsed" data-toggle="collapse" data-target="#collapsenewfive" aria-expanded="false" aria-controls="collapsenewfive">
													05. How do I update my tutorship plan?
													</a>
												</h2>
											</div>
											<div id="collapsenewfive" class="collapse " aria-labelledby="headingnewfive" data-parent="#accordionExample2">
												<div class="card-body">
													<p>when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic </p>
												</div>
											</div>
										</div>
										<div class="card">
											<div class="card-header" id="headingnewsix">
												<h2 class="mb-0">
													<a class="btn-link btn-block text-left collapsed" data-toggle="collapse" data-target="#collapsenewsix" aria-expanded="false" aria-controls="collapsenewsix">
													06. How do I fix my rates?
													</a>
												</h2>
											</div>
											<div id="collapsenewsix" class="collapse " aria-labelledby="headingnewsix" data-parent="#accordionExample2">
												<div class="card-body">
													<p>when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic </p>
												</div>
											</div>
										</div>
										<div class="card">
											<div class="card-header" id="headingnewseven">
												<h2 class="mb-0">
													<a class="btn-link btn-block text-left collapsed" data-toggle="collapse" data-target="#collapsenewseven" aria-expanded="false" aria-controls="collapsenewseven">
													07. How do I schedule my availability?
													</a>
												</h2>
											</div>
											<div id="collapsenewseven" class="collapse " aria-labelledby="headingnewseven" data-parent="#accordionExample2">
												<div class="card-body">
													<p>when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic </p>
												</div>
											</div>
										</div>
										<div class="card">
											<div class="card-header" id="headingneweight">
												<h2 class="mb-0">
													<a class="btn-link btn-block text-left collapsed" data-toggle="collapse" data-target="#collapseneweight" aria-expanded="false" aria-controls="collapseneweight">
													08. Where can I find my sessions?
													</a>
												</h2>
											</div>
											<div id="collapseneweight" class="collapse " aria-labelledby="headingneweight" data-parent="#accordionExample2">
												<div class="card-body">
													<p>when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic </p>
												</div>
											</div>
										</div>
										<div class="card">
											<div class="card-header" id="headingnewninty">
												<h2 class="mb-0">
													<a class="btn-link btn-block text-left collapsed" data-toggle="collapse" data-target="#collapsenewninty" aria-expanded="false" aria-controls="collapsenewninty">
													09. Can I cancel my booked class?
													</a>
												</h2>
											</div>
											<div id="collapsenewninty" class="collapse " aria-labelledby="headingnewninty" data-parent="#accordionExample2">
												<div class="card-body">
													<p>when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic </p>
												</div>
											</div>
										</div>
										<div class="card">
											<div class="card-header" id="headingnewtenty">
												<h2 class="mb-0">
													<a class="btn-link btn-block text-left collapsed" data-toggle="collapse" data-target="#collapsenewtenty" aria-expanded="false" aria-controls="collapsenewtenty">
													10. Where can I find my payment details?
													</a>
												</h2>
											</div>
											<div id="collapsenewtenty" class="collapse " aria-labelledby="headingnewtenty" data-parent="#accordionExample2">
												<div class="card-body">
													<p>when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic </p>
												</div>
											</div>
										</div> --}}
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
@endsection
@section('footer')
@include('include.footer')
@endsection
@section('script')
@include('include.script')
@endsection
