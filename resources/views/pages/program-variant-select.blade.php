@extends('layouts.app')

@section('page_title', 'Program Detail')

@section('left_part')
@include('include.header_menu_part')

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>

/* HERO SAME */
.hero {
  min-height: 30vh;
  position: relative;
  text-align: center;
  overflow: hidden;
}
.hero .hero-bg img {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
}
.hero .hero-overlay {
  position: absolute;
  inset: 0;
  background: rgba(90, 90, 90, 0.55);
  z-index: 2;
}
.hero .container {
  position: relative;
  z-index: 2;
  padding: 120px 15px;
}

.hero-title,
.hero h1 {
  color: #ffffff !important;
  font-size: 46px;
  font-weight: 700;
}

.hero .breadcrumb {
  background: transparent !important;
  padding: 0;
  margin-bottom: 15px;
}

.hero .breadcrumb-item,
.hero .breadcrumb-item a {
  color: #ffffff;
}

.top-programs-box {
  background: linear-gradient(
    135deg,
    #ffffff 0%,
    #ffffff 60%,
    rgba(215, 38, 61, 0.08) 100%
  );
  padding: 32px 34px;
  border-radius: 16px;
  padding: 40px;
  box-shadow: 0 20px 45px rgba(0,0,0,0.12);
}

/* PROGRESS (same modal) */
/* GRID */
.option-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 18px;
}
@media (max-width: 768px) {

  .variant-box {
    padding: 25px 15px;
    margin: 0;
    border-radius: 14px;
  }

  /* Grades - 2 columns */
  #step-year .option-grid {
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 12px;
  }

  /* States - 1 column */
  #step-state .option-grid {
    grid-template-columns: 1fr;
    gap: 12px;
  }

  .option-card {
    min-width: 0;
    width: 100%;
  }

  .option-content {
    width: 100%;
    box-sizing: border-box;
    padding: 18px 12px;
  }

  .option-icon {
    font-size: 25px;
  }

  .option-text {
    font-size: 15px;
    line-height: 1.3;
  }
}
/* CARD */
.option-card input { display:none; }

.option-content {
  border: 2px solid #e0e0e0;
  border-radius: 14px;
  padding: 22px;
  text-align: center;
  cursor: pointer;
  background: #fff;
  transition: all .25s ease;
}

/* ICON */
.option-icon {
  font-size: 30px;
  margin-bottom: 10px;
}

/* TEXT */
.option-text {
  font-size: 16px;
  font-weight: 600;
}

/* HOVER */
.option-content:hover {
  border-color: #b80f0a;
  background: #fff5f5;
  transform: translateY(-3px);
  box-shadow: 0 12px 28px rgba(0,0,0,0.12);
}

