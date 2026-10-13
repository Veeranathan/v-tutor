@extends('layouts.app') 

@section('page_title', 'V-Tutor | Maths Online Tutoring')
@section('meta_description', 'Online Maths tutoring with personalised lessons to build strong foundations in numbers, problem-solving, and data concepts.')
@section('meta_keywords', 'maths online tutoring, maths tutor Australia, online maths classes')

@section('left_part')
@include('include.header_menu_part')
@endsection

@section('content')

<!-- ======= Hero Section with Breadcrumb ======= -->
<section id="hero" class="hero section hero-with-breadcrumb">
  <div class="hero-bg">
    <img src="{{ public_asset('assets/images/hero-services-img.webp') }}" alt="Maths Online Tutoring">
  </div>

  <div class="container">
    <div class="row justify-content-center text-center">
      <div class="col-lg-10">

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="hero-breadcrumb">
          <ol class="breadcrumb justify-content-center">
            <li class="breadcrumb-item">
              <a href="{{ url('/') }}">Home</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
              Maths
            </li>
          </ol>
        </nav>

        <!-- Hero Title -->
        <h1>
           <span id="typed-text">Maths Online Tutoring</span>
          <span class="typed-cursor" aria-hidden="true">|</span>
        </h1>

      </div>
    </div>
  </div>
</section>
<!-- End Hero -->
<!-- ======= Academic Program Features ======= -->
<section class="academic-features-section">
  <div class="container">
    <div class="row align-items-center mb-5">
      <div class="col text-center">
        <h2 class="section-title">
          Our <span class="section-heading"> Academic Learning Programs  </span> are designed and ​tailored for your success in Maths
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
          Our academic programs are carefully structured to support, strengthen,
          and extend your child’s maths learning at every level.
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
                Focused help for specific learning gaps through personalised sessions.
              </p>
            </div>
          </div>

          <!-- Feature 2 -->
          <div class="col-md-6">
            <div class="academic-feature-item">
              <div class="academic-feature-header">
                <img src="{{ public_asset('assets/images/landing_tutor/flex_2.svg') }}" alt="">
                <h5>Structured Curriculum</h5>
              </div>
              <p>
                Clear lesson plans aligned to learning outcomes and student progress.
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
                Regular performance insights to keep parents informed and confident.
              </p>
            </div>
          </div>

          <!-- Feature 4 -->
          <div class="col-md-6">
            <div class="academic-feature-item">
              <div class="academic-feature-header">
                <img src="{{ public_asset('assets/images/landing_tutor/flex_4.svg') }}" alt="">
                <h5>Advanced Extension</h5>
              </div>
              <p>
                Higher-level challenges for students ready to go beyond the syllabus.
              </p>
            </div>
          </div>

        </div>
      </div>

      <!-- RIGHT IMAGE -->
      <div class="col-lg-6 schedule-content-col">
        <div class="flexibility-content-box  top-programs-box">
          <h3 class="flexibility-title">
            Top <span class="section-heading">Programs</span> In Maths
          </h3>
          <ul class="flexibility-list">
            <li>
              <i class="bi bi-mortarboard"></i>
                Master Algebra Program
            </li>
            <li>
            <i class="bi bi-calculator"></i>
                Foundation Maths
            </li>
            <li>
            <i class="bi bi-graph-up"></i>
              Advanced Maths Extension
            </li>
            <li>
              <i class="bi bi-lightbulb"></i>
                Problem Solving & Logic
            </li>
            <li>
              <i class="bi bi-award"></i>
              Exam Preparation Program
            </li>
            <li>
              <i class="bi bi-trophy"></i>
              Olympiad & Competitive Maths
            </li>
          </ul>
             <!-- Book Now Button -->
            <div class="mt-4 text-start">
              <button class="btn btn-primary px-4"  data-bs-toggle="modal"  data-bs-target="#pricingModal">Book Now</button>
            </div>
      </div>
  </div>
</div>
</div>

</section>
<!-- End Academic Program Features -->
  <!--Book A Free Trial-->
