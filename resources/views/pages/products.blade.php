@extends('layouts.app') 

@php
$type = request()->route('type');

$seo = [
    'learning' => [
        'title' => 'Online Learning Programs (Year 1–12) | Maths, English, Science',
        'description' => 'Explore structured online learning programs for Year 1 to Year 12 in Maths, English and Science across Australia. Find the right program by year and state.',
        'keywords' => 'online tutoring Australia, online tutors Australia, online tutors, online learning programs Australia, maths english science tutoring, year 1 to 12 programs, academic learning programs'
    ],
    'oc' => [
        'title' => 'OC Preparation Programs (Opportunity Class) Australia',
        'description' => 'Prepare for Opportunity Class (OC) exams with structured tutoring programs. Improve reasoning, maths and English skills with expert tutors.',
        'keywords' => 'online tutoring Australia, online tutors Australia, online tutors, OC preparation Australia, opportunity class tutoring, OC exam coaching, academic learning programs, oc programs'
    ],
    'naplan' => [
        'title' => 'NAPLAN Preparation Programs | Year 3, 5, 7, 9',
        'description' => 'Boost NAPLAN scores with targeted preparation programs in reading, writing and numeracy. Designed for Australian students.',
        'keywords' => 'online tutoring Australia, online tutors Australia, online tutors, NAPLAN preparation, NAPLAN tutoring Australia, year 3 5 7 9 NAPLAN,academic learning programs, naplan programs'
    ]
];

$currentSeo = $seo[$type] ?? $seo['learning'];
@endphp

@section('page_title', $currentSeo['title'])
@section('meta_description', $currentSeo['description'])
@section('meta_keywords', $currentSeo['keywords'])


@section('left_part')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
@include('include.header_menu_part')
@endsection

@section('content')
@php
$type = request()->route('type');

$title = 'Learning Programs';

if ($type == 'oc') {
    $title = 'Opportunity Class Programs';
} elseif ($type == 'naplan') {
    $title = 'Naplan Programs';
}
@endphp
<!-- ================= HERO (Modern Card Header) ================= -->
@include('include.page_hero', [
    'title' => $title,
    'showBreadcrumb' => true
])

<!-- ================= END HERO ================= -->

<!-- ================= FILTER SECTION ================= -->
<section class="program-filter-section py-1">
  <div class="container">

    <div class="filter-card">


      <!-- YEAR SELECTION -->
      <!-- ================= YEAR SELECTION ================= -->
    <div class="year-filter-wrapper mt-2">

    <div class="year-header">

       <h2 class="section-title text-center mb-0">
        Find Learning Programs By <span class="section-heading">Year</span>
      </h2>

        <!-- Desktop Button -->
        <button id="moreFiltersBtn" class="btn filter-main-btn desktop-only">
            More Filters <i class="bi bi-funnel"></i>
        </button>

    </div>

    <!-- Year Grid -->
    <div class="year-grid mt-4">
        @foreach($grades as $grade)
        <button class="year-btn" data-slug="{{ $grade->slug }}" data-id="{{ $grade->id }}">
          {{ $grade->grade_name }}
        </button>
        @endforeach
    </div>

    <!-- ================= STATE SELECTION ================= -->
<div class="state-filter-wrapper mt-4">

    <h2 class="section-title text-center mb-2"><span class="section-heading">State</span></h2>

    <div class="state-grid mt-3">
        @php
        $states = [
            'New South Wales' => 'NSW',
            'Victoria' => 'VIC',
            'Queensland' => 'QLD',
           /* 'South Australia' => 'SA',
            'Western Australia' => 'WA',
            'Tasmania' => 'TAS',
            'Australian Capital Territory' => 'ACT',
            'Northern Territory' => 'NT',
             */
        ];
        @endphp

        @foreach($states as $full => $short)
            <button class="state-btn" data-name="{{ $full }}">
                {{ $short }}
            </button>
        @endforeach
    </div>

