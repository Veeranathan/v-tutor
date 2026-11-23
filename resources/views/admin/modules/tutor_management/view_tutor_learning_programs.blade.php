@extends('admin.layouts.app')
@section('title')
Learning Programs
@endsection
@section('links')
@include('admin.includes.links')
<link rel="stylesheet" type="text/css" href="{{ public_asset('admin/assets/libs/css/chosen.css') }}">
<style type="text/css">
    :root {
        --tw-primary: #d71f3e;
        --tw-primary-dark: #b4152f;
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

    .tw-breadcrumb {
        font-size: 13px;
        color: var(--tw-muted);
        margin-bottom: 6px;
    }

    .tw-breadcrumb a {
        color: var(--tw-muted);
        text-decoration: none;
    }

    .tw-breadcrumb a:hover {
        color: var(--tw-primary);
    }

    .tw-breadcrumb span {
        margin: 0 6px;
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
        padding: 8px 16px;
    }

    .tw-card {
        background: #fff;
        border: 1px solid var(--tw-border);
        border-radius: var(--tw-radius);
        padding: 20px 22px;
        margin-bottom: 18px;
        box-shadow: 0 1px 2px rgba(27, 36, 55, .04);
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

    .tw-main {
        flex: 1;
        min-width: 0;
    }

    /* ---------- Status badge ---------- */
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

    /* ---------- Section heading + Add button ---------- */
    .tw-section-head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 16px;
    }

    .tw-section-title {
        margin: 0;
        font-size: 22px;
        font-weight: 700;
        color: var(--tw-ink);
    }

    .tw-section-sub {
        margin: 4px 0 0;
        color: var(--tw-muted);
        font-size: 13px;
    }

    .tw-btn-primary {
        background: var(--tw-primary);
        border: 1px solid var(--tw-primary);
        color: #fff;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 700;
        padding: 10px 20px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .tw-btn-primary:hover,
    .tw-btn-primary:focus {
        background: var(--tw-primary-dark);
        border-color: var(--tw-primary-dark);
        color: #fff;
    }

    /* ---------- Admin privileges notice ---------- */
    .tw-notice {
        display: flex;
        align-items: center;
        gap: 12px;
        background: #e9ebfb;
        border: 1px solid #c9cdf2;
        border-radius: 10px;
        padding: 11px 16px;
        margin-bottom: 18px;
        font-size: 13px;
        font-weight: 600;
        color: #2a3a78;
    }

    .tw-notice i {
        font-size: 20px;
        color: #2a3a78;
    }

    /* ---------- Chips row ---------- */
    .tw-chips {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 14px;
    }

    .tw-chip-list {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .tw-chip {
        border: 0;
        border-radius: 20px;
        padding: 6px 14px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        background: var(--tw-primary-soft);
        color: var(--tw-primary);
        transition: box-shadow .15s;
    }

    .tw-chip.tw-chip-total {
        background: #e3e9fb;
        color: #2a3a78;
    }

    .tw-chip.active {
        box-shadow: 0 0 0 2px var(--tw-primary);
    }

    .tw-chip.tw-chip-total.active {
        box-shadow: 0 0 0 2px #2a3a78;
    }

    .tw-readonly {
        font-size: 12px;
        color: var(--tw-muted);
    }

    /* ---------- Table ---------- */
    .tw-table-card {
        padding: 0 22px 22px;
    }

    .tw-table-card .table-responsive {
        border: 0;
        margin-bottom: 0;
    }

    #lpTable {
        width: 100%;
        border: 0;
        margin-bottom: 0;
    }

    #lpTable thead th {
        background: #eef1f8;
        color: var(--tw-ink);
        font-size: 13px;
        font-weight: 700;
        border: 0;
        border-bottom: 1px solid var(--tw-border);
        padding: 13px 12px;
        white-space: nowrap;
    }

    #lpTable tbody td {
        border: 0;
        border-bottom: 1px solid var(--tw-border);
        padding: 13px 12px;
        font-size: 14px;
        color: #3b4458;
        vertical-align: middle;
    }

    #lpTable tbody tr:hover {
        background: var(--tw-primary-soft);
    }

    .tw-empty {
        text-align: center;
        color: var(--tw-muted);
        padding: 28px 0 !important;
    }

    .tw-btn-remove {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #fff;
        color: var(--tw-primary);
        border: 1px solid #f3b9c3;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 700;
        padding: 6px 14px;
    }

    .tw-btn-remove:hover {
        background: var(--tw-primary-soft);
        border-color: var(--tw-primary);
        color: var(--tw-primary);
    }

    .tw-foot-note {
        text-align: right;
        font-size: 11px;
        letter-spacing: .4px;
        color: #9aa2b4;
        text-transform: uppercase;
        margin: 0;
    }

    /* ---------- Modals ---------- */
    .tw-modal .modal-content {
        border-radius: 12px;
        border: 0;
    }

    .tw-modal .modal-title {
        font-weight: 700;
        color: var(--tw-ink);
        font-size: 18px;
    }

    .tw-modal label {
        font-weight: 600;
        font-size: 13px;
        color: var(--tw-ink);
    }

    .tw-modal .form-control {
        border-radius: 8px;
        border-color: var(--tw-border);
        height: 40px;
    }

    /* ---------- Responsive ---------- */
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
        .tw-btn-primary {
            width: 100%;
            justify-content: center;
        }

        .tw-foot-note {
            text-align: left;
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
$activeRoute = 'view.tutor.learning.programs';
$fullName = trim(implode(' ', array_filter([@$user->f_name, @$user->m_name, @$user->l_name])));
$initials = strtoupper(mb_substr((string) @$user->f_name, 0, 1) . mb_substr((string) @$user->l_name, 0, 1));

$tutorCode = @$user->tutor_id ?: 'TUT' . str_pad((string) @$user->id, 6, '0', STR_PAD_LEFT);

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
['Overview', 'view.tutor.overview', 'peri.png', 'perih.png'],
['Personal Details', 'view.tutor.personal.info.step.1', 'peri.png', 'perih.png'],
['Tutorship Plan', 'view.tutor.tutorship.plans', 'gar.png', 'garh.png'],
['Academics', 'view.tutor.academics', 'aca.png', 'acah.png'],
['Work Experience', 'view.tutor.experience', 'ex.png', 'exh.png'],
['Recognitions', 'view.tutor.recognitions', 'rec.png', 'rech.png'],
['Right to Work', 'view.tutor.right.to.work', 'rec.png', 'rech.png'],
['Availability', 'view.tutor', 'rec.png', 'checked.png'],
['Learning Programs', 'view.tutor.learning.programs', 'aca.png', 'acah.png'],
['Public Profile', 'view.tutor.public.profile', 'peri.png', 'perih.png'],
];