<section class="makes_special_sec faq-sec mt-4 mb-10">
  <div class="container">
    <div class="row">
      <div class="col-xl-10 offset-xl-1 col-md-12">

        <div class="assessment-box text-center">
          <h3 class="mb-3">
            Book a <span class="section-heading"> Free Trial </span> Session on Maths
          </h3>

          <!-- Horizontal Form -->
          <form class="assessment-actions mt-4">
            <div class="row g-10 align-items-center justify-content-center">

              <!-- Grade Dropdown -->
              <div class="col-md-3 col-sm-6">
                <select class="form-select" name="grade" required>
                  <option value="">Select Grade</option>
                  @for ($i = 1; $i <= 12; $i++)
                    <option value="Grade {{ $i }}">Grade {{ $i }}</option>
                  @endfor
                </select>
              </div>

              <!-- State Dropdown -->
              <div class="col-md-4 col-sm-6">
                <select class="form-select" name="state" required>
                  <option value="">Select State</option>
                  <option>New South Wales</option>
                  <option>Victoria</option>
                  <option>Queensland</option>
                  <option>South Australia</option>
                  <option>Tasmania</option>
                  <option>Western Australia</option>
                  <option>Australian Capital Territory</option>
                  <option>Northern Territory</option>
                </select>
              </div>

              <!-- Button -->
              <div class="col-md-5 col-sm-12">
                <button type="button" class="btn btn-primary w-100">
                  Book Free Trial
                </button>
              </div>

            </div>
          </form>

        </div>

      </div>
    </div>
  </div>
</section>

<!-- End  Book A Free Trial-->
<!-- ======= Learning Goals Section ======= -->
<section class="learning-goals-section mt-4">
  <div class="container">

    <div class="row mb-5">
      <div class="col text-center">
        <h2 class="section-title">
          How does our <span class="section-heading">Academic Learning Programs</span> work to fix​ and eliminate learning gaps in Maths
        </h2>
      </div>
    </div>

    <div class="row g-4 justify-content-center">

      <div class="col-auto">
        <div class="goal-card">
          <div class="goal-image">
            <img src="{{ public_asset('assets/images/primary.png') }}" alt="Falling behind">
          </div>
          <div class="goal-content">
            <h4>Falling behind?</h4>
            <p>Target specific problem areas with personalised tutor support.</p>
          </div>
        </div>
      </div>

      <div class="col-auto">
        <div class="goal-card">
          <div class="goal-image">
            <img src="{{ public_asset('assets/images/primary-excel.png') }}" alt="Extra motivation">
          </div>
          <div class="goal-content">
            <h4>Extra motivation?</h4>
            <p>Keep your child engaged and confident with guided learning.</p>
          </div>
        </div>
      </div>

      <div class="col-auto">
        <div class="goal-card">
          <div class="goal-image">
            <img src="{{ public_asset('assets/images/primary-keepup.png') }}" alt="Ready to extend">
          </div>
          <div class="goal-content">
            <h4>Ready to extend?</h4>
            <p>Challenge advanced learners to reach their full potential.</p>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>
<!-- End Learning Goals Section -->
 <!-- ======= Academic Programs Section (Owl Carousel) ======= -->