</div>

    <!-- Mobile Button -->
    <div class="mobile-only text-center mt-3">
        <button id="moreFiltersBtnMobile" class="btn filter-main-btn w-100">
             More Filters <i class="bi bi-funnel"></i>
        </button>
    </div>

    <!-- POPUP PANEL (Single Shared Panel) -->
  <div id="moreFiltersPanel" class="more-filters-panel card-popover">

    <!-- Close Button -->
    <button type="button" id="closeFiltersPanel" class="close-filter-btn">
        &times;
    </button>

    <!-- Subject -->
    <div class="filter-item">
        <label for="subject">Subject</label>
        <select id="subject">
        <option value="">Select Subject</option>
          @php
                $allowedBranches = ['Maths', 'Science', 'English'];
          @endphp

        @foreach($branches->whereIn('branch_name', $allowedBranches) as $branch)
        <option value="{{ $branch->id }}">
            {{ $branch->branch_name }}
        </option>
        @endforeach
        </select>
    </div>

    <!-- Year -->
    <div class="filter-item">
        <label for="yearFilter">Year</label>
        <select id="yearFilter">
        <option value="">Select Year</option>
          @foreach($grades as $grade)
        <option value="{{ $grade->id }}">
          {{ $grade->grade_name }}
        </option>
        @endforeach
      </select>
    </div>

    <!-- State -->
    <div class="filter-item">
        <label for="state">State</label>
        <select id="state">
            <option value="">Any State</option>
            <option value="New South Wales">New South Wales</option>
            <option value="Victoria">Victoria</option>
            <option value="Queensland">Queensland</option>
            <!-- <option value="South Australia">South Australia</option>
            <option value="Western Australia">Western Australia</option>
            <option value="Tasmania">Tasmania</option>
            <option value="Australian Capital Territory">Australian Capital Territory</option>
            <option value="Northern Territory">Northern Territory</option>  -->
      </select>
    </div>

    <!-- Curriculum -->
    <div class="filter-item">
        <label for="curriculum">Curriculum</label>
        <select id="curriculum">
          <option value="">Select Curriculum</option>
          <option value="NESA Curriculum">NESA Curriculum</option>
          <option value="VCAA curriculum">VCAA curriculum</option>
          <option value="QCAA Curriculum">QCAA Curriculum</option>
          <option value="SACE Curriculum">SACE Curriculum</option>
          <option value="WACE Curriculum">WACE Curriculum</option>
          <option value="BSSS Curriculum">BSSS Curriculum</option>
          <option value="TASC Curriculum">TASC Curriculum</option>
          <option value="NTBS Curriculum">NTBS Curriculum</option>
        </select>
    </div>

    <!-- Actions -->
    <div class="filter-actions mt-2">
        <button id="clearFilters" class="btn btn-outline-program filter-actions-button">
            Clear All
        </button>

        <button id="applyFilters" class="btn btn-add-cart filter-actions-button">
            Apply Filters
        </button>
    </div>
    <div id="filterError" class="filter-error"></div>

  </div>

  </div>
       
    <!-- ================= INFO MESSAGE ================= -->
    <div id="infoBox" class="info-box">
      <div class="row align-items-center justify-content-center text-center text-md-start">
<!-- 
        Image Left
        <div class="col-md-4  mb-4 mb-md-0">
          <img src="{{ public_asset('assets/images/academic-program-view.png') }}" 
            class="info-img img-fluid">
        </div> -->

        <!-- Text Right -->
        <!-- <div class="col-md-6">
          <h2 class="section-title">
         Explore Our Learning Programs designed for Real <span class="section-heading">Academic Progress</span>  
          </h2>
          <p class="text-muted mb-0">
            Choose your child's year and state above to view available programs
          </p>
        </div> -->

      </div>
    </div>
   <div id="activeFiltersWrapper" class="mb-3" style="display:none;">
        <div id="activeFilters"></div>
    <div id="programCount" class="program-count"></div>
</div>
    <div class="mt-4" id="programResults" style="display:none;">
    </div>
     
    <div class="mt-4" id="prePopulatedData">

@php
$order = ['Maths', 'English', 'Science'];

$subjectImages = [
    'Maths' => 'assets/images/english-programs.png',
    'English' => 'assets/images/maths-programs.png',
    'Science' => 'assets/images/science-programs.png',
];
@endphp

@foreach($order as $subjectName)

@if(isset($prePopulatedData[$subjectName]) && count($prePopulatedData[$subjectName]['programs']) > 0)

@php 
$data = $prePopulatedData[$subjectName]; 
@endphp


<!-- SUBJECT BANNER -->
<div class="subject-banner mb-10">
    <img src="{{ public_asset($subjectImages[$subjectName] ?? 'assets/images/banner-default.jpg') }}"
        alt="{{ $subjectName }}"
        class="subject-banner-img">

    <div class="banner-overlay"></div>

    <h3 class="banner-title">{{ $subjectName }}</h3>
