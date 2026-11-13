@php
    $QualificationAr = [
        '1' => 'Certificate I',
        '2' => 'Certificate II',
        '3' => 'Certificate III',
        '4' => 'Certificate IV',
        '5' => 'Diploma',
        '6' => 'Advanced Diploma',
        '7' => 'Vocational Graduate Certificate',
        '8' => 'Vocational Graduate Diploma',
        '9' => 'Associate Degree',
        '10' => 'Bachelor’s Degree',
        '11' => 'Bachelor Honours Degree',
        '12' => 'Graduate Certificate',
        '13' => 'Graduate Diploma',
        '14' => 'Master’s Degree',
        '15' => 'Doctoral Degree / PhD',
    ];
@endphp

@extends('layouts.app')

@section('page_title', 'V-Tutor | Online Tutors Search Results Australia')
@section('meta_description', 'Find qualified online tutors in Australia for Maths, Science, and English. Browse V-Tutor’s online tutoring platform for verified tutors and flexible learning options.')
@section('meta_keywords', 'online tutoring Australia, search tutors, online tutors, qualified tutors, Maths tutors, Science tutors, English tutors, tutoring platform Australia')

@section('og_title', 'V-Tutor | Online Tutors Search Results Australia')
@section('og_description', 'Browse search results on V-Tutor for online tutors in Australia. Find verified Maths, Science, and English tutors for personalised online tutoring.')
@section('og_image', asset('images/vtutor-og-image.jpg'))

@section('twitter_title', 'V-Tutor | Online Tutors Search Results Australia')
@section('twitter_description', 'Find verified online tutors in Australia for Maths, Science, and English through V-Tutor’s online tutoring platform.')
@section('twitter_image', asset('images/vtutor-og-image.jpg'))

@section('canonical', url()->current())
@section('language', 'en-au')

@section('left_part')
@include('include.header_menu_part')
@endsection

@section('content')
@php
$w_days = ['1' => 'Mon', '2' => 'Tue', '3' => 'Wed', '4' => 'Thu', '5' => 'Fri', '6' => 'Sat', '7' => 'Sun'];
$stateAbbr = [
    'New South Wales' => 'NSW',
    'Victoria' => 'VIC',
    'Queensland' => 'QLD',
    'South Australia' => 'SA',
    'Western Australia' => 'WA',
    'Tasmania' => 'TAS',
    'Northern Territory' => 'NT',
    'Australian Capital Territory' => 'ACT',
];
$min = $request_min_hourly_rate ?? 0;
$max = $request_max_hourly_rate ?? ($max_hourly_rate_fetch ?? 200);
$sortValue = old('sort_type_value',$sort_type_value ?? request('sort_type_value', 'D'));
$totalTutors = method_exists($tutors, 'total') ? $tutors->total() : count($tutors);
$hasAdvanced = !empty(request('availability')) || request()->filled('review')
|| request()->filled('min_hourly_rate') || request()->filled('max_hourly_rate');
@endphp

