@extends('layouts.app')

@section('page_title', 'V-Tutor | Assessment')

@section('left_part')
@include('include.header_menu_part')
@endsection

@section('content')
@php
$title = 'Student Diagnostic Assessment ';
@endphp
<!-- ================= HERO (Modern Card Header) ================= -->
@include('include.page_hero', [
    'title' => $title,
    'showBreadcrumb' => false
])


<section class="makes_special_sec faq-sec mt-6 mb-6">
    <div class="container">
        <div class="row">
            <div class="col-xl-10 offset-xl-1 col-md-12">
                <div class="assessment-box text-center">
                    <div class="status-icon mb-3">
                        <i class="fa fa-exclamation-circle text-danger" style="font-size: 48px;"></i>
                    </div>
                    <h2 class="unavailable-msg text-center">
                        This assessment is not yet available.
                    </h2>
                    <p class="text-muted mt-2">
                        Please check back later or contact support.
                    </p>
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
.assessment-box {
    background: #fff;
    border-top: 6px solid #b80f0a;
    border-radius: 16px;
    padding: 50px 40px;
    box-shadow: 0 20px 45px rgba(0,0,0,0.15);
}

.unavailable-msg {
    color: #b80f0a;
    font-weight: 700;
    font-size: 26px;
    margin: 0;
}

.check-box {
    margin-bottom: 12px;
}

.check-box input[type="radio"] {
    opacity: 0;
    position: absolute;
}

.check-box label {
    padding-left: 35px;
    cursor: pointer;
    background: url({{ public_asset('assets/images/check.png') }}) no-repeat left center;
}

.check-box input[type="radio"]:checked + label {
    background: url({{ public_asset('assets/images/checked.png') }}) no-repeat left center;
}

.passage-box {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 20px;
}

.section-title {
    font-weight: 700;
    font-size: 22px;
    margin: 25px 0;
    text-align: center;
    width: 100%;
    position: relative;
}

.section-title::after {
    content: "";
    display: block;
    width: 60px;
    height: 3px;
    background: #b80f0a;
    margin: 10px auto 0;
    border-radius: 2px;
}

.question-image {
    margin: 20px 0;
    text-align: left;
}

.question-image img {
    display: block;
    width: 100%;
    max-width: 500px;
    height: auto;
    border-radius: 8px;
    border: 1px solid #ddd;
}

@media (max-width: 768px) {
    .assessment-box {
        padding: 30px 20px;
    }
    
    .unavailable-msg {
        font-size: 20px;
    }

    .question-image img {
        max-width: 100%;
    }
}
</style>

@endsection