</div>


<!-- SUBJECT CAROUSEL -->
<div class="owl-carousel owl-theme subject-carousel mb-5"
     id="carousel-{{ strtolower($subjectName) }}">

    @foreach($data['programs'] as $programName => $programItems)

    @php
        $firstProgram = $programItems->first();
    @endphp

    <div class="item mt-2">

        <div class="program-pre-card">

            <div class="program-meta-top">
                {{ $subjectName }} Program
             </div>

            <h5 class="program-title">
                {{ $programName }}
            </h5>
            <p class="program-desc">
                {{ \Illuminate\Support\Str::limit($firstProgram->description, 160) }}
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
                <div class="program-tags">

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
                    @endphp

                    @php
                        $allGrades = $programItems->pluck('grade.grade_name')->unique()->join(', ');
                        $allStates = $programItems->pluck('state')->unique()->map(fn($s) => $stateShortMap[$s] ?? $s)->join(', ');
                    @endphp

                        <span class="tag grade-tag">{{ $allGrades }}</span>
                        <span class="tag state-tag">{{ $allStates }}</span>

                </div>

                {{-- Actions --}}
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

@endif
@endforeach

</div>

  </div>
  </div>
</section>
<!-- ================= END FILTER SECTION ================= -->
<!-- ================= POPULAR PROGRAMS ================= -->
<section class="popular-programs pb-5">
  <div class="container">
     <div class="popular-box">
    <h2 class="section-title text-center mb-4">Popular <span class="section-heading">Programs</span></h2>
    <div class="row">

        @php
            $popularPrograms = [
            [
                'title' => 'Master Number Sense',
                'state' => 'NSW',
                'image' => 'assets/images/maths-whiz-online.png',
                'slug' => 'master-number-sense'
            ],
            [
                'title' => 'Master Critical Reading',
                'state' => 'VIC',
                'image' => 'assets/images/creative-writing-workshop.png',
                'slug' => 'master-critical-reading',
            ],
            [
                'title' => 'Master Scientific Thinking',
                'state' => 'NSW',
                'image' => 'assets/images/maths-mastery-tutoring.png',
                'slug' => 'master-scientific-thinking'
            ],
            [
                'title' => 'Master Core Number Skills',
                'state' => 'WA',
                'image' => 'assets/images/advance-year5-maths.png',
                'slug' => 'master-core-number-skills',
            ],
        ];
        @endphp
        @foreach($popularPrograms as $program)
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="program-card">

            <div class="program-img">
                <img src="{{ public_asset($program['image']) }}" alt="{{ $program['title'] }}">
            </div>

            <div class="program-content">
                <h6>{{ $program['title'] }}</h6>
                <p class="program-meta">⭐⭐⭐ {{ $program['state'] }}</p>

                <div class="program-buttons">
                     <a href="{{ route('program.detail', $program['slug']) }}" class="btn btn-add-cart">
                                        Learn More
                                </a>
                </div>
            </div>
        </div>
        </div>
        @endforeach
    </div>
    </div>
  </div>
</section>
<!-- ================= END POPULAR ================= -->
<!-- <script>
const programType = "{{ request()->route('type') }}";
</script> -->
<!-- ================= Learning Program Assessment Start ================= -->
<section class="assesment-section">
        @include('include.learning_program_section')
        @include('include.learning_program_modal_only') 
</section>


<!-- ================= Learning Program Assessment End ================= -->
@endsection
@section('footer')
@include('include.footer')
@endsection

@section('script')
@include('include.script')

<style>
/* Title & Badge */
.hero-compact-title {
  font-size: 22px;
  font-weight: 800;
  color: #0f172a;
  letter-spacing: -0.3px;
  line-height: 1.25;
}

.badge-year {
  background: #fff1f2;
  color: #D7263D;
  font-size: 14px;
  font-weight: 700;
  padding: 2px 8px;
  border-radius: 6px;
  border: 1px solid #fecdd3;
  display: inline-block;
  vertical-align: middle;
}

/* Subtitle */
.hero-compact-subtitle {
  font-size: 14px;
  color: #475569 !important;
  max-width: 680px;
  line-height: 1.45;
}