<section class="vt-page">
    {{---------- HERO ---------}}
    <div class="vt-hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <span class="vt-eyebrow">Meet our specialists</span>
                    <h1 class="vt-hero-title">
                        Meet the learning specialists behind <span class="vt-underline">V-Tutor.</span>
                    </h1>
                    <p class="vt-hero-text">
                        Our tutors bring subject expertise, real teaching experience and a passion for helping
                        students progress. They work within V-Tutor’s Managed Learning Programs to deliver
                        targeted, structured and measurable learning outcomes.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="container find-tutor">
        {{-------- Aligned Card  ---------}}
        <div class="vt-strip">
            <div class="row  g-0 align-items-center">
                <div class="col-lg-3 vt-strip-lead">
                    <h3>Aligned to<br class="mobile">Managed<br class="mobile">Learning Programs</h3>
                </div>
                <div class="col-lg-3 col-md-4 vt-strip-item">
                    <span class="vt-strip-ico"><i class="fas fa-bullseye"></i></span>
                    <div>
                        <h4>Program-aligned teaching</h4>
                        <p>Delivers structured, outcome-based learning from our Managed Learning Programs.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 vt-strip-item">
                    <span class="vt-strip-ico vt-ico-orange"><i class="fas fa-chart-bar"></i></span>
                    <div>
                        <h4>Targeted skill development</h4>
                        <p>Builds the right skills, fills knowledge gaps and strengthens understanding.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 vt-strip-item">
                    <span class="vt-strip-ico"><i class="fas fa-award"></i></span>
                    <div>
                        <h4>Measurable progress</h4>
                        <p>Supports your child’s learning goals with clear outcomes and ongoing review.</p>
                    </div>
                </div>
            </div>
        </div>

        {{------ Filters -------}}
        <form action="{{ route('search.result.j') }}" method="get" id="searchVtutorForm" class="vt-filters">
            <div class="vt-search">
                <i class="fas fa-search"></i>
                <input type="text" name="q" value="{{ request('q') }}"
                    placeholder="Search by tutor name, subject or program (e.g. Fractions, Algebra, NAPLAN).">
            </div>
            <div class="vt-filter-row">
                <button type="button" class="vt-filter-toggle {{ $hasAdvanced ? 'active' : '' }}" id="vtToggleAdvanced"
                    aria-label="More filters">
                    <i class="fas fa-sliders-h"></i>
                </button>
                <div class="vt-select">
                    <select name="branch_id[]" id="branch_id" class="change_apply">
                        <option value="">All Subjects</option>
                        @if (!empty($branches) && is_iterable($branches))
                        @foreach ($branches as $branch)
                        <option value="{{ $branch->slug }}"
                            @if (!empty($branch_slugs) && in_array($branch->slug, $branch_slugs)) selected @endif>
                            {{ $branch->branch_name }}
                        </option>
                        @endforeach
                        @endif
                    </select>
                </div>
                <div class="vt-select">
                    <select name="grade" id="grade" class="change_apply">
                        <option value="">All Year Levels</option>
                        @foreach ($grades as $grade)
                        <option value="{{ $grade->slug }}" {{ request('grade') == $grade->slug ? 'selected' : '' }}>
                            {{ $grade->grade_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="vt-select">
                    <select name="program_type" class="change_apply">
                        <option value="">All Program Types</option>
                        @foreach ($programTypes as $key => $pt)
                        <option value="{{ $key }}"
                            {{ request('program_type') == $key ? 'selected' : '' }}>
                            {{ $pt }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="vt-select">
                    <select name="learning_program" class="change_apply">
                        <option value="">All Learning Program</option>
                        @foreach ($learningPrograms as $key => $name)
                        <option value="{{ $key }}"
                            {{ request('learning_program') == $key ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <a href="{{ route('search.result.j') }}" class="vt-clear" id="vtClearFilters">
                    Clear Filters
                </a>
            </div>

            {{----- Inside filters (availability / rating / rate) -----}}
            <div class="vt-advanced" id="vtAdvanced" style="{{ $hasAdvanced ? '' : 'display:none;' }}">
                <div class="row">
                    <div class="col-lg-4 mb-3">
                        <h6>Availability</h6>
                        <div class="vt-chip-group">
                            @foreach ($w_days as $dk => $dv)
                            <label class="vt-chip-check">
                                <input type="checkbox" name="availability[]" value="{{ $dk }}"
                                    class="click_apply"
                                    {{ !empty($request['availability']) && in_array($dk, $request['availability']) ? 'checked' : '' }}>
                                <span>{{ $dv }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-lg-4 mb-3">
                        <h6>Ratings</h6>
                        <div class="vt-chip-group">
                            @foreach ([4, 3, 2, 1, 0] as $r)
                            <label class="vt-chip-check">
                                <input type="radio" name="review" value="{{ $r }}" class="click_apply"
                                    @if (isset($review_value) && $review_value !=='' && (int) $review_value===$r) checked @endif>
                                <span>{{ $r }}<i class="fa fa-star"></i> &amp; up</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-lg-4 mb-3">
                         <div class="slider_rnge">
        <div id="slider-range"></div>

        <span class="range-text">
            <span id="vtRateText">$0 - $200</span>

            <input type="hidden"
                   id="min_hourly_rate_value"
                   name="min_hourly_rate"
                   value="{{ $min }}">

            <input type="hidden"
                   id="max_hourly_rate_value"
                   name="max_hourly_rate"
                   value="{{ $max }}">
        </span>
    </div>
                    </div>
                </div>
            </div>
        </form>

        {{-- Total and Recommended --}}
        <div class="vt-result-head">
            <h2>{{ $totalTutors }} Learning {{ $totalTutors == 1 ? 'Specialist' : 'Specialists' }}</h2>
            <div class="vt-sort">
                <label for="sort_type_id" class="sort_by">Sort by:</label>
                <div class="vt-select vt-select-plain">
                    <select name="sort_type_value" id="sort_type_id" form="searchVtutorForm">
                        <option value="D" {{ ($sortValue ?? '') == 'D' ? 'selected' : '' }}>Recommended</option>
                            <option value="R" {{ ($sortValue ?? '') == 'R' ? 'selected' : '' }}>Ratings: High to Low</option>
                            <option value="E" {{ ($sortValue ?? '') == 'E' ? 'selected' : '' }}>Experience: Most to Least</option>
                            <option value="N" {{ ($sortValue ?? '') == 'N' ? 'selected' : '' }}>Name: A to Z</option>
                            <option value="S" {{ ($sortValue ?? '') == 'S' ? 'selected' : '' }}>Subject: A to Z</option>
                    </select>
                </div>
            </div>
        </div>

        {{----- Tutor Cards ------}}
        <div id="tutorResults">
            @if (count($tutors) > 0)
            <div class="row vt-cards">
                @foreach ($tutors as $tutor)
                @php
                $plans = $tutor->getTutorShipPlan->unique('branch_id');
                $subjectList = $plans->map(fn($p) => $p->getbranch->branch_name ?? null)->filter()->values();
                $avg = (float) ($tutor->avg_review ?? 0);
                $profile = url('tutor-public-profile') . '/' . $tutor->slug;
                $photo = $tutor->profile_pic
                ? asset('storage/teacher_profile_pic/' . $tutor->profile_pic)
                : ($tutor->avatar ?: public_asset('assets/images/blank1.png'));
                $headline = $tutor->headline ?? ($subjectList->first() ? $subjectList->first() . ' Specialist' : 'Learning Specialist');
                $yearRange = $tutor->year_levels ?? null; 
                $programChips = collect($tutor->learning_programs ?? [])->take(4); 
                @endphp

                <div class="col-lg-4 col-md-6 mb-4 d-flex">
                    <article class="vt-card">
                        <div class="vt-card-top">
                            <img src="{{ $photo }}" alt="{{ $tutor->f_name }} {{ $tutor->l_name }}" class="vt-avatar">
                            <div class="vt-card-main">
                                <div class="vt-name-row">
                                    <h3>
                                        <a href="{{ $profile }}" target="_blank"
                                            class="save_input_data_on_click" data-type="PP"
                                            data-id="{{ $tutor->id }}">{{ $tutor->f_name . ' ' . $tutor->l_name }}</a>
                                    </h3>
                                    <span class="vt-states">
                                       @foreach ($tutor->unique_wwcc_states as $state)
                                            @if (!empty($stateAbbr[$state->state_name]))
                                                <span class="vt-state">{{ $stateAbbr[$state->state_name] }}</span>
                                            @endif
                                        @endforeach
                                    </span>
                                </div>

                                <div class="vt-meta-row">
                                    <span class="vt-verified"><i class="fas fa-shield-alt"></i> WWCC Verified</span>
                                    @if(($tutor->total_no_of_reviews ?? 0) > 0)
                                        <span class="vt-rating">
                                            <i class="fa fa-star"></i>
                                            {{ number_format($avg, 1) }}
                                            <small>({{ $tutor->total_no_of_reviews }})</small>
                                        </span>
                                    @endif
                                </div>

                                <div class="vt-headline">{{ $tutor->skills }}</div>
                            </div>
                        </div>

                        <ul class="vt-info">
                            <li>
                                <i class="fas fa-graduation-cap"></i>
                                {{ $subjectList->take(3)->implode('  •  ') ?: 'Subjects not listed' }}
                            </li>
                            @if ($yearRange)
                            <li><i class="fas fa-layer-group"></i> {{ $yearRange }}</li>
                            @endif
                        </ul>

                        @if ($programChips->isNotEmpty())
                        <div class="vt-prog-title">Learning Programs <span>|</span> Support</div>
                        <div class="vt-chips">
                            @foreach ($programChips as $chip)
                            <span class="vt-chip">{{ $chip }}</span>
                            @endforeach
                        </div>
                        @endif

                        <div class="vt-card-foot">
                            <p>{{ \Illuminate\Support\Str::limit(strip_tags($tutor->capabilities ?? ''), 110) }}</p>
                            <a href="{{ $profile }}" target="_blank" class="vt-btn-outline save_input_data_on_click"
                                data-type="PP" data-id="{{ $tutor->id }}">
                                View Profile <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </article>
                </div>
                @endforeach
            </div>
            <div class="vt-pagination">
                {{ $tutors->appends(request()->query())->links() }}
            </div>
            @else
            <div class="vt-empty">
                <img src="{{ public_asset('assets/images/empty_img.png') }}" alt="">
                <h2>No tutors match your current filters.</h2>
                <p>Adjust your selections to explore more available tutors.</p>
                <small>Note: Tutor availability depends on state authorisation and subject preferences. We’re
                    onboarding new tutors regularly - adjust your filters or check back soon to see more options.</small>
            </div>
            @endif
        </div>

        {{---- HOW WE SELECT  ----}}
        <div class="vt-select-cta">
            <div class="vt-cta-ico"><i class="fas fa-clipboard-check"></i><i class="fas fa-graduation-cap"></i></div>
            <div class="vt-cta-text">
                <h3>How We Select Our Tutors</h3>
                <p>Discover our thorough screening, interview and verification process to ensure we work with
                    qualified, experienced and child-safe educators.</p>
            </div>
            <a href="{{ url('faq') }}?tab=tutors" class="vt-btn-outline vt-btn-lg">
                Learn About Our Selection Process <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

<style>
    :root {
        --vt-navy: #0b1f4d;
        --vt-red: #e11d48;
        --vt-red-soft: #fde8ec;
        --vt-bg: #fdf8f3;
        --vt-border: #ece3dc;
        --vt-text: #3d4a6b;
        --abt-cream-hero: #fdf8f5;
    }
    html,
	body {
		max-width: 100%;
		overflow-x: hidden;
	}
    .vt-page {
        background: var(--vt-bg);
        color: var(--vt-text);
    }

    .vt-page h1,
    .vt-page h2,
    .vt-page h3,
    .vt-page h4,
    .vt-page h5,
    .vt-page h6 {
        color: var(--vt-navy);
    }

    /* Hero */
    
    .vt-hero {
        position: relative;
        background-color: var(--abt-cream-hero);
        background-image: url("{{ public_asset('assets/images/about/image1.png') }}");
        background-repeat: no-repeat;
        background-size: 60% 100%;
        background-position: right center;
        overflow: hidden;
        min-height: 300px;
    }

    .vt-hero::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg,
                var(--abt-cream-hero) 0%,
                var(--abt-cream-hero) 25%,
                rgba(255, 248, 235, 0.95) 45%,
                rgba(255, 248, 235, 0.65) 55%,
                rgba(255, 248, 235, 0.15) 75%,
                transparent 100%);

        z-index: 1;
        pointer-events: none;
    }

    .vt-hero .container {
        position: relative;
        z-index: 2;
        margin-top: 5%;
        margin-bottom: 5%;
    }

    .find-tutor.container {
        margin-top: 2%;
    }

    .vt-hero .row {
        min-height: 220px;
        align-items: center;
    }

    .vt-hero-title {
        font-size: 44px;
        line-height: 1.1;
        font-weight: 800;
        margin: 0 0 18px;
        max-width: 560px;
    }

    .vt-hero-text {
        font-size: 16px;
        line-height: 1.55;
        max-width: 520px;
        color: var(--vt-navy);
        margin-bottom: 0;
    }

    @media (max-width: 991px) {
        .mobile {
            display: none;
        }

        .vt-hero {
            background-size: cover;
        }

        .vt-hero-title {
            font-size: 34px;
        }
    }

    .vt-eyebrow {
        display: block;
        color: var(--vt-red);
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        font-size: 14px;
        margin-bottom: 10px;
    }

    .vt-hero-title {
        font-size: 44px;
        line-height: 1.1;
        font-weight: 800;
        margin: 0 0 18px;
        max-width: 560px;
    }

    .vt-underline {
        position: relative;
        display: inline-block;
    }

    .vt-underline::after {
        content: "";
        position: absolute;
        left: 6%;
        right: 0;
        bottom: -6px;
        height: 8px;
        border-bottom: 3px solid var(--vt-red);
        border-radius: 50%;
    }

    .vt-hero-text {
        font-size: 16px;
        line-height: 1.55;
        max-width: 520px;
        color: var(--vt-navy);
    }

    .vt-hero-img {
        max-height: 240px;
        width: auto;
        border-radius: 0 0 0 40px;
    }

    .vt-cards {
        margin-left: -8px;
        margin-right: -8px;
    }

    .vt-cards>div {
        padding-left: 8px;
        padding-right: 8px;
    }

    /* Aligned card */
    .vt-strip {
        background: #fdeeee;
        border: 1px solid #f9d8dc;
        border-radius: 16px;
        padding: 18px 10px;
        margin: 0 0 28px;
        position: relative;
        top: -10px;
        box-shadow: 0 4px 14px rgba(225, 29, 72, .06);
    }

    .vt-strip-lead {
        padding: 0 20px;
    }

    .vt-strip-lead h3 {
        font-size: 20px;
        font-weight: 800;
        line-height: 1.2;
        margin: 0;
    }

    .vt-strip-item {
        display: flex;
        align-items: center;
        padding: 6px 18px;
        border-left: 1px solid #f0cfd4;
    }

    .vt-strip-item h4 {
        font-size: 15px;
        font-weight: 700;
        margin: 0 0 4px;
    }

    .vt-strip-item p {
        font-size: 12px;
        line-height: 1.4;
        margin: 0;
    }

    .vt-strip-ico {
        flex: 0 0 56px;
        height: 56px;
        border-radius: 50%;
        background: #fbd5da;
        color: var(--vt-red);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-right: 14px;
    }

    .vt-ico-orange {
        background: #fde7c8;
        color: #f08a0c;
    }

    /* Search + filters */
    .vt-search {
        position: relative;
        background: #fff;
        border: 1px solid #f3c9cf;
        border-radius: 40px;
        padding: 0 20px 0 52px;
        height: 52px;
        display: flex;
        align-items: center;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .03);
    }

    .vt-search i {
        position: absolute;
        left: 20px;
        color: var(--vt-red);
        font-size: 18px;
    }

    .vt-search input {
        border: 0;
        outline: 0;
        width: 100%;
        background: transparent;
        font-size: 15px;
        color: var(--vt-navy);
    }
    .sort_by {
        white-space: nowrap;
    }
    .vt-filter-row {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 12px;
        margin: 18px 0 8px;
    }

    .vt-filter-toggle {
        background: transparent;
        border: 0;
        color: var(--vt-navy);
        font-size: 20px;
        padding: 6px 8px;
        cursor: pointer;
    }

    .vt-filter-toggle.active {
        color: var(--vt-red);
    }

    .vt-select {
        position: relative;
    }

    .vt-select select {
        appearance: none;
        -webkit-appearance: none;
        background: #fff;
        border: 1px solid var(--vt-border);
        border-radius: 30px;
        padding: 10px 40px 10px 20px;
        font-weight: 600;
        color: var(--vt-navy);
        min-width: 150px;
        font-size: 14px;
        cursor: pointer;
        box-shadow: 0 2px 6px rgba(0, 0, 0, .03);
    }

    .vt-select::after {
        content: "\f078";
        font-family: "Font Awesome 5 Free", "Font Awesome 6 Free", FontAwesome;
        font-weight: 900;
        font-size: 10px;
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
        color: var(--vt-navy);
    }

    .vt-select-plain select {
        background: transparent;
        border: 0;
        box-shadow: none;
        padding: 4px 26px 4px 6px;
        min-width: 0;
        font-size: 16px;
    }

    .vt-select-plain::after {
        right: 6px;
    }

    .vt-clear {
        margin-left: auto;
        color: #1a73c8;
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
    }

    .vt-clear:hover {
        text-decoration: underline;
    }

    .vt-advanced {
        background: #fff;
        border: 1px solid var(--vt-border);
        border-radius: 14px;
        padding: 18px 20px 6px;
        margin: 10px 0 6px;
    }

    .vt-advanced h6 {
        font-weight: 700;
        margin-bottom: 10px;
    }

    .vt-advanced h6 small {
        color: var(--vt-red);
        font-weight: 600;
        margin-left: 6px;
    }

    .vt-chip-group {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .vt-chip-check input {
        display: none;
    }

    .vt-chip-check span {
        display: inline-block;
        padding: 5px 14px;
        border: 1px solid var(--vt-border);
        border-radius: 20px;
        font-size: 13px;
        cursor: pointer;
        background: #fff;
    }

    .vt-chip-check span .fa-star {
        color: #f5a623;
        margin-left: 3px;
        font-size: 11px;
    }

    .vt-chip-check input:checked+span {
        background: var(--vt-red);
        border-color: var(--vt-red);
        color: #fff;
    }

    .vt-slider {
        margin: 18px 8px 10px;
        height: 6px;
        background: #f1e6e0;
        border: 0;
        border-radius: 6px;
    }

    .vt-slider .ui-slider-range {
        background: var(--vt-red);
    }

    .vt-slider .ui-slider-handle {
        width: 18px;
        height: 18px;
        top: -6px;
        border-radius: 50%;
        background: #fff;
        border: 2px solid var(--vt-red);
        outline: 0;
        cursor: pointer;
    }

    /* Total */
    .vt-result-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 22px 0 16px;
    }

    .vt-result-head h2 {
        font-size: 26px;
        font-weight: 800;
        margin: 0;
    }

    .vt-sort {
        display: flex;
        align-items: center;
        gap: 6px;
        font-weight: 600;
        color: var(--vt-navy);
    }

    .vt-sort label {
        margin: 0;
    }

    .vt-sort select {
        font-weight: 600;
    }
   .slider_rnge {
    width: 100%;
    padding: 12px 5px;
}

#slider-range {
    height: 5px;
    background: #ebe2e2 !important;
    border: none;
    border-radius: 10px;
    margin: 15px 5px 20px;
    position: relative;
}

#slider-range .ui-slider-range {
    background: #b80f0a !important;
    border: none;
    height: 5px;
}

#slider-range .ui-slider-handle {
    width: 17px;
    height: 17px;
    border-radius: 50%;
    background: #fff;
    top: -6px;
    cursor: pointer;
    outline: none;
}

