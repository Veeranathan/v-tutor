@extends('layouts.app') 

@php
    $title = '';
    $description = '';
    $keywords = '';

    if ($pageType === 'subject') {
        $subject = $pageConfig['page_short_name'] ?? 'Tutoring';

        $title = "Online {$subject} Tutoring Australia | {$subject} Tutors | V-Tutor";

        $description = "Expert {$subject} tutoring in Australia for Year 1–12 students. Improve confidence, close learning gaps and achieve academic success with personalised online lessons.";

        $keywords = "{$subject} tutoring Australia, online {$subject} tutor, {$subject} classes online, {$subject} tutor Australia, learn {$subject} online, online tutoring Australia, online tutors Australia";
    }

    elseif ($pageType === 'year') {
        $year = str_replace('year-', '', request()->route('slug'));

        $title = "Year {$year} Tutoring Programs Australia | Online Tutors | V-Tutor";

        $description = "Year {$year} tutoring programs for Maths, English and Science. Designed to build strong foundations and improve academic performance across Australia.";

        $keywords = "Year {$year} tutoring, Year {$year} online classes, Year {$year} maths English science tutoring Australia, online tutoring Australia, online tutors Australia";
    }

    elseif ($pageType === 'state') {
        $state = $pageConfig['hero']['title'] ?? 'Australia';

        $title = "Top Tutoring Programs in {$state} | Online Tutors | V-Tutor";

        $description = "Find the best tutoring programs in {$state} for Maths, English and Science. Personalised learning aligned with local curriculum for school students.";

        $keywords = "tutoring in {$state}, {$state} tutors, online tutoring {$state}, maths English science tutors {$state},online tutoring Australia, online tutors Australia";
    }

    else {
        $title = "Online Tutoring Australia | Maths, English, Science | V-Tutor";
        $description = "Find expert online tutors across Australia for Maths, English and Science. Personalised learning programs for school students.";
        $keywords = "online tutoring Australia, maths tutor, English tutor, science tutor";
    }
@endphp

@section('page_title', $title)
@section('meta_description', $description)
@section('meta_keywords', $keywords)

@section('left_part')
@include('include.header_menu_part')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"/>
<style>
.hero {
  width: 100%;
  min-height: 15vh;
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  overflow: hidden;
}

.hero .hero-bg img {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  z-index: 1;
}

.hero .hero-bg::before {
  content: "";
  position: absolute;
  inset: 0;
  background: rgba(68, 68, 68, 0.55);
  z-index: 2;
}

.hero .container {
  position: relative;
  z-index: 3;
  padding: 120px 15px;
}

.hero h1 {
  font-size: 48px;
  font-weight: 700;
  color: #ffffff !important;
}

.hero p {
  font-size: 16px;
  color: rgba(255,255,255,0.88);
  max-width:700px;
  margin: 0 auto;
}
/* ==========================
   HERO BREADCRUMB
========================== */
.hero-with-breadcrumb .hero-breadcrumb {
  margin-bottom: 10px;
}

.hero-with-breadcrumb .breadcrumb {
  background: transparent;
  padding: 0;
  margin: 0;
}

.hero-with-breadcrumb .breadcrumb-item,
.hero-with-breadcrumb .breadcrumb-item a {
  color: rgba(255, 255, 255, 0.9);
  font-size: 14px;
  text-decoration: none;
}

.hero-with-breadcrumb .breadcrumb-item a:hover {
  text-decoration: underline;
}

.hero-with-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
  color: rgba(255, 255, 255, 0.7);
}
/* ==========================
   TYPED TEXT
========================== */
#typed-text { white-space: nowrap; }

.typed-cursor {
  margin-left: 4px;
  font-weight: 700;
  color: #ffffff !important;
  animation: blink 1s infinite;
}

@keyframes blink {
  0%,50%,100% { opacity: 1; }
  25%,75% { opacity: 0; }
}
/* Set section Widths */
.academic-features-section .row.align-items-center {
  max-width: 1040px; 
  margin-left: auto;
  margin-right: auto;
}
.learning-goals-section{
  padding: 10px 0;
  background: #f9f9f9;
  max-width: 1140px; 
  margin-left: auto;
  margin-right: auto;
}
.team-section {
  max-width: 1180px; 
  margin-left: auto;
  margin-right: auto;
}
/* ==========================
   LEARNING GOALS
========================== */

.section-title {
  font-size: 32px;
  font-weight: 700;
  color: #222;
}
.goal-content {
  flex: 1;
}
.goal-card {
  width: 294px;
  background: #fff;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 8px 20px rgba(0,0,0,0.08);
  text-align: center;
  transition: transform 0.3s ease;
  display: flex;
  flex-direction: column;
  height: 100%;
}

.goal-card h4 {
  display: -webkit-box;
  -webkit-line-clamp: 2;   
  -webkit-box-orient: vertical;
  overflow: hidden;
  min-height: 56px;
}

.goal-card p{
 line-height: 1.4;
}

.goal-card:hover {
  transform: translateY(-6px);
}

.goal-image img {
  width: 294px;
  height: 176px;
  object-fit: cover;
}

.goal-content {
  padding: 18px;
}

/* ==========================
   FLEXIBILITY SECTION
========================== */
.flexibility-section {
  padding: 70px 0;
  background: transparent;
}