/* ================= FILTER CARD ================= */
.filter-card {
  background:#FFF9EC;
  border-radius:16px;
  padding:20px;
  box-shadow:0 10px 30px rgba(0,0,0,0.08);
}

.subject-btn {
  border:1px solid #ddd;
  background:#f8f9fa;
  padding:10px 25px;
  margin:5px;
  border-radius:8px;
  font-weight:600;
  cursor:pointer;
}
.subject-btn.active,
.subject-btn:hover {
  background:#D7263D;
  color:#fff;
  border-color:#D7263D;
}

.filter-title {
  font-weight:600;
  margin-bottom:15px;
}

.year-btn:hover {
  background:#D7263D;
  color:#fff;
  border-color:#D7263D;
}

/* ================= INFO BOX ================= */
.info-box {
  padding:40px 10px 10px;
}

.section-title {
  font-weight:600;
  line-height:1.4;
}

/* ================= PROGRAM CARDS ================= */
.program-card {
  background:#fff;
  border-radius:16px;
  overflow:hidden;
  box-shadow:0 8px 20px rgba(0,0,0,0.08);
  transition:0.3s;
}
.program-card:hover {
  transform:translateY(-5px);
}

.program-img img {
  width:100%;
  height:160px;
  object-fit:cover;
}

.program-content {
  padding:20px;
}

.program-content h6 {
  font-weight:600;
  margin-bottom:6px;
}

.program-meta {
  font-size:14px;
  color:#6b7280;
}

.program-buttons {
  display: flex;
  justify-content: flex-end;
  margin-top: 15px;
}

.btn-outline-program {
  border:1px solid #D7263D;
  color:#D7263D;
  border-radius:8px;
  padding:6px 14px;
}
.btn-outline-program:hover {
  background:#D7263D;
  color:#fff;
}

.btn-add-cart {
  background: #D7263D;
  color:#fff;
  border:none;
  border-radius:8px;
  padding:6px 14px;
}
.filter-main-btn {
  background: #D7263D;
  color:#fff;
  border:none;
  border-radius:8px;
}
.btn-add-cart:hover {
  background:#b91c1c;
}
.section-heading {
 color: #dc3545;
}
/* ================= INFO IMAGE ================= */
.info-img {
  max-width: 220px;
  width: 100%;
  float: right;

  animation: attentionEntry 1s ease-in-out infinite alternate;
}
/* ================= INFO IMAGE ================= */
.more-filters-panel .filter-item {
    margin-bottom: 15px;
}

.more-filters-panel label {
    display: block;
    font-weight: 600;
    margin-bottom: 5px;
}

.more-filters-panel select,
.more-filters-panel input[type=range] {
    width: 100%;
    padding: 6px 10px;
    border-radius: 6px;
    border: 1px solid #ddd;
}

.filter-actions {
    display: flex;
    justify-content: flex-end;
    gap: 8px;
}

.filter-actions-button {
    padding: 4px 12px !important;
    font-size: 12px !important;
    border-radius: 6px;    
}

@keyframes attentionEntry {
  0% {
    transform: translateY(0);
  }
  15% {
    transform: translateY(-10px);
  }
  30% {
    transform: translateY(0);
  }
  100% {
    transform: translateY(0);
  }
}
/* ================= POPULAR BOX ================= */
.popular-box {
  background: #FFF9EC;
  padding: 50px 40px;
  border-radius: 16px;
  box-shadow: 0 10px 25px rgba(0,0,0,0.05);
  margin-top: 60px !important;
}
/* ================= RESPONSIVE ================= */
@media(max-width:768px){
  .program-buttons {
    flex-direction:column;
    gap:8px;
  }
  .info-img {
    float: left;
  }
}
/* ================= YEAR HEADER ================= */
.year-header {
    position: relative;
    display: flex;
    justify-content: center;   /* center the title */
    align-items: center;
}

.year-header h2 {
    text-align: center;
}

/* Keep More Filters at right without disturbing title */
.year-header .desktop-only {
    position: absolute;
    right: 0;
}

/* ===== YEAR FILTER WRAPPER ===== */
.year-filter-wrapper {
    position: relative;
}

/* Year Grid Desktop */
.year-grid {
    display: grid;
    grid-template-columns: repeat(6, 1fr); /* 6 per row */
    gap: 8px;
    max-width: 500px;
    margin: 0 auto; /* center grid */
}