#slider-range .ui-slider-handle:focus {
    box-shadow: 0 0 0 3px rgba(241, 90, 36, 0.15);
}

.range-text {
    display: block;
    font-size: 14px;
    font-weight: 600;
    color: #333;
    text-align: left;
    margin-top: 8px;
}
    /* Cards */
    .vt-card {
        background: #fff;
        border: 1px solid var(--vt-border);
        border-radius: 14px;
        padding: 16px;
        width: 100%;
        display: flex;
        flex-direction: column;
        box-shadow: 0 3px 12px rgba(11, 31, 77, .04);
        transition: box-shadow .2s, transform .2s;
    }

    .vt-card:hover {
        box-shadow: 0 10px 24px rgba(11, 31, 77, .1);
        transform: translateY(-2px);
    }

    .vt-card-top {
        display: flex;
        gap: 14px;
    }

    .vt-avatar {
        width: 100px;
        height: 100px;
        border-radius: 10px;
        object-fit: cover;
        flex: 0 0 100px;
        background: #eee;
    }

    .vt-card-main {
        flex: 1;
        min-width: 0;
    }

    .vt-name-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 6px;
    }

    .vt-name-row h3 {
        font-size: 17px;
        font-weight: 700;
        margin: 0 0 6px;
        line-height: 1.2;
    }

    .vt-name-row h3 a {
        color: var(--vt-navy);
        text-decoration: none;
    }

    .vt-states {
        display: flex;
        flex-wrap: wrap;
        gap: 4px;
        justify-content: flex-end;
    }

    .vt-state {
        background: var(--vt-red-soft);
        color: var(--vt-red);
        font-size: 11px;
        font-weight: 700;
        padding: 2px 10px;
        border-radius: 12px;
    }

    .vt-meta-row {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 10px;
        margin-bottom: 8px;
    }

    .vt-verified {
        background: #dff5e6;
        color: #178a43;
        font-size: 12px;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 6px;
        white-space: nowrap;
    }

    .vt-rating {
        font-weight: 700;
        color: var(--vt-navy);
        font-size: 13px;
        white-space: nowrap;
    }

    .vt-rating .fa-star {
        color: #f5a623;
    }

    .vt-rating small {
        color: var(--vt-text);
        font-weight: 500;
    }

    .vt-headline {
        font-size: 14px;
        color: #4a5a85;
    }

    .vt-info {
        list-style: none;
        padding: 0;
        margin: 12px 0 10px;
        font-size: 13px;
    }

    .vt-info li {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 4px;
    }

    .vt-info i {
        color: var(--vt-navy);
        width: 16px;
        text-align: center;
    }

    .vt-prog-title {
        font-weight: 700;
        font-size: 13px;
        color: var(--vt-navy);
        margin-bottom: 8px;
    }

    .vt-prog-title span {
        margin: 0 3px;
    }

    .vt-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 3px;
        margin-bottom: 14px;
    }

    .vt-chip {
        background: var(--vt-red-soft);
        color: #c0213f;
        font-size: 10px;
        padding: 4px 12px;
        border-radius: 14px;
    }

    .vt-card-foot {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 12px;
        margin-top: auto;
        padding-top: 8px;
    }

    .vt-card-foot p {
        font-size: 12px;
        line-height: 1.45;
        margin: 0;
        flex: 1;
    }

    .vt-btn-outline {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: 1.5px solid var(--vt-red);
        color: var(--vt-red);
        background: #fff;
        border-radius: 22px;
        padding: 7px 18px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
        transition: .2s;
    }

    .vt-btn-outline:hover {
        background: var(--vt-red);
        color: #fff;
        text-decoration: none;
    }

    .vt-btn-lg {
        padding: 12px 26px;
        font-size: 15px;
        border-radius: 10px;
    }

    /* Pagination */
    .vt-pagination {
        display: flex;
        justify-content: center;
        margin: 10px 0 30px;
    }

    .vt-pagination .pagination {
        gap: 10px;
        margin: 0;
    }

    .vt-pagination .page-link {
        border-radius: 50% !important;
        width: 38px;
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--vt-border);
        color: var(--vt-navy);
        background: #fff;
        padding: 0;
        box-shadow: 0 2px 6px rgba(0, 0, 0, .05);
    }

    .vt-pagination .page-item.active .page-link {
        background: var(--vt-red);
        border-color: var(--vt-red);
        color: #fff;
    }

    .vt-pagination .page-item {
        margin: 0;
    }

    .vt-empty {
        text-align: center;
        background: #fff;
        border: 1px solid var(--vt-border);
        border-radius: 14px;
        padding: 50px 20px;
        margin-bottom: 30px;
    display: flex;
    justify-content: center;
    align-items: center;
    }

    .vt-empty img {
        max-width: 180px;
          display: block;
    }

    .vt-empty small {
        display: block;
        max-width: 560px;
        margin: 10px auto 0;
    }

    /* How we select */
    .vt-select-cta {
        display: flex;
        align-items: center;
        gap: 24px;
        background: #fcefe3;
        border: 1px solid #f4dfcc;
        border-radius: 18px;
        padding: 22px 30px;
    }

    .vt-cta-ico {
        font-size: 46px;
        color: var(--vt-navy);
        display: flex;
        gap: 6px;
        padding-right: 24px;
        border-right: 1px solid #e8cfb8;
    }

    .vt-cta-text {
        flex: 1;
    }

    .vt-cta-text h3 {
        font-size: 26px;
        font-weight: 800;
        margin: 0 0 6px;
    }

    .vt-cta-text p {
        margin: 0;
        font-size: 15px;
        max-width: 600px;
    }

    @media (max-width: 991px) {
        .vt-hero-title {
            font-size: 34px;
        }

        .vt-strip {
            top: 0;
        }

        .vt-strip-lead {
            margin-bottom: 10px;
        }

        .vt-strip-item {
            border-left: 0;
            border-top: 1px solid #f0cfd4;
            padding: 12px 18px;
        }

        .vt-select-cta {
            flex-direction: column;
            align-items: flex-start;
        }

        .vt-cta-ico {
            border-right: 0;
            padding-right: 0;
        }
    }

    @media (max-width: 575px) {
        .vt-filter-row {
            gap: 8px;
        }

        .vt-select,
        .vt-select select {
            width: 100%;
        }

        .vt-clear {
            margin-left: 0;
        }

        .vt-result-head {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }

        .vt-card-foot {
            flex-direction: column;
            align-items: stretch;
        }

        .vt-btn-outline {
            justify-content: center;
        }
    }
