@extends('admin.layouts.app')
@section('title')
Public Profile
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

    /* ---------- Vertical tab nav (replaces .step_tab) ---------- */
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

    /* ---------- Key / value rows ---------- */
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

    .tw-alert {
        display: flex;
        gap: 12px;
        align-items: flex-start;
        background: #eaf0ff;
        color: #243b86;
        border: 1px solid #d3deff;
        border-radius: 10px;
        padding: 12px 16px;
        margin-bottom: 16px;
        font-size: 13px;
        line-height: 1.6;
    }

    .tw-alert i {
        margin-top: 3px;
        color: #2a47a8;
        font-size: 16px;
    }

    .tw-pp-card {
        background: #fff;
        border: 1px solid var(--tw-border);
        border-radius: 12px;
        padding: 14px 18px 16px;
        margin-bottom: 14px;
    }

    .tw-pp-head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 10px;
    }

    .tw-pp-title {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
        color: var(--tw-ink);
    }

    .tw-pp-desc {
        margin: 2px 0 0;
        font-size: 12px;
        color: var(--tw-muted);
    }

    .tw-pp-actions {
        display: flex;
        gap: 8px;
        flex-shrink: 0;
    }

    .tw-pp-note {
        font-size: 12px;
        font-weight: 600;
        color: var(--tw-muted);
        white-space: nowrap;
    }

    .tw-btn-light,
    .tw-btn-red,
    .tw-btn-red-outline {
        height: 34px;
        padding: 0 16px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        white-space: nowrap;
    }

    .tw-btn-light {
        background: #fff;
        border: 1px solid var(--tw-border);
        color: var(--tw-ink);
    }

    .tw-btn-light:hover {
        border-color: #b9c0d0;
    }

    .tw-btn-red {
        background: var(--tw-primary);
        border: 1px solid var(--tw-primary);
        color: #fff;
    }

    .tw-btn-red:hover {
        background: #b9142f;
        border-color: #b9142f;
    }

    .tw-btn-red-outline {
        background: #fff;
        border: 1px solid var(--tw-primary);
        color: var(--tw-primary);
    }

    .tw-btn-red-outline:hover {
        background: var(--tw-primary-soft);
    }

    .tw-btn-red:disabled,
    .tw-btn-red-outline:disabled {
        opacity: .5;
        cursor: not-allowed;
    }

    .tw-input {
        width: 100%;
        height: 38px;
        padding: 0 12px;
        border: 1px solid var(--tw-border);
        border-radius: 8px;
        font-size: 14px;
        color: var(--tw-ink);
        background: #fff;
    }

    .tw-input[readonly] {
        background: #fbfcff;
    }

    .tw-input:focus {
        outline: 0;
        border-color: var(--tw-primary);
        box-shadow: 0 0 0 3px rgba(215, 31, 62, .12);
    }

    .tw-textarea {
        width: 100%;
        min-height: 130px;
        padding: 10px 12px;
        border: 1px solid var(--tw-border);
        border-radius: 8px;
        font-family: inherit;
        font-size: 14px;
        line-height: 1.7;
        color: var(--tw-ink);
        background: #fff;
        resize: vertical;
        display: block;
    }

    .tw-textarea[readonly] {
        background: #fbfcff;
        resize: none;
    }

    .tw-textarea:focus {
        outline: 0;
        border-color: var(--tw-primary);
        box-shadow: 0 0 0 3px rgba(215, 31, 62, .12);
    }

    .tw-counter {
        margin: 6px 0 0;
        font-size: 12px;
        color: var(--tw-muted);
        text-align: right;
    }

    .tw-pill {
        display: inline-block;
        padding: 3px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        margin-left: 8px;
        vertical-align: middle;
    }

    .tw-pill-optional {
        background: #eef0f5;
        color: var(--tw-muted);
    }

    .tw-pill-linked {
        background: #dcf5e4;
        color: #1a7a3c;
        margin-left: 0;
    }

    .tw-pill-none {
        background: #eef0f5;
        color: var(--tw-muted);
        margin-left: 0;
    }

    /* Video block */
    .tw-video-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.15fr) minmax(0, 1fr);
        gap: 20px;
        align-items: start;
    }

    .tw-video-box {
        position: relative;
        width: 100%;
        padding-top: 56.25%;
        border-radius: 12px;
        overflow: hidden;
        background: linear-gradient(135deg, #0f1730, #1d2a52);
    }

    .tw-video-box iframe,
    .tw-video-empty {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: 0;
    }

    .tw-video-empty {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        color: #c9d2ec;
        font-size: 13px;
        gap: 10px;
    }

    .tw-video-empty i {
        font-size: 40px;
        color: #fff;
        opacity: .85;
    }

    .tw-video-caption {
        margin: 8px 0 0;
        font-size: 12px;
        color: var(--tw-muted);
    }

    .tw-video-title {
        margin: 0 0 10px;
        font-size: 15px;
        font-weight: 700;
        color: var(--tw-ink);
    }

    .tw-video-btns {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin: 12px 0 10px;
    }

    .tw-help {
        margin: 0;
        font-size: 12px;
        line-height: 1.6;
        color: var(--tw-muted);
    }

    @media (max-width: 991px) {
        .tw-video-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 575px) {
        .tw-pp-actions {
            width: 100%;
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
['Personal Details', 'view.tutor.personal.info.step.1', 'peri.png', 'perih.png', false],
['Tutorship Plan', 'view.tutor.tutorship.plans', 'gar.png', 'garh.png', false],
['Academics', 'view.tutor.academics', 'aca.png', 'acah.png', false],
['Experience', 'view.tutor.experience', 'ex.png', 'exh.png', false],
['Recognitions', 'view.tutor.recognitions', 'rec.png', 'rech.png', false],
['Right to Work', 'view.tutor.right.to.work', 'rec.png', 'rech.png', false],
['Availability', 'view.tutor', 'rec.png', 'checked.png', false],
['Learning Programs', 'view.tutor.learning.programs', 'aca.png', 'acah.png', false],
['Public Profile', 'view.tutor.public.profile', 'peri.png', 'perih.png', true],
];
@endphp
<div class="content tw-page">
    <div class="wraper container-fluid">

        {{-- Page header + actions --}}
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

                <h2 class="tw-section-title">Public Profile</h2>
                <p class="tw-section-sub">Public-facing presentation details. Admin can manage only the optional YouTube introduction video.</p>

                @php
                $ppSkillTag = @$skill_tag;
                $ppCapability = @$capability_statement ?: '';
                $ppVideoUrl = @$video_url;

                $ppCapabilityText = preg_replace('~<\s*br\s* /?\s*>|</\s*(p|div|li|h[1-6])\s*>~i', "\n", (string) $ppCapability);
                    $ppCapabilityText = html_entity_decode(strip_tags($ppCapabilityText), ENT_QUOTES, 'UTF-8');
                    $ppCapabilityText = trim(preg_replace("~\n{3,}~", "\n\n", $ppCapabilityText));

                    $ppVideoId = null;
                    if ($ppVideoUrl && preg_match('~^(?:https?://)?(?:www\.|m\.)?(?:youtube\.com/(?:watch\?(?:.*&)?v=|embed/|shorts/)|youtu\.be/)([A-Za-z0-9_-]{11})(?:[&?#/].*)?$~i', trim($ppVideoUrl), $ppMatch)) {
                    $ppVideoId = $ppMatch[1];
                    }

                    $ppSaveRouteName = 'save.tutor.skills.capability';
                    $ppSaveUrl = \Illuminate\Support\Facades\Route::has($ppSaveRouteName) ? route($ppSaveRouteName) : '';
                    @endphp

                    {{-- Routes used by the buttons below --}}
                    <div id="ppConfig"
                        data-save="{{ route('admin.tutor.details.save') }}"
                        data-tutor="{{ $user->id }}">
                    </div>

                    <div class="tw-alert">
                        <i class="fas fa-info-circle"></i>
                        <div><strong>Admin Permissions:</strong> Admins can enter, edit, or replace the Skill Tag and Capability Statement, and manage the YouTube introduction video (upload, update, or remove).</div>
                    </div>

                    {{-- Skill Tag --}}
                    <div class="tw-pp-card">
                        <div class="tw-pp-head">
                            <div>
                                <h3 class="tw-pp-title">Skill Tag</h3>
                                <p class="tw-pp-desc">Enter, edit, or replace the tutor's skill tag (a short, public-facing descriptor).</p>
                            </div>
                            <div class="tw-pp-actions">
                                <button type="button" class="tw-btn-light" id="editSkillTag"><i class="fas fa-pen"></i> Edit</button>
                                <button type="button" class="tw-btn-red" id="saveSkillTag">Save Changes</button>
                            </div>
                        </div>
                        <input type="text" class="tw-input" id="skill_tag" maxlength="80" value="{{ $ppSkillTag }}" placeholder="e.g. Mathematics &amp; English Learning Specialist" readonly>
                    </div>

                    <div class="tw-pp-card">
                        <div class="tw-pp-head">
                            <div>
                                <h3 class="tw-pp-title">Capability Statement</h3>
                                <p class="tw-pp-desc">Enter, edit, or replace the tutor's capability statement (a concise summary of their strengths and teaching focus).</p>
                            </div>
                            <div class="tw-pp-actions">
                                <button type="button" class="tw-btn-light" id="editCapability"><i class="fas fa-pen"></i> Edit</button>
                                <button type="button" class="tw-btn-red" id="saveCapability">Save Changes</button>
                            </div>
                        </div>
                        <textarea class="tw-textarea" id="capability_text" rows="5" maxlength="2000" placeholder="Write a concise summary of the tutor's strengths and teaching focus..." readonly>{{ $ppCapabilityText }}</textarea>
                        <p class="tw-counter"><span id="capCount">0</span> / 2000</p>
                    </div>

                    <div class="tw-pp-card">
                        <div class="tw-pp-head" style="margin-bottom:4px;">
                            <h3 class="tw-pp-title">Teaching Philosophy</h3>
                            <span class="tw-pp-note">Read only · Tutor-managed</span>
                        </div>
                        <p class="tw-text">{{ @$user->teaching_philosophy ?: '—' }}</p>
                    </div>

                    <div class="tw-pp-card">
                        <div class="tw-pp-head">
                            <h3 class="tw-pp-title">YouTube Introduction Video <span class="tw-pill tw-pill-optional">Optional</span></h3>
                            @if($ppVideoUrl)
                            <span class="tw-pill tw-pill-linked">Video linked</span>
                            @else
                            <span class="tw-pill tw-pill-none">No video</span>
                            @endif
                        </div>

                        <div class="tw-video-grid">
                            <div>
                                <div class="tw-video-box">
                                    @if($ppVideoId)
                                    <iframe src="https://www.youtube.com/embed/{{ $ppVideoId }}" title="Introduction video preview" allowfullscreen loading="lazy"></iframe>
                                    @elseif($ppVideoUrl)
                                    <div class="tw-video-empty"><i class="fab fa-youtube"></i><span>Preview is available for YouTube links only</span></div>
                                    @else
                                    <div class="tw-video-empty"><i class="fab fa-youtube"></i><span>No introduction video linked</span></div>
                                    @endif
                                </div>
                                <p class="tw-video-caption">Introduction video preview</p>
                            </div>

                            <div>
                                <h4 class="tw-video-title">Tutor Introduction – {{ $fullName ?: 'Tutor' }}</h4>
                                <input type="url" class="tw-input" id="profile_video" value="{{ $ppVideoUrl }}" placeholder="https://www.youtube.com/watch?v=...">
                                <div class="tw-video-btns">
                                    <button type="button" class="tw-btn-red" id="saveVideo">Upload / Update Video</button>
                                    <button type="button" class="tw-btn-red-outline" id="removeVideo" {{ $ppVideoUrl ? '' : 'disabled' }}>Remove Video</button>
                                </div>
                                <p class="tw-help">Use a validated YouTube URL. Hide this block on the public profile when no video is linked.</p>
                            </div>
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
<script type="text/javascript">
    $(document).ready(function() {

        var cfg = $('#ppConfig').data();
        var csrf = '{{ csrf_token() }}';

        var $capability = $('#capability_text');
        var $skill = $('#skill_tag');


        function notify(ok, msg) {

            if (window.toastr) {
                ok ? toastr.success(msg) : toastr.error(msg);
            } else {
                alert(msg);
            }

        }

       
        function post(url, data, done) {

            if (!url) {
                notify(false, 'Save route is not configured.');
                return;
            }

            data._token = csrf;

            $.ajax({

                url: url,
                type: 'POST',
                dataType: 'json',
                data: data,

                success: function(r) {

                    var ok = (r.success === true || r.status == 1);

                    notify(
                        ok,
                        r.message || (ok ? 'Saved successfully.' : 'Something went wrong!')
                    );

                    if (ok && done) {
                        done(r);
                    }

                },

                error: function(xhr) {

                    var message = 'Something went wrong! Please try again.';

                    if (xhr.responseJSON) {

                        if (xhr.responseJSON.errors) {

                            message = $.map(xhr.responseJSON.errors, function(v) {
                                return v[0];
                            })[0];

                        } else if (xhr.responseJSON.message) {

                            message = xhr.responseJSON.message;

                        }

                    }

                    notify(false, message);

                }

            });

        }


        $('#editSkillTag').on('click', function() {

            $skill.prop('readonly', false).focus();

        });


        function updateCount() {
            $('#capCount').text($capability.val().length);
        }

        updateCount();

        $capability.on('input', updateCount);

        $('#editCapability').on('click', function() {

            $capability.prop('readonly', false).focus();

        });


        function getProfileData() {

            var skill = $.trim($skill.val());

            var caps = $.trim($capability.val());

            var videoUrl = $.trim($('#profile_video').val());


            if (caps.length > 600) {

                notify(false, 'Capability Statement maximum is 600 characters.');

                return false;

            }

            return {
                tutor_id: cfg.tutor,
                skills: skill,
                capabilities: caps,
                profile_video: videoUrl
            };

        }

        function savePublicProfile(done) {

            var data = getProfileData();

            if (!data) {
                return;
            }

            post(cfg.save, data, done);

        }

        
        function saveSkillTag() {

            var skill = $.trim($skill.val());

            if (skill === '') {
                notify(false, 'Please enter Skill Tag.');
                return;
            }

            post(cfg.save, {
                tutor_id: cfg.tutor,
                skills: skill
            }, function() {
                $skill.prop('readonly', true);
            });
        }


        function saveCapability() {

            var caps = $.trim($capability.val());

            if (caps === '') {
                notify(false, 'Please enter Capability Statement.');
                return;
            }

            if (caps.length > 600) {
                notify(false, 'Capability Statement maximum is 600 characters.');
                return;
            }

            post(cfg.save, {
                tutor_id: cfg.tutor,
                capabilities: caps
            }, function() {
                $capability.prop('readonly', true);
            });
        }


       
            $('#saveSkillTag').on('click', function() {
                saveSkillTag();
            });


            $('#saveCapability').on('click', function() {
                saveCapability();
            });

        $('#saveVideo').on('click', function() {

            var videoUrl = $.trim($('#profile_video').val());

            if (videoUrl === '') {

                notify(false, 'Please enter a YouTube URL.');

                return;

            }

            var youtubePattern =
                /^(https?:\/\/)?(www\.)?(youtube\.com\/(watch\?v=|embed\/|shorts\/)|youtu\.be\/)[a-zA-Z0-9_-]{11}([?&].*)?$/;

            if (!youtubePattern.test(videoUrl)) {

                notify(false, 'Please enter a valid YouTube URL.');

                return;

            }

            savePublicProfile(function() {

                location.reload();

            });

        });


        $('#removeVideo').on('click', function() {

            if (!confirm('Are you sure you want to remove this introduction video?')) {

                return;

            }

            var skill = $.trim($skill.val());

            var caps = $.trim($capability.val());

            if (skill === '') {

                notify(false, 'Please enter Skill Tag.');

                return;

            }

            if (caps === '') {

                notify(false, 'Please enter Capability Statement.');

                return;

            }

            post(cfg.save, {

                tutor_id: cfg.tutor,

                skills: skill,

                capabilities: caps,

                profile_video: ''

            }, function() {

                location.reload();

            });

        });

    });
</script>
@endsection