@if(!empty($groupedPrograms))

@php
$subjectImages = [
    'Maths' => 'assets/images/english-programs.png',
    'English' => 'assets/images/maths-programs.png',
    'Science' => 'assets/images/science-programs.png',
];
@endphp

@foreach($groupedPrograms as $subjectName => $programs)

    @if(!empty($programs))

        <!-- SUBJECT BANNER -->
        <div class="subject-banner mb-3 mt-4">
            <img src="{{ public_asset($subjectImages[$subjectName] ?? 'assets/images/banner-default.jpg') }}"
                 alt="{{ $subjectName }}"
                 class="subject-banner-img">
            <div class="banner-overlay"></div>
            <h3 class="banner-title">{{ $subjectName }}</h3>
        </div>

        <!-- PROGRAMS -->
        <div class="row mb-5 mt-16">
            @foreach($programs as $program)

                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="program-pre-card">
                        <div class="program-meta-top">
                            {{ $subjectName }} Program
                        </div>
                            <h5 class="program-title">
                                {{ $program->name ?? 'Program Name' }}
                            </h5>
                            <p class="program-desc">
                                {{ \Illuminate\Support\Str::limit($program->description ?? '', 80) }}
                            </p>

                        @php
                            $programType = trim(strtolower($program->program_type ?? ''));
                        @endphp

                        @if(in_array($programType, ['core training program', 'foundation training program', 'ctp', 'ftp']))
                            <p class="guarantee-text">✔ 30-Day Skill Progress Guarantee</p>
                        @elseif(in_array($programType, ['intensive crash program', 'icp']))
                            <p class="guarantee-text">✔ Exam-Focused Practice</p>
                        @endif

                            {{-- Sessions --}}
                        <div class="session-box">
                            <span class="session-number">
                                {{ $program->number_of_sessions }}
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

                            $allGrades = collect($program->grades)->pluck('grade_name')->unique()->join(', ');
                            $allStates = collect($program->states ?? [])->unique()->map(fn($s) => $stateShortMap[$s] ?? $s)->join(', ');
                            @endphp

                            <span class="tag grade-tag">{{ $allGrades }}</span>
                            <span class="tag state-tag">{{ $allStates }}</span>
                        </div>
                        <!-- JSON FOR JS -->
                        <div class="text-center mt-3">
                            <a href="#"
                               class="btn btn-add-cart w-100 program-detail-btn"
                               data-slug="{{ $program->slug }}"

                               {{--grades as {id:name} --}}
                               data-grades='@json(collect($program->grades)->mapWithKeys(fn($g) => [(string)$g->id => $g->grade_name]))'

                               {{-- states as array --}}
                               data-states='@json(array_values($program->states ?? []))'

                               data-single="{{ $program->singleProgram ? 1 : 0 }}">
                               Learn More →
                            </a>
                        </div>
                    </div>
                </div>

            @endforeach
        </div>

    @endif

@endforeach

@else
<div class="text-center">
    <p>No programs found.</p>
</div>
@endif