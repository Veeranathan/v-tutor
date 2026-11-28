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

$order = ['Maths', 'English', 'Science'];

$allowedBranches = ['Maths', 'English', 'Science', 'Languages', 'Technologies', 'Creative Arts', 'HSIE'];
$subjectIcons = [
'Maths' => 'bi-calculator', 'English' => 'bi-journal-text', 'Science' => 'bi-radioactive',
'Languages' => 'bi-globe2', 'Technologies' => 'bi-cpu', 'Creative Arts' => 'bi-palette', 'HSIE' => 'bi-people',
];
$subjectList = $branches->whereIn('branch_name', $allowedBranches);

$yearLabel = fn($g) => preg_match('/\d+/', $g->grade_name, $m) ? $m[0] : $g->grade_name;

$programTypes = [
['code' => 'MLP', 'class' => 'mlp', 'name' => 'Micro Learning Program', 'desc' => 'Targeted support for specific concepts or skills.'],
['code' => 'CTP', 'class' => 'ctp', 'name' => 'Core Training Program', 'desc' => 'Structured learning across a broader set of skills.'],
['code' => 'ICP', 'class' => 'icp', 'name' => 'Intensive Crash Program', 'desc' => 'Focused support within a shorter learning period.'],
['code' => 'FTP', 'class' => 'ftp', 'name' => 'Foundation Training Program', 'desc' => 'Longer-term support to strengthen foundational learning.'],
];
@endphp