<section class="academic-programs-section mt-8">
  <div class="academic-program-slider">
  <div class="container">

    <div class="row mb-5">
      <div class="col text-center">
        <h2 class="section-title">
          Choose The Right <span class="section-heading">Program</span>
        </h2>
        <!-- <p class="section-subtitle">
          Carefully designed programs to support, strengthen, and extend your child’s maths learning.
        </p> -->
      </div>
    </div>

    @php
      $programs = [
        [
          'title'=>'Foundation Maths',
          'desc'=>'Ideal for students who need help building strong fundamentals.',
          'price'=>'$180',
          'features'=>['2 sessions per week','Core concepts & basics','Personal progress tracking'],
          'btn_class'=>'btn-outline-primary',
          'badge'=>null,
        ],
        [
          'title'=>'Master Algebra Program',
          'desc'=>'A structured program focused on algebra mastery.',
          'price'=>'$240',
          'features'=>['3 sessions per week','Step-by-step problem solving','Weekly performance reports'],
          'btn_class'=>'btn-primary',
          'badge'=>'Most Popular',
        ],
        [
          'title'=>'Advanced Maths Extension',
          'desc'=>'Designed for students ready to go beyond the syllabus.',
          'price'=>'$300',
          'features'=>['3–4 sessions per week','Advanced problem solving','Olympiad-style questions'],
          'btn_class'=>'btn-outline-primary',
          'badge'=>null,
        ],
      ];
    @endphp

    <div class="owl-carousel owl-theme" id="programsCarousel">
      @foreach($programs as $program)
        <div class="item">
          <div class="program-card text-center {{ $program['badge'] ? 'featured' : '' }}">
            @if($program['badge'])
              <span class="badge-popular">{{ $program['badge'] }}</span>
            @endif
            <h4>{{ $program['title'] }}</h4>
            <p class="program-desc">{{ $program['desc'] }}</p>
            <div class="program-price"><span>{{ $program['price'] }}</span> / month</div>
            <ul class="program-features">
              @foreach($program['features'] as $feature)
                <li>✔ {{ $feature }}</li>
              @endforeach
            </ul>
            <button class="btn {{ $program['btn_class'] }} w-100" data-bs-toggle="modal" data-bs-target="#pricingModal">Book Now</button>
          </div>
        </div>
      @endforeach
    </div>

  </div>
</div>
</section>
<!-- End Academic Programs Section -->
<!-- ======= Flexibility Section ======= -->
<section class="flexibility-section">
  <div class="container">

    <div class="flexibility-wrapper">
      <div class="row align-items-center gy-4">

        <!-- Left Image -->
        <div class="col-lg-6 text-center">
          <img
            src="{{ public_asset('assets/images/features-2.jpg') }}"
            alt="Flexible learning"
            class="flexibility-img"
          >
        </div>

        <!-- Right Content (BOX SHADOW ONLY HERE) -->
        <div class="col-lg-6 flexibility-content-col">
          <div class="flexibility-content-box">
            <h3 class="flexibility-title">
              Address the gap don’t avoid the subject ​
            </h3>

            <ul class="flexibility-list">
              <li>
                <i class="bi bi-check-circle-fill"></i>
                Learn from home (or anywhere) via our online platform.
              </li>
              <li>
                <i class="bi bi-check-circle-fill"></i>
                Schedule sessions when they suit you, between 7am and 10pm, 7 days per week.
              </li>
              <li>
                <i class="bi bi-check-circle-fill"></i>
                Reschedule easily when things get busy.
              </li>
            </ul>
          </div>
        </div>

      </div>
    </div>

  </div>
</section>
<!-- End Flexibility Section -->
 <!-- ======= Get Your Free Assessment ======= -->
<section class="makes_special_sec faq-sec mt-4 mb-10">
  <div class="container">
    <div class="row">
      <div class="col-xl-10 offset-xl-1 col-md-12">

        <div class="assessment-box text-center">
          <h3 class="mb-4">
            Get your <span class="section-heading">free assessment</span> now
          </h3>

          <div class="assessment-actions justify-content-center">
            <button
              type="button"
              class="btn btn-primary px-5"
              data-bs-toggle="modal"
              data-bs-target="#pricingModal"
            >
              Book Free Assessment
            </button>
          </div>

        </div>

      </div>
    </div>
  </div>
</section>
<!-- ======= End Get Your Free Assessment ======= -->

<!-- ======= Schedule Section ======= -->
<section class="schedule-section">
  <div class="container">

    <div class="flexibility-wrapper">
      <div class="row align-items-center gy-4">

        <!-- Left Content -->
        <div class="col-lg-6 schedule-content-col">
          <div class="flexibility-content-box">
            <h3 class="flexibility-title">
              Why this proven system of tutoring works?​
            </h3>

            <ul class="flexibility-list">
              <li>
                <i class="bi bi-check-circle-fill"></i>
                We don’t focus simply on tutoring.
              </li>
              <li>
                <i class="bi bi-check-circle-fill"></i>
                 Our sessions are tailored to address the core issue.
              </li>
              <li>
                <i class="bi bi-check-circle-fill"></i>
                 Our razor focused approach in every session will ensure your success​
              </li>
            </ul>
          </div>
        </div>

        <!-- Right Image -->
        <div class="col-lg-6 text-center">
          <img
            src="{{ public_asset('assets/images/features-1.jpg') }}"
            alt="Easy scheduling"
            class="flexibility-img"
          >
        </div>

      </div>
    </div>

  </div>
