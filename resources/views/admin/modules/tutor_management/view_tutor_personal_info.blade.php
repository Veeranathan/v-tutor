@extends('admin.layouts.app')
@section('title')
Personal Details
@endsection
@section('links')
@include('admin.includes.links')
<style type="text/css">
    .buttons-excel {
        display: none;
    }

    :root {
        --tw-primary: #d71f3e;
        --tw-primary-soft: #fdebee;
        --tw-ink: #1b2437;
        --tw-muted: #6b7488;
        --tw-border: #e6e9f0;
        --tw-bg: #f6f7fb;
        --tw-radius: 12px;
    }

    .tw-page {
        background: var(--tw-bg);
    }

    .tw-head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 18px;
    }

    .tw-head h1 {
        margin: 0;
        font-size: 26px;
        font-weight: 700;
        color: var(--tw-ink);
    }

    .tw-head .small_tag {
        margin: 4px 0 0;
        color: var(--tw-muted);
        font-size: 13px;
    }

    .tw-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .tw-actions .btn {
        border-radius: 8px;
        background: #fff !important;
        color: var(--tw-ink);
        font-weight: 600;
        font-size: 13px;
        padding: 7px 14px;
    }

    .tw-card {
        background: #fff;
        border: 1px solid var(--tw-border);
        border-radius: var(--tw-radius);
        padding: 20px 22px;
        margin-bottom: 18px;
        box-shadow: 0 1px 2px rgba(27, 36, 55, .04);
    }

    .tw-card-title {
        margin: 0 0 14px;
        font-size: 16px;
        font-weight: 700;
        color: var(--tw-ink);
    }

    .tw-profile {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

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

    .tw-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .tw-profile-name {
        margin: 0;
        font-size: 20px;
        font-weight: 700;
        color: var(--tw-ink);
    }

    .tw-profile-sub {
        color: var(--tw-muted);
        font-size: 13px;
        margin-top: 2px;
    }

    .tw-meta {
        display: flex;
        flex-wrap: wrap;
        margin-left: auto;
    }

    .tw-meta-item {
        padding: 0 24px;
        border-left: 1px solid var(--tw-border);
    }

    .tw-meta-item span {
        display: block;
        font-size: 12px;
        color: var(--tw-muted);
    }

    .tw-meta-item strong {
        font-size: 14px;
        color: var(--tw-ink);
    }

    .tw-layout {
        display: flex;
        gap: 18px;
        align-items: stretch;
    }

    .tw-side {
        width: 250px;
        flex-shrink: 0;
        align-self: stretch;
    }

    .tw-section-title {
        margin: 0;
        font-size: 22px;
        font-weight: 700;
        color: var(--tw-ink);
    }

    .tw-section-sub {
        margin: 4px 0 18px;
        color: var(--tw-muted);
        font-size: 13px;
    }

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

    .tw-badge.approved {
        background: #dcf5e4;
        color: #1a7a3c;
    }

    .tw-badge.pending {
        background: #fff3d6;
        color: #a86b00;
    }

    .tw-badge.rejected {
        background: #fde2e5;
        color: #b4152f;
    }

    .tw-main {
        flex: 1;
        min-width: 0;
    }

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

    .tw-nav li {
        margin: 0 0 2px;
    }

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

    .tw-nav li a span {
        display: inline-flex;
        width: 18px;
    }

    .tw-nav li a span img {
        width: 16px;
        height: auto;
    }

    .tw-nav li a .accth {
        display: none;
    }

    .tw-nav li a:hover,
    .tw-nav li.active a {
        background: var(--tw-primary-soft);
        color: var(--tw-primary);
        border-left-color: var(--tw-primary);
    }

    .tw-nav li a:hover .actt,
    .tw-nav li.active a .actt {
        display: none;
    }

    .tw-nav li a:hover .accth,
    .tw-nav li.active a .accth {
        display: inline;
    }

    .tw-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 18px;
    }

    .tw-grid .tw-card {
        margin-bottom: 0;
    }

    .tw-grid-wrap {
        margin-bottom: 18px;
    }

    .tw-list {
        margin: 0;
    }

    .tw-row {
        display: flex;
        padding: 10px 0;
        border-bottom: 1px solid var(--tw-border);
        font-size: 14px;
    }

    .tw-row:last-child {
        border-bottom: 0;
    }

    .tw-row dt {
        width: 40%;
        font-weight: 600;
        color: var(--tw-ink);
    }

    .tw-row dd {
        margin: 0;
        flex: 1;
        color: #3b4458;
        word-break: break-word;
    }

    .tw-addr {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        column-gap: 28px;
    }

    .tw-text {
        margin: 0;
        color: #3b4458;
        line-height: 1.7;
        font-size: 14px;
    }

    @media (max-width: 991px) {
        .tw-layout {
            flex-direction: column;
        }

        .tw-side {
            width: 100%;
        }

        .tw-nav {
            display: flex;
            overflow-x: auto;
            white-space: nowrap;
            gap: 4px;
            height: auto;
            min-height: 0;
        }

        .tw-nav li {
            margin: 0;
        }

        .tw-meta {
            margin-left: 0;
            width: 100%;
        }

        .tw-meta-item:first-child {
            border-left: 0;
            padding-left: 0;
        }
    }

    @media (max-width: 575px) {
        .tw-addr {
            grid-template-columns: 1fr;
        }

        .tw-row {
            flex-direction: column;
        }

        .tw-row dt {
            width: 100%;
            margin-bottom: 2px;
        }
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

// Status: map your stored value => [label, css class]
if ($user->status == 'A' && $user->subscription == 'S' && $user->draft == 'N') {
$statusLabel = 'Approved';
$statusClass = 'approved';
} elseif ($user->status == 'A') {
$statusLabel = 'Pending';
$statusClass = 'pending';
} elseif ($user->status == 'I') {
$statusLabel = 'Suspended';
$statusClass = 'suspended';
} elseif ($user->status == 'R') {
$statusLabel = 'Rejected';
$statusClass = 'rejected';
} else {
$statusLabel = '—';
$statusClass = '';
}


$subjectsText = collect(@$tutor_subjects)->pluck('name')->filter()->implode(', ');

$availabilityText = @$user->availability_status ? 'Yes' : 'No';

$navUrl = function ($name) use ($user) {
return \Illuminate\Support\Facades\Route::has($name) ? route($name, $user->id) : 'javascript:void(0);';
};
$navItems = [
['Overview', 'view.tutor.overview', 'peri.png', 'perih.png', false],
['Personal Details', 'view.tutor.personal.info.step.1', 'peri.png', 'perih.png', true],
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

        {{-- Profile summary --}}
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

            {{-- Side navigation (same routes as before) --}}
            <aside class="tw-side">
                <a href="javascript:void(0);" id="clickHere" data-toggle="modal" data-target="#instructionModal" style="display:none;">Click</a>
                <ul class="tw-nav">
                    @foreach($navItems as [$label, $routeName, $icon, $iconHover, $isActive])
                    <li class="{{ $isActive ? 'active' : '' }}">
                        <a href="{{ $navUrl($routeName) }}">
                            <span><img src="{{ public_asset('admin/assets/images/' . $icon) }}" class="actt"><img src="{{ public_asset('admin/assets/images/' . $iconHover) }}" class="accth"></span>
                            {{ $label }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </aside>

            {{-- Main content --}}
            <section class="tw-main">

                <h2 class="tw-section-title">Personal Details</h2>
                <p class="tw-section-sub">Read-only tutor-submitted personal information.</p>

                <div class="tw-grid tw-grid-wrap">
                    {{-- Identity --}}
                    <div class="tw-card">
                        <h3 class="tw-card-title gj_pd_hd">Identity Information</h3>
                        <dl class="tw-list">
                            <div class="tw-row">
                                <dt>First Name</dt>
                                <dd>{{ @$user->f_name ?: '—' }}</dd>
                            </div>
                            <div class="tw-row">
                                <dt>Middle Name</dt>
                                <dd>{{ @$user->m_name ?: '—' }}</dd>
                            </div>
                            <div class="tw-row">
                                <dt>Last Name</dt>
                                <dd>{{ @$user->l_name ?: '—' }}</dd>
                            </div>
                            <div class="tw-row">
                                <dt>Nationality</dt>
                                <dd>{{ @$user->nationality ?: '—' }}</dd>
                            </div>
                        </dl>
                    </div>

                    {{-- Contact --}}
                    <div class="tw-card">
                        <h3 class="tw-card-title">Contact Information</h3>
                        <dl class="tw-list">
                            <div class="tw-row">
                                <dt>Primary Email</dt>
                                <dd>{{ @$user->email ?: '—' }}</dd>
                            </div>
                            <div class="tw-row">
                                <dt>Primary Phone</dt>
                                <dd>{{ @$user->phone ?: '—' }}</dd>
                            </div>
                            <div class="tw-row">
                                <dt>Time Zone</dt>
                                <dd>{{ @$user->timezone_id ?: '—' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                {{-- Residential address --}}
                <div class="tw-card">
                    <h3 class="tw-card-title gj_res_addr_hd">Residential Address</h3>
                    <dl class="tw-list tw-addr">
                        <div class="tw-row">
                            <dt>Street</dt>
                            <dd>{{ @$user->address ?: '—' }}</dd>
                        </div>
                        <div class="tw-row">
                            <dt>Suburb</dt>
                            <dd>{{ @$user->city ?: '—' }}</dd>
                        </div>
                        <div class="tw-row">
                            <dt>State / Territory</dt>
                            <dd>{{ @$user->getState->state_name ?: '—' }}</dd>
                        </div>
                        <div class="tw-row">
                            <dt>Postcode</dt>
                            <dd>{{ @$user->zip ?: '—' }}</dd>
                        </div>
                        <div class="tw-row">
                            <dt>Country</dt>
                            <dd>{{ 'Australia' }}</dd>
                        </div>
                    </dl>
                </div>

                {{-- About Tutor + Teaching Philosophy (side by side) --}}
                <div class="tw-grid tw-grid-wrap">
                    <div class="tw-card">
                        <h3 class="tw-card-title">About Tutor</h3>
                        <p class="tw-text">{{ @$user->about_me ?: '—' }}</p>
                    </div>

                    <div class="tw-card">
                        <h3 class="tw-card-title">Teaching Philosophy</h3>
                        {{-- TODO: confirm field name (assumed: teaching_philosophy) --}}
                        <p class="tw-text">{{ @$user->teaching_philosophy ?: '—' }}</p>
                    </div>
                </div>

            </section>
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
@endsection