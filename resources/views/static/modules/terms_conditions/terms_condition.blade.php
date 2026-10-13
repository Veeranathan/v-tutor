@extends('layouts.app')

@section('page_title', 'V-Tutor | Terms & Conditions – Online Tutoring Australia')
@section('meta_description', 'Read the terms and conditions for using V-Tutor, Australia’s online tutoring platform. Understand policies for qualified Maths, Science, and English tutors and students.')
@section('meta_keywords', 'terms and conditions, online tutoring Australia, online tutors, qualified tutors, Maths tutors, Science tutors, English tutors, tutoring platform Australia')

@section('left_part')
{{-- @include('include.left_part') --}}
@include('include.header_menu_part')
@endsection
@section('content')
<!-- bannersec -->
<!-- bannersec -->
	{{-- <div class="top_mar"></div>
    <section class="about-banner">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
							<li class="breadcrumb-item active" aria-current="page">{!! strip_tags(@$contentDetails->title) !!}</li>
						</ol>
					</nav>
					<div class="inner-banner-title">
						<h1 class="title">
		            {!! strip_tags(@$contentDetails->title) !!}
		          </h1>
		          @include('include.errors') </div>
				</div>
			</div>
		</div>
	</section> --}}
<section class="terms-sec">
	<div class="container">
		<div class="row">
			<div class="col-12">

				<div class="privacy-content">
					{!! @$contentDetails->description!!}

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

