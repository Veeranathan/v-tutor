@extends('layouts.app')

@section('title')
    <title>V-Tutor</title>
@endsection

@section('left_part')
    @include('include.header_menu_part')

    <link href="{{ public_asset('assets/faro_font/stylesheet.css') }}" rel="stylesheet">
    <link href="{{ public_asset('assets/css/landing_animation.css') }}" rel="stylesheet" type="text/css">

    <style type="text/css">
        /* Banner Styling */
        .banner_main_div {
              border-radius: 0 !important;
            background-color: #D7263D  !important;
        }
        .safty-learning {
            margin-top: 0px;
            background-color: rgba(42, 42, 42, 1) !important;
        }
        .safty-learning.steps-section {
             background-color: #D7263D  !important;
        }

        .banner-img {
            max-width: 100%;
            height: auto;
            max-height: 420px;
            object-fit: cover;
            border-radius: 32px;
        }
        
        /* Testimonial Section */
        .testimonial-section {
            background-color: rgba(247, 231, 213, 1) !important;
            padding: 40px 0;
            border-top: 2px solid #c0392b;
            border-bottom: 2px solid #c0392b;
        }

        .testimonial-stars {
            color: #c0392b;
            font-size: 18px;
            letter-spacing: 3px;
        }

        .testimonial-text {
            color: #000;
            font-size: 15px;
            max-width: 800px;
            margin: 0 auto 10px;
        }

        .testimonial-author {
            text-align: right;
            font-style: italic;
            max-width: 800px;
            margin: 10px auto 0;
        }
       
        .testimonial-top {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 15px;
            font-size: 13px;
            font-weight: 600;
            color: #000;
            max-width: 1000px;
            margin: 0 auto 15px;
        }

        .testimonial-top span {
            white-space: nowrap;
        }

        /* Divider */
        .testimonial-divider {
            border: none;
            border-top: 2px solid #D7263D;
            max-width: 1000px;
            margin: 10px auto 20px;
        }

        /* Content width control */
        .testimonial-content {
            max-width: 1000px;
            margin: 0 auto;
        }
        /* Step Section Custom */
        .step-card {
            text-align: left;
        }
        .step{
            text-align: left !important;
        }
        /* Step Number */
        .step-number {
            display: inline-block;
            color: rgba(247, 231, 213, 1) !important;
            font-size: 48px;
            font-weight: 1000;
            margin-bottom: 10px;
        }

        /* Step Title */
        .step-title {
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 8px;
        }

        /* Team Section */
        .team-section {
            padding: 40px 0;
            background: rgba(247, 231, 213, 1) !important;
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
        .section-head {
            max-width: 780px; 
            margin-left: auto;
            margin-right: auto;
        }
        .team-section-h {
            font-weight: 600;
            font-size: 36px !important;
        }
         .team-section-p {
            color: #bd1922;
        }
        .btn-primary {
            background-color: #D7263D !important;
            border-color: #D7263D !important;
            color: #ffffff !important;
        }
        .btn-primary:hover {
            background-color: #c21f34 !important; 
            border-color: #c21f34 !important;
        }
        /* ===== FAQ SECTION FULL DARK ===== */
        .faq-section {
            background: #1f1f1f;
            padding: 80px 0;
        }
        /* Label */
        .faq-label {
            color: #ff3b3b;
            font-size: 12px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        /* Heading */
        .faq-heading {
            font-size: 48px;
            font-weight: 800;
            color: rgb(247, 231, 213) !important;
        }
        /* CARD */
        .newfaq .card {
            background: #000 !important;
            border: 1px solid #ff3b3b !important;
            border-radius: 6px;
            margin-bottom: 15px;
            overflow: hidden;
        }

        /* HEADER (IMPORTANT FIX) */
        .newfaq .card-header {
            background: #000 !important;   /* force black */
            border: none !important;
            padding: 0;
        }

        /* BUTTON (QUESTION) */
        .newfaq .btn-link {
            background: #000 !important;   /* force black */
            color: #ffffff !important;
            font-size: 18px;
            font-weight: 600;
            padding: 18px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            text-decoration: none;
        }
        .makes_faq_bx .btn-link.collapsed {
            color: #ffffff !important;
        }
        /* REMOVE BOOTSTRAP BLUE EFFECT */
        .newfaq .btn-link:hover,
        .newfaq .btn-link:focus {
            color: #ffffff !important;
            text-decoration: none;
            background: #000 !important;
            box-shadow: none;
        }
        /* BODY */
        .newfaq .card-body {
            background: #000 !important;
            color: #cccccc;
            font-size: 14px;
            padding: 15px 20px 20px;
        }

        /* REMOVE WHITE BG FROM COLLAPSE */
        .newfaq .collapse,
        .newfaq .collapsing {
            background: #000 !important;
        }
        .makes_faq_bx .card-body p {
            color: #fff !important;
            padding-left:40px !important;
            padding-right:40px !important;
            padding-bottom: 40px !important;
        }
        /* ===== BOOK ASSESSMENT SECTION ===== */
        .book-assessment-section {
            background: #c0392b;
            padding: 80px 0;
        }
        /* LEFT TEXT BOX */
        .assessment-left {
            background: #e9dccb;
            border-radius: 16px;
            padding: 40px;
            height: 100%;
        }
        .assessment-left h2 {
            font-size: 36px;
            font-weight: 800;
            color: #000;
            line-height: 1.3;
        }
        .assessment-left p {
            margin-top: 15px;
            font-size: 14px;
            color: #000;
        }
        /* RIGHT FORM BOX */
        .assessment-form {
            background: #e9dccb;
            border-radius: 16px;
            padding: 40px;
        }
        /* FORM TITLE */
        .assessment-form h3 {
            font-size: 26px;
            font-weight: 800;
            margin-bottom: 5px;
        }
        .assessment-form small {
            display: block;
            margin-bottom: 20px;
        }
        /* INPUTS */
        .assessment-form input,
        .assessment-form select {
            width: 100%;
            padding: 12px 14px;
            border-radius: 6px;
            border: 1px solid #999;
            margin-bottom: 15px;
            font-size: 14px;
        }
        /* BUTTON */
        .assessment-btn {
            background: #c0392b;
            color: #fff;
            border: none;
            padding: 12px 25px;
            border-radius: 30px;
            font-weight: 600;
            margin-top: 10px;
        }

        .assessment-btn:hover {
            background: #a93226;
        }
        label.error {
            display: block !important;
            margin-top: 5px;
            font-size: 13px;
        }
        .footer-custom {
            margin-top: 0px !important;
        }

        html {
            scroll-behavior: smooth;
        }

        @media only screen and (max-width: 768px) {
            .safty-learning .feature-content {
                display: block !important;
            }
            .team-card {
                margin-bottom: 20px !important;
            }
             .assessment-form {
                margin-top: 20px !important;
            }
        }

        @media only screen and (max-width: 1600px) {
            .banner_main_div h1 {
                font-size: 43px !important;
                line-height: 60px !important;
            }
        }
</style>
@endsection


@section('content')
    <!-- Banner Section -->
    <div class="banner_main_div">
        <div class="container main_div">
            <section class="text-white rounded-3 position-relative overflow-hidden">
                <div class="container-fluid container-lg">

                    <div class="row align-items-center mt-6 mb-6">

                        <!-- LEFT SIDE TEXT -->
                        <div class="col-lg-6 p-2 py-4 py-md-5">
                            <h1 class="mb-2">
                                Structured tutoring that targets exactly what your child needs
                            </h1>

                            <p class="pt-1 para-text showForLap mb-2">
                                Not general sessions. A program built around the specific gaps that are holding your child back.
                            </p>

                            <p class="pt-1 para-text showForMbl pb-2">
                                Not general sessions. A program built around the specific gaps that are holding your child back.
                            </p>

                            <a href="#book-assessment-landing" class="bk_btn_hdr_link scroll-to-assessment">
                                <button class="primary-button mt-4">
                                    Book My Free Assessment
                                </button>
                            </a>
                        </div>

                        <!-- RIGHT SIDE IMAGE -->
                        <div class="col-lg-6 text-center">
                            <img 
                                src="{{ public_asset('assets/images/landing_tutor/book-free-web-banner.png') }}" 
                                alt="Online tutoring Australia"
                                class="img-fluid banner-img"
                            >
                        </div>

                    </div>

                </div>
            </section>
        </div>
    </div>
    
    <!-- Testimonial Section -->
    <section class="testimonial-section">
        <div class="container">

            <!-- Top Features Row -->
            <div class="testimonial-top text-center">
                <span>✓ DIAGNOSTIC-LED PROGRAMS</span>
                <span>✓ TRUSTED BY AUSTRALIAN FAMILIES</span>
                <span>✓ SELECTIVE TEAM OF HIGH-PERFORMING TUTORS</span>
                <span>✓ PRECISION-BASED</span>
            </div>

            <hr class="testimonial-divider">

            <!-- Testimonial Content -->
            <div class="testimonial-content text-center">

                <div class="testimonial-stars mb-2">
                    ★ ★ ★ ★ ★
                </div>

                <p class="testimonial-text">
                    "Ms. Ruvindya was a great tutor who taught my daughter.
                </p>

                <p class="testimonial-text">
                    Her specialty is how she conducts timed memory recap papers and quizzes to evaluate students' knowledge.
                    This made noticeable progress in my daughter's academic profile.
                </p>

                <p class="testimonial-text">
                    My daughter loved these sessions due to the non-judgmental environment the tutor maintained.
                    Her teaching platform was always open for communication, questions and answers."
                </p>

                <p class="testimonial-author">– Serena P.</p>

                <hr class="testimonial-divider">

            </div>

        </div>
    </section>

    <!-- Safety Section -->
    <section class="container safty-learning text-white">
        <div class="text-center">

            <h2 class="mb-4 mb-md-5">
                 The right tutoring, not just more tutoring:
            </h2>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">

                <div class="col">
                    <div class="p-1 p-md-3">
                        <div class="d-flex justify-content-center align-items-center">
                            <img class="feature-icon"
                                src="{{ public_asset('assets/images/landing_tutor/diagnosis.jpg') }}"
                                alt="WWCC verified online tutors Australia ensuring safe learning for Maths, Science and English" />
                        </div>
                        <p class="feature-title">Clear Diagnosis</p>
                        <p class="feature-content">
                            Every student begins with an assessment that identifies the exact gap affecting performance.
                        </p>
                    </div>
                </div>

                <div class="col">
                    <div class="p-1 p-md-3">
                        <div class="d-flex justify-content-center align-items-center">
                            <img class="feature-icon"
                                src="{{ public_asset('assets/images/landing_tutor/personalised-plan.jpg') }}"
                                alt="Secure online tutoring Australia with monitored and recorded sessions for student safety" />
                        </div>
                        <p class="feature-title">Personalised Plan</p>
                        <p class="feature-content">
                            A targeted program is built to address that gap, with each session focused on a specific objective.
                        </p>
                    </div>
                </div>

                <div class="col">
                    <div class="p-1 p-md-3">
                        <div class="d-flex justify-content-center align-items-center">
                            <img class="feature-icon"
                                src="{{ public_asset('assets/images/landing_tutor/visible-progress.jpg') }}"
                                alt="ACARA-aligned online tutors Australia for consistent Maths, Science and English learning" />
                        </div>
                        <p class="feature-title">Visible Progress </p>
                        <p class="feature-content">
                            After every session, you receive a clear report on what has improved and what still needs attention.
                        </p>
                    </div>
                </div>

                <div class="col">
                    <div class="p-1 p-md-3">
                        <div class="d-flex justify-content-center align-items-center">
                            <img class="feature-icon"
                                src="{{ public_asset('assets/images/landing_tutor/confident-thinking.jpg') }}"
                                alt="Reliable support for students using V-Tutor’s online tutoring Australia platform" />
                        </div>
                        <p class="feature-title">Confident Thinking</p>
                        <p class="feature-content">
                            Students learn how to approach problems with clarity, not just arrive at the answer.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>
      <!-- Step Section -->
    <section class="container safty-learning steps-section text-white">
        <div class="text-center">

            <h2 class="mb-4 mb-md-5">
                From assessment to results in 4 steps:
            </h2>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">

                <div class="col">
                    <div class="step-card p-3 text-start">
                        <div class="step-number">01</div>
                        <p class="step-title">Book free assessment:</p>
                        <p class="feature-content step">
                            Fill in the form and we'll confirm within 24 hours. No commitment, no payment required.
                        </p>
                    </div>
                </div>

                <div class="col">
                    <div class="step-card p-3 text-start">
                        <div class="step-number">02</div>
                        <p class="step-title">We identify the gap:</p>
                        <p class="feature-content step">
                            A targeted program is built to address that gap, with each session focused on a specific objective.
                        </p>
                    </div>
                </div>

                <div class="col">
                    <div class="step-card p-3 text-start">
                        <div class="step-number">03</div>
                            <p class="step-title">We recommend the right program:</p>
                            <p class="feature-content step">
                                After every session, you receive a clear report on what has improved and what still needs attention.
                            </p>
                    </div>
                </div>

                <div class="col">
                    <div class="step-card p-3 text-start">
                        <div class="step-number">04</div>
                        <p class="step-title">Sessions begin:</p>
                        <p class="feature-content step">
                            Students learn how to approach problems with clarity, not just arrive at the answer.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>
     <!-- ======= Team Section ======= -->
<section class="team-section">
  <div class="container">
        <div class="text-center section-head">
            <h2 class="mb-4 team-section-h">
                Real experts. Real people.<br>
                You choose who works with your child.
            </h2>
            <p class="mb-4 mb-md-5 team-section-p">Every tutor in our network is individually selected for academic excellence and teaching ability.
                Please review their full profile and credentials before your child's first session.</p>
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
            <p class="mt-3 mb-2 text-center">
              5+ years tutoring experience across Maths, Science and English.
            </p>
            <p class="text-center">Prize-winning Electrical Engineering undergraduate with 2x Academic Excellence Scholarships.
            </p>
            <a href="{{ url('tutor-search-result') }}"
              target="_blank" class="btn btn-primary px-5 mt-5">View Profile
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
            <p class="mt-3 mb-2 text-center">
              7+ years tutoring experience across Maths, Chemistry and Biology.
            </p>
            <p class="text-center">
              Studying a Bachelor of Medical Studies. Obtained a Medicine Diploma and Biological Sciences Diploma.
            </p>
            <a href="{{ url('tutor-search-result') }}"
              target="_blank" class="btn btn-primary px-5 mt-4">View Profile
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
            <p class="mt-3 mb-2 text-center">
              5+ years tutoring experience across Maths and Science.
            </p>
            <p class="text-center">
              Studying a Bachelor of Pharmacy. Obtained a Diploma of Health Science and a University Scholarship for Outstanding GPA.
            </p>
            <a href="{{ url('tutor-search-result') }}"
              target="_blank" class="btn btn-primary px-5 mt-4">View Profile
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
            <p class="mt-3 mb-2 text-center">
              Primary School Teacher with 10+ years classroom experience. Obtained a Primary School Education Diploma.
            </p>
            <p class="text-center">
             10+ years tutoring experience across various Primary School subjects. 
            </p>
            <a href="{{ url('tutor-search-result') }}"
              target="_blank" class="btn btn-primary px-5 mt-4">View Profile
            </a>
          </div>
        </div>
      </div>

    </div>

  </div>
</section>
 <!-- faqsec -->
<section class="faq-section">
    <div class="container">

        <div class="mb-4">
            <p class="faq-label">COMMON QUESTIONS</p>
            <h2 class="faq-heading">Everything you need to know:</h2>
        </div>

        <div class="makes_faq_bx newfaq">
            <div class="accordion" id="homePageFaqAccordion">

                 <!-- FAQ 1 -->
    <div class="card">
        <div class="card-header" id="faqHeading1">
            <h2 class="mb-0">
                <a class="btn-link btn-block text-left" data-toggle="collapse" data-target="#collapseFaq1" aria-expanded="true">
                    1. What if my child doesn't improve?
                </a>
            </h2>
        </div>
        <div id="collapseFaq1" class="collapse show" data-parent="#homePageFaqAccordion">
            <div class="card-body">
                <p>
                    We take a structured, diagnostic-led approach to identify exactly where your child is struggling. 
                    Each session targets specific gaps, and progress is monitored closely. If improvement isn’t seen, 
                    we reassess the approach, adjust the learning plan, or match your child with a different tutor 
                    to ensure the right support is in place.
                </p>
            </div>
        </div>
    </div>

    <!-- FAQ 2 -->
    <div class="card">
        <div class="card-header" id="faqHeading2">
            <h2 class="mb-0">
                <a class="btn-link btn-block text-left collapsed" data-toggle="collapse" data-target="#collapseFaq2">
                    2. What happens after the 10 sessions are done?
                </a>
            </h2>
        </div>
        <div id="collapseFaq2" class="collapse" data-parent="#homePageFaqAccordion">
            <div class="card-body">
                <p>
                    There's no automatic renewal or lock-in. Once your program is complete you'll receive a full 
                    end-of-program assessment and a recommendation for next steps. That may include a different program, 
                    a different subject or nothing at all. The decision is entirely yours.
                </p>
            </div>
        </div>
    </div>

    <!-- FAQ 3 -->
    <div class="card">
        <div class="card-header" id="faqHeading3">
            <h2 class="mb-0">
                <a class="btn-link btn-block text-left collapsed" data-toggle="collapse" data-target="#collapseFaq3">
                    3. Can I change tutors if it's not a good fit?
                </a>
            </h2>
        </div>
        <div id="collapseFaq3" class="collapse" data-parent="#homePageFaqAccordion">
            <div class="card-body">
                <p>
                    Absolutely. Finding the right tutor match is important for your child’s learning and confidence. 
                    If you feel the tutor isn’t the right fit, you can request a change at any time - we’ll help you 
                    find a tutor better suited to your child’s needs.
                </p>
            </div>
        </div>
    </div>

    <!-- FAQ 4 -->
    <div class="card">
        <div class="card-header" id="faqHeading4">
            <h2 class="mb-0">
                <a class="btn-link btn-block text-left collapsed" data-toggle="collapse" data-target="#collapseFaq4">
                    4. How does online tutoring actually work?
                </a>
            </h2>
        </div>
        <div id="collapseFaq4" class="collapse" data-parent="#homePageFaqAccordion">
            <div class="card-body">
                <p>
                   Sessions are conducted live through our secure online classroom powered by Daily.co. Your child joins at the scheduled time and learns one-on-one with their tutor using 
                   interactive tools like screen sharing, digital whiteboards, and real-time explanations - closely mirroring an in-person experience from the comfort of home.
                    <br/>
                    Daily.co runs directly in your browser with no downloads required, offering high-quality video, low latency, and secure access, along with built-in interactive tools 
                    that keep lessons smooth, engaging, and easy to follow.
                </p>
            </div>
        </div>
    </div>

    <!-- FAQ 5 -->
    <div class="card">
        <div class="card-header" id="faqHeading5">
            <h2 class="mb-0">
                <a class="btn-link btn-block text-left collapsed" data-toggle="collapse" data-target="#collapseFaq5">
                    5. Why is this better than finding a tutor independently?
                </a>
            </h2>
        </div>
        <div id="collapseFaq5" class="collapse" data-parent="#homePageFaqAccordion">
            <div class="card-body">
                <p>
                    Many independent tutors offer general homework help. Our programs are diagnostic-led. Every session 
                    targets a specific identified gap, and is followed by a progress report. All of our tutors are 
                    individually selected for academic excellence and teaching ability.
                </p>
            </div>
        </div>
    </div>

            </div>
        </div>

    </div>
</section>
<!-- BOOK FREE ASSESSMENT -->
<section id="book-assessment-landing" class="book-assessment-section">
    <div class="container">
        <div class="row g-4 align-items-stretch">
            <!-- LEFT SIDE -->
            <div class="col-lg-4">
                <div class="assessment-left">
                    <h2>
                        Find the gap.<br>
                        Close it. Start<br>
                        with a free<br>
                        assessment.
                    </h2>
                    <p>
                        If it's not the right fit, you won't pay a cent.
                    </p>
                </div>
            </div>
            <!-- RIGHT SIDE FORM -->
            <div class="col-lg-8">
                <div class="assessment-form">
                    <h3>Book Your Free Assessment</h3>
                    <small>Takes 2 minutes. No commitment required.</small>
                    <div id="assessmentSuccess" class="alert alert-success" style="display:none;"></div>
                    <form id="assessmentForm" method="POST">
                        @csrf

                        <label>Parent Name*</label>
                        <input type="text" name="parent_name" placeholder="Parent name"  required>

                        <label>Student Name*</label>
                        <input type="text" name="child_name" placeholder="Child name" required>

                        <label>Email*</label>
                        <input type="email" name="email" placeholder="your@email.com" required>

                        <label>Student Year*</label>
                        <select name="year_level" required>
                            <option value="">Select year level</option>
                                @for ($i = 1; $i <= 12; $i++)
                            <option value="Grade {{ $i }}">Year {{ $i }}</option>
                                @endfor
                        </select>

                        <!-- Added State Select Dropdown -->
                        <label>State*</label>
                        <select name="state" required>
                            <option value="">Select State</option>
                            @php
                                $states = [
                                    'New South Wales',
                                    'Victoria',
                                    'Queensland',
                                    'South Australia',
                                    'Tasmania',
                                    'Western Australia',
                                    'Australian Capital Territory',
                                    'Northern Territory'
                                ];
                            @endphp
                             @foreach ($states as $state)
                                <option value="{{ $state }}">{{ $state }}</option>
                            @endforeach
                        </select>

                        <!-- <label>Child's subject*</label>
                        <select name="subject" required>
                            <option value="">Select subject</option>
                                @foreach ($branches->whereIn('branch_name', ['Maths','Science','English']) as $branch)
                            <option value="{{ $branch->branch_name }}">
                                {{ $branch->branch_name }}
                            </option>
                            @endforeach
                        </select> -->

                        <button type="button" class="assessment-btn" id="assessmentSubmitBtn">
                            BOOK MY FREE ASSESSMENT
                        </button>
                    </form>
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
    <script>
$(document).ready(function () {

    // VALIDATION
    $('#assessmentForm').validate({
    rules: {
        parent_name: "required",
        child_name: "required",
        email: {
            required: true,
            email: true
        },
        year_level: "required",
        subject: "required"
    },

    errorPlacement: function (error, element) {
        error.addClass('text-danger d-block mt-1 mb-2'); 
        error.insertAfter(element); 
    }
});

    $("#assessmentSubmitBtn").on("click", function () {

        if (!$('#assessmentForm').valid()) {
            return;
        }

        $(".backend-error").remove();

        let btn = $(this);
        btn.prop("disabled", true).html(
            `<span class="spinner-border spinner-border-sm"></span> Sending...`
        );

        fetch("{{ route('program.book.free.assessment.submit') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            },
            body: new FormData(document.getElementById("assessmentForm"))
        })
        .then(res => res.json())
        .then(data => {

            if (data.success) {

                $("#assessmentSuccess")
                    .text(data.message)
                    .fadeIn();

                setTimeout(() => {
                    $("#assessmentSuccess").fadeOut();
                }, 3000);

                $('#assessmentForm')[0].reset();

            } else if (data.errors) {

                $.each(data.errors, function (field, messages) {
                    let input = $('[name="' + field + '"]');

                    if (input.length) {
                        input.after(
                            `<label class="error backend-error">${messages[0]}</label>`
                        );
                    }
                });

                $('html, body').animate({
                    scrollTop: $('.backend-error:first').offset().top - 100
                }, 400);
            }

        })
        .catch(() => alert("Something went wrong"))
        .finally(() => {
            btn.prop("disabled", false).text("BOOK MY FREE ASSESSMENT");
        });

    });

    $('.scroll-to-assessment').on('click', function(e) {
        e.preventDefault();

        $('html, body').animate({
            scrollTop: $('#book-assessment-landing').offset().top - 80
        }, 600);
    });

});

</script>
@endsection