$programs = collect(@$learning_programs);
$programTypes = $programs->pluck('type')->filter()->unique()->values();
@endphp
<div class="content tw-page">
    <div class="wraper container-fluid">

        {{-- Page header --}}
        <div class="tw-head">
            <div>
                <div class="tw-breadcrumb">
                    <a href="javascript:void(0);">Tutor Management</a><span>/</span>
                    <a href="{{ \Illuminate\Support\Facades\Route::has('manage.tutors') ? route('manage.tutors') : 'javascript:void(0);' }}">Tutor Directory</a><span>/</span>
                    Tutor Workspace
                </div>
                <h1>Tutor Workspace</h1>
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
                    <img src="{{ URL::to('storage/teacher_profile_pic/'.@$user->profile_pic) }}" alt="{{ $fullName }}">
                    @elseif(@$user->avatar)
                    <img src="{{ @$user->avatar }}" alt="{{ $fullName }}">
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
                        <strong>{{ $subjectsText ?: '—' }}</strong>
                    </div>
                    <div class="tw-meta-item">
                        <span>State</span>
                        <strong>{{ @$user->getState->state_name ?: '—' }}</strong>
                    </div>
                    <div class="tw-meta-item">
                        <span>Availability</span>
                        <strong>{{ $availabilityText }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="tw-layout">

            <aside class="tw-side">
                <ul class="tw-nav">
                    @foreach($navItems as [$label, $routeName, $icon, $iconHover])
                    <li class="{{ $routeName === $activeRoute ? 'active' : '' }}">
                        <a href="{{ $navUrl($routeName) }}">
                            <span><img src="{{ public_asset('admin/assets/images/' . $icon) }}" class="actt"><img src="{{ public_asset('admin/assets/images/' . $iconHover) }}" class="accth"></span>
                            {{ $label }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </aside>

            <section class="tw-main">
                <div class="tw-card">

                    <div class="tw-section-head">
                        <div>
                            <h2 class="tw-section-title">Learning Programs</h2>
                            <p class="tw-section-sub">Approved Managed Learning Programs the tutor can support.</p>
                        </div>
                      
                    </div>

                    <div class="tw-notice">
                        <i class="fas fa-shield-alt"></i>
                        <span>Admin Privileges: As an admin, you can add or remove learning programs for this tutor.</span>
                    </div>

                    <div class="tw-chips">
                        <div class="tw-chip-list">
                            <button type="button" class="tw-chip tw-chip-total active" data-type="">{{ $programs->count() }} Programs</button>
                            @foreach($programTypes as $type)
                            <button type="button" class="tw-chip" data-type="{{ $type }}">{{ $type }}</button>
                            @endforeach
                        </div>
                        <span class="tw-readonly">Read-only association records</span>
                    </div>

                    {{-- Table --}}
                    <div class="table-responsive">
                        <table class="table" id="lpTable">
                            <thead>
                                <tr>
                                    <th>Learning Program</th>
                                    <th>Type</th>
                                    <th>Subject</th>
                                    <th>Year Levels</th>
                                  
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($programs as $program)
                                @php
                                $pKey = strtolower((string) data_get($program, 'status'));
                                $pLabel = $statusMap[$pKey][0] ?? ucfirst($pKey ?: '—');
                                $pClass = $statusMap[$pKey][1] ?? '';
                                @endphp
                                <tr data-type="{{ data_get($program, 'type') }}">
                                    <td>{{ data_get($program, 'name') }}</td>
                                    <td>{{ data_get($program, 'type') }}</td>
                                    <td>{{ data_get($program, 'subject') }}</td>
                                    <td>{{ data_get($program, 'year_levels') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="tw-empty">No learning programs linked to this tutor.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
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
<script>
    $(document).ready(function() {

        $('.tw-chip').on('click', function() {
            var type = $(this).data('type');

            $('.tw-chip').removeClass('active');
            $(this).addClass('active');

            $('#lpTable tbody tr[data-type]').each(function() {
                $(this).toggle(type === '' || $(this).data('type') === type);
            });
        });

    });
</script>
@endsection