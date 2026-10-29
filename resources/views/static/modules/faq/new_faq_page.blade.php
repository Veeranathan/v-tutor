@extends('layouts.app')

@section('page_title', 'V-Tutor | FAQ Online Tutors & Tutoring Platform Australia')
@section('meta_description', 'Find answers to common questions about V-Tutor’s online tutoring platform in Australia, including how online tutoring works, booking sessions, tutor verification, and more.')
@section('meta_keywords', 'online tutoring Australia, online tutors, qualified tutors, FAQ, Maths tutors, Science tutors, English tutors, tutoring platform Australia')

@section('left_part')
@include('include.header_menu_part')
@endsection
@section('content')
@php
$title = 'FAQs';
@endphp
<!-- ================= HERO (Modern Card Header) ================= -->
@include('include.page_hero', [
    'title' => $title,
    'showBreadcrumb' => true
])
<section class="makes_special_sec faq-sec">
	<div class="container">
		<div class="makes_special_inr">
			<div class="row">
				<div class="col-md-12 col-xl-10 offset-xl-1">
					<div class="makes_faq p-0">						
					<div class="page_hed faq-intro">
    					<h1>Everything You Need to Know About V-Tutor</h1>
   						<p>
        				Find answers about our learning programs, diagnostic assessment,
        				tutors, bookings and how we help you explore the right learning
        				support for your child.
    					</p>
					</div>

						<div class="text-center">
							<ul class="nav nav-tabs faq-tabs">
								<li><a data-toggle="tab" href="#tut_faq" class="active">Tutors</a></li>
								<li class=""><a data-toggle="tab" href="#par_faq">Parents</a></li>

							</ul>
						</div>
						<div class="tab-content">
							<div id="tut_faq" class="tab-pane fade in show active">
								<div class="makes_faq_bx newfaq">
									<div class="accordion" id="accordionExample2">
										@if(@$TutorFaqModel)
                                            @foreach(@$TutorFaqModel as $key => $faq)
                                                <div class="card">
                                                    <div class="card-header" id="headingOne{{ $key }}">
                                                        <h2 class="mb-0">
                                                            <a class="btn-link btn-block text-left {{ $key == 0 ? '' : 'collapsed' }}"  data-toggle="collapse" data-target="#collapseOne{{ $key }}" aria-expanded="true" aria-controls="collapseOne{{ $key }}">
                                                                {{ @$faq->question }}
                                                            </a>
                                                        </h2>
                                                    </div>
                                                    <div id="collapseOne{{ $key }}" class="collapse {{ $key == 0 ? 'show' : '' }}" aria-labelledby="headingOne{{ $key }}" data-parent="#accordionExample2">
                                                        <div class="card-body">
                                                            <div class="faq_answer">{!! @$faq->answer !!}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
										@endif

										{{-- <div class="card">
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
										</div> --}}
									</div>
								</div>
							</div>

							<div id="par_faq" class="tab-pane fade  in ">
								<div class="makes_faq_bx newfaq">
									<div class="accordion" id="accordionExample">
										@if(@$StudentFaqModel)
											@foreach(@$StudentFaqModel as $sfk => $sfv)
												<div class="card">
                                                    <div class="card-header" id="StheadingOne{{ $sfk }}">
                                                        <h2 class="mb-0">
                                                            <a class="btn-link btn-block text-left {{ $sfk == 0 ? '' : 'collapsed' }}"  data-toggle="collapse" data-target="#StcollapseOne{{ $sfk }}" aria-expanded="true" aria-controls="StcollapseOne{{ $sfk }}">
                                                                {{ @$sfv->question }}
                                                            </a>
                                                        </h2>
                                                    </div>
                                                    <div id="StcollapseOne{{ $sfk }}" class="collapse {{ $sfk == 0 ? 'show' : '' }}" aria-labelledby="StheadingOne{{ $sfk }}" data-parent="#accordionExample">
                                                        <div class="card-body">
                                                            <div class="faq_answer">{!! @$sfv->answer !!}</div>
                                                        </div>
                                                    </div>
                                                </div>
												{{-- <div class="card">
													<div class="card-header" id="headingOne">
														<h2 class="mb-0">
															<a class="btn-link btn-block text-left"  data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
																{{ @$faq->question }}
															</a>
														</h2>
													</div>
													<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
														<div class="card-body">
															//<p>{!! strip_tags(@$faq->answer) !!}</p>
															<div class="faq_answer">{!! @$faq->answer !!}</div>
														</div>
													</div>
												</div> --}}
											@endforeach
										@endif
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
<style>
	
.faq-intro {
    margin-bottom: 30px;
}

.faq-intro h1 {
    font-size: 24px;
    line-height: 1.3;
    font-weight: 700;
    margin-bottom: 15px;
}

.faq-intro p {
    font-size: 24px;
    line-height: 1.7;
}

@media (max-width: 767px) {
    .faq-intro h1 {
        font-size: 28px;
    }

    .faq-intro p {
        font-size: 16px;
    }
}

</style>
@endsection