.flexibility-wrapper {
  max-width: 900px;
  margin: 0 auto;
}

.flexibility-img {
  width: 371px;
  height: 280px;
  object-fit: cover;
  border-radius: 12px;
  max-width: 100%;
}

/* ✅ shadow ONLY on right content */
.flexibility-img {
  width: 546px;
  height: 490px;
  object-fit: cover;
  border-radius: 12px;
  max-width: 100%;
}

.flexibility-content-box {
  background: #ffffff;
  padding: 28px 30px;
  border-radius: 12px;
  box-shadow: 0 10px 28px rgba(0, 0, 0, 0.08);
}

.flexibility-title {
  font-size: 28px;
  font-weight: 700;
  margin-bottom: 18px;
  color: #222;
}

.flexibility-list {
  list-style: none;
  padding: 0;
  margin: 0;
}

.flexibility-list li {
  display: flex;
  gap: 12px;
  margin-bottom: 14px;
  font-size: 16px;
  color: #555;
  align-items: flex-start;
}
.text-wrap {
  display: flex;
  flex-direction: column; /* forces second line */
}

.list-head {
  font-weight: 600;
  color: #000;
}

.list-desc {
  margin-top: 4px;
  color: #555;
}

.flexibility-list i {
  color: #bd1922;
  font-size: 20px;
  margin-top: 2px;
}
/* Extra space between image and content (desktop only) */
@media (min-width: 992px) {
  .flexibility-content-col {
    padding-left: 60px !important; 
  }
}
/* ==========================
   SCHEDULE SECTION
========================== */
.schedule-section {
  padding: 70px 0;
  background: transparent;
}

/* Extra space between content and image (desktop only) */
@media (min-width: 992px) {
  .schedule-content-col {
    padding-right: 60px !important;
  }
}
/* ==========================
   ACADEMIC PROGRAMS
========================== */
.academic-programs-section {
  padding: 60px 0; /* top/bottom from second (overrides first) */
  background: #f9f9f9; /* from second */
}

.section-subtitle {
  font-size: 18px;
  color: #666;
  max-width: 720px;
  margin: 12px auto 0;
}
/* ==========================
   PRIMARY BUTTON COLOR
========================== */
.btn-primary,
.btn-outline-primary:hover {
  background-color: #D7263D !important;
  border-color: #D7263D !important;
  color: #ffffff !important;
}

/* Outline button default */
.btn-outline-primary {
  color: #D7263D !important;
  border-color: #D7263D !important;
  background: transparent !important;
}

/* Hover effect */
.btn-primary:hover {
  background-color: #c21f34 !important; 
  border-color: #c21f34 !important;
}
/* ==========================
   ACADEMIC PROGRAM FEATURES
========================== */

.academic-feature-header {
  display: flex;
  align-items: center;
  gap: 12px;
}

/* icon */
.academic-feature-header img {
  width: 18px;
  height: 18px;
  object-fit: contain;
  margin-top: 2px;
}

/* title */
.academic-feature-header h5 {
  font-size: 18px;
  font-weight: 600;
  margin: 0;
  color: #222;
}

.academic-feature-item p {
  margin-top: 6px;
  margin-left: 30px;
  font-size: 15px;
  color: #555;
  line-height: 1.4;
}
.academic-features-section,
.academic-programs-section {
  /* background: #ffffff; */
}
.academic-features-section {
  padding: 40px 0 40px;
}

.academic-features-section .container,
.academic-programs-section .container {
  max-width: 1040px;
}
.flexibility-list i {
  color: #bd1922;
  font-size: 20px;
  margin-top: 2px;
}
.section-heading {
      color: #dc3545;
    }
.assessment-box {
  background: #fff;
  border-top: 6px solid #b80f0a;
  border-radius: 16px;
  padding: 45px 30px;
  box-shadow: 0 20px 45px rgba(0, 0, 0, 0.15);
  margin-top: 40px;
  }
  .assessment-actions {
    display: flex;
    justify-content: center;
    gap: 25px;
        }
/* ==========================
   TEAM SECTION
========================== */
.team-section {
  padding: 40px 0;
  background: #f9f9f9;
}

.team-card {
  background: #ffffff;
  border-radius: 16px;
  overflow: hidden;
  text-align: center;
  box-shadow: 0 12px 30px rgba(0,0,0,0.08);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.team-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 18px 45px rgba(0,0,0,0.12);
}

.team-card img {
  width: 100%;
  height: 200px;
  object-fit: cover;
}

.team-content {
  padding: 22px 18px 26px;
}

.team-content h5 {
  font-size: 18px;
  font-weight: 700;
  margin-bottom: 4px;
  color: #222;
}

.team-content span {
  font-size: 14px;
  color: #bd1922;
  font-weight: 600;
  display: block;
  margin-bottom: 10px;
}

.team-content p {
  font-size: 14px;
  color: #555;
  line-height: 1.6;
  text-align: left;
}
/* ==========================
   TOP PROGRAMS – GRADIENT BOX
========================== */
.top-programs-box {
  background: linear-gradient(
    135deg,
    #ffffff 0%,
    #ffffff 60%,
    rgba(215, 38, 61, 0.08) 100%
  );
  border-left: 6px solid #D7263D;
  padding: 32px 34px;
  border-radius: 14px;
  box-shadow: 0 14px 36px rgba(0, 0, 0, 0.12);
}