/* Year Button */
.year-btn {
    height: 34px;        /* fixed compact height */
    font-size: 13px;
    border-radius: 6px;
    border: 1px solid #ddd;
    background: #fff;
    cursor: pointer;
    font-weight: 500;
    transition: 0.2s ease;
}

.year-btn:hover,
.year-btn.active {
    background: #D7263D;
    color: #fff;
    border-color: #D7263D;
}

/* Hide mobile button on desktop */
.mobile-only {
    display: none;
}
/* ===== Close Button ===== */
.close-filter-btn {
    position: absolute;
    top: 10px;
    right: 12px;
    background: transparent;
    border: none;
    font-size: 20px;
    font-weight: 600;
    cursor: pointer;
    color: #999;
    transition: 0.2s ease;
    line-height: 1;
}

.close-filter-btn:hover {
    color: #D7263D;
}

@media (min-width: 769px) {
  .desktop-filter-wrapper {
        position: relative;
        display: inline-block;
    }

    .card-popover {
        position: absolute;
        top: 60px;
        right: 0;
        width: 320px;

        background: #fff;
        border-radius: 12px;
        border: 1px solid #ddd;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        padding: 20px;
        z-index: 999;

        display: none;
        opacity: 0;
        transition: opacity 0.25s ease;
    }

    .card-popover.show {
        display: block;
        opacity: 1;
    }

    .card-popover::after {
        content: "";
        position: absolute;
        top: -8px;
        right: 25px;
        border-width: 0 8px 8px 8px;
        border-style: solid;
        border-color: transparent transparent #fff transparent;
    }
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

.curriculum-tag{
    background:#f3f4f6;
    color:#4b5563;
}

/* PRICE SECTION */

.program-price{
    margin-top:auto;
    margin-bottom:10px;
}

/* FINAL PRICE */

.final-price{
    font-size:30px;
    font-weight:800;
    color:#e63946;
    letter-spacing:-1px;
}

/* REGULAR PRICE */

.regular-price{
    font-size:24px;
}

.regular-price .strike{
    text-decoration:line-through;
    color:#999;
    margin-right:6px;
}

.regular-price .offer{
    color:#16a34a;
    font-weight:600;
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
/*  Image Banner */
.subject-banner{
    position: relative;
    width: 100%;
    height: 140px;
    overflow: hidden;
    border-radius: 12px;
}

.subject-banner-img{
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* dark overlay to reduce brightness */
.banner-overlay{
    position: absolute;
    inset: 0;
    background: rgba(63, 63, 63, 0.45);
}

/* centered title */
.banner-title{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: #fff !important;
    font-size: 46px;
    font-weight: 700;
    letter-spacing: 1px;
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
    background: #fff;
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
.guarantee-text {
    font-size: 13px;
    color: #16a34a;
    font-weight: 600;
    margin-bottom: 6px;
}
/*  Responsive */
@media (max-width: 768px) {

    .year-header {
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 10px;
    }

    .desktop-only {
        display: none;
    }

    .mobile-only {
        display: block;
    }

    .card-popover {
        position: absolute;
        top: calc(100% + 6px); 
        right: -20px;
        width: 320px;

        background: #fff;
        border-radius: 12px;
        border: 1px solid #ddd;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        padding: 20px;
        z-index: 999;

        display: none;
        opacity: 0;
        transition: opacity 0.25s ease;
    }

    .card-popover.show {
        display: block;
        opacity: 1;
    }

    .card-popover::after {
        content: "";
        position: absolute;
        top: -8px;
        right: 25px;
        border-width: 0 8px 8px 8px;
        border-style: solid;
        border-color: transparent transparent #fff transparent;
    }
    .year-btn {
        font-size: 12px;
    }
    .state-btn {
        height: 30px;
        font-size: 12px;
        padding: 2px 8px;
    }
}
@media (max-width: 390px) {
     .year-btn {
        font-size: 10px;
    }
    .state-btn {
        height: 28px;
        font-size: 10px;
        padding: 2px 8px;
    }
}

</style>
<script>
document.addEventListener('DOMContentLoaded', function() {

    const moreBtnDesktop = document.getElementById('moreFiltersBtn');
    const moreBtnMobile = document.getElementById('moreFiltersBtnMobile');
    const panel = document.getElementById('moreFiltersPanel');
    const applyBtn = document.getElementById('applyFilters');
    const clearBtn = document.getElementById('clearFilters');
    const closeBtn = document.getElementById('closeFiltersPanel');
    const resultContainer = document.getElementById('programResults');
    document.getElementById('prePopulatedData').style.display = 'block';

    function togglePanel(e) {
        e.preventDefault();
        e.stopPropagation();

        panel.classList.toggle('show');
        document.body.classList.toggle('filter-open');
    }

    if (moreBtnDesktop) {
        moreBtnDesktop.addEventListener('click', togglePanel);
    }

    if (moreBtnMobile) {
        moreBtnMobile.addEventListener('click', togglePanel);
    }

    /*
    ===============================
    APPLY FILTERS (AJAX CALL)
    ===============================
    */
    if (applyBtn) {
        
        applyBtn.addEventListener('click', function(){

        const errorBox = document.getElementById("filterError");

        const programType = "{{ request()->route('type') }}";

        const filters = {
           // type: programType,
            subject: document.getElementById('subject').value,
            year: document.getElementById('yearFilter').value,
            curriculum: document.getElementById('curriculum').value,
            state: document.getElementById('state').value,
        };

        const hasFilter = Object.values(filters).some(v => v !== "");

        if(!hasFilter){
            errorBox.innerHTML = "Please select at least one filter";
            errorBox.style.display = "block";
            return;
        }
        filters.type = programType;
        errorBox.style.display = "none";
        fetch("{{ route('programs.filter') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify(filters)
        })
        .then(response => response.json())
        .then(data => {

            if(data.status){
              resultContainer.innerHTML = data.html;
              document.getElementById("infoBox").style.display = "none";
              document.getElementById("prePopulatedData").style.display = "none"; 
              resultContainer.style.display = "block";
             // renderFilterBadges(filters);
              renderFilterBadges(filters, data.count); 
              syncYearGrid(filters.year);
            }

        })
        .catch(error => {
            console.error("Filter Error:", error);
        });

        panel.classList.remove('show');
        document.body.classList.remove('filter-open');

    });
}

    /*
    ===============================
    CLEAR FILTERS
    ===============================
    */
    if (clearBtn) {
        clearBtn.addEventListener('click', function(){

            document.getElementById('subject').value = "";
            document.getElementById('yearFilter').value = "";
            document.getElementById('curriculum').value = "";
            document.getElementById('state').value = "";
            syncYearGrid("");

        });
    }

    /*
    ===============================
    CLOSE FILTER PANEL
    ===============================
    */
    if (closeBtn) {
        closeBtn.addEventListener('click', function() {
            panel.classList.remove('show');
            document.body.classList.remove('filter-open');
        });
    }

    /*
===============================
YEAR GRID CLICK
===============================
*/

const yearButtons = document.querySelectorAll('.year-btn');

yearButtons.forEach(btn => {

    btn.addEventListener('click', function(){

        const yearId = this.dataset.id;

        // remove active from all
        yearButtons.forEach(b => b.classList.remove('active'));

        // activate clicked
        this.classList.add('active');

        // sync dropdown
        document.getElementById('yearFilter').value = yearId;

        // call existing ajax
        document.getElementById('applyFilters').click();

    });

});

});

const stateButtons = document.querySelectorAll('.state-btn');

stateButtons.forEach(btn => {

    btn.addEventListener('click', function(){

        const stateName = this.dataset.name;

        // remove active from all
        stateButtons.forEach(b => b.classList.remove('active'));

        // activate clicked
        this.classList.add('active');

        // sync dropdown
        document.getElementById('state').value = stateName;

        // trigger filter
        document.getElementById('applyFilters').click();

    });

});

$(document).ready(function () {

$('.subject-carousel').each(function(){

const $carousel = $(this);

const itemCount = parseInt($carousel.data("count"),10) || 0;

$carousel.owlCarousel({

loop: itemCount > 3,
autoplay: false,
nav: itemCount > 3,
dots: false,

margin: 30,

navText: [
'<span class="owl-prev-btn">&#10094;</span>',
'<span class="owl-next-btn">&#10095;</span>'
],

responsive:{
0:{ items:1 },
768:{ items:2 },
992:{ items:3 }
}

});

});

});

function renderFilterBadges(filters, count){

    const badgeContainer = document.getElementById("activeFilters");
    const wrapper = document.getElementById("activeFiltersWrapper");
    const countBox = document.getElementById("programCount");

    badgeContainer.innerHTML = "";

    Object.keys(filters).forEach(key => {

        if(key === 'type') return; // hide program type

        if(filters[key]){

            const labelMap = {
                subject : document.querySelector(`#subject option[value="${filters[key]}"]`)?.textContent,
                year : document.querySelector(`#yearFilter option[value="${filters[key]}"]`)?.textContent,
                curriculum : filters[key],
                state : filters[key]
            };

            const badge = document.createElement("div");

            badge.className = "filter-badge";

            badge.innerHTML = `${labelMap[key] || filters[key]}`;

            badgeContainer.appendChild(badge);
        }

    });

    if(badgeContainer.innerHTML !== ""){
        wrapper.style.display = "flex";
        countBox.innerHTML = `${count} Program${count > 1 ? 's' : ''} Found`;
    }else{
        wrapper.style.display = "none";
    }

}
function syncYearGrid(yearId){

    const yearButtons = document.querySelectorAll('.year-btn');

    yearButtons.forEach(btn => {

        if(btn.dataset.id == yearId){
            btn.classList.add('active');
        }else{
            btn.classList.remove('active');
        }

    });

}
function syncStateGrid(stateName){

    const stateButtons = document.querySelectorAll('.state-btn');

    stateButtons.forEach(btn => {

        if(btn.dataset.name === stateName){
            btn.classList.add('active');
        } else {
            btn.classList.remove('active');
        }

    });

}
$(document).on('click', '.add-to-cart-text', function () {

    const cartText = $(this);
    const programId = cartText.data('id');

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
            buyBtn.text('Get Now');
        }

    });

});