</style>
@endsection

@section('footer')
@include('include.footer')
@endsection

@section('script')
@include('include.script')
<script src="https://kit.fontawesome.com/446e463225.js" crossorigin="anonymous"></script>
<link rel="stylesheet"
href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
<script>
    
$(function () {

    var $form = $("#searchVtutorForm");
    var ajaxRequest = null;
    var searchTimer = null;
    var filterTimer = null;

    var minRate = Number(@json($min));
    var maxRate = Number(@json($max));

    var stateMap = {
        'New South Wales': 'NSW',
        'Victoria': 'VIC',
        'Queensland': 'QLD',
        'South Australia': 'SA',
        'Western Australia': 'WA',
        'Tasmania': 'TAS',
        'Northern Territory': 'NT',
        'Australian Capital Territory': 'ACT'
    };

    $("#slider-range").slider({

        range: true,
        min: 0,
        max: 200,
        step: 1,
        values: [minRate, maxRate],

        slide: function (event, ui) {

            $("#vtRateText").text(
                "$" + ui.values[0] + " - $" + ui.values[1]
            );

            $("#min_hourly_rate_value").val(ui.values[0]);
            $("#max_hourly_rate_value").val(ui.values[1]);

        },

        stop: function (event, ui) {

            $("#min_hourly_rate_value").val(ui.values[0]);
            $("#max_hourly_rate_value").val(ui.values[1]);

            loadTutorResults();

        }

    });

    function escapeHtml(value) {

        return $('<div>')
            .text(value == null ? '' : String(value))
            .html();

    }

    function stripHtml(value) {

        return $('<div>')
            .html(value || '')
            .text()
            .trim();

    }

    function buildTutorCards(tutors) {

        var html = '';

        if (!tutors || tutors.length === 0) {
            return `
                <div class="vt-empty">
                    <img src="{{ public_asset('assets/images/empty_img.png') }}"
                         alt="No tutors found">

                    <h2>No tutors match your current filters.</h2>
                </div>
            `;
        }

        html += '<div class="row vt-cards">';

        tutors.forEach(function (tutor) {

            var profile =
                "{{ url('tutor-public-profile') }}/" +
                encodeURIComponent(tutor.slug || '');

            var photo = tutor.profile_pic
                ? "{{ asset('storage/teacher_profile_pic') }}/" +
                    encodeURIComponent(tutor.profile_pic)
                : (
                    tutor.avatar ||
                    "{{ public_asset('assets/images/blank1.png') }}"
                );

            var avg = parseFloat(tutor.avg_review || 0).toFixed(1);

            var states = '';

            if (tutor.unique_wwcc_states) {

                tutor.unique_wwcc_states.forEach(function (state) {

                    var abbreviation =
                        stateMap[state.state_name] || '';

                    if (abbreviation) {

                        states += `
                            <span class="vt-state">
                                ${escapeHtml(abbreviation)}
                            </span>
                        `;

                    }

                });

            }

            // Subjects
            var subjects = [];

            if (Array.isArray(tutor.get_tutor_ship_plan)) {

                tutor.get_tutor_ship_plan.forEach(function (plan) {

                    var branchName =
                        plan.getbranch?.branch_name;

                    if (
                        branchName &&
                        !subjects.includes(branchName)
                    ) {
                        subjects.push(branchName);
                    }

                });

            }

            var subjectText = subjects.slice(0, 3).join(' • ');

            if (!subjectText) {
                subjectText = tutor.subjects || 'Subjects not listed';
            }

            // Learning programs
            var programs = '';

            if (
                tutor.learning_programs &&
                tutor.learning_programs.length
            ) {

                programs += `
                    <div class="vt-prog-title">
                        Learning Programs <span>|</span> Support
                    </div>

                    <div class="vt-chips">
                `;

                tutor.learning_programs
                    .slice(0, 4)
                    .forEach(function (chip) {

                        programs += `
                            <span class="vt-chip">
                                ${escapeHtml(chip)}
                            </span>
                        `;

                    });

                programs += '</div>';

            }

            var yearRange = tutor.year_levels
                ? `
                    <li>
                        <i class="fas fa-layer-group"></i>
                        ${escapeHtml(tutor.year_levels)}
                    </li>
                `
                : '';

            // Capabilities
            var capabilities = stripHtml(tutor.capabilities);

            if (capabilities.length > 110) {

                capabilities =
                    capabilities.substring(0, 107) + '...';

            }

            // Reviews: show only when reviews exist
            var ratingHtml = '';

            if (Number(tutor.total_no_of_reviews || 0) > 0) {

                ratingHtml = `
                    <span class="vt-rating">
                        <i class="fa fa-star"></i>
                        ${avg}
                        <small>
                            (${escapeHtml(tutor.total_no_of_reviews)})
                        </small>
                    </span>
                `;

            }

            html += `
                <div class="col-lg-4 col-md-6 mb-4 d-flex">

                    <article class="vt-card">

                        <div class="vt-card-top">

                            <img src="${escapeHtml(photo)}"
                                 alt="${escapeHtml(tutor.f_name)} ${escapeHtml(tutor.l_name)}"
                                 class="vt-avatar">

                            <div class="vt-card-main">

                                <div class="vt-name-row">

                                    <h3>
                                        <a href="${escapeHtml(profile)}"
                                           target="_blank"
                                           class="save_input_data_on_click"
                                           data-type="PP"
                                           data-id="${escapeHtml(tutor.id)}">

                                            ${escapeHtml(tutor.f_name)}
                                            ${escapeHtml(tutor.l_name)}

                                        </a>
                                    </h3>

                                    <span class="vt-states">
                                        ${states}
                                    </span>

                                </div>

                                <div class="vt-meta-row">

                                    <span class="vt-verified">
                                        <i class="fas fa-shield-alt"></i>
                                        WWCC Verified
                                    </span>

                                    ${ratingHtml}

                                </div>

                                <div class="vt-headline">
                                    ${escapeHtml(tutor.skills || '')}
                                </div>

                            </div>

                        </div>

                        <ul class="vt-info">

                            <li>
                                <i class="fas fa-graduation-cap"></i>
                                ${escapeHtml(subjectText)}
                            </li>

                            ${yearRange}

                        </ul>

                        ${programs}

                        <div class="vt-card-foot">

                            <p>${escapeHtml(capabilities)}</p>

                            <a href="${escapeHtml(profile)}"
                               target="_blank"
                               class="vt-btn-outline save_input_data_on_click"
                               data-type="PP"
                               data-id="${escapeHtml(tutor.id)}">

                                View Profile
                                <i class="fas fa-arrow-right"></i>

                            </a>

                        </div>

                    </article>

                </div>
            `;

        });

        html += '</div>';

        return html;

    }

    function loadTutorResults(url = null) {

        if (ajaxRequest) {
            ajaxRequest.abort();
        }

        ajaxRequest = $.ajax({

            url: url || $form.attr("action"),

            type: "GET",

            data: $form.serialize(),

            dataType: "json",

            cache: false,

            beforeSend: function () {

                $("#tutorResults").css("opacity", "0.5");

            },

            success: function (response) {

                var tutors =
                    response.tutors?.data || [];

                var html = buildTutorCards(tutors);

                if (tutors.length > 0 && response.pagination) {

                    html += `
                        <div class="vt-pagination">
                            ${response.pagination}
                        </div>
                    `;

                }

                $("#tutorResults").html(html);

                var total = Number(response.total || 0);

                $(".vt-result-head h2").text(
                    total + " Learning " +
                    (total === 1 ? "Specialist" : "Specialists")
                );

            },

            error: function (xhr, status) {

                if (status !== "abort") {

                    console.log(
                        "Tutor AJAX Error:",
                        xhr.responseText
                    );

                }

            },

            complete: function () {

                $("#tutorResults").css("opacity", "1");

            }

        });

    }

    $(document).on(
        "change",
        ".change_apply, #sort_type_id, .click_apply",
        function () {

            clearTimeout(filterTimer);

            filterTimer = setTimeout(function () {

                loadTutorResults();

            }, 300);

        }
    );

    $('input[name="q"]').on("input", function () {

        clearTimeout(searchTimer);

        searchTimer = setTimeout(function () {

            loadTutorResults();

        }, 300);

    });

    $(document).on(
        "click",
        "#tutorResults .pagination a",
        function (e) {

            e.preventDefault();

            var url = $(this).attr("href");

            if (url) {

                clearTimeout(filterTimer);
                loadTutorResults(url);

            }

        }
    );

    $(document).on(
        "click",
        "#vtToggleAdvanced",
        function () {

            $("#vtAdvanced").stop(true, true).slideToggle(200);

            $(this).toggleClass("active");

        }
    );

    $(document).on(
        "click",
        "#vtClearFilters",
        function (e) {

            e.preventDefault();

            clearTimeout(filterTimer);
            clearTimeout(searchTimer);

            if (ajaxRequest) {
                ajaxRequest.abort();
            }

            $form[0].reset();

            if ($("#slider-range").hasClass("ui-slider")) {

                var min = $("#slider-range").slider("option", "min");
                var max = $("#slider-range").slider("option", "max");

                $("#slider-range").slider(
                    "values",
                    [min, max]
                );

                $("#min_hourly_rate_value").val(min);
                $("#max_hourly_rate_value").val(max);

                $("#vtRateText").text(
                    "$" + min + " - $" + max
                );

            }

            $("#vtAdvanced").stop(true, true).slideUp(200);

            $("#vtToggleAdvanced").removeClass("active");

            $("#sort_type_id").val("D");

            loadTutorResults();

        }
    );

});

</script>
@endsection