.top-programs-box .flexibility-title {
  color: #222;
}

.top-programs-box .flexibility-list i {
  color: #D7263D;
}

.top-programs-box .btn {
  margin-top: 10px;
}
/* ==========================
   MOBILE HERO FONT SIZE
========================== */
@media (max-width: 576px) {
  .hero h1 {
    font-size: 25px !important;
    line-height: 1.3;
  }

  #typed-text,
  .typed-cursor {
    font-size: 25px !important;
  }
}
 .form-error {
    min-height: 18px; /* reserves space */
    display: block;
    visibility: hidden;
  }
  .form-error.show {
    visibility: visible;
  }
  .add-to-cart-text {
  display: inline-block;
  font-size: 15px;
  color: #D7263D;
  cursor: pointer;
  text-decoration: underline;
}

.add-to-cart-text:hover {
  color: #b80f0a;
}

.final-price {
  font-size: 34px;
  font-weight: 700;
  color: #d85a56;
}

.regular-price {
  display: flex;
  align-items: center;
  justify-content: center;  
  gap: 10px;
  font-size: 26px;
  margin-top: 6px;
  text-align: center;
}

.regular-price .strike {
  text-decoration: line-through;
  color: #999;
}

.regular-price .offer {
  color: #28a745;
  font-weight: 500;
}
.learn-more-wrap {
  margin-bottom: 12px;
}

.learn-more-text {
  font-size: 15px;
  color: #D7263D;
  text-decoration: underline;
  cursor: pointer;
}

.learn-more-text:hover {
  color: #b80f0a;
}
/* Owl Carousel Prev/Next Buttons */
.owl-prev, .owl-next {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  z-index: 9999; /* increase */
}


.owl-prev { left: -20px; }  
.owl-next { right: -20px; } 

.owl-prev span, .owl-next span {
  font-size: 22px;
  color: #ffffff !important;              
  background: #bd1922 !important;
  padding: 6px 10px;
  border-radius: 50%;
  cursor: pointer;
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
  display: inline-block;
  transition: all 0.3s ease;
}

.owl-prev span:hover, .owl-next span:hover {
  /* background: #d85a56; */
  color: #fff !important;
  background: #bd1922 !important;          
}
.owl-nav.disabled, 
.owl-dots.disabled {
    display: block !important;
}
.filter-badge{
    display:inline-flex;
    align-items:center;
    background:#f1f5f9;
    border:1px solid #e2e8f0;
    border-radius:30px;
    padding:6px 12px;
    margin:4px;
    font-size:13px;
    font-weight:500;
}

.filter-label{
    font-weight:600;
    margin-right:6px;
    color:#374151;
}
#activeFiltersWrapper{
    display:flex;
    flex-direction:column; 
    align-items:flex-start;
    gap:8px;
}

.program-count{
    font-weight:600;
    color:#374151;
    font-size:14px;
    margin-left:4px;
}
#activeFilters{
    display:flex;
    flex-wrap:wrap;
    gap:6px;
}
.filter-error{
    color:#dc3545;
    font-size:13px;
    margin-top:6px;
    display:none;
}
/* STATE GRID */
.state-grid {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 8px;
    max-width: 500px;
    margin: 0 auto;
}

.state-btn {
    height: 34px;
    font-size: 13px;
    border-radius: 6px;
    border: 1px solid #ddd;
    background: #f8f9fa;
    cursor: pointer;
    font-weight: 500;
    transition: 0.2s ease;

    padding: 4px 12px;   
    min-width: auto;     
    width: auto;        
}

.state-btn:hover,
.state-btn.active {
    background: #D7263D;
    color: #fff;
    border-color: #D7263D;
}
.state-tag{
    background:#ecfdf5;
    color:#047857;
}
.session-box{
    display:flex;
    align-items:center;
    gap:8px;
    background:#fff5f5;
    border:1px solid #ffe3e3;
    border-radius:10px;
    padding:8px 12px;
    margin-bottom:14px;
    width:fit-content;
}

.session-number{
    font-size:18px;
    font-weight:700;
    color:#D7263D;
}

.session-label{
    font-size:12px;
    color:#6b7280;
}
.owl-carousel .item{
    display:flex;
    height:100%;
}

.program-pre-card{
    display:flex;
    flex-direction:column;
    justify-content: space-between; /* ensures consistent bottom alignment */
    min-height: 420px; 
}
.program-meta-top{
    font-size:12px;
    color:#9ca3af;
    margin-bottom:6px;
}
/* ================= WORLD CLASS PROGRAM CARD ================= */