<div class="lp-page">
  <section class="lp-hero">
    <div class="container programs-wrap">
      <div class="row align-items-center">
        <div class="col-lg-6 py-4 py-lg-5">
          <h1 class="lp-title">{{ $title }}</h1>
          <p class="lp-subtitle">
            Explore structured learning programs designed to address your child's learning needs,
            strengthen essential skills and build confidence.
          </p>
        </div>
      </div>
    </div>
  </section>

  <section class="pb-3">
    <div class="container programs-wrap">

      <div class="lp-card lp-search mb-3">
        <i class="bi bi-search"></i>
        <input type="search" id="programSearch" class="form-control"
          placeholder="Search programs by name, topic or skill (e.g. fractions, essay writing, algebra)..."
          autocomplete="off">
      </div>

      <div class="lp-card lp-pillbox">
        <div class="pill-row">
          <span class="pill-label">YEAR</span>
          <div class="pill-list">
            <button type="button" class="pill year-pill active" data-filter-btn="year" data-value="">All</button>
            @foreach($grades as $grade)
            <button type="button" class="pill year-pill" data-filter-btn="year" data-value="{{ $grade->id }}"
              data-slug="{{ $grade->slug }}">{{ $yearLabel($grade) }}</button>
            @endforeach
          </div>
        </div>

        <div class="pill-row">
          <span class="pill-label">SUBJECT</span>
          <div class="pill-list">
            <button type="button" class="pill subject-pill active" data-filter-btn="subject" data-value="">All</button>
            @foreach($subjectList as $branch)
            <button type="button" class="pill subject-pill" data-filter-btn="subject" data-value="{{ $branch->id }}">
              <i class="bi {{ $subjectIcons[$branch->branch_name] ?? 'bi-grid' }}"></i> {{ $branch->branch_name }}
            </button>
            @endforeach
          </div>
        </div>
      </div>

    </div>
  </section>

  <section class="pb-4">
    <div class="container programs-wrap">
      <div class="type-strip">
        <div class="type-intro">
          <h2>Our Learning<br class="mobile">Program Types</h2>
          <p><i class="bi bi-info-circle"></i> Choose a program type that best fits your child's needs.</p>
        </div>
        @foreach($programTypes as $pt)
        <div class="type-item">
          <div class="type-top">
            <span class="ptype {{ $pt['class'] }}">{{ $pt['code'] }}</span>
            <i class="bi bi-info-circle type-info" title="{{ $pt['name'] }}"></i>
          </div>
          <h3>{{ $pt['name'] }}</h3>
          <p>{{ $pt['desc'] }}</p>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  <section class="pb-4">
    <div class="container programs-wrap">
      <div class="row g-4 flex-lg-nowrap">

        <div class="col-lg-auto">
          <div class="fs-backdrop" id="fsBackdrop"></div>
          <aside class="filters-sidebar" id="filtersSidebar">

            <div class="fs-head">
              <span class="fs-title">FILTERS</span>
              <div class="fs-head-actions">
              <button type="button" class="link-clear" data-clear-all>Clear all</button>
              <button type="button" class="fs-close d-lg-none" id="closeFilters" aria-label="Close">&times;</button>
           </div>
            </div>

            <div class="fs-group">
              <button type="button" class="fs-toggle">Year <i class="bi bi-chevron-up"></i></button>
              <div class="fs-body">
                <label class="fs-check"><input type="checkbox" data-filter="year" value=""><span>All Years</span></label>
                @foreach($grades as $grade)
                <label class="fs-check"><input type="checkbox" data-filter="year" value="{{ $grade->id }}"><span>{{ $grade->grade_name }}</span></label>
                @endforeach
              </div>
            </div>

            <div class="fs-group">
              <button type="button" class="fs-toggle">Subject <i class="bi bi-chevron-up"></i></button>
              <div class="fs-body">
                <label class="fs-check"><input type="checkbox" data-filter="subject" value=""><span>All Subjects</span></label>
                @foreach($subjectList as $branch)
                <label class="fs-check"><input type="checkbox" data-filter="subject" value="{{ $branch->id }}"><span>{{ $branch->branch_name }}</span></label>
                @endforeach
              </div>
            </div>

            <div class="fs-group">
              <button type="button" class="fs-toggle">Program Type <i class="bi bi-chevron-up"></i></button>
              <div class="fs-body">
                @foreach($programTypes as $pt)
                <label class="fs-check"><input type="checkbox" data-filter="program_type" value="{{ $pt['name'] }}"><span>{{ $pt['name'] }} ({{ $pt['code'] }})</span></label>
                @endforeach
              </div>
            </div>

            @if(!empty($learningFocuses))
            <div class="fs-group collapsed">
              <button type="button" class="fs-toggle">Learning Focus <i class="bi bi-chevron-up"></i></button>
              <div class="fs-body">
                @foreach($learningFocuses as $focus)
                <label class="fs-check"><input type="checkbox" data-filter="focus" value="{{ $focus }}"><span>{{ $focus }}</span></label>
                @endforeach
              </div>
            </div>
            @endif

            <div class="fs-group">
              <button type="button" class="fs-toggle">Curriculum / State <i class="bi bi-chevron-up"></i></button>
              <div class="fs-body">
                <label class="fs-select-label" for="curriculum">Curriculum</label>
                <select id="curriculum" class="form-select form-select-sm mb-2 w-100">
                  <option value="">Any Curriculum</option>
                  <option value="NESA Curriculum">NESA Curriculum</option>
                  <option value="VCAA curriculum">VCAA curriculum</option>
                  <option value="QCAA Curriculum">QCAA Curriculum</option>
                  <option value="SACE Curriculum">SACE Curriculum</option>
                  <option value="WACE Curriculum">WACE Curriculum</option>
                  <option value="BSSS Curriculum">BSSS Curriculum</option>
                  <option value="TASC Curriculum">TASC Curriculum</option>
                  <option value="NTBS Curriculum">NTBS Curriculum</option>
                </select>

                <label class="fs-select-label" for="state">State</label>
                <select id="state" class="form-select form-select-sm w-100">
                  <option value="">Any State</option>
                  <option value="New South Wales">New South Wales</option>
                  <option value="Victoria">Victoria</option>
                  <option value="Queensland">Queensland</option>
                </select>
              </div>
            </div>

            <button type="button" class="btn btn-outline-program w-100 mt-3" data-clear-all>
              <i class="bi bi-arrow-repeat"></i> Clear Filters
            </button>
          </aside>
        </div>

        <div class="col results-col">

          <button type="button" class="btn btn-outline-program d-lg-none mb-3" id="openFilters">
            <i class="bi bi-funnel"></i> Filters
          </button>

          <div class="results-bar">
            <h2 class="results-count" id="programCount">0 programs found</h2>

            <div class="results-tools">
              <label class="tool-label" for="sortBy">Sort by:</label>
              <select id="sortBy" class="form-select form-select-sm sort-select">
                <option value="relevance">Relevance</option>
                <option value="price-asc">Price: Low to High</option>
                <option value="price-desc">Price: High to Low</option>
                <option value="name">Name: A-Z</option>
              </select>
            </div>
          </div>

          <div id="activeFilters" class="active-filters d-none"></div>

          <div id="programResults" class="row g-3 program-grid d-none"></div>

          <div id="prePopulatedData" class="row g-3 program-grid">

            @foreach($order as $subjectName)
            @if(isset($prePopulatedData[$subjectName]) && count($prePopulatedData[$subjectName]['programs']) > 0)
            @php
            $typeMap = [
            'Micro Learning Program' => ['MLP', 'mlp'],
            'Core Training Program' => ['CTP', 'ctp'],
            'Intensive Crash Program' => ['ICP', 'icp'],
            'Foundation Training Program' => ['FTP', 'ftp'],
            ];
            $stateShortMap = [
            'New South Wales' => 'NSW', 'Victoria' => 'VIC', 'Queensland' => 'QLD',
            'South Australia' => 'SA', 'Western Australia' => 'WA', 'Tasmania' => 'TAS',
            'Australian Capital Territory' => 'ACT', 'Northern Territory' => 'NT',
            ];
            $subjectImages = [
            'English' => 'assets/images/maths-programs.png',
            'Maths' => 'assets/images/english-programs.png',
            'Science' => 'assets/images/science-programs.png',
            ];
            @endphp

            @foreach($prePopulatedData[$subjectName]['programs'] as $programName => $programItems)
            @php
            $first = $programItems->first();
            $outcomes = $programItems
            ->flatMap(fn($program) => $program->keyLearningPrograms->pluck('name'))
            ->filter()
            ->unique()
            ->values()
            ->all();
            $programType = $first->program_type ?? '';
            [$typeCode, $typeClass] = $typeMap[$programType] ?? [null, 'mlp'];

            $allGrades = $programItems->pluck('grade.grade_name')->filter()->unique()->join(', ');
            $allStates = $programItems->pluck('state')->filter()->unique()->map(fn($s) => $stateShortMap[$s] ?? $s)->join(', ');

            $price = $programItems->min('price');
            $imageName = trim($first->image ?? '', " \t\n\r\0\x0B\"'");

            $img = !empty($imageName)
            ? 'assets/images/learning_program_images/' . $imageName
            : ($subjectImages[$subjectName] ?? 'assets/images/banner-default.jpg');

            $searchBlob = strtolower($programName . ' ' . ($first->description ?? '') . ' ' . $subjectName . ' ' . $allGrades);

            $dataYears = $programItems->map(fn($p) => $p->grade_id ?? optional($p->grade)->id)->filter()->unique()->join(',');
            $dataStates = $programItems->pluck('state')->filter()->unique()->join('|');
            $dataCurriculum = $programItems->pluck('curriculum')->filter()->unique()->join('|');

            $variants = $programItems->map(fn($p) => [
            'state' => $p->state,
            'state_short' => $stateShortMap[$p->state] ?? $p->state,
            'year' => (string) ($p->grade_id ?? optional($p->grade)->id),
            'grade' => optional($p->grade)->grade_name,
            'curriculum' => $p->curriculum,
            'price' => $p->price,
            'slug' => $p->slug,
            ])->values();
            @endphp

            <div class="col-12 col-sm-6 col-xl-3 program-item"
              data-years="{{ $dataYears }}"
              data-subject="{{ $subjectName }}"
              data-states="{{ $dataStates }}"
              data-ptype="{{ $programType }}"
              data-curriculum="{{ $dataCurriculum }}"
              data-search="{{ $searchBlob }}"
              data-name="{{ $programName }}"
              data-price="{{ $price ?? '' }}"
              data-sessions="{{ $first->number_of_sessions ?? '' }}"
              data-url-template="{{ route('program.detail', '__SLUG__') }}"
              data-variants="{{ $variants->toJson() }}">
              <article class="pcard">
                <div class="pcard-img">
                  <img src="{{ public_asset($img) }}" alt="{{ $programName }}" loading="lazy">
                </div>

                <div class="pcard-body">
                  @if($typeCode)
                  <span class="ptype {{ $typeClass }}">{{ $typeCode }}</span>
                  @endif

                  <h3 class="pcard-title">{{ $programName }}</h3>
                  <p class="pcard-desc">{{ \Illuminate\Support\Str::limit($first->description ?? '', 110) }}</p>

                  @if(count($outcomes))
                  <div class="pcard-outcomes">
                    <div class="po-title">Key Learning Outcomes</div>
                    <ul>
                      @foreach($outcomes as $o)
                      <li>
                        <i class="bi bi-check2"></i>
                        {{ $o }}
                      </li>
                      @endforeach
                    </ul>
                  </div>
                  @endif

                  <div class="pcard-tags">
                    <span class="ptag grade {{ $allGrades ? '' : 'd-none' }}" data-role="grade">{{ $allGrades }}</span>
                    <span class="ptag subject">{{ $subjectName }}</span>
                    <span class="ptag state {{ $allStates ? '' : 'd-none' }}" data-role="state">{{ $allStates }}</span>
                  </div>

                  <div class="pcard-meta">
                    <span class="sessions"><i class="bi bi-person"></i> {{ $first->number_of_sessions }} sessions</span>
                    <span class="price {{ $price ? '' : 'd-none' }}" data-role="price">From <strong>${{ number_format((float) $price) }}</strong></span>
                  </div>

                  <a href="{{ route('program.detail', $first->slug) }}" class="btn btn-add-cart pcard-btn" data-role="link">
                    View Program <i class="bi bi-arrow-right"></i>
                  </a>
                </div>
              </article>
            </div>
            @endforeach
            @endif
            @endforeach
          </div>

          <div id="emptyState" class="empty-state d-none">
            <i class="bi bi-search"></i>
            <p>No programs match your filters. Try clearing some filters.</p>
          </div>

          <div class="text-center mt-4" id="loadMoreWrap">
            <button type="button" id="loadMoreBtn" class="btn btn-outline-program load-more">
              Load More Programs <i class="bi bi-chevron-down"></i>
            </button>
          </div>

        </div>
      </div>
    </div>
  </section>

