@extends('admin.layouts.app')

@section('title')
Tutor Overview
@endsection

@section('links')
@include('admin.includes.links')

<style type="text/css">
    .buttons-excel { display: none; }

    :root {
        --tw-primary: #d71f3e;
        --tw-primary-soft: #fdebee;
        --tw-ink: #1b2437;
        --tw-muted: #6b7488;
        --tw-border: #e6e9f0;
        --tw-bg: #f6f7fb;
        --tw-radius: 12px;
    }

    .tw-page { background: var(--tw-bg); }

    .tw-head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 18px;
    }

    .tw-head h1 { margin: 0; font-size: 26px; font-weight: 700; color: var(--tw-ink); }
    .tw-head .small_tag { margin: 4px 0 0; color: var(--tw-muted); font-size: 13px; }
    .tw-actions { display: flex; flex-wrap: wrap; gap: 8px; }

    .tw-actions .btn {
        border-radius: 8px;
        background: #fff !important;
        color: var(--tw-ink);
        font-weight: 600;
        font-size: 13px;
        padding: 7px 14px;
    }

    .tw-actions .btn:hover { border-color: var(--tw-primary); color: var(--tw-primary); }

    .tw-card {
        background: #fff;
        border: 1px solid var(--tw-border);
        border-radius: var(--tw-radius);
        padding: 20px 22px;
        margin-bottom: 18px;
        box-shadow: 0 1px 2px rgba(27, 36, 55, .04);
    }

    .tw-card-title { margin: 0 0 14px; font-size: 16px; font-weight: 700; color: var(--tw-ink); }

    .tw-profile { display: flex; align-items: center; flex-wrap: wrap; gap: 20px; }

    .tw-avatar {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: var(--tw-primary-soft);
        color: var(--tw-primary);
        font-weight: 700;
        font-size: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex-shrink: 0;
    }

    .tw-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .tw-profile-name { margin: 0; font-size: 20px; font-weight: 700; color: var(--tw-ink); }
    .tw-profile-sub { color: var(--tw-muted); font-size: 13px; margin-top: 2px; }
    .tw-meta { display: flex; flex-wrap: wrap; margin-left: auto; }
    .tw-meta-item { padding: 0 24px; border-left: 1px solid var(--tw-border); }
    .tw-meta-item span { display: block; font-size: 12px; color: var(--tw-muted); }
    .tw-meta-item strong { font-size: 14px; color: var(--tw-ink); }
    .tw-layout { display: flex; gap: 18px; align-items: stretch; }
    .tw-side { width: 250px; flex-shrink: 0; align-self: stretch; }
    .tw-section-title { margin: 0; font-size: 22px; font-weight: 700; color: var(--tw-ink); }
    .tw-section-sub { margin: 4px 0 18px; color: var(--tw-muted); font-size: 13px; }

    .tw-badge {
        display: inline-block;
        margin-left: 8px;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        background: #eef0f5;
        color: var(--tw-muted);
    }

    .tw-badge.approved { background: #dcf5e4; color: #1a7a3c; }
    .tw-badge.pending { background: #fff3d6; color: #a86b00; }
    .tw-badge.rejected { background: #fde2e5; color: #b4152f; }

    .tw-main { flex: 1; min-width: 0; }

    .tw-nav {
        height: 100%;
        min-height: calc(100vh - 280px);
        list-style: none;
        margin: 0;
        padding: 10px;
        background: #fff;
        border: 1px solid var(--tw-border);
        border-radius: var(--tw-radius);
    }

    .tw-nav li { margin: 0 0 2px; }

    .tw-nav li a {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        color: var(--tw-ink);
        text-decoration: none;
        border-left: 3px solid transparent;
        transition: background .15s, color .15s;
    }

    .tw-nav li a span { display: inline-flex; width: 18px; }
    .tw-nav li a span img { width: 16px; height: auto; }
    .tw-nav li a .accth { display: none; }

    .tw-nav li a:hover,
    .tw-nav li.active a {
        background: var(--tw-primary-soft);
        color: var(--tw-primary);
        border-left-color: var(--tw-primary);
    }

    .tw-nav li a:hover .actt,
    .tw-nav li.active a .actt { display: none; }

    .tw-nav li a:hover .accth,
    .tw-nav li.active a .accth { display: inline; }

    .tw-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 240px), 1fr)); gap: 18px; }
    .tw-grid .tw-card { margin-bottom: 0; }
    .tw-grid-wrap { margin-bottom: 18px; }
    .tw-list { margin: 0; }

    .tw-row {
        display: flex;
        padding: 10px 0;
        border-bottom: 1px solid var(--tw-border);
        font-size: 14px;
    }

    .tw-row:last-child { border-bottom: 0; }
    .tw-row dt { width: 40%; font-weight: 600; color: var(--tw-ink); }
    .tw-row dd { margin: 0; flex: 1; color: #3b4458; word-break: break-word; }
    .tw-addr { display: grid; grid-template-columns: repeat(2, 1fr); column-gap: 28px; }
    .tw-text { margin: 0; color: #3b4458; line-height: 1.7; font-size: 14px; }

    @media (max-width: 991px) {
        .tw-layout { flex-direction: column; }
        .tw-side { width: 100%; }
        .tw-nav { display: flex; overflow-x: auto; white-space: nowrap; gap: 4px; height: auto; min-height: 0; }
        .tw-nav li { margin: 0; }
        .tw-meta { margin-left: 0; width: 100%; }
        .tw-meta-item:first-child { border-left: 0; padding-left: 0; }
    }

    @media (max-width: 575px) {
        .tw-addr { grid-template-columns: 1fr; }
        .tw-row { flex-direction: column; }
        .tw-row dt { width: 100%; margin-bottom: 2px; }
    }

    .tw-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 16px;
    }

    .tw-viewonly { font-size: 12px; color: var(--tw-muted); }

    .tw-info {
        background: #eaf0ff;
        color: #2a47a8;
        border-radius: 10px;
        padding: 12px 16px;
        font-size: 14px;
        line-height: 1.5;
    }

    .tw-status {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        background: #eef0f5;
        color: var(--tw-muted);
        white-space: nowrap;
    }

    .tw-st-done { background: #dcf5e4; color: #1a7a3c; }
    .tw-st-warn { background: #fff3d6; color: #a86b00; }
    .tw-st-bad { background: #fde2e5; color: #b4152f; }
    .tw-st-neutral { background: #eef0f5; color: #4a5468; }

    .tw-ov-actions { display: flex; flex-wrap: wrap; gap: 8px; margin-left: auto; }

    .tw-btn-outline, .tw-btn-danger-outline {
        height: 34px;
        padding: 0 14px;
        border-radius: 8px;
        background: #fff !important;
        font-size: 13px;
        font-weight: 700;
    }

    .tw-btn-outline { border: 1px solid var(--tw-border); color: var(--tw-ink); }
    .tw-btn-danger-outline { border: 1px solid var(--tw-primary); color: var(--tw-primary); }

    .tw-btn-outline:hover, .tw-btn-outline:focus {
        border-color: #b9c0d0;
        color: var(--tw-ink);
        background: #fff;
    }

    .tw-btn-danger-outline:hover, .tw-btn-danger-outline:focus {
        background: var(--tw-primary-soft);
        color: var(--tw-primary);
    }

    .tw-ov-actions .dropdown-menu {
        border-radius: 10px;
        border: 1px solid var(--tw-border);
        font-size: 13px;
    }

    .tw-ov-actions .dropdown-menu > .active > a {
        background: var(--tw-primary-soft);
        color: var(--tw-primary);
    }

    .tw-ov-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 14px;
        margin-bottom: 14px;
    }

    .tw-ov-card {
        border: 1px solid var(--tw-border);
        border-radius: 12px;
        background: #fbfdff;
        padding: 16px 18px;
        min-height: 104px;
    }

    .tw-ov-label { display: block; font-size: 12px; color: var(--tw-muted); margin-bottom: 12px; }
    .tw-ov-body { display: flex; align-items: center; gap: 12px; }
    .tw-ov-value { font-size: 20px; color: var(--tw-ink); }
    .tw-ov-big { display: block; font-size: 20px; line-height: 1.25; color: var(--tw-ink); }
    .tw-ov-grid ~ .tw-info { margin-top: 18px; }

    .tw-switch {
        position: relative;
        display: inline-block;
        width: 52px;
        height: 28px;
        margin: 0;
        cursor: pointer;
    }

    .tw-switch input { opacity: 0; width: 0; height: 0; position: absolute; }

    .tw-switch-slider {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        border-radius: 28px;
        background: #cfd5e2;
        transition: background .2s;
    }

    .tw-switch-slider::before {
        content: "";
        position: absolute;
        width: 22px;
        height: 22px;
        left: 3px;
        top: 3px;
        border-radius: 50%;
        background: #fff;
        transition: transform .2s;
        box-shadow: 0 1px 2px rgba(0,0,0,.25);
    }

    .tw-switch input:checked + .tw-switch-slider { background: #1fa855; }
    .tw-switch input:checked + .tw-switch-slider::before { transform: translateX(24px); }

    @media (max-width: 1199px) {
        .tw-ov-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 575px) {
        .tw-ov-grid { grid-template-columns: 1fr; }
        .tw-ov-actions { margin-left: 0; }
    }
</style>
@endsection

@section('header')
@include('admin.includes.header')
@endsection

@section('sidebar')
@include('admin.includes.sidebar')
@endsection

@section('content')

@php
    $fullName = trim(implode(' ', array_filter([@$user->f_name, @$user->m_name, @$user->l_name])));
    $initials = strtoupper(mb_substr((string) @$user->f_name, 0, 1) . mb_substr((string) @$user->l_name, 0, 1));
    $tutorCode = @$user->tutor_id ?: 'TUT' . str_pad((string) @$user->id, 6, '0', STR_PAD_LEFT);


    if (@$user->status == 'A' && @$user->subscription == 'S' && @$user->draft == 'N') {
        $statusLabel = 'Approved';
        $statusClass = 'approved';
    } elseif (@$user->status == 'A') {
        $statusLabel = 'Pending';
        $statusClass = 'pending';
    } elseif (@$user->status == 'I') {
        $statusLabel = 'Suspended';
        $statusClass = 'suspended';
    } elseif (@$user->status == 'R') {
        $statusLabel = 'Rejected';
        $statusClass = 'rejected';
    } else {
        $statusLabel = '—';
        $statusClass = '';
    }

    $subjectsText = collect(@$tutor_subjects)->pluck('name')->filter()->implode(', ');
    $availabilityText = @$user->availability_status ? 'Yes' : 'No';

    $navUrl = function ($name) use ($user) {
        return \Illuminate\Support\Facades\Route::has($name)
            ? route($name, $user->id)
            : 'javascript:void(0);';
    };

    $navItems = [
        ['Overview', 'view.tutor.overview', 'peri.png', 'perih.png', true],
        ['Personal Details', 'view.tutor.personal.info.step.1', 'peri.png', 'perih.png', false],
        ['Tutorship Plan', 'view.tutor.tutorship.plans', 'gar.png', 'garh.png', false],
        ['Academics', 'view.tutor.academics', 'aca.png', 'acah.png', false],
        ['Experience', 'view.tutor.experience', 'ex.png', 'exh.png', false],
        ['Recognitions', 'view.tutor.recognitions', 'rec.png', 'rech.png', false],
        ['Right to Work', 'view.tutor.right.to.work', 'rec.png', 'rech.png', false],
        ['Availability', 'view.tutor', 'rec.png', 'checked.png', false],
        ['Learning Programs', 'view.tutor.learning.programs', 'aca.png', 'acah.png', false],
        ['Public Profile', 'view.tutor.public.profile', 'peri.png', 'perih.png', false],
    ];
@endphp

@php
    if (@$user->status == 'A' && @$user->subscription == 'S' && @$user->draft == 'N') {
        $ovStatusLabel = 'Approved';
        $ovStatusClass = 'tw-st-done';
    } elseif (@$user->status == 'A') {
        $ovStatusLabel = 'Pending';
        $ovStatusClass = 'tw-st-warn';
    } elseif (@$user->status == 'I') {
        $ovStatusLabel = 'Suspended';
        $ovStatusClass = 'tw-st-warn';
    } elseif (@$user->status == 'R') {
        $ovStatusLabel = 'Rejected';
        $ovStatusClass = 'tw-st-bad';
    } else {
        $ovStatusLabel = '—';
        $ovStatusClass = 'tw-st-neutral';
    }

    $ovStates = (array) config('tutor_form.australian_states', []);

    $ovVerifiedStates = collect($tutor_wwcc ?? [])
        ->filter(function ($item) {
            return (int) $item->is_valid === 1;
        })
        ->pluck('states')
        ->map(function ($stateId) use ($ovStates) {
            return $ovStates[$stateId] ?? null;
        })
        ->filter()
        ->unique()
        ->values();

    $ovFreeTrial = @$user->free_trial ? 'Yes' : 'No';
    $ovFeatured = (bool) @$user->is_featured;
    $ovSubjects = @$subjects ?: collect(@$tutor_subjects)->pluck('name')->filter()->implode(', ');
    $ovYearLevels = @$year_levels ?: '—';
    $ovAvailability = @$availability_summary ?: (@$availability ?: '—');
@endphp

<div class="content tw-page">
    <div class="wraper container-fluid">

        <div class="tw-head">
            <div>
                <h1>Tutor Workspace</h1>
                <p class="small_tag">You can find information or view tutor profile in this section</p>
            </div>

            <div class="tw-actions">
                <a class="btn" href="{{ route('tutor.public.profile', $user->slug) }}">
                    <i class="fas fa-external-link-alt"></i> View Public Profile
                </a>
            </div>
        </div>

        @include('admin.includes.message')

        <div class="tw-card">
            <div class="tw-profile">

                <div class="tw-avatar">
                    @if(@$user->profile_pic)
                        <img id="img2" src="{{ URL::to('storage/teacher_profile_pic/'.@$user->profile_pic) }}" alt="{{ $fullName }}">
                    @elseif(@$user->avatar)
                        <img id="img2" src="{{ @$user->avatar }}" alt="{{ $fullName }}">
                    @else
                        {{ $initials ?: '?' }}
                    @endif
                </div>

                <div>
                    <h2 class="tw-profile-name">{{ $fullName ?: '—' }}</h2>

                    <div class="tw-profile-sub">
                        Tutor ID: {{ $tutorCode }}

                        @if($statusLabel)
                            <span class="tw-badge {{ $statusClass }}">{{ $statusLabel }}</span>
                        @endif
                    </div>
                </div>

                <div class="tw-meta">
                    <div class="tw-meta-item">
                        <span>Subjects</span>
                        &#x20;
                        <strong>{{ $branch ?: '—' }}</strong>
                    </div>

                    <div class="tw-meta-item">
                        <span>State</span>
                        <strong>{{ @$user->getState->state_name ?: '—' }}</strong>
                    </div>

                    <div class="tw-meta-item">
                        <span>Availability</span>
                        <strong>{{ $availability }}</strong>
                    </div>
                </div>

            </div>
        </div>

        <div class="tw-layout">

            <aside class="tw-side">
                <a href="javascript:void(0);" id="clickHere" data-toggle="modal" data-target="#instructionModal" style="display:none;">Click</a>

                <ul class="tw-nav">
                    @foreach($navItems as [$label, $routeName, $icon, $iconHover, $isActive])
                        <li class="{{ $isActive ? 'active' : '' }}">
                            <a href="{{ $navUrl($routeName) }}">
                                <span>
                                    <img src="{{ public_asset('admin/assets/images/' . $icon) }}" class="actt">
                                    <img src="{{ public_asset('admin/assets/images/' . $iconHover) }}" class="accth">
                                </span>
                                {{ $label }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </aside>

            <section class="tw-main">

                <h2 class="tw-section-title">Tutor Overview</h2>
                <p class="tw-section-sub">Status and teaching information at a glance.</p>

                <div class="tw-bar">
                    <span class="tw-viewonly" style="margin-left:0;">Tutor profile summary</span>

                    <div class="tw-ov-actions">

                        <div class="btn-group">
                            @if($user->status != 'R')
                            <button type="button"
                                class="btn tw-btn-outline dropdown-toggle"
                                data-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false">

                                Update Status: <span id="tutorStatusText"></span>
                                <span class="caret"></span>
                            </button>

                            <ul class="dropdown-menu dropdown-menu-right" id="tutorStatusActions">

                                @if($user->status == 'A' && $user->subscription == 'S' && $user->draft == 'N')

                                    <li>
                                        <a href="javascript:void(0);"
                                            class="js-status-action"
                                            data-status="suspended">
                                            Suspend
                                        </a>
                                    </li>

                                @elseif($user->status == 'A')

                                    <li>
                                        <a href="javascript:void(0);"
                                            class="js-status-action"
                                            data-status="approved">
                                            Approve
                                        </a>
                                    </li>

                                    <li>
                                        <a href="javascript:void(0);"
                                            class="js-status-action"
                                            data-status="rejected">
                                            Reject
                                        </a>
                                    </li>

                                @elseif($user->status == 'I')

                                    <li>
                                        <a href="javascript:void(0);"
                                            class="js-status-action"
                                            data-status="approved">
                                            Approve
                                        </a>
                                    </li>

                                @endif

                            </ul>
                        </div>
                      @endif
                    </div>
                </div>

                <div class="tw-ov-grid">

                    <div class="tw-ov-card">
                        <span class="tw-ov-label">Tutor Status</span>
                        <div class="tw-ov-body">
                            <span class="tw-status {{ $ovStatusClass }}">{{ $ovStatusLabel }}</span>
                        </div>
                    </div>

                    <div class="tw-ov-card">
                        <span class="tw-ov-label">WWCC Status</span>

                        <div class="tw-ov-body" style="flex-wrap:wrap; gap:6px;">
                            @forelse($ovVerifiedStates as $state)
                                <span class="tw-status tw-st-done"style="white-space:normal;">
                                    {{ $state }} (Verified)
                                </span>
                            @empty
                                <span class="tw-status tw-st-neutral">
                                    Not verified
                                </span>
                            @endforelse
                        </div>
                    </div>

                    <div class="tw-ov-card">
                        <span class="tw-ov-label">Free Trial</span>

                        <div class="tw-ov-body">
                            <label class="tw-switch">
                                <input type="checkbox" id="freeTrialToggle" {{ @$user->free_trial ? 'checked' : '' }}>
                                <span class="tw-switch-slider"></span>
                            </label>

                            <strong class="tw-ov-value" id="freeTrialText">
                                {{ @$user->free_trial ? 'Yes' : 'No' }}
                            </strong>
                        </div>
                    </div>
                    <div class="tw-ov-card">
                        <span class="tw-ov-label">Featured</span>
                        <div class="tw-ov-body">
                            <label class="tw-switch">
                                <input type="checkbox"
                                    id="featuredToggle"
                                    data-id="{{ $user->id }}"
                                    {{ old('featured', $user->featured) == 1 ? 'checked' : '' }}>
                                <span class="tw-switch-slider"></span>
                            </label>
                            <strong class="tw-ov-value" id="featuredText">
                                {{ $user->featured == 1 ? 'Yes' : 'No' }}
                            </strong>
                        </div>
                    </div>
                </div>
                <div class="tw-ov-grid">

                    <div class="tw-ov-card">
                        <span class="tw-ov-label">Subjects</span>
                        <strong class="tw-ov-big">{{ $branch ?: '—' }}</strong>
                    </div>

                    <div class="tw-ov-card">
                        <span class="tw-ov-label">Year Levels</span>
                        <strong class="tw-ov-big">{{ $ovYearLevels }}</strong>
                    </div>

                    <div class="tw-ov-card">
                        <span class="tw-ov-label">Learning Programs</span>

                        <strong class="tw-ov-big">
                                {{ $learningProgramsCount ?? 0 }} Managed Learning Programs
                        </strong>
                    </div>

                    <div class="tw-ov-card">
                        <span class="tw-ov-label">Availability</span>
                        <strong class="tw-ov-big">{{ $ovAvailability }}</strong>
                    </div>

                </div>

                <div class="tw-info">
                    Status choices:
                    <strong>Approved · Rejected · Suspended · Pending</strong>.
                </div>

            </section>
        </div>
    </div>
</div>


{{-- APPROVE --}}
<div class="modal res-modal newqusmo instructionModal adminpasswordPopup" id="approveTutorModal">
    <div class="modal-dialog modal-dialog-centered instructionModal">
        <div class="modal-content instructionModal">
            <div class="modal-header instructionModal">
                <h4 class="modal-title passText">Confirmation</h4>
                <button type="button" class="close" onclick="ClosePopupModel(this)" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body instructionModal noinsBodyDev">
                <div class="divs">
                    <div class="appome_input form_box_area cls1">
                        <div class="gj_confirm_div">
                            <p class="gj_popup_text">Are you sure you want to approve this tutor?</p>
                        </div>
                    </div>
                </div>
                <input type="hidden" value="" name="tut_id" id="tut_id">
            </div>
            <div class="modal-footer adm_modal_Footer">
                <button type="button" class="btn btn-new btn-danger" onclick="approveTutorNow(this)" style="color:#b80f0a;">Yes</button>
                <button type="button" class="btn btn-new btn-danger popup_no" onclick="ClosePopupModel(this)" style="color:#b80f0a;">No</button>
            </div>
        </div>
    </div>
</div>

{{-- REJECT --}}
<div class="modal res-modal newqusmo instructionModal adminpasswordPopup" id="rejectTutorModal">
    <div class="modal-dialog modal-dialog-centered instructionModal">
        <div class="modal-content instructionModal">
            <div class="modal-header instructionModal">
                <h4 class="modal-title passText gj_modal_title">Confirmation</h4>
                <button type="button" class="close" onclick="ClosePopupModel(this)" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body instructionModal noinsBodyDev">
                <div class="divs">
                    <div class="appome_input form_box_area cls1">
                        <div class="gj_confirm_div">
                            <p class="gj_popup_text">Are you sure you want to reject this tutor?</p>
                        </div>
                        <div class="gj_submit_div">
                            <textarea class="form-control" name="reject_reason" id="reject_reason" placeholder="Enter your reason"></textarea>
                            <p class="reject_reason_error" style="color:#ef5350;"></p>
                            <button type="button" class="btn btn-new btn-danger" style="color:#b80f0a;" onclick="submitRejectFn(this)">Submit</button>
                        </div>
                    </div>
                </div>
                <input type="hidden" value="" name="rtut_id" id="rtut_id">
            </div>
            <div class="modal-footer adm_modal_Footer">
                <button type="button" class="btn btn-new btn-danger" style="color:#b80f0a;" onclick="yesRejectFn(this)">Yes</button>
                <button type="button" class="btn btn-new btn-danger popup_no" onclick="ClosePopupModel(this)" style="color:#b80f0a;">No</button>
            </div>
        </div>
    </div>
</div>

{{-- SUSPEND --}}
<div class="modal res-modal newqusmo instructionModal adminpasswordPopup" id="suspendTutorModal">
    <div class="modal-dialog modal-dialog-centered instructionModal">
        <div class="modal-content instructionModal">
            <div class="modal-header instructionModal">
                <h4 class="modal-title passText gj_modal_title">Confirmation</h4>
                <button type="button" class="close" onclick="ClosePopupModel(this)" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body instructionModal noinsBodyDev">
                <div class="divs">
                    <div class="appome_input form_box_area cls1">
                        <div class="gj_confirm_div">
                            <p class="gj_popup_text">Are you sure you want to suspend this tutor?</p>
                            <p class="gj_popup_warning">Warning: This action will disable the user’s ability to login. Consider the impact before proceeding.</p>
                        </div>
                        <div class="gj_submit_div">
                            <div class="gj_status_change_user"><span>Name: </span> <span>{{ @Auth::guard('admin')->user()->name }}</span></div>
                            <div class="gj_status_change_date"><span>Date: </span> <span>{{ date('d M Y') }}</span></div>
                            <textarea class="form-control" name="suspend_reason" id="suspend_reason" placeholder="Enter the reason"></textarea>
                            <p class="suspend_reason_error" style="color:#ef5350;"></p>
                            <button type="button" class="btn btn-new btn-danger" style="color:#b80f0a;" onclick="submitSuspendFn(this)">Submit</button>
                        </div>
                    </div>
                </div>
                <input type="hidden" value="" name="stut_id" id="stut_id">
            </div>
            <div class="modal-footer adm_modal_Footer">
                <button type="button" class="btn btn-new btn-danger" style="color:#b80f0a;" onclick="yesSuspendFn(this)">Yes</button>
                <button type="button" class="btn btn-new btn-danger popup_no" onclick="ClosePopupModel(this)" style="color:#b80f0a;">No</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('footer')
@include('admin.includes.footer')
@endsection

@section('script')
@include('admin.includes.script')

<script src="{{ public_asset('admin/assets/js/jquery.validate.js') }}"></script>

<script type="text/javascript">
    
    var tutorId = {{ (int) $user->id }};
    var csrfToken = '{{ csrf_token() }}';

    $(document).ready(function () {

        $('#featuredToggle').on('change', function () {

            var toggle = $(this);
            var tutor_id = toggle.data('id');
            var status = toggle.is(':checked') ? 1 : 0;

            $.ajax({
                url: "{{ route('update.featured.status') }}",
                type: "POST",
                data: {
                    _token: csrfToken,
                    tutor_id: tutor_id,
                    status: status
                },
                success: function(res) {
             
                if (res.status) {
                        $('#featuredText').text(status === 1 ? 'Yes' : 'No');
                        toastr.success(res.message);
                    } else {
                        toggle.prop('checked', !status);
                        toastr.error(res.message || 'Failed to update featured status');
                    }
                },
                error: function() {
                    toggle.prop('checked', !status);
                    toastr.error('Error updating featured status');
                }
            });
        });


        $('#freeTrialToggle').on('change', function () {

            var toggle = $(this);
            var status = toggle.is(':checked') ? 1 : 0;

            $.ajax({
                url: "{{ route('update.free.trail.status') }}",
                type: "POST",
                data: {
                    _token: csrfToken,
                    tutor_id: tutorId,
                    status: status
                },
                success: function (res) {

                if (res.status) {
                        $('#freeTrialText').text(status ? 'Yes' : 'No');
                        toastr.success(res.message);
                    } else {
                        toggle.prop('checked', !status);
                        toastr.error(res.message || 'Unable to update free trial status.');
                    }
                },
                error: function () {
                    toggle.prop('checked', !status);
                    toastr.error('Something went wrong!');
                }
            });
        });

    });

    $(document).on('click', '.js-status-action', function () {

    var status = $(this).data('status');

        if (status === 'approved') {
            $('#tut_id').val(tutorId);
            $('#approveTutorModal').modal('show');

        } else if (status === 'rejected') {
            $('#rtut_id').val(tutorId);
            $('#rejectTutorModal .gj_modal_title').text('Confirmation');
            $('#rejectTutorModal .adm_modal_Footer').show();
            $('#rejectTutorModal .gj_confirm_div').show();
            $('#rejectTutorModal .gj_submit_div').hide();
            $('#rejectTutorModal .reject_reason_error').hide();
            $('#rejectTutorModal').modal('show');

        } else if (status === 'suspended') {
            $('#stut_id').val(tutorId);
            $('#suspendTutorModal .gj_modal_title').text('Confirmation');
            $('#suspendTutorModal .adm_modal_Footer').show();
            $('#suspendTutorModal .gj_confirm_div').show();
            $('#suspendTutorModal .gj_submit_div').hide();
            $('#suspendTutorModal .suspend_reason_error').hide();
            $('#suspendTutorModal').modal('show');
        }
    });

    function ClosePopupModel(its) {
        $(its).closest('.modal').modal('hide');
    }

    function sendStatusChange(url, payload, newStatus) {
        $("#v_tutor_Loader").css("display", "flex");
        $.ajax({
            url: url,
            dataType: 'json',
            type: 'post',
            data: { 'jsonrpc': '2.0', '_token': csrfToken, 'data': payload },
            success: function (resp) {
                if (resp.status == 1) {
                    updateTutorStatus(newStatus);
                    toastr.success(resp.message);
                } else {
                    toastr.error(resp.message);
                }
            },
            error: function () {
                toastr.error("Something went wrong! Ajax error!");
            },
            complete: function () {
                $("#v_tutor_Loader").hide();
            }
        });
    }

    function approveTutorNow() {
        $('#approveTutorModal').modal('hide');
        sendStatusChange(
            "{{ route('ajax.status.change.user.approved') }}",
            { id: $('#tut_id').val() },
            'Approved'
        );
    }

    function yesRejectFn() {
        $('#rejectTutorModal .gj_modal_title').text('Reject this Tutor?');
        $('#rejectTutorModal .adm_modal_Footer').hide();
        $('#rejectTutorModal .gj_confirm_div').hide();
        $('#rejectTutorModal #reject_reason').val('');
        $('#rejectTutorModal .gj_submit_div').show();
        $('#rejectTutorModal .reject_reason_error').hide();
    }

    function submitRejectFn(its) {
        var reason = $.trim($('#reject_reason').val());
        if (!reason) {
            $('#rejectTutorModal .reject_reason_error').text('This field is required').show();
            return;
        }
        $(its).closest('.modal').modal('hide');
        sendStatusChange(
            "{{ route('ajax.status.change.user.rejected') }}",
            { id: $('#rtut_id').val(), reason: reason },
            'Rejected'
        );
    }

    function yesSuspendFn() {
        $('#suspendTutorModal .gj_modal_title').text('Reason to suspend');
        $('#suspendTutorModal .adm_modal_Footer').hide();
        $('#suspendTutorModal .gj_confirm_div').hide();
        $('#suspendTutorModal #suspend_reason').val('');
        $('#suspendTutorModal .gj_submit_div').show();
        $('#suspendTutorModal .suspend_reason_error').hide();
    }

    function submitSuspendFn(its) {
        var reason = $.trim($('#suspend_reason').val());
        if (!reason) {
            $('#suspendTutorModal .suspend_reason_error').text('This field is required').show();
            return;
        }
        $(its).closest('.modal').modal('hide');
        sendStatusChange(
            "{{ route('ajax.status.change.user.suspended') }}",
            { id: $('#stut_id').val(), reason: reason },
            'Suspended'
        );
    }

    function updateTutorStatus(status) {

        var statusClass = '';
        var badgeClass = '';
        var actions = '';

        if (status === 'Approved') {

            statusClass = 'approved';
            badgeClass = 'tw-st-done';
            actions += '<li><a href="javascript:void(0);" class="js-status-action" data-status="suspended">Suspend</a></li>';

        } else if (status === 'Pending') {

            statusClass = 'pending';
            badgeClass = 'tw-st-warn';
            actions += '<li><a href="javascript:void(0);" class="js-status-action" data-status="approved">Approve</a></li>';
            actions += '<li><a href="javascript:void(0);" class="js-status-action" data-status="rejected">Reject</a></li>';

        } else if (status === 'Rejected') {

            statusClass = 'rejected';
            badgeClass = 'tw-st-bad';

        } else if (status === 'Suspended') {

            statusClass = 'suspended';
            badgeClass = 'tw-st-warn';
            actions += '<li><a href="javascript:void(0);" class="js-status-action" data-status="approved">Approve</a></li>';
        }

        $('#tutorStatusText').text(status);

        $('.tw-profile-sub .tw-badge')
            .removeClass('approved pending rejected suspended')
            .addClass(statusClass)
            .text(status);

        $('.tw-ov-grid').first().find('.tw-ov-card:first .tw-status')
            .removeClass('tw-st-done tw-st-warn tw-st-bad tw-st-neutral')
            .addClass(badgeClass)
            .text(status);

        $('#tutorStatusActions').html(actions);
    }
</script>
@endsection