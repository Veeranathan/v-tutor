@extends('layouts.app')
@section('title')
<title>V-Tutor  | Login</title>
@endsection
@section('left_part')
{{-- @include('include.left_part') --}}
@include('include.header_menu_part')
@endsection
@section('content')
<!-- bannersec -->
<div class="top_mar"></div>
<section class="login-body">
	{{--
	<div class="login-info">
		<div class="login-details">

			@include('include.errors')

		</div>
	</div> --}}
	<div class="login-info xyz">
		<div class="login-details">
			<div class="upper-login">

			</div>

			<div class="login-from ">
				<div class="msgg">

				@include('include.errors')

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