<!-- CTA BANNER -->
<section class="select-cta mt-5">
  <div class="container programs-wrap">
    <div class="cta-banner">

      <div class="cta-icon">
        <i class="bi bi-clipboard2-check"></i>
      </div>

      <div class="cta-text">
        <h3>Not sure which program is right for your child?</h3>
        <p>
          Start with a free diagnostic assessment to better understand
          your child's learning needs and explore suitable program recommendations.
        </p>
      </div>

      <div class="assessment-actions">
        <a href="#assessment"
           class="btn btn-add-cart cta-btn cta-btn-lg assessment-btn"
           data-type="me">
          Find Your Child's Learning Path
          <i class="bi bi-arrow-right"></i>
        </a>
      </div>

    </div>
  </div>
</section>
</div>

<section class="assesment-section" id="assessment">
  @include('include.learning_program_section')
  @include('include.learning_program_modal_only')
</section>
@endsection

@section('footer')
@include('include.footer')
@endsection

@section('script')
@include('include.script')

<style>
  .lp-page {
    --red: #D7263D;
    --red-dark: #b91c1c;
    --ink: #0f172a;
    --muted: #6b7280;
    --cream: #FFF9EC;
    --peach: #fdeee4;
    --line: #eadfd3;
    background: var(--cream);
    color: var(--ink);
  }

  html,
	body {
		max-width: 100%;
		overflow-x: hidden;
	}

  .programs-wrap {
    max-width: 1280px;
  }

  .lp-hero {
    position: relative;
    overflow: hidden;
  }

  .lp-title {
    font-size: clamp(32px, 4.6vw, 48px);
    font-weight: 800;
    letter-spacing: -1px;
    margin-bottom: 14px;
    color: var(--ink);
  }

.lp-hero {
    position: relative;
    background-color: var(--cream);
    background-image: url("{{ public_asset('assets/images/learning_program_images/find_tutor.png') }}");
    background-repeat: no-repeat;
    background-size: 60% 100%;
    background-position: right center;
    overflow: hidden;
    min-height: 300px;
}

.lp-hero::before {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(
        90deg,
        var(--cream) 0%,
        var(--cream) 25%,
        rgba(255, 249, 236, 0.95) 45%,
        rgba(255, 249, 236, 0.75) 55%,
        rgba(255, 249, 236, 0.2) 75%,
        transparent 100%
    );

    z-index: 1;
    pointer-events: none;
}

.lp-hero .container {
    position: relative;
    z-index: 2;
}

.lp-title {
    font-size: clamp(32px, 4.6vw, 48px);
    font-weight: 800;
    letter-spacing: -1px;
    margin-bottom: 14px;
    color: var(--ink);
}

.lp-subtitle {
    font-size: 17px;
    line-height: 1.55;
    color: #0b1f4d;
    max-width: 430px;
    margin: 0;
}

@media (max-width: 991.98px) {
    .lp-hero {
        background-size: 65% 100%;
        min-height: 280px;
    }
}

.program-grid:not(.list-view) .program-item {
    display: flex;
    align-items: stretch;
}