document.addEventListener('click', function(e){

    const btn = e.target.closest('.program-detail-btn');
    if(!btn) return;

    e.preventDefault();

    console.log('BUTTON CLICKED');

    const slug = btn.dataset.slug;

    let grades = {};
    let states = [];

    try {

        //RAW DATA LOG
        const gradesStr = (btn.dataset.grades || '{}').trim();
        const statesStr = (btn.dataset.states || '[]').trim();

        console.log('RAW DATA:', gradesStr, statesStr);

        // PARSE
        grades = JSON.parse(gradesStr);
        states = JSON.parse(statesStr);

        console.log('PARSED GRADES:', grades);
        console.log('PARSED STATES:', states);

    } catch (err) {
        console.error('JSON PARSE ERROR', err);
        return;
    }

    const single = btn.dataset.single == '1';

    console.log('IS SINGLE PROGRAM:', single);

    const gradeIds = Object.keys(grades);
    const statesFormatted = states.map(s =>
        s.toLowerCase().replace(/ /g,'-')
    );

    console.log('GRADE COUNT:', gradeIds.length);
    console.log('STATE COUNT:', states.length);

    /* SINGLE PROGRAM */
    if(single && states.length > 0){

        const year = gradeIds[0];
        const state = statesFormatted[0];

        console.log('REDIRECT (SINGLE):', {
            slug,
            year,
            state
        });

        window.location.href = `/program/${slug}?year=${year}&state=${state}`;
        return;
    }

    /* 1 YEAR + 1 STATE */
    if(gradeIds.length === 1 && states.length === 1){

        const year = gradeIds[0];
        const state = statesFormatted[0];

        console.log('REDIRECT (DIRECT):', {
            slug,
            year,
            state
        });

        window.location.href = `/program/${slug}?year=${year}&state=${state}`;
        return;
    }

    /* 1 YEAR + MULTIPLE STATES → SKIP YEAR → SHOW STATE*/
    if(gradeIds.length === 1 && states.length > 1){

        const year = gradeIds[0];
        const statesParam = statesFormatted.join(',');

        console.log('REDIRECT (SKIP YEAR → STATE):', {
            slug,
            year,
            states: statesParam
        });

        window.location.href = `/program/${slug}?year=${year}&states=${statesParam}`;
        return;
    }

    /* MULTIPLE YEARS → SHOW YEAR STEP FIRST*/
    if(gradeIds.length > 1){

        const statesParam = statesFormatted.join(',');

        console.log('REDIRECT (SHOW YEAR STEP):', {
            slug,
            states: statesParam
        });

        window.location.href = `/program/${slug}?states=${statesParam}`;
        return;
    }

});
</script>
@endsection