.program-pre-card{
    background: linear-gradient(180deg,#ffffff 0%,#fafafa 100%);
    border-radius:18px;
    padding:24px;
    height:100%;
    display:flex;
    flex-direction:column;
    border:1px solid #f1f1f1;
    position:relative;
    overflow:hidden;

    transition:all .35s ease;

    box-shadow:
        0 12px 30px rgba(0,0,0,0.06),
        0 2px 8px rgba(0,0,0,0.04);
}

.program-pre-card:hover{
    transform:translateY(-10px);
    box-shadow:
        0 30px 70px rgba(0,0,0,0.12),
        0 12px 30px rgba(0,0,0,0.08);
}
/* TOP ACCENT LINE */

.program-pre-card::before{
    content:"";
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:4px;

    background:linear-gradient(
        90deg,
        #ff4b2b,
        #ff416c,
        #ff7a18
    );
}

/* HOVER EFFECT */

.program-pre-card:hover{
    transform:translateY(-10px);
    box-shadow:
        0 25px 60px rgba(0,0,0,0.12),
        0 0 0 1px rgba(215,38,61,0.05);
}

/* TITLE */

.program-title{
     font-size:20px;
    font-weight:700;
    margin-bottom:1px;
    line-height:1.35;

    display:-webkit-box;
    -webkit-line-clamp:2;
    -webkit-box-orient:vertical;
    overflow:hidden;
    min-height:44px;

    background: linear-gradient(90deg,#111827,#374151);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
/* DESCRIPTION */

.program-desc{
    font-size:14px;
    color:#6b7280;
    line-height:1.6;
    margin-top:1px;
    margin-bottom:2px;

    display:-webkit-box;
    -webkit-line-clamp:3;
    -webkit-box-orient:vertical;
    overflow:hidden;
    min-height:66px;
}

/* TAGS */

.program-tags{
    display:flex;
    flex-wrap:wrap;
    gap:8px;
}

.tag{
    font-size:11px;
    padding:5px 12px;
    border-radius:30px;
    font-weight:600;
}

/* TAG COLORS */

.grade-tag{
    background:#fff3cd;
    color:#856404;
}

.subject-tag{
    background:#e8f1ff;
    color:#1d4ed8;
}

/* GET NOW BUTTON */

.program-pre-card .btn-outline-program{
    border-radius:10px;
    font-weight:600;
    padding:9px;
}

/* BUTTON AREA */

.program-actions{
    display:flex;
    gap:10px;
    margin-top:14px;
}

.program-actions .btn{
    flex:1;
}

/* ADD CART BUTTON */

.btn-add-cart{
    background:#D7263D;
    border:none;
    color:#fff;
    font-weight:600;
    border-radius:10px;
}

.btn-add-cart:hover{
    background:#b91c1c;
}

/* PREMIUM HOVER BUTTON EFFECT */

.program-pre-card:hover .btn-add-cart{
    transform:scale(1.02);
}
.program-actions{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-top:14px;
}

/* text style actions */

.program-link{
    font-size:14px;
    font-weight:600;
    text-decoration:none;
    border:none;
    background:none;
    cursor:pointer;
    padding:0;
}

/* learn more */

.learn-link{
    color:#374151;
}

.learn-link:hover{
    color:#111827;
    text-decoration:underline;
}

/* add to cart */

.cart-link{
    color:#D7263D;
}

.cart-link:hover{
    color:#b91c1c;
}
.btn-add-cart {
    background: #D7263D;
    color: #fff;
    border: none;
    border-radius: 10px;
}

.btn-add-cart:hover {
    background: #b91c1c;
    color: #fff;
}

.guarantee-text {
    font-size: 13px;
    color: #16a34a;
    font-weight: 600;
    margin-bottom: 6px;
}
</style>

@endsection

@section('content')
<!-- ================= HERO (Modern Card Header) ================= -->

@include('include.page_hero', [
    'title' => $title,
    'showBreadcrumb' => true
])
<!-- ======= Hero Section with Breadcrumb ======= -->
<!-- <section id="hero" class="hero section hero-with-breadcrumb">
  <div class="hero-bg">
    <img src="{{ public_asset('assets/images/category.png') }}" alt="Maths Online Tutoring">
  </div>
 
  <div class="container">
    <div class="row justify-content-center text-center">
      <div class="col-lg-10">

         Breadcrumb -->
        <!-- <nav aria-label="breadcrumb" class="hero-breadcrumb mt-4">
          <ol class="breadcrumb justify-content-center">
            <li class="breadcrumb-item">
              <a href="{{ url('/') }}">Home</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
             {{ $pageConfig['hero']['title'] }}
            </li>
          </ol>
        </nav> -->

        <!-- Hero Title -->
        <!-- <div class=" mb-2">
            @if($pageType === 'subject')
              <h1>{{ $pageConfig['page_short_name'] }} Tutoring Australia</h1>
              <p class="mt-2">
                Expert {{ $pageConfig['page_short_name'] }} tutoring for Year 1–12 students.
              </p>
            @endif
            @if($pageType === 'year')
            <h1>Year {{ str_replace('year-', '', request()->route('slug')) }} Tutoring</h1>
            <p class="mt-2">
              Maths, English and Science tutoring for Year {{ str_replace('year-', '', request()->route('slug')) }} students.
            </p>
            @endif
            @if($pageType === 'state')
              <h1>Tutoring in {{ $pageConfig['hero']['title'] }}</h1>
            <p class="mt-2">
              Maths, English and Science tutoring across {{ $pageConfig['hero']['title'] }}
            </p>
            @endif
        </div>

      </div>
    </div>   
  </div>
</section> -->
<!-- End Hero -->
<!-- ======= Academic Program Features ======= -->
<section class="academic-features-section">
  <div class="container">
    <div class="row align-items-center mb-5">
      <div class="col text-center">
        <h2 class="section-title">
          Our <span class="section-heading"> Academic Learning Programs  </span> are designed to close learning gaps and accelerate progress
          @if( 
            $pageType === 'subject' && !in_array(request()->route('slug'), ['naplan', 'learning-programs'])
          )
            in {{ $pageConfig['hero']['title'] }}
          @endif
        </h2>
      </div>
    </div>
    <div class="row align-items-center gy-5">

      <!-- LEFT CONTENT -->
      <div class="col-lg-6">

        <h2 class="section-title text-start mb-3">
          Key Features
        </h2>

        <p class="section-subtitle text-start mb-4">
          Our Academic Programs are structured to strengthen skills, close gaps and extend learning at every level.
        </p>

        <!-- FEATURES GRID -->
        <div class="row g-4">

          <!-- Feature 1 -->
          <div class="col-md-6">
            <div class="academic-feature-item">
              <div class="academic-feature-header">
                <img src="{{ public_asset('assets/images/landing_tutor/flex_1.svg') }}" alt="">
                <h5>Targeted Support</h5>
              </div>
              <p>
                Personalised sessions that identify and close learning gaps.
              </p>
            </div>
          </div>

          <!-- Feature 2 -->
          <div class="col-md-6">
            <div class="academic-feature-item">
              <div class="academic-feature-header">
                <img src="{{ public_asset('assets/images/landing_tutor/flex_2.svg') }}" alt="">
                <h5>Structured Learning</h5>
              </div>
              <p>
                Guided lesson plans that ensure step-by-step progress.
              </p>
            </div>
          </div>

          <!-- Feature 3 -->
          <div class="col-md-6">
            <div class="academic-feature-item">
              <div class="academic-feature-header">
                <img src="{{ public_asset('assets/images/landing_tutor/flex_4.svg') }}" alt="">
                <h5>Progress Tracking</h5>
              </div>
              <p>
                Regular tracking to monitor performance and inform parents.
              </p>
            </div>
          </div>

          <!-- Feature 4 -->
          <div class="col-md-6">
            <div class="academic-feature-item">
              <div class="academic-feature-header">
                <img src="{{ public_asset('assets/images/landing_tutor/flex_4.svg') }}" alt="">
                <h5>Assessment Validation</h5>
              </div>
              <p>
                Session-based assessments to confirm understanding and mastery.
              </p>
            </div>
          </div>

        </div>
      </div>

      <!-- RIGHT IMAGE -->
      <div class="col-lg-6 schedule-content-col">
        <div class="flexibility-content-box  top-programs-box">
          <h3 class="flexibility-title">
            Leading<span class="section-heading"> Programs</span>
            @if(
              $pageType !== 'subject' || !in_array(request()->route('slug'), ['naplan', 'learning-programs'])
            )
             for {{ $pageConfig['page_short_name'] }}
            @endif
          </h3>
          <ul class="flexibility-list">
             @foreach($pageConfig['top_programs'] ?? [] as $program)
            <li>
                <i class="bi {{ $program['icon'] }}"></i>
                {{ $program['title'] }}
                </li>
            @endforeach
          </ul>
             <!-- Book Now Button -->
            <div class="mt-4 text-start">
              <button class="btn btn-primary px-4 scroll-to-program">Get Now</button>
            </div>
      </div>
  </div>
</div>
</div>

</section>
<!-- End Academic Program Features -->
<!-- ======= Academic Programs Section (Owl Carousel) ======= -->
@if($academicPrograms->count())
<section class="academic-programs-section mt-8" id="choose-program">
    <div class="academic-program-slider">
      <div class="container">
        <div class="row mb-5">
          <div class="col text-center">
            <h2 class="section-title">
              Choose a Program Designed to <span class="section-heading">Address Learning Gaps</span> for your Child
            </h2>
          </div>
        </div>

        <div class="owl-carousel owl-theme" id="programsCarousel" data-count="{{ count($academicPrograms) }}">
          @foreach($academicPrograms as $programName => $programItems)
            @php
              $firstProgram = $programItems->first();
            @endphp
          <div class="item mt-2">
            <div class="program-pre-card">
              <div class="program-meta-top">
                {{ $firstProgram->branch->branch_name ?? 'Program' }}
              </div>
              <h5 class="program-title">
                {{ $programName }}
              </h5>
              <p class="program-desc">
                {{ \Illuminate\Support\Str::limit($firstProgram->description, 150) }}
              </p>

              @php
                $programType = $firstProgram->program_type ?? '';
            @endphp

            @if(in_array($programType, ['Core Training Program', 'Foundation Training Program']))
                <p class="guarantee-text">✔ 30-Day Skill Progress Guarantee</p>
            @elseif($programType == 'Intensive Crash Program')
                <p class="guarantee-text">✔ Exam-Focused Practice</p>
            @endif

              {{-- Sessions --}}
              <div class="session-box">
                <span class="session-number">
                  {{ $firstProgram->number_of_sessions }}
                </span>
                <span class="session-label">Sessions</span>
              </div>

              {{-- Tags --}}
              @php
                $stateShortMap = [
                  'New South Wales' => 'NSW',
                  'Victoria' => 'VIC',
                  'Queensland' => 'QLD',
                  'South Australia' => 'SA',
                  'Western Australia' => 'WA',
                  'Tasmania' => 'TAS',
                  'Australian Capital Territory' => 'ACT',
                  'Northern Territory' => 'NT',
              ];

                $allGrades = $programItems->pluck('grade.grade_name')->unique()->join(', ');
                $allStates = $programItems->pluck('state')->unique()->map(fn($s) => $stateShortMap[$s] ?? $s)->join(', ');
              @endphp

              <div class="program-tags">
                <span class="tag grade-tag">{{ $allGrades }}</span>
                <span class="tag state-tag">{{ $allStates }}</span>
              </div>

              {{-- Action --}}
              <div class="program-actions">
                <a href="{{ route('program.detail', $firstProgram->slug) }}"
                  class="btn btn-add-cart w-100">
                    Learn More →
                </a>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
  </div>
  <div class="text-center">
            <a href="{{ route('products',['type'=>'learning']) }}"
              target="_self" class="btn btn-primary px-5 mt-4">More Programs
            </a>
          </div>
</section>
@else
<div class="text-center py-5">
  <p class="text-muted fs-5">
    No academic programs available for this selection.
  </p>
</div>
@endif
<!-- End Academic Programs Section -->
<!-- ======= Learning Goals Section ======= -->
<section class="learning-goals-section mt-4">
  <div class="container">

    <div class="row mb-5">
      <div class="col text-center">
        <h2 class="section-title">
          How Our Academic Learning Programs Are Designed to <span class="section-heading">Identify and Close Learning Gaps</span>
        </h2>
      </div>
    </div>

    <div class="row g-4 justify-content-center">

      <div class="col-auto">
        <div class="goal-card">
          <div class="goal-image">
            <img src="{{ public_asset('assets/images/target_specific.png') }}" alt="Falling behind">
          </div>
          <div class="goal-content">
            <h4>Address Learning Gaps</h4>
            <p class="mt-2 mb-4">Structured assessments identify gaps and guide targeted learning.</p>
          </div>
        </div>
      </div>

      <div class="col-auto">
        <div class="goal-card">
          <div class="goal-image">
            <img src="{{ public_asset('assets/images/motivation.png') }}" alt="Extra motivation">
          </div>
          <div class="goal-content">
            <h4>Build Mastery and Confidence</h4>
            <p class="mt-2">Guided practice strengthens understanding and supports steady progress.</p>
          </div>
        </div>
      </div>

      <div class="col-auto">
        <div class="goal-card">
          <div class="goal-image">
            <img src="{{ public_asset('assets/images/extend.png') }}" alt="Ready to extend">
          </div>
          <div class="goal-content">
            <h4>Validate Learning Progress</h4>
            <p class="mt-2 mb-3">Assessments confirm mastery and guide next-step improvement.</p>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>
<!-- End Learning Goals Section -->
 {{-- 
 <!-- Book A Free Trial -->
<section class="makes_special_sec faq-sec mt-4 mb-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-xl-10 col-md-12">

        <div class="assessment-box text-center">
          <h3 class="mb-4">
            Book a <span class="section-heading">Free Trial Session</span> with our specialist subject Tutors
          </h3>

          <form id="trialForm"
                class="assessment-actions"
                method="GET"
                action="{{ url('tutor-search-result') }}">

            <div class="row g-3 align-items-center justify-content-center">

              <!-- Year -->
              <div class="col-md-3 col-sm-6 col-12 text-start">
                <select class="form-select w-100" name="grade" id="grade">
                  <option value="">Select Year</option>
                  @foreach($grades as $grade)
                    <option value="{{ $grade->slug }}">
                      {{ $grade->grade_name }}
                    </option>
                  @endforeach
                </select>
                <small id="gradeError" class="form-error text-danger">
                  Please select year
                </small>
              </div>

              <!-- Subject -->
              <div class="col-md-4 col-sm-6 col-12 text-start">
                <select class="form-select w-100" name="branch_id[]" id="subject">
                  <option value="">Select Subject</option>
                  @php 
                    $excluded = ['technologies-6', '-14'];
                  @endphp
                  @foreach($branches as $branch)
                    @if(!in_array($branch->slug, $excluded))
                      <option value="{{ $branch->slug }}">
                        {{ $branch->branch_name }}
                      </option>
                    @endif
                  @endforeach
                </select>
                <small id="subjectError" class="form-error text-danger">
                  Please select subject
                </small>
              </div>

              <!-- Button -->
              <div class="col-md-5 col-sm-12 col-12 text-start">
                <button type="submit" class="btn btn-primary w-100">
                  Book Free Trial
                </button>
                  <small class="form-error">&nbsp;</small>
              </div>

            </div>
          </form>

        </div>

      </div>
    </div>
  </div>
</section>
<!-- End  Book A Free Trial-->
 --}}
<!-- ======= Get Your Free Assessment ======= -->
 @include('include.learning_program_section', ['isCategoryPage' => true]) 
  <!-- ======= End Get Your Free Assessment =======  -->
<!-- ======= Flexibility Section ======= -->
<section class="flexibility-section">
  <div class="container">

    <div class="flexibility-wrapper">
      <div class="row align-items-center gy-4">

        <!-- Left Image -->
        <div class="col-lg-5 text-center">
          <img
            src="{{ public_asset('assets/images/address_gap.png') }}"
            alt="Flexible learning"
            class="flexibility-img"
          >
        </div>

        <!-- Right Content (BOX SHADOW ONLY HERE) -->
        <div class="col-lg-7 flexibility-content-col">
          <div class="flexibility-content-box">
            <h3 class="flexibility-title" style="text-align:center;">
              We are the ‘<em>No-Nonsense</em>’ <span class="section-heading">Tutoring Experts</span>
            </h3>

            <ul class="flexibility-list">
              <li>
                <i class="bi bi-check-circle-fill"></i>
                  <div class="text-wrap">
                    <span class="list-head">Free Assessment & Counselling</span>
                    <span class="list-desc">
                       Do not pay for initial assessment. We provide free assessment and counselling
                    </span>
                  </div>
              </li>
              <li>
                <i class="bi bi-check-circle-fill"></i>
                  <div class="text-wrap">
                    <span class="list-head">Choose Your Own Tutor</span>
                    <span class="list-desc">
                       Choose your own tutor from our match of recommended tutors suited for your child
                    </span>
                  </div>
              </li>
              <li>
                <i class="bi bi-check-circle-fill"></i>
                  <div class="text-wrap">
                    <span class="list-head">Flexible Scheduling</span>
                    <span class="list-desc">
                       Flexible booking at your comfort anytime between 6 am and 8pm, 7 days a week. 
                    </span>
                  </div>
              </li>
              <li>
                <i class="bi bi-check-circle-fill"></i>
                  <div class="text-wrap">
                    <span class="list-head">Book Sessions on-the-go</span>
                    <span class="list-desc">
                       Book your own sessions on the go, no waiting for tutor availability.
                    </span>
                  </div>
              </li>
              <li>
                <i class="bi bi-check-circle-fill"></i>
                  <div class="text-wrap">
                    <span class="list-head">Transparent Pricing</span>
                    <span class="list-desc">
                       Clear affordable prices what you see, no hidden charges, don’t overpay for sessions
                    </span>
                  </div>
              </li>
               
            </ul>
          </div>
        </div>

      </div>
    </div>

  </div>
</section>
<!-- End Flexibility Section -->
<!-- ======= Talk to Our Academic Partner ======= -->
<section class="makes_special_sec faq-sec mt-4 mb-10">
  <div class="container">
    <div class="row">
      <div class="col-xl-10 offset-xl-1 col-md-12">

        <div class="assessment-box text-center">
          <h3 class="mb-4">
            Speak with an Academic Advisor to <span class="section-heading">Explore the Right Learning Path</span> for Your Child
          </h3>
          <div class="assessment-actions justify-content-center">
            <a href="https://outlook.office.com/bookwithme/user/afc138ab2d934547a2160371735b38e9@afor.com.au/meetingtype/z6rInP8MT0iOAWyKLg5lFQ2?anonymous&ismsaljsauthenabled&ep=mcard"
              target="_blank" class="btn btn-primary px-5">Book Here
            </a>
          </div>

        </div>

      </div>
    </div>
  </div>
</section>
<!-- ======= End Talk to Our Academic Partner ======= -->
<!-- ======= Schedule Section ======= -->
<section class="schedule-section">
  <div class="container">

    <div class="flexibility-wrapper">
      <div class="row align-items-center gy-4">

        <!-- Left Content -->
        <div class="col-lg-6 schedule-content-col">
          <div class="flexibility-content-box">
            <h3 class="flexibility-title" style="text-align:center;">
              Why Our <span class="section-heading"> Proven Tutoring </span>System Works
            </h3>

            <ul class="flexibility-list">
              <li>
                <i class="bi bi-check-circle-fill"></i>
                Our lessons are programmed to focus on the core learning gaps, not just general tutoring
              </li>
              <li>
                <i class="bi bi-check-circle-fill"></i>
                 Every session is structured to target the exact skills your child needs to succeed.
              </li>
              <li>
                <i class="bi bi-check-circle-fill"></i>
                 A clear, targeted method ensures steady improvement and increased confidence
              </li>
            </ul>
          </div>
        </div>

        <!-- Right Image -->
        <div class="col-lg-6 text-center">
          <img
            src="{{ public_asset('assets/images/tutoring_works.png') }}"
            alt="Easy scheduling"
            class="flexibility-img"
          >
        </div>

      </div>
    </div>

  </div>
</section>
<!-- End Schedule Section -->
 <!-- ======= Team Section ======= -->
<section class="team-section">
  <div class="container">

    <!-- Heading -->
    <div class="row mb-5">
      <div class="col text-center">
        <h2 class="section-title">
          Our Specialist Tutors work closely with Your Child to support <span class="section-heading">Consistent Learning Progress</span>
        </h2>
      </div>
    </div>

    <!-- Team Cards -->
    <div class="row g-4 justify-content-center">

      <!-- Team Member -->
      <div class="col-lg-3 col-md-6 col-sm-10">
        <div class="team-card">
          <img src="{{ public_asset('assets/images/team/tutor-1.jpg') }}" alt="Tutor">
          <div class="team-content">
            <h5>Ruvindya</h5>
            <!-- <span>Senior Maths Tutor</span> -->
            <p>
              I am a prize winning Electrical Engineering undergraduate and empathetic tutor w... 
            </p>
            <a href="{{ url('tutor-search-result') }}"
              target="_blank" class="btn btn-primary px-5 mt-4">Book Trial
            </a>
          </div>
        </div>
      </div>

      <!-- Team Member -->
      <div class="col-lg-3 col-md-6 col-sm-10">
        <div class="team-card">
          <img src="{{ public_asset('assets/images/team/tutor-2.png') }}" alt="Tutor">
          <div class="team-content">
            <h5>Yuk Chun</h5>
            <!-- <span>Algebra Specialist</span> -->
            <p>
              I believe my strengths are three-fold. First, I have a deep and recent academic... 
            </p>
            <a href="{{ url('tutor-search-result') }}"
              target="_blank" class="btn btn-primary px-5 mt-4">Book Trial
            </a>
          </div>
        </div>
      </div>

      <!-- Team Member -->
      <div class="col-lg-3 col-md-6 col-sm-10">
        <div class="team-card">
          <img src="{{ public_asset('assets/images/team/tutor-3.jpeg') }}" alt="Tutor">
          <div class="team-content">
            <h5>THUY Y VAN</h5>
            <!-- <span>Advanced Maths Coach</span> -->
            <p>
              Hi! I’m Navy (Ms Bee) — a friendly Math & Science tutor with 5+ years’ experienc... 
            </p>
            <a href="{{ url('tutor-search-result') }}"
              target="_blank" class="btn btn-primary px-5 mt-4">Book Trial
            </a>
          </div>
        </div>
      </div>

      <!-- Team Member -->
      <div class="col-lg-3 col-md-6 col-sm-10">
        <div class="team-card">
          <img src="{{ public_asset('assets/images/team/tutor-4.jpg') }}" alt="Tutor">
          <div class="team-content">
            <h5>Nina</h5>
            <!-- <span>Exam Prep Expert</span> -->
            <p>
              I’m a supportive, engaging tutor who creates a positive learning environment... 
            </p>
            <a href="{{ url('tutor-search-result') }}"
              target="_blank" class="btn btn-primary px-5 mt-4">Book Trial
            </a>
          </div>
        </div>
      </div>

    </div>

  </div>
</section>
<!-- ======= End Team Section ======= -->
@include('include.learning_program_section')
@include('include.learning_program_modal_only')

@endsection

@section('footer')
@include('include.footer')
@endsection

@section('script')

@include('include.script')
<script>
$(document).ready(function () {
  const $carousel = $("#programsCarousel");

  // safety check
  if (!$carousel.length) return;

  const itemCount = parseInt($carousel.data("count"), 10) || 0;

  $carousel.owlCarousel({
    loop: itemCount > 3,
    autoplay: itemCount > 3,
    nav: itemCount > 1,
    dots: itemCount > 1,
    margin: 30,
    navRewind: false,
    autoplayTimeout: 3000,
    autoplayHoverPause: true,

    navText: [
      '<span class="owl-prev-btn">&#10094;</span>',
      '<span class="owl-next-btn">&#10095;</span>'
    ],

    responsive: {
    0:   { items: 1 },
    768: { items: 2 },
    992: { items: 3 }
}

  });
});
</script>
<!-- Validation Script -->
<script>
  const form = document.getElementById('trialForm');
  const grade = document.getElementById('grade');
  const subject = document.getElementById('subject');

  const gradeError = document.getElementById('gradeError');
  const subjectError = document.getElementById('subjectError');

  form.addEventListener('submit', function (e) {
    let isValid = true;

    gradeError.classList.remove('show');
    subjectError.classList.remove('show');

    if (!grade.value) {
      gradeError.classList.add('show');
      isValid = false;
    }

    if (!subject.value) {
      subjectError.classList.add('show');
      isValid = false;
    }

    if (!isValid) {
      e.preventDefault();
    }
  });

  grade.addEventListener('change', () => {
    gradeError.classList.remove('show');
  });

  subject.addEventListener('change', () => {
    subjectError.classList.remove('show');
  });

  // Reset form when user comes back
  window.addEventListener('pageshow', function () {
    form.reset();
    gradeError.classList.remove('show');
    subjectError.classList.remove('show');
  });
</script>
<script>
$(document).on('click', '.add-to-cart-text', function () {

    const cartText = $(this);
    const programId = cartText.data('id');

    // find matching Buy button
    const buyBtn = $('.buy-now-btn[data-id="' + programId + '"]');

    fetch("{{ route('cart.toggle') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ program_id: programId })
    })
    .then(res => res.json())
    .then(data => {

        if (data.in_cart) {
            cartText.text('Remove');
            buyBtn.text('Proceed to Buy');
        } else {
            cartText.text('Add to Cart');
            buyBtn.text('Buy Now');
        }

    });
});
document.addEventListener("DOMContentLoaded", function () {
  const btn = document.querySelector(".scroll-to-program");

  if (!btn) return;

  btn.addEventListener("click", function () {
    const target = document.getElementById("choose-program");
    if (!target) return;

    const headerOffset = 90;
    const elementPosition = target.getBoundingClientRect().top;
    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

    window.scrollTo({
      top: offsetPosition,
      behavior: "smooth"
    });
  });
});

</script>
@endsection