.program-grid:not(.list-view) .pcard {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

/* Image cover fix */




/* Card content */
.program-grid:not(.list-view) .pcard-body {
    display: flex;
    flex-direction: column;
    flex: 1;
    min-width: 0;
    padding: 12px;
}

/* Remove unnecessary fixed gaps */
.program-grid:not(.list-view) .pcard-title {
    min-height: 0;
    font-size: 15px;
    line-height: 1.35;
    margin-bottom: 7px;
}

.program-grid:not(.list-view) .pcard-desc {
    min-height: 0;
    font-size: 12px;
    line-height: 1.5;
    margin-bottom: 10px;
}

/* Outcomes */
.program-grid:not(.list-view) .pcard-outcomes {
    margin-bottom: 10px;
    padding: 9px;
}

/* Tags */
.program-grid:not(.list-view) .pcard-tags {
    margin-top: auto;
    margin-bottom: 10px;
}

.program-grid:not(.list-view) .pcard-meta {
    gap: 6px;
    flex-wrap: wrap;
}

@media (max-width: 991.98px) {
    .program-grid:not(.list-view) .pcard-img {
        height: 145px;
        flex-basis: 145px;
    }
}

@media (max-width: 575.98px) {

    .program-grid:not(.list-view) .program-item {
        padding-left: 5px;
        padding-right: 5px;
        padding-bottom: 10px;
    }

    .program-grid:not(.list-view) .pcard-img {
        height: 125px;
        flex-basis: 125px;
    }

    .program-grid:not(.list-view) .pcard-body {
        padding: 9px;
    }

    .program-grid:not(.list-view) .pcard-title {
        font-size: 13px;
        line-height: 1.35;
        min-height: 0;
    }

    .program-grid:not(.list-view) .pcard-desc {
        font-size: 11px;
        line-height: 1.4;
        min-height: 0;
    }

    .program-grid:not(.list-view) .pcard-outcomes {
        padding: 7px;
    }

    .program-grid:not(.list-view) .pcard-outcomes li {
        font-size: 10px;
    }

    .program-grid:not(.list-view) .ptag {
        font-size: 9px;
        padding: 3px 6px;
    }

    .program-grid:not(.list-view) .pcard-meta {
        font-size: 10px;
    }

    .program-grid:not(.list-view) .pcard-meta .price strong {
        font-size: 12px;
    }

    .program-grid:not(.list-view) .btn.pcard-btn {
        font-size: 10px !important;
        padding: 5px 9px;
    }
}

/* Very small mobile */
@media (max-width: 380px) {
    .program-grid:not(.list-view) .pcard-img {
        height: 105px;
        flex-basis: 105px;
    }

    .program-grid:not(.list-view) .pcard-body {
        padding: 7px;
    }

    .program-grid:not(.list-view) .pcard-title {
        font-size: 12px;
    }
}

@media (max-width: 767.98px) {
    .lp-hero {
        background-size: auto 100%;
        background-position: right center;
        min-height: 260px;
    }

    .lp-hero::before {
        background: linear-gradient(
            90deg,
            var(--cream) 0%,
            rgba(255, 249, 236, 0.97) 40%,
            rgba(255, 249, 236, 0.85) 65%,
            rgba(255, 249, 236, 0.4) 100%
        );
    }

    .lp-title {
        font-size: 32px;
    }

    .lp-subtitle {
        font-size: 15px;
        max-width: 300px;
    }
}
  .lp-card {
    background: #fff;
    border-radius: 14px;
    border: 1px solid #f3eadf;
    box-shadow: 0 6px 20px rgba(0, 0, 0, .05);
  }

  .lp-search {
    display: flex;
    align-items: center;
    padding: 4px 16px;
  }

  .lp-search i {
    color: #6b7280;
    margin-right: 8px;
  }

  .lp-search .form-control {
    border: 0;
    box-shadow: none;
    font-size: 13px;
    padding: 10px 0;
    background: transparent;
  }

  .lp-pillbox {
    padding: 16px 18px;
    display: flex;
    flex-direction: column;
    gap: 14px;
  }

  .pill-row {
    display: flex;
    align-items: center;
    gap: 16px;
  }

  .pill-label {
    width: 70px;
    flex: 0 0 70px;
    font-size: 12px;
    font-weight: 800;
    letter-spacing: .3px;
  }

  .pill-list {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
  }

  .pill {
    border: 1px solid #e5e7eb;
    background: #fff;
    color: var(--ink);
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    line-height: 1;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    cursor: pointer;
    transition: .2s;
  }

  .year-pill {
    min-width: 38px;
    height: 34px;
    justify-content: center;
    padding: 0 12px;
  }

  .subject-pill {
    height: 36px;
    padding: 0 14px;
  }

  .subject-pill i {
    color: #2f7df6;
    font-size: 14px;
  }

  .pill:hover {
    border-color: var(--red);
    color: var(--red);
  }

  .year-pill.active {
    background: var(--red);
    border-color: var(--red);
    color: #fff;
  }

  .subject-pill.active {
    background: #fff1f2;
    border-color: var(--red);
    color: var(--red);
  }

  #prePopulatedData {
    --bs-gutter-x: 8px;
    --bs-gutter-y: 10px;
  }

  #programResults {
    --bs-gutter-x: 8px;
    --bs-gutter-y: 10px;
  }

  .program-item {
    padding-left: 6px;
    padding-right: 6px;
    padding-bottom: 17px;
  }

  .pcard {
    width: 100%;
    height: 100%;
  }

  .pcard-body {
    padding: 12px 10px;
  }

  .type-strip {
    display: grid;
    grid-template-columns: 1.1fr repeat(4, 1fr);
    gap: 18px;
    background: linear-gradient(90deg, #fdeee4, #fff4ec);
    border: 1px solid #f6dfd0;
    border-radius: 14px;
    padding: 18px 22px;
  }

  .type-intro h2 {
    font-size: 19px;
    font-weight: 800;
    line-height: 1.2;
    margin: 0 0 8px;
  }

  .type-intro p {
    font-size: 12px;
    color: #4b5563;
    line-height: normal;
    margin: 0;
    display: flex;
    gap: 6px;
  }

  .fs-head-actions {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 12px;
    flex-wrap: nowrap;
    white-space: nowrap;
}

.fs-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: nowrap;
}