</section>
<!-- End Schedule Section -->
 <!-- ======= Talk to Our Academic Partner ======= -->
<section class="makes_special_sec faq-sec mt-4 mb-10">
  <div class="container">
    <div class="row">
      <div class="col-xl-10 offset-xl-1 col-md-12">

        <div class="assessment-box text-center">
          <h3 class="mb-4">
            Talk to our <span class="section-heading">academic partner</span> now
          </h3>

          <div class="assessment-actions justify-content-center">
            <button
              type="button"
              class="btn btn-primary px-5"
              data-bs-toggle="modal"
              data-bs-target="#pricingModal"
            >
              Book Here
            </button>
          </div>

        </div>

      </div>
    </div>
  </div>
</section>
<!-- ======= End Talk to Our Academic Partner ======= -->

 <!-- ======= Team Section ======= -->
<section class="team-section">
  <div class="container">

    <!-- Heading -->
    <div class="row mb-5">
      <div class="col text-center">
        <h2 class="section-title">
          Meet our team of highly effective tutoring partners
        </h2>
        <p class="section-subtitle">
          who would tailor your success in <span class="section-heading">Maths</span>
        </p>
      </div>
    </div>

    <!-- Team Cards -->
    <div class="row g-4 justify-content-center">

      <!-- Team Member -->
      <div class="col-lg-3 col-md-6 col-sm-10">
        <div class="team-card">
          <img src="{{ public_asset('assets/images/team/tutor-1.jpg') }}" alt="Tutor">
          <div class="team-content">
            <h5>Emily Johnson</h5>
            <span>Senior Maths Tutor</span>
            <p>
              10+ years experience helping students master core maths concepts with confidence.
            </p>
          </div>
        </div>
      </div>

      <!-- Team Member -->
      <div class="col-lg-3 col-md-6 col-sm-10">
        <div class="team-card">
          <img src="{{ public_asset('assets/images/team/tutor-2.png') }}" alt="Tutor">
          <div class="team-content">
            <h5>Daniel Smith</h5>
            <span>Algebra Specialist</span>
            <p>
              Expert in algebra and problem-solving techniques for middle & senior school.
            </p>
          </div>
        </div>
      </div>

      <!-- Team Member -->
      <div class="col-lg-3 col-md-6 col-sm-10">
        <div class="team-card">
          <img src="{{ public_asset('assets/images/team/tutor-3.jpeg') }}" alt="Tutor">
          <div class="team-content">
            <h5>Sophia Lee</h5>
            <span>Advanced Maths Coach</span>
            <p>
              Passionate about advanced maths, exam strategies, and confidence building.
            </p>
          </div>
        </div>
      </div>

      <!-- Team Member -->
      <div class="col-lg-3 col-md-6 col-sm-10">
        <div class="team-card">
          <img src="{{ public_asset('assets/images/team/tutor-4.jpg') }}" alt="Tutor">
          <div class="team-content">
            <h5>Michael Brown</h5>
            <span>Exam Prep Expert</span>
            <p>
              Focused on exam preparation, Olympiads, and competitive maths training.
            </p>
          </div>
        </div>
      </div>

    </div>

  </div>
</section>
<!-- ======= End Team Section ======= -->
@include('include.learning_program_modal_only')
@include('include.learning_program_section')
@endsection

@section('footer')
@include('include.footer')
@endsection

@section('script')
<!-- ===== Owl Carousel Scripts ===== -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

@include('include.script')

