@extends('layouts.app')

@section('page_title', 'V-Tutor | Privacy Policy – Online Tutors Australia')
@section('meta_description', 'Read V-Tutor’s privacy policy for our online tutoring platform in Australia. Understand how we protect data for students and verified tutors in Maths, Science, and English.')
@section('meta_keywords', 'privacy policy, online tutoring Australia, online tutors, qualified tutors, Maths tutors, Science tutors, English tutors, tutoring platform Australia')

@section('left_part')
{{-- @include('include.left_
	part') --}}
@include('include.header_menu_part')
@endsection
@section('content')
@php
$title = 'Privacy Policy';
@endphp
<!-- ================= HERO (Modern Card Header) ================= -->
@include('include.page_hero', [
    'title' => $title,
    'showBreadcrumb' => true
])
	
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