.fs-close {
    flex-shrink: 0;
    padding: 0;
    line-height: 1;
}

  .type-item {
    border-left: 1px solid #f0d9c8;
    padding-left: 18px;
  }

  .type-top {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 8px;
  }

  .type-info {
    color: #6b7280;
    font-size: 14px;
    cursor: help;
  }

  .type-item h3 {
    font-size: 13px;
    font-weight: 700;
    margin: 0 0 4px;
  }

  .type-item p {
    font-size: 12px;
    color: #6b7280;
    margin: 0;
    line-height: 1.4;
  }

  .ptype {
    display: inline-block;
    font-size: 11px;
    font-weight: 700;
    color: #fff;
    padding: 3px 10px;
    border-radius: 5px;
    letter-spacing: .3px;
  }

  .ptype.mlp {
    background: #22a559;
  }

  .ptype.ctp {
    background: #f59e0b;
  }

  .ptype.icp {
    background: #2f7df6;
  }

  .ptype.ftp {
    background: #8b5cf6;
  }

  .filters-sidebar {
    width: 235px;
    font-size: 13px;
  }

  .fs-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 14px;
  }

  .fs-title {
    font-size: 13px;
    font-weight: 800;
  }

  .link-clear {
    background: none;
    border: 0;
    color: var(--red);
    font-size: 13px;
    font-weight: 700;
    padding: 0;
  }

  .fs-group {
    border-bottom: 1px solid var(--line);
    padding: 10px 0;
  }

  .fs-toggle {
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: none;
    border: 0;
    padding: 2px 0 8px;
    font-size: 13px;
    font-weight: 700;
    color: var(--ink);
  }

  .fs-toggle i {
    transition: transform .2s;
    font-size: 12px;
  }

  .fs-group.collapsed .fs-toggle i {
    transform: rotate(180deg);
  }

  .fs-group.collapsed .fs-body {
    display: none;
  }

  .fs-check {
    display: flex;
    align-items: center;
    gap: 8px;
    margin: 0 0 1px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 12px;
    color: #374151;
  }

  .fs-check input {
    appearance: none;
    -webkit-appearance: none;
    width: 14px;
    height: 14px;
    flex: 0 0 14px;
    border: 1px solid #cbd5e1;
    border-radius: 3px;
    background: #fff;
    margin: 0;
    cursor: pointer;
    position: relative;
  }

  .fs-check input:checked {
    background: var(--red);
    border-color: var(--red);
  }

  .fs-check input:checked::after {
    content: "";
    position: absolute;
    left: 4px;
    top: 1px;
    width: 4px;
    height: 8px;
    border: solid #fff;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
  }

  .fs-check.checked {
    background: #fde7e7;
    color: var(--ink);
    font-weight: 600;
  }

  .fs-select-label {
    font-size: 12px;
    font-weight: 600;
    margin-bottom: 3px;
    display: block;
  }

  .fs-backdrop {
    display: none;
  }

  .fs-close {
    background: none;
    border: 0;
    font-size: 26px;
    line-height: 1;
    color: #9ca3af;
  }

  .results-col {
    min-width: 0;
    border-left: 1px solid var(--line);
    padding-left: 18px;
  }

  .results-bar {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    margin-bottom: 12px;
  }

  .results-count {
    font-size: 16px;
    font-weight: 800;
    margin: 0;
  }

  .results-tools {
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .tool-label {
    font-size: 12px;
    color: #6b7280;
    margin: 0;
  }

  .sort-select {
    width: 170px;
    font-size: 12px;
    border-radius: 8px;
  }

  .view-toggle {
    display: inline-flex;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    overflow: hidden;
    background: #fff;
  }

  .view-toggle button {
    width: 34px;
    height: 32px;
    border: 0;
    background: #fff;
    color: #6b7280;
  }

  .view-toggle button.active {
    background: var(--red);
    color: #fff;
  }

  .active-filters {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 14px;
  }

  .filter-chip {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #fde7e7;
    color: var(--ink);
    border: 1px solid #fbd0d0;
    border-radius: 30px;
    padding: 5px 12px;
    font-size: 12px;
    font-weight: 600;
  }

  .filter-chip button {
    border: 0;
    background: none;
    color: var(--red);
    font-size: 16px;
    line-height: 1;
    padding: 0;
  }

  .program-grid.is-loading {
    opacity: .5;
    pointer-events: none;
  }

  .pcard {
    background: #fff;
    border-radius: 12px;
    border: 1px solid #f0e6dc;
    height: 100%;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    box-shadow: 0 4px 14px rgba(0, 0, 0, .06);
    transition: .25s;
  }

  .pcard:hover {
    transform: translateY(-4px);
    box-shadow: 0 14px 30px rgba(0, 0, 0, .12);
  }

  .pcard-img {
    height: 112px;
    background: #f3f4f6;
    flex: 0 0 auto;
  }

  .pcard-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
  }

  .pcard-body {
    padding: 10px;
    display: flex;
    flex-direction: column;
    flex: 1;
  }

  .pcard-body .ptype {
    align-self: flex-start;
    font-size: 10px;
    padding: 2px 8px;
    margin-bottom: 6px;
  }

  .pcard-title {
    font-size: 15px;
    font-weight: 800;
    line-height: 1.25;
    margin: 0 0 6px;
    min-height: 38px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .pcard-desc {
    font-size: 11.5px;
    color: #6b7280;
    line-height: 1.45;
    margin: 0 0 8px;
    min-height: 50px;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .pcard-outcomes {
    background: #fff1ee;
    border-radius: 8px;
    padding: 8px 10px;
    margin-bottom: 10px;
  }

  .po-title {
    font-size: 11px;
    font-weight: 800;
    color: var(--red);
    margin-bottom: 4px;
  }

  .pcard-outcomes ul {
    list-style: none;
    margin: 0;
    padding: 0;
  }

  .pcard-outcomes li {
    font-size: 10.5px;
    color: #374151;
    display: flex;
    gap: 4px;
    line-height: 1.35;
    margin-bottom: 2px;
  }

  .pcard-outcomes li i {
    color: var(--red);
  }

  .pcard-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin-top: auto;
    margin-bottom: 10px;
  }

  .ptag {
    font-size: 10.5px;
    font-weight: 600;
    padding: 3px 9px;
    border-radius: 6px;
  }

  .ptag.grade {
    background: #fff3cd;
    color: #856404;
  }

  .ptag.subject {
    background: #e8f1ff;
    color: #1d4ed8;
  }

  .ptag.state {
    background: #ecfdf5;
    color: #047857;
  }

  .pcard-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 11px;
    color: #374151;
    margin-bottom: 10px;
  }

  .pcard-meta .price strong {
    font-size: 14px;
    color: var(--red);
  }

  .btn.pcard-btn {
    align-self: center;
    width: auto !important;
    min-width: 0;
    font-size: 11px !important;
    font-weight: 600;
    padding: 3px 12px;
    line-height: 1.4;
    border-radius: 5px;
  }

  .pcard-btn i {
    font-size: 10px;
  }

  .row.program-grid {
    --bs-gutter-x: .7rem;
    --bs-gutter-y: .7rem;
  }

  .program-grid.list-view .program-item {
    flex: 0 0 100%;
    max-width: 100%;
  }

  .program-grid.list-view .pcard {
    flex-direction: row;
  }

  .program-grid.list-view .pcard-img {
    width: 210px;
    height: auto;
    min-height: 100%;
  }

  .program-grid.list-view .pcard-title,
  .program-grid.list-view .pcard-desc {
    min-height: 0;
  }

  .btn-add-cart {
    background: var(--red);
    color: #fff;
    border: 0;
    border-radius: 8px;
    font-weight: 600;
  }

  .btn-add-cart:hover {
    background: var(--red-dark);
    color: #fff;
  }

  .btn-outline-program {
    border: 1px solid var(--red);
    color: var(--red);
    background: #fff;
    border-radius: 8px;
    font-weight: 600;
    font-size: 13px;
    padding: 7px 16px;
  }

  .btn-outline-program:hover {
    background: var(--red);
    color: #fff;
  }

  .load-more {
    padding: 8px 26px;
  }

  .lp-page .btn {
    text-transform: none;
    font-size: 12px !important;
    letter-spacing: normal;
    width: 100% !important;
    border-radius: 8px;
  }

  .lp-page .cta-btn.cta-btn-lg {
    font-size: 15px !important;
    border-radius: 10px !important;
  }

  .empty-state {
    text-align: center;
    padding: 50px 10px;
    color: #6b7280;
  }

  .empty-state i {
    font-size: 34px;
  }

  .select-cta {
    display: flex;
    align-items: center;
    gap: 24px;
    border-radius: 18px;
  }

  .cta-banner {
    display: flex;
    align-items: center;
    gap: 28px;
    background: linear-gradient(90deg, #fdeee4, #fff1e8);
    border: 1px solid #f6dfd0;
    border-radius: 14px;
    padding: 22px 30px;
  }
.cta-text{
  flex: 1;
}
  .cta-icon {
  
    border-radius: 50%;
    color: var(--red);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 56px;
    padding-right: 24px;
  }

  .cta-text h3 {
    font-weight: 800;
    margin: 0 0 10px;
  }

  .cta-text p {
    font-size: 15px;
    color: #374151;
    margin: 0;
    line-height: 1.6;
  }

  .cta-action {
    flex: 0 0 auto;
  }

  .cta-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    border-radius: 22px;
    padding: 7px 18px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    white-space: nowrap;
    transition: .2s;
  }

  .cta-btn-lg {
    padding: 18px 40px;
    font-size: 18px !important;
    border-radius: 12px;
    min-width: 340px;
  }

  .cta-btn-lg i {
    font-size: 20px;
  }