<script>
$(document).ready(function(){
  $("#programsCarousel").owlCarousel({
    loop:true,
    margin:30,
    nav:true,
    dots:true,
    navRewind: false,
    autoplay:true,
    autoplayTimeout:3000,
    autoplayHoverPause:true,
    navText: [
      '<span class="owl-prev-btn">&#10094;</span>', // left arrow
      '<span class="owl-next-btn">&#10095;</span>'  // right arrow
    ],

    responsive:{
      0:{ items:1 },
      768:{ items:2 },
      992:{ items:3 }
    }
  });
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
  const text = "Maths Online Tutoring";
  const typedText = document.getElementById("typed-text");
  typedText.textContent = "";

  let index = 0;
  let isDeleting = false;

  function typeLoop() {
    if (!isDeleting && index < text.length) {
      typedText.textContent += text.charAt(index++);
      setTimeout(typeLoop, 90);
    } else if (!isDeleting) {
      isDeleting = true;
      setTimeout(typeLoop, 1500);
    } else if (index > 0) {
      typedText.textContent = text.substring(0, --index);
      setTimeout(typeLoop, 50);
    } else {
      isDeleting = false;
      setTimeout(typeLoop, 600);
    }
  }

  typeLoop();
});
</script>
<!-- ========================== Other Styles & Typed Text Script ========================== -->
<style>
/* ==========================
   HERO
========================== */
.hero {
  width: 100%;
  min-height: 30vh;
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
  transform: scale(1.1);
  z-index: 1;
}

.hero .hero-bg::before {
  content: "";
  position: absolute;
  inset: 0;
  background: rgba(90, 90, 90, 0.55);
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
  font-size: 20px;
  color: rgba(255,255,255,0.88);
}
/* ==========================
   HERO BREADCRUMB
========================== */
.hero-with-breadcrumb .hero-breadcrumb {
  margin-bottom: 18px;
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
  padding: 70px 0;
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

.goal-card {
  width: 294px;
  background: #fff;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 8px 20px rgba(0,0,0,0.08);
  text-align: center;
  transition: transform 0.3s ease;
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
  height: 409px;
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
  padding: 80px 0;
  background: #f9f9f9;
}

.section-subtitle {
  font-size: 18px;
  color: #666;
  max-width: 720px;
  margin: 12px auto 0;
}

.program-card {
  background: #ffffff;
  border-radius: 14px;
  padding: 30px 26px;
  text-align: center;
  box-shadow: 0 10px 26px rgba(0,0,0,0.08);
  position: relative;
  transition: transform 0.3s ease;
}

.program-card:hover {
  transform: translateY(-8px);
}

.program-card h4 {
  font-size: 22px;
  font-weight: 700;
  margin-bottom: 12px;
}

.program-desc {
  font-size: 15px;
  color: #666;
  margin-bottom: 18px;
}

.program-price {
  font-size: 20px;
  margin-bottom: 18px;
}

.program-price span {
  font-size: 34px;
  font-weight: 700;
  color: #d85a56;
}

.program-features {
  list-style: none;
  padding: 0;
  margin: 0 0 22px;
}

.program-features li {
  font-size: 15px;
  margin-bottom: 8px;
  color: #444;
}

/* Featured Card */
.program-card.featured {
  border: 2px solid #d85a56;
}

.badge-popular {
  position: absolute;
  top: -12px;
  right: 20px;
  background: #d85a56;
  color: #fff;
  font-size: 12px;
  padding: 6px 10px;
  border-radius: 20px;
}

/* ==========================
   PRICING TABLE
========================== */
.pricing-table th {
  background: #f1f1f1;
  font-weight: 700;
}

.pricing-note {
  font-size: 14px;
  color: #666;
  margin-top: 12px;
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
  font-size: 32px;
  color: #ffffff !important;              
  background: #bd1922 !important;
  padding: 8px 12px;
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
  line-height: 1.6;
}
.academic-features-section,
.academic-programs-section {
  background: #ffffff;
}
.academic-features-section {
  padding: 40px 0 40px;
}

.academic-programs-section {
  padding: 40px 0 80px;
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
</style>
@endsection