/* SELECTED */
.option-card input:checked + .option-content {
  border-color: #b80f0a;
  background: #fff5f5;
  box-shadow: 0 10px 25px rgba(184,15,10,0.18);
}
.variant-box {
  background: linear-gradient(180deg, #ffffff 0%, #fafafa 100%);
  border-radius: 18px;
  padding: 42px;
  position: relative;

  /* layered shadow = premium feel */
  box-shadow:
    0 18px 38px rgba(0, 0, 0, 0.08),
    0 8px 16px rgba(0, 0, 0, 0.06);

  margin: 10px; /* important for visibility */
}

/* Optional top highlight */
.variant-box::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 5px;
  border-radius: 18px 18px 0 0;
  background: linear-gradient(90deg, #b80f0a, #e53935);
}
</style>
@endsection


@section('content')
@php
$title = 'Learning Program';
@endphp
<!-- ================= HERO (Modern Card Header) ================= -->
@include('include.page_hero', [
    'title' => $title,
    'showBreadcrumb' => true
])

<!-- VARIANT SELECT -->
<section class="py-5">
<div class="container">

  <div class="variant-box">

      <div class="" id="progressBar" style="width:50%"></div>

    <!-- STEP 1 -->
    <div id="step-year" style="{{ !empty($selectedYear) ? 'display:none;' : '' }}">

    <h5 class="text-center mb-4">
      Which grade is your child currently in?
    </h5>

    <div class="option-grid">

    @foreach($programs->unique('grade_id') as $program)

    <label class="option-card">
      <input type="radio"
           class="year-option"
           data-year="{{ $program->grade_id }}">

      <div class="option-content">
        <div class="option-icon">🎓</div>
        <div class="option-text">
            {{ $program->grade->grade_name }}
        </div>
    </div>
    </label>

    @endforeach

</div>
</div>


<!-- STEP 2 -->
<div id="step-state" style="display:none;">

<h5 class="text-center mb-4">
 Which state are you in?
</h5>

<div class="option-grid">

@foreach($programs as $program)

<label class="option-card state-item"
       data-year="{{ $program->grade_id }}">

    <input type="radio"
           class="state-option"
           data-state="{{ strtolower(str_replace(' ', '-', $program->state)) }}">

    <div class="option-content">
        <div class="option-icon">📍</div>
        <div class="option-text">
            {{ $program->state }}
        </div>
    </div>

</label>

@endforeach

</div>
</div>

</div>
</div>
</section>


<script>
document.addEventListener("DOMContentLoaded", function () {

let selectedYear = "{{ $selectedYear ?? '' }}";
let slug = "{{ $slug }}";
let filteredStates = @json($filteredStates ?? []);

/* PRESELECT FLOW */
if(selectedYear){

    let visibleStates = [];

    document.querySelectorAll('.state-item').forEach(item => {

        const stateSlug = item.querySelector('.state-option').dataset.state;

        if(item.dataset.year == selectedYear &&
           (filteredStates.length === 0 || filteredStates.includes(stateSlug))){
            visibleStates.push(stateSlug);
        }
    });

   /*  AUTO REDIRECT IF ONLY 1 STATE */
    if(visibleStates.length === 1){
        window.location.href = `/program/${slug}?year=${selectedYear}&state=${visibleStates[0]}`;
        return;
    }

     /* SHOW STATE STEP */
    document.getElementById('step-state').style.display = "block";
    document.getElementById('progressBar').style.width = "100%";

    document.querySelectorAll('.state-item').forEach(item => {
        const stateSlug = item.querySelector('.state-option').dataset.state;

        item.style.display =
            (item.dataset.year == selectedYear &&
            (filteredStates.length === 0 || filteredStates.includes(stateSlug)))
            ? "block" : "none";
    });
}

/* YEAR SELECT */
document.querySelectorAll('.year-option').forEach(input => {

    input.addEventListener('change', function(){

        selectedYear = this.dataset.year;

        let visibleStates = [];

        document.querySelectorAll('.state-item').forEach(item => {
            if(item.dataset.year == selectedYear){
                visibleStates.push(item.querySelector('.state-option').dataset.state);
            }
        });

       /* ONLY ONE STATE */
        if(visibleStates.length === 1){
            window.location.href = `/program/${slug}?year=${selectedYear}&state=${visibleStates[0]}`;
            return;
        }

       /*  MULTIPLE STATES */
        document.getElementById('step-year').style.display = "none";
        document.getElementById('step-state').style.display = "block";
        document.getElementById('progressBar').style.width = "100%";

        document.querySelectorAll('.state-item').forEach(item => {
            item.style.display = item.dataset.year == selectedYear ? "block" : "none";
        });

    });

});

/* STATE SELECT */
document.querySelectorAll('.state-option').forEach(input => {

    input.addEventListener('change', function(){

        let selectedState = this.dataset.state;

        window.location.href =
            `/program/${slug}?year=${selectedYear}&state=${selectedState}`;

    });

});

});
</script>

@endsection


@section('footer')
@include('include.footer')
@endsection

@section('script')
@include('include.script')
@endsection