.program-grid.list-view .program-item {
  flex: 0 0 100%;
  max-width: 100%;
}

.program-grid.list-view .pcard {
  flex-direction: row;
}

.program-grid.list-view .pcard-img {
  position: relative;
  width: 210px;
  flex: 0 0 210px;
  height: auto;
  min-height: 0;
}

.program-grid.list-view .pcard-img img {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.program-grid.list-view .pcard-body {
  min-width: 0;
}

.program-grid.list-view .pcard-title,
.program-grid.list-view .pcard-desc {
  min-height: 0;
}

  @media (max-width: 768px) {
    .cta-banner {
      flex-direction: column;
      text-align: center;
      justify-content: center;
      padding: 22px;
    }

  .program-grid.list-view .pcard-img {
    width: 110px;
    flex: 0 0 110px;
    min-height: 150px;
  }

.program-grid.list-view .pcard-body {
  padding: 10px;
}

.program-grid.list-view .pcard-title {
  font-size: 14px;
}

.program-grid.list-view .pcard-tags {
  margin-top: 6px;
  margin-bottom: 8px;
}

.program-grid.list-view .btn.pcard-btn {
  align-self: flex-start;
}
    
.mobile {
  display: none;
  }

    .cta-text h2 {
      font-size: 22px;
    }

    .cta-text p {
      font-size: 15px;
    }

    .cta-action {
      width: 100%;
    }

    .cta-btn {
      width: 100%;
      white-space: normal;
    }

    .lp-page .cta-btn.cta-btn-lg {
      min-width: 0;
      font-size: 15px !important;
    }
  }

  @media (max-width:1199.98px) {
    .type-strip {
      grid-template-columns: repeat(2, 1fr);
    }

    .type-item {
      border-left: 0;
      padding-left: 0;
    }
  }

  @media (max-width:991.98px) {
    .results-col {
      border-left: 0;
      padding-left: 12px;
    }

    .filters-sidebar {
      position: fixed;
      top: 0;
      left: 0;
      bottom: 0;
      width: 290px;
      background: #fff;
      z-index: 1051;
      transform: translateX(-100%);
      transition: transform .3s;
      overflow-y: auto;
      padding: 18px;
    }

    .filters-sidebar.open {
      transform: none;
    }

    .fs-backdrop.show {
      display: block;
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, .45);
      z-index: 1050;
    }
  }

  @media (max-width:767.98px) {
    .pill-label {
      flex: auto;
    }

    .pill-row {
      flex-direction: column;
      align-items: flex-start;
      gap: 8px;
    }

    .type-strip {
      grid-template-columns: 1fr;
    }

    .program-grid.list-view .pcard {
      flex-direction: column;
    }

    .program-grid.list-view .pcard-img {
      width: 100%;
      height: 112px;
    }

    .cta-banner {
      text-align: center;
      justify-content: center;
    }

    .cta-btn {
      width: 100%;
    }
  }
</style>

<script>
  (function() {
    const ROUTE = "{{ route('programs.filter') }}";
    const CSRF = "{{ csrf_token() }}";
    const PAGE_TYPE = "{{ request()->route('type') }}";
    const PAGE_SIZE = 8;

    const labels = {
    year: @json($grades->pluck('grade_name', 'id')),
    subject: @json($branches->pluck('branch_name', 'id')),
};
    const typeShort = {
      'Micro Learning Program': 'MLP',
      'Core Training Program': 'CTP',
      'Intensive Crash Program': 'ICP',
      'Foundation Training Program': 'FTP'
    };

    const qs = (s, c) => (c || document).querySelector(s);
    const qsa = (s, c) => Array.from((c || document).querySelectorAll(s));
    const esc = s => String(s).replace(/[&<>"']/g, m => ({
      '&': '&amp;',
      '<': '&lt;',
      '>': '&gt;',
      '"': '&quot;',
      "'": '&#39;'
    } [m]));
    const slugify = s => String(s || '').toLowerCase().trim().replace(/\s+/g, '-');

    const F = {
      year: '',
      subject: '',
      curriculum: '',
      state: '',
      program_type: '',
      focus: '',
      search: ''
    };
    const SERVER_KEYS = ['year', 'subject', 'curriculum', 'state', 'program_type', 'focus'];

    const defaultEl = qs('#prePopulatedData');
    const resultsEl = qs('#programResults');
    const countEl = qs('#programCount');
    const chipsEl = qs('#activeFilters');
    const emptyEl = qs('#emptyState');
    const moreWrap = qs('#loadMoreWrap');
    const sortSel = qs('#sortBy');
    const sidebar = qs('#filtersSidebar');
    const backdrop = qs('#fsBackdrop');

   
    const USE_SERVER = false;

    let limit = PAGE_SIZE,
      reqId = 0,
      serverCount = null,
      mode = 'default';

    function getVariants(el) {
      if (el._variants !== undefined) return el._variants;
      try {
        el._variants = JSON.parse(el.dataset.variants || '[]');
      } catch (e) {
        el._variants = [];
      }
      return el._variants;
    }

    function matchingVariants(el) {
      return getVariants(el).filter(v =>
        (!F.year || String(v.year) === String(F.year)) &&
        (!F.state || v.state === F.state) &&
        (!F.curriculum || v.curriculum === F.curriculum)
      );
    }

    function matchesFilters(el) {
      const d = el.dataset;
      if (F.subject && (d.subject || '') !== (labels.subject[F.subject] || '')) return false;
      if (F.program_type && (d.ptype || '') !== F.program_type) return false;

      const variants = getVariants(el);
      if (variants.length) return matchingVariants(el).length > 0;

      if (F.year && !(d.years || '').split(',').includes(String(F.year))) return false;
      if (F.state && !(d.states || '').split('|').includes(F.state)) return false;
      if (F.curriculum && !(d.curriculum || '').split('|').includes(F.curriculum)) return false;
      return true;
    }

    function updateCard(el) {
      const variants = getVariants(el);
      if (!variants.length) return;

      const list = matchingVariants(el);
      const use = list.length ? list : variants;
      const uniq = arr => arr.filter((v, i) => v && arr.indexOf(v) === i);

      const grades = uniq(use.map(v => v.grade)).join(', ');
      const states = uniq(use.map(v => v.state_short)).join(', ');
      const prices = use.map(v => parseFloat(v.price)).filter(p => !isNaN(p) && p > 0);
      const price = prices.length ? Math.min.apply(null, prices) : null;

      const gradeEl = qs('[data-role="grade"]', el);
      const stateEl = qs('[data-role="state"]', el);
      const priceEl = qs('[data-role="price"]', el);
      const linkEl = qs('[data-role="link"]', el);

      if (gradeEl) {
        gradeEl.textContent = grades;
        gradeEl.classList.toggle('d-none', !grades);
      }
      if (stateEl) {
        stateEl.textContent = states;
        stateEl.classList.toggle('d-none', !states);
      }
      if (priceEl) {
        priceEl.innerHTML = price !== null ? 'From <strong>$' + Math.round(price).toLocaleString() + '</strong>' : '';
        priceEl.classList.toggle('d-none', price === null);
      }
      el.dataset.price = price !== null ? price : '';

      if (linkEl && el.dataset.urlTemplate) {
        const v = use[0];
        let href = el.dataset.urlTemplate.replace('__SLUG__', encodeURIComponent(v.slug));
        const params = [];
        if (F.year && v.year) params.push('year=' + encodeURIComponent(v.year));
        if (F.state && v.state) params.push('state=' + encodeURIComponent(slugify(v.state)));
        if (params.length) href += (href.indexOf('?') > -1 ? '&' : '?') + params.join('&');
        linkEl.setAttribute('href', href);
      }
    }

    function syncUI() {
      qsa('[data-filter-btn]').forEach(b =>
        b.classList.toggle('active', String(F[b.dataset.filterBtn]) === b.dataset.value));

      qsa('input[data-filter]').forEach(i => {
        i.checked = String(F[i.dataset.filter]) === i.value;
        const lbl = i.closest('label');
        if (lbl) lbl.classList.toggle('checked', i.checked && i.value !== '');
      });

      ['curriculum', 'state'].forEach(k => {
        const el = qs('#' + k);
        if (el) el.value = F[k];
      });

      const s = qs('#programSearch');
      if (s && s.value !== F.search) s.value = F.search;
    }

    function renderChips() {
      const names = {
        year: 'Year',
        subject: 'Subject',
        curriculum: 'Curriculum',
        state: 'State',
        program_type: 'Type',
        focus: 'Focus',
        search: 'Search'
      };
      const val = k => {
        if (k === 'year') return String(labels.year[F.year] || F.year).replace(/^Year\s*/i, '');
        if (k === 'subject') return labels.subject[F.subject] || F.subject;
        if (k === 'program_type') return typeShort[F.program_type] || F.program_type;
        return F[k];
      };
      chipsEl.innerHTML = Object.keys(names).filter(k => F[k]).map(k =>
        `<span class="filter-chip">${names[k]}: ${esc(val(k))}
               <button type="button" data-remove="${k}" aria-label="Remove filter">&times;</button></span>`
      ).join('');
      chipsEl.classList.toggle('d-none', !chipsEl.innerHTML);
    }

    const num = el => (el.dataset.price === '' || el.dataset.price === undefined) ? Infinity : parseFloat(el.dataset.price);
    const cmpN = (a, b) => a < b ? -1 : (a > b ? 1 : 0);

    function sortItems(grid, items) {
      const sorters = {
        'relevance': (a, b) => cmpN(+a.dataset.idx, +b.dataset.idx),
        'price-asc': (a, b) => cmpN(num(a), num(b)),
        'price-desc': (a, b) => cmpN(num(b), num(a)),
        'name': (a, b) => (a.dataset.name || '').localeCompare(b.dataset.name || '')
      };
      items.slice().sort(sorters[sortSel.value] || sorters.relevance).forEach(el => grid.appendChild(el));
    }

    function refresh() {
      const grid = mode === 'results' ? resultsEl : defaultEl;
      const items = qsa('.program-item', grid);
      items.forEach((el, i) => {
        if (el.dataset.idx === undefined) el.dataset.idx = i;
      });

      if (mode === 'default') items.forEach(updateCard);
      sortItems(grid, items);

      const q = F.search.trim().toLowerCase();
      const matched = items.filter(el =>
        (mode === 'results' || matchesFilters(el)) &&
        (!q || (el.dataset.search || el.textContent).toLowerCase().includes(q)));
      const visible = new Set(matched.slice(0, limit));
      items.forEach(el => el.classList.toggle('d-none', !visible.has(el)));

      const total = (mode === 'results' && serverCount !== null && !q) ? serverCount : matched.length;
      countEl.textContent = total + ' program' + (total === 1 ? '' : 's') + ' found';

      moreWrap.classList.toggle('d-none', matched.length <= limit);
      emptyEl.classList.toggle('d-none',
        !(grid.children.length === 0 || (items.length > 0 && matched.length === 0)));
      renderChips();
    }

    function load() {
      const my = ++reqId;

      if (!USE_SERVER || !SERVER_KEYS.some(k => F[k])) {
        mode = 'default';
        serverCount = null;
        resultsEl.classList.add('d-none');
        resultsEl.innerHTML = '';
        defaultEl.classList.remove('d-none');
        refresh();
        return;
      }

      const body = {
        type: PAGE_TYPE
      };
      SERVER_KEYS.forEach(k => body[k] = F[k]);

      resultsEl.classList.add('is-loading');
      defaultEl.classList.add('is-loading');

      fetch(ROUTE, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': CSRF,
            'Accept': 'application/json'
          },
          body: JSON.stringify(body)
        })
        .then(r => r.json())
        .then(data => {
          if (my !== reqId) return;
          if (data.status) {
            mode = 'results';
            resultsEl.innerHTML = data.html;
            serverCount = (typeof data.count === 'number') ? data.count : null;
            defaultEl.classList.add('d-none');
            resultsEl.classList.remove('d-none');
          }
          refresh();
        })
        .catch(err => console.error('Filter Error:', err))
        .finally(() => {
          if (my === reqId) {
            resultsEl.classList.remove('is-loading');
            defaultEl.classList.remove('is-loading');
          }
        });
    }

    function setFilter(key, value) {
      F[key] = value;
      limit = PAGE_SIZE;
      syncUI();
      key === 'search' ? refresh() : load();
    }

    function clearAll() {
      Object.keys(F).forEach(k => F[k] = '');
      limit = PAGE_SIZE;
      syncUI();
      load();
    }

    document.addEventListener('click', function(e) {
      const pill = e.target.closest('[data-filter-btn]');
      if (pill) {
        setFilter(pill.dataset.filterBtn, pill.dataset.value);
        return;
      }

      const rm = e.target.closest('[data-remove]');
      if (rm) {
        setFilter(rm.dataset.remove, '');
        return;
      }

      if (e.target.closest('[data-clear-all]')) {
        clearAll();
        return;
      }

      const tg = e.target.closest('.fs-toggle');
      if (tg) {
        tg.parentElement.classList.toggle('collapsed');
        return;
      }

      const view = e.target.closest('[data-view]');
      if (view) {
        qsa('[data-view]').forEach(b => b.classList.toggle('active', b === view));
        [defaultEl, resultsEl].forEach(g => g.classList.toggle('list-view', view.dataset.view === 'list'));
        return;
      }

      if (e.target.closest('#loadMoreBtn')) {
        limit += PAGE_SIZE;
        refresh();
        return;
      }

      const cta = e.target.closest('a[href="#assessment"]');
      if (cta) {
        e.preventDefault();
        qs('#assessment').scrollIntoView({
          behavior: 'smooth'
        });
      }
    });

    qsa('input[data-filter]').forEach(i =>
      i.addEventListener('change', () => setFilter(i.dataset.filter, i.checked ? i.value : '')));

    ['curriculum', 'state'].forEach(k => {
      const el = qs('#' + k);
      if (el) el.addEventListener('change', () => setFilter(k, el.value));
    });

    sortSel.addEventListener('change', refresh);

    let searchTimer;
    qs('#programSearch').addEventListener('input', function() {
      clearTimeout(searchTimer);
      const v = this.value;
      searchTimer = setTimeout(() => setFilter('search', v), 200);
    });

    const openDrawer = () => {
      sidebar.classList.add('open');
      backdrop.classList.add('show');
    };
    const closeDrawer = () => {
      sidebar.classList.remove('open');
      backdrop.classList.remove('show');
    };
    qs('#openFilters').addEventListener('click', openDrawer);
    qs('#closeFilters').addEventListener('click', closeDrawer);
    backdrop.addEventListener('click', closeDrawer);

    syncUI();
    refresh();
  })();

  $(document).on('click', '.add-to-cart-text', function() {
    const cartText = $(this);
    const programId = cartText.data('id');
    const buyBtn = $('.buy-now-btn[data-id="' + programId + '"]');

    fetch("{{ route('cart.toggle') }}", {
        method: "POST",
        headers: {
          "X-CSRF-TOKEN": "{{ csrf_token() }}",
          "Content-Type": "application/json"
        },
        body: JSON.stringify({
          program_id: programId
        })
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

  document.addEventListener('click', function(e) {
    const btn = e.target.closest('.program-detail-btn');
    if (!btn) return;
    e.preventDefault();

    const slug = btn.dataset.slug;
    let grades = {},
      states = [];

    try {
      grades = JSON.parse((btn.dataset.grades || '{}').trim());
      states = JSON.parse((btn.dataset.states || '[]').trim());
    } catch (err) {
      console.error('JSON PARSE ERROR', err);
      return;
    }

    const single = btn.dataset.single == '1';
    const gradeIds = Object.keys(grades);
    const statesFormatted = states.map(s => s.toLowerCase().replace(/ /g, '-'));

    if (single && states.length > 0) {
      window.location.href = `/program/${slug}?year=${gradeIds[0]}&state=${statesFormatted[0]}`;
      return;
    }
    if (gradeIds.length === 1 && states.length === 1) {
      window.location.href = `/program/${slug}?year=${gradeIds[0]}&state=${statesFormatted[0]}`;
      return;
    }
    if (gradeIds.length === 1 && states.length > 1) {
      window.location.href = `/program/${slug}?year=${gradeIds[0]}&states=${statesFormatted.join(',')}`;
      return;
    }
    if (gradeIds.length > 1) {
      window.location.href = `/program/${slug}?states=${statesFormatted.join(',')}`;
      return;
    }
  });
</script>
@endsection