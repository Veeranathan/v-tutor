<style>
/* =========================================================
   V-TUTOR HEADER
========================================================= */

.gj_hdr_sec {
    position: relative;
    z-index: 1000;
}

.gj_hdr_sec .navbar {
    min-height: 70px;
}


/* =========================================================
   DESKTOP NAVIGATION
========================================================= */

.desktop-nav-wrapper {
    margin-left: auto;
    margin-right: 12px;
    flex-shrink: 0;
}

.desktop-nav-menu {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 2px;
    margin: 0;
    padding: 0;
    list-style: none;
}

.desktop-nav-menu .nav-item {
    position: relative;
}

.desktop-nav-menu .nav-link {
    display: inline-flex;
    align-items: center;
    color: #fff !important;
    font-size: 15px;
    font-weight: 500;
    line-height: 1.4;
    padding: 8px 10px !important;
    white-space: nowrap;
    text-decoration: none;
    transition: opacity 0.2s ease;
}

.desktop-nav-menu .nav-link:hover,
.desktop-nav-menu .nav-link:focus {
    color: #fff !important;
    opacity: 0.85;
}

/* =========================================================
   DESKTOP DROPDOWN
========================================================= */

.desktop-nav-menu .dropdown-menu {
    min-width: 220px;
    margin-top: 8px;
    padding: 8px 0;
    border: 0;
    border-radius: 10px;
    background: #fff;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
}

.desktop-nav-menu .dropdown-item {
    display: block;
    padding: 9px 18px;
    color: #333;
    font-size: 14px;
    font-weight: 400;
    white-space: nowrap;
    transition:
        background-color 0.2s ease,
        color 0.2s ease;
}

.desktop-nav-menu .dropdown-item:hover,
.desktop-nav-menu .dropdown-item:focus {
    background-color: #f7f7f7;
    color: #c21f34;
}


/* =========================================================
   HEADER ACTIONS
========================================================= */

.header-actions {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 10px;
    margin-left: 0;
    flex-shrink: 0;
}

.header-program-link {
    display: inline-flex;
    align-items: center;
    flex-shrink: 0;
    margin-right: 2px;
}

.header-program-link .primary-button {
    white-space: nowrap;
    margin-right: 0 !important;
}


/* =========================================================
   LOGIN
========================================================= */

.login_hdr_link {
    display: inline-flex;
    align-items: center;
    text-decoration: none;
}

.login_hdr_link .secondary-button {
    white-space: nowrap;
}


/* =========================================================
   PROFILE
========================================================= */

.header_book_user_drop {
    position: relative;
    display: flex;
    align-items: center;
    flex-shrink: 0;
}

.profile-user-name {
    list-style: none;
    margin: 0;
    padding: 0;
}

.profile-user-name > a {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    margin: 0;
    padding: 0;
    color: #fff !important;
    text-decoration: none;
}

.profile-user-name > a em {
    display: block;
    width: 36px;
    height: 36px;
    flex-shrink: 0;
    overflow: hidden;
    border-radius: 50%;
    background: #fff;
}

/* Ensure the user name text (span) remains visible on mobile */
.profile-user-name > a span {
    display: inline-block !important; /* Forces visibility */
    color: #fff !important;
    white-space: nowrap;
}

/* Ensure the parent link wrapper maintains flex layout on smaller screens */
.profile-user-name > a {
    display: inline-flex !important;
    align-items: center;
    gap: 7px;
}

.profile_img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
}


/* =========================================================
   ACCOUNT DROPDOWN
========================================================= */

.open_menu {
    position: absolute;
    top: calc(100% + 10px);
    right: 0;
    min-width: 220px;
    padding: 8px 0;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    z-index: 1050;
}

.open_menu ul {
    margin: 0;
    padding: 0;
    list-style: none;
}

.open_menu li {
    margin: 0;
    padding: 0;
}

.open_menu li a {
    display: block;
    padding: 10px 18px;
    color: #333;
    font-size: 14px;
    text-decoration: none;
    transition:
        background-color 0.2s ease,
        color 0.2s ease;
}

.open_menu li a:hover,
.open_menu li a:focus {
    background: #f7f7f7;
    color: #c21f34;
}


/* =========================================================
   NOTIFICATIONS
========================================================= */

.notification-wrapper {
    position: relative;
    display: flex;
    align-items: center;
    flex-shrink: 0;
}

.notification-button {
    position: relative;
    width: 38px;
    height: 38px;
    padding: 6px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 0;
    background: transparent;
    color: #fff;
    cursor: pointer;
}

.notification-icon {
    width: 21px;
    height: 21px;
    fill: #fff;
}


.notification-button:focus {
    outline: 2px solid rgba(255, 255, 255, 0.5);
    outline-offset: 2px;
}

.notification-count {
    position: absolute;
    top: 1px;
    right: 1px;
    min-width: 17px;
    height: 17px;
    padding: 0 4px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: #c21f34;
    color: #fff;
    font-size: 10px;
    font-weight: 700;
    line-height: 1;
}

.notification-count[hidden] {
    display: none;
}

.notification-dropdown {
    position: absolute;
    top: calc(100% + 8px);
    right: 0;
    width: 320px;
    max-width: calc(100vw - 30px);
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    overflow: hidden;
    z-index: 1100;
}

.notification-dropdown[hidden] {
    display: none;
}

.notification-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 12px 16px;
    border-bottom: 1px solid #eee;
}

.notification-title {
    color: #333;
    font-size: 14px;
    font-weight: 600;
}

.notification-mark-read {
    padding: 0;
    border: 0;
    background: transparent;
    color: #c21f34;
    font-size: 12px;
    cursor: pointer;
}

.notification-list {
    max-height: 350px;
    margin: 0;
    padding: 0;
    overflow-y: auto;
    list-style: none;
}

.notification-empty {
    padding: 18px 16px;
    color: #777;
    font-size: 13px;
}


/* =========================================================
   MOBILE MENU TOGGLE
========================================================= */

.mobile-menu-toggle {
    width: 42px;
    height: 42px;
    margin-left: 8px;
    padding: 0;
    display: none;
    align-items: center;
    justify-content: center;
    border: 0;
    background: transparent;
    cursor: pointer;
}

.mobile-menu-toggle:focus {
    outline: 2px solid rgba(255, 255, 255, 0.5);
    outline-offset: 2px;
}

.mobile-menu-icon {
    width: 24px;
    height: 20px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.mobile-menu-icon span {
    display: block;
    width: 24px;
    height: 2px;
    border-radius: 2px;
    background: #fff;
    transition:
        transform 0.25s ease,
        opacity 0.2s ease;
}

.mobile-menu-toggle.is-open .mobile-menu-icon span:nth-child(1) {
    transform: translateY(9px) rotate(45deg);
}

.mobile-menu-toggle.is-open .mobile-menu-icon span:nth-child(2) {
    opacity: 0;
}

.mobile-menu-toggle.is-open .mobile-menu-icon span:nth-child(3) {
    transform: translateY(-9px) rotate(-45deg);
}


/* =========================================================
   MOBILE NAVIGATION
========================================================= */

.mobile-navigation {
    display: none;
    width: 100%;
    margin-top: 12px;
    padding-bottom: 16px;
}

.mobile-navigation.is-open {
    display: block;
}

.mobile-navigation-inner {
    width: 100%;
    overflow: hidden;
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 10px 35px rgba(0, 0, 0, 0.15);
}

.mobile-nav-list {
    margin: 0;
    padding: 0;
    list-style: none;
}

.mobile-nav-item {
    margin: 0;
    padding: 0;
    border-bottom: 1px solid #eee;
}

.mobile-nav-item:last-child {
    border-bottom: 0;
}


/* =========================================================
   MOBILE NAV LINKS
========================================================= */

.mobile-nav-link {
    width: 100%;
    min-height: 52px;
    padding: 15px 18px;

    display: flex;
    align-items: center;
    justify-content: space-between;

    border: 0;
    background: transparent;

    color: #222 !important;

    font-size: 15px;
    font-weight: 500;
    line-height: 1.4;

    text-align: left;
    text-decoration: none !important;

    cursor: pointer;

    transition:
        background-color 0.2s ease,
        color 0.2s ease;
}

.mobile-nav-link:hover,
.mobile-nav-link:focus {
    background: #f8f8f8;
    color: #c21f34 !important;
}


/* =========================================================
   MOBILE CHEVRON
========================================================= */

.mobile-chevron {
    flex-shrink: 0;
    color: #777;
    font-size: 12px;
    transition:
        transform 0.25s ease,
        color 0.25s ease;
}

.mobile-submenu-toggle.is-open .mobile-chevron {
    transform: rotate(180deg);
    color: #c21f34;
}


/* =========================================================
   MOBILE SUBMENU
========================================================= */

.mobile-submenu {
    padding: 4px 0 8px;
    background: #fafafa;
}

.mobile-submenu[hidden] {
    display: none;
}

.mobile-submenu-link {
    display: block;
    padding: 11px 18px 11px 34px;
    color: #555 !important;
    font-size: 14px;
    font-weight: 400;
    text-decoration: none !important;
    transition:
        background-color 0.2s ease,
        color 0.2s ease;
}

.mobile-submenu-link:hover,
.mobile-submenu-link:focus {
    background: #f1f1f1;
    color: #c21f34 !important;
}


/* =========================================================
   MOBILE ACCOUNT
========================================================= */

.mobile-account-section {
    border-top: 8px solid #f5f5f5;
}

.mobile-account-title {
    padding: 15px 18px 8px;
    color: #888;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}

.mobile-direct-link {
    justify-content: flex-start;
}

.mobile-logout-item {
    margin-top: 4px;
}

.mobile-logout-item .mobile-nav-link {
    color: #c21f34 !important;
}

.after_log ul li a i {
  color: #fff !important;
}
/* =========================================================
   RESPONSIVE
========================================================= */

@media (min-width: 992px) and (max-width: 1199.98px) {

    .desktop-nav-wrapper {
        margin-right: 8px;
    }

    .desktop-nav-menu {
        gap: 0;
    }

    .desktop-nav-menu .nav-link {
        padding-left: 7px !important;
        padding-right: 7px !important;
        font-size: 14px;
    }

}

@media (max-width: 991.98px) {

    .gj_hdr_sec .navbar {
        display: flex !important;
        flex-direction: row !important;
        flex-wrap: nowrap !important;
        justify-content: space-between !important;
        align-items: center !important;
    }

    .gj_hdr_sec .header-actions {
        display: inline-flex !important;
        flex-direction: row !important;
        flex-wrap: nowrap !important;
        align-items: center !important;
        justify-content: flex-end !important;
        margin-left: auto !important;
        float: none !important;
        gap: 6px !important;
    }

    .gj_hdr_sec .notification-wrapper,
    .gj_hdr_sec .header_book_user_drop,
    .gj_hdr_sec .mobile-menu-toggle {
        display: inline-flex !important;
        float: none !important;
        position: relative !important;
        top: auto !important;
        bottom: auto !important;
        left: auto !important;
        right: auto !important;
    }

    .gj_hdr_sec .profile-user-name > a span {
        display: inline-block !important;
        max-width: 80px !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        white-space: nowrap !important;
        font-size: 13px !important;
    }

    .gj_hdr_sec .profile-user-name > a i {
        display: none !important;
    }

    .book-free-assessment-link,
    .get-programs-link {
        display: none !important;
    }
}

@media (max-width: 575.98px) {

    .mobile-navigation-inner {
        border-radius: 10px;
    }

    .mobile-nav-link {
        min-height: 50px;
        padding: 14px 16px;
        font-size: 14px;
    }

    .mobile-submenu-link {
        padding-left: 30px;
        font-size: 13px;
    }

    .notification-dropdown {
        right: -190px;
        width: 300px;
    }

}

</style>
@php

    /*
    |--------------------------------------------------------------------------
    | Logged-in Student Grade
    |--------------------------------------------------------------------------
    | Used for Book a Session URL.
    |--------------------------------------------------------------------------
    */

    $myGrade = null;

    if (Auth::check() && Auth::user()->user_type === 'U') {

        $myGrade = \App\Models\Grade::where([
            'id'     => Auth::user()->grade,
            'status' => 'A',
        ])
        ->select('id', 'slug')
        ->first();

    }

@endphp


@section('head')

    @include('include.head')

    <link
        href="{{ public_asset('assets/css/landing_animation.css') }}"
        rel="stylesheet"
        type="text/css"
    >

@endsection


<header class="header_sec shadow-none gj_hdr_sec">

    <div class="container">

        <nav
            class="navbar navbar-expand-lg navbar-custom p-0 d-flex align-items-center"
            aria-label="Main navigation"
        >

            {{-- =====================================================
                LEFT SIDE
            ====================================================== --}}

            <div class="d-flex align-items-center p-0">

                {{-- Desktop Menu --}}
                <div class="top-menu-container d-none d-lg-block">

                    <div class="top-menu">

                        <img
                            src="{{ public_asset('assets/images/top-menu.svg') }}"
                            alt="Open V-Tutor menu"
                        >

                    </div>


                    <div class="top-menu-popup">

                        <div class="vtutor-section">

                            <div class="row mx-0">

                                {{-- Subjects --}}
                                <div class="col-lg-1 col-md-2 col-sm-6 col-6 mb-4">

                                    <h5>Subjects</h5>

                                    <ul class="list-group vtutor-list">

                                        @foreach(config('menu.subject', []) as $slug => $label)

                                            <li class="list-group-item">

                                                <a href="{{ url('subject/' . $slug) }}">
                                                    {{ $label }}
                                                </a>

                                            </li>

                                        @endforeach

                                    </ul>

                                </div>


                                {{-- Year --}}
                                <div class="col-lg-1 col-md-2 col-sm-6 col-6 mb-4">

                                    <h5>Year</h5>

                                    <ul class="list-group vtutor-list">

                                        @foreach(config('menu.year', []) as $slug => $label)

                                            <li class="list-group-item">

                                                <a href="{{ url('year/' . $slug) }}">
                                                    {{ $label }}
                                                </a>

                                            </li>

                                        @endforeach

                                    </ul>

                                </div>


                                {{-- States --}}
                                <div class="col-lg-2 col-md-3 col-sm-6 col-6 mb-4">

                                    <h5>States</h5>

                                    <ul class="list-group vtutor-list">

                                        @foreach(config('menu.state', []) as $slug => $label)

                                            <li class="list-group-item">

                                                <a href="{{ url('state/' . $slug) }}">
                                                    {{ $label }}
                                                </a>

                                            </li>

                                        @endforeach

                                    </ul>

                                </div>


                                {{-- Tutor CTA --}}
                                <div class="col-lg-4 col-md-5 col-sm-6 col-6 mb-4">

                                    <h6 class="mb-4">
                                        Turn Passion Into Purpose
                                    </h6>

                                    <div
                                        class="ratio ratio-16x9 mb-3"
                                        style="
                                            background-image: url('{{ public_asset('assets/images/landing_tutor/menu_banner.png') }}');
                                            background-size: cover;
                                            background-position: center;
                                            min-height: 180px;
                                            border-radius: 20px;
                                        "
                                    ></div>

                                    <div class="cta-content">

                                        <h2 class="pt-2">
                                            Teach Your Way. Join Today!
                                        </h2>

                                        <p class="py-3">
                                            Join a community of educators making a difference
                                        </p>

                                        <div class="pt-1">

                                            <a
                                                href="{{ route('tutor_landing') }}"
                                                class="cta-link"
                                            >
                                                Be a V-Tutor
                                                <i
                                                    class="fas fa-chevron-right"
                                                    aria-hidden="true"
                                                ></i>
                                            </a>

                                        </div>

                                    </div>

                                </div>

                            </div>


                            <hr class="my-4">


                            {{-- Menu Footer --}}
                            <div class="d-flex flex-wrap justify-content-start align-items-center menu-footer mb-2">

                                <div class="key_img">

                                    <img
                                        src="{{ public_asset('assets/images/landing_tutor/key.png') }}"
                                        alt=""
                                        aria-hidden="true"
                                    >

                                </div>

                                <p class="mb-0">

                                    Give your child the best start with Australia’s most trusted
                                    tutoring platform — book your first session now.

                                </p>


                                @guest

                                    <a
                                        href="{{ route('products', ['type' => 'learning']) }}"
                                        class="bk_btn_mm_link"
                                    >
                                        <span class="primary-button mr-3">
                                            Book a Session
                                        </span>
                                    </a>

                                @endguest

                            </div>

                        </div>

                    </div>

                </div>


                {{-- Logo --}}
                <a
                    class="navbar-brand"
                    href="{{ url('/') }}"
                    aria-label="V-Tutor home"
                >

                    <img
                        src="{{ public_asset('assets/images/landing_tutor/logo_white.svg') }}"
                        alt="V-Tutor online tutoring Australia"
                        class="main-logo"
                    >

                </a>

            </div>


            {{-- =====================================================
                DESKTOP NAVIGATION
            ====================================================== --}}

            <div class="desktop-nav-wrapper d-none d-lg-flex align-items-center">

                <ul class="navbar-nav desktop-nav-menu flex-row align-items-center mb-0">

                    {{-- Our Programs --}}
                    <li class="nav-item dropdown">

                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            id="programsDropdown"
                            role="button"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                        >
                            Our Programs
                        </a>

                        <div
                            class="dropdown-menu"
                            aria-labelledby="programsDropdown"
                        >

                            <a
                                class="dropdown-item"
                                href="{{ route('products', ['type' => 'learning']) }}"
                            >
                                Learning Programs
                            </a>

                            <a
                                class="dropdown-item"
                                href="{{ route('products', ['type' => 'mlp']) }}"
                            >
                                Micro Learning Programs
                            </a>

                            <a
                                class="dropdown-item"
                                href="{{ route('products', ['type' => 'ctp']) }}"
                            >
                                Core Training Programs
                            </a>
                            <a
                                class="dropdown-item"
                                href="{{ route('products', ['type' => 'icp']) }}"
                            >
                                Intensive Crash Programs
                            </a>

                        </div>

                    </li>


                    {{-- Resources --}}
                    <li class="nav-item dropdown">

                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            id="resourcesDropdown"
                            role="button"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                        >
                            Resources
                        </a>

                        <div
                            class="dropdown-menu"
                            aria-labelledby="resourcesDropdown"
                        >

                            <a
                                class="dropdown-item"
                                href="{{ url('blog') }}"
                            >
                                Blogs
                            </a>

                        </div>

                    </li>


                    {{-- For Families --}}
                    <li class="nav-item dropdown">

                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            id="familiesDropdown"
                            role="button"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                        >
                            For Families
                        </a>

                        <div
                            class="dropdown-menu"
                            aria-labelledby="familiesDropdown"
                        >

                            <a
                                class="dropdown-item"
                                href="{{ route('about.us') }}"
                            >
                                About Us
                            </a>

                            <a
                                class="dropdown-item"
                                href="{{ route('search.result.j') }}"
                            >
                                Find Tutor
                            </a>

                            <a
                                class="dropdown-item"
                                href="{{ url('faq') }}"
                            >
                                FAQs
                            </a>

                            <a
                                class="dropdown-item"
                                href="{{ url('terms-service') }}"
                            >
                                Terms Of Service
                            </a>

                            <a
                                class="dropdown-item"
                                href="{{ url('privacy-policy') }}"
                            >
                                Privacy Policy
                            </a>

                            <a
                                class="dropdown-item"
                                href="{{ url('contact-us') }}"
                            >
                                Message Us
                            </a>

                        </div>

                    </li>


                    {{-- For Tutors --}}
                    <li class="nav-item dropdown">

                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            id="tutorsDropdown"
                            role="button"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                        >
                            For Tutors
                        </a>

                        <div
                            class="dropdown-menu"
                            aria-labelledby="tutorsDropdown"
                        >

                            <a
                                class="dropdown-item"
                                href="{{ route('tutor_landing') }}"
                            >
                                Be a V-Tutor
                            </a>

                            <a
                                class="dropdown-item"
                                href="{{ url('faq') }}"
                            >
                                FAQs
                            </a>

                            <a
                                class="dropdown-item"
                                href="{{ url('contact-us') }}"
                            >
                                Message Us
                            </a>

                        </div>

                    </li>

                </ul>

            </div>

{{-- =====================================================
    RIGHT SIDE
====================================================== --}}
<div class="header-actions">

    {{-- PRIMARY CTA (Hidden on mobile via CSS) --}}
    @auth
        <a href="{{ route('products', ['type' => 'learning']) }}" class="header-program-link get-programs-link">
            <span class="primary-button book-resp">Get Programs</span>
        </a>
    @else
        <a href="{{ route('program.assessment') }}" target="_blank" rel="noopener noreferrer" class="header-program-link book-free-assessment-link">
            <span class="primary-button book-resp mr-3">Book Free Assessment</span>
        </a>
    @endauth

    {{-- AUTHENTICATED USER --}}
    @auth
        @php
            $user = Auth::user();
            $avatarUrl = match (true) {
                !empty($user->profile_pic) && $user->user_type === 'T' => url('/storage/teacher_profile_pic/' . $user->profile_pic),
                !empty($user->profile_pic)                            => public_asset('assets/images/all_avatars/' . $user->profile_pic),
                !empty($user->avatar)                                 => $user->avatar,
                default                                               => public_asset('assets/images/user_login.png'),
            };
        @endphp

        {{-- NOTIFICATIONS (BELL FIRST) --}}
        <div class="notification-wrapper">
            <button
                id="bellButton"
                type="button"
                class="notification-button"
                aria-label="Notifications"
                aria-haspopup="true"
                aria-expanded="false"
                aria-controls="bookingDropdown"
            >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="notification-icon" aria-hidden="true">
                    <path d="M12 2a6 6 0 0 0-6 6v4.586l-.707.707A1 1 0 0 0 6 15h12a1 1 0 0 0 .707-1.707L18 12.586V8a6 6 0 0 0-6-6zm0 20a2.5 2.5 0 0 0 2.45-2h-4.9a2.5 2.5 0 0 0 2.45 2z"/>
                </svg>
                <span id="bookingCount" class="notification-count" hidden>0</span>
            </button>

            <div id="bookingDropdown" class="notification-dropdown" hidden role="dialog" aria-label="Notifications">
                <div class="notification-header">
                    <span class="notification-title">Notifications</span>
                    <button id="markAllReadBtn" type="button" class="notification-mark-read">
                        Mark all as read
                    </button>
                </div>
                <ul id="bookingList" class="notification-list">
                    <li class="notification-empty">No new notifications</li>
                </ul>
            </div>
        </div>

        {{--  PROFILE DROPDOWN (SECOND) --}}
        <div class="login_menu after_log header_book_user_drop">
            <ul class="click_open mb-0">
                <li class="profile-user-name">
                    <a href="#" aria-label="Open account menu">
                        <em>
                            <img src="{{ $avatarUrl }}" alt="User profile" class="profile_img">
                        </em>
                        <span>
                            Hi, {{ $user->f_name }}
                            <i class="fas fa-angle-down" aria-hidden="true"></i>
                        </span>
                    </a>
                </li>
            </ul>

            {{--  STUDENT ACCOUNT MENU--}}
            <div class="open_menu" style="display:none;">
                <ul>
                    @if ($user->user_type === 'U')
                        @if ($user->status === 'A')
                            <li><a href="{{ url('tutor-search-result?grade=' . ($myGrade->slug ?? '')) }}">Book a Session</a></li>
                            <li><a href="{{ url('my-profile') }}">Profile</a></li>
                            <li><a href="{{ route('student.my.classes') }}">Sessions</a></li>
                            <li><a href="{{ route('list.of.favourite') }}">My Tutors</a></li>
                            <li><a href="{{ route('student.my.review.no.slug') }}">My Reviews</a></li>
                            <li><a href="{{ route('student.my.payments') }}">Payments</a></li>
                            <li><a href="{{ route('student.my.academic.program') }}">Learning Programs</a></li>
                            
                            @if (!$user->platform_id)
                                <li><a href="{{ route('student.reset.password.view') }}">Change Password</a></li>
                            @endif
                        @endif
                    {{--  TUTOR ACCOUNT MENU --}}
                    @elseif ($user->user_type === 'T')
                        @if ($user->status === 'A')
                            <li><a href="{{ route('teacher.profile') }}">Profile</a></li>

                            @if ($user->subscription === 'S' && $user->draft === 'N')
                                <li><a href="{{ route('tutor.availability') }}">Schedule</a></li>
                                <li><a href="{{ route('tutor.myclass') }}">Sessions</a></li>
                                <li><a href="{{ route('tutor.my.payments') }}">Payments</a></li>
                                <li><a href="{{ route('tutor.my.review') }}">Reviews</a></li>
                            @endif

                            @if (!$user->platform_id)
                                <li><a href="{{ route('teacher.reset.password.view') }}">Change Password</a></li>
                            @endif
                        @endif
                    @endif

                    <li>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-desktop').submit();">
                            Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <form id="logout-form-desktop" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>

    @else
        {{-- GUEST LOGIN --}}
        <a href="{{ url('login') }}" class="login_hdr_link notlogin_hdr_link">
            <span class="secondary-button mr-0 d-flex justify-content-center align-items-center">
                <span class="d-flex mr-2">
                    <img src="{{ public_asset('assets/images/landing_tutor/user.svg') }}" alt="" aria-hidden="true">
                </span>
                Login
            </span>
        </a>
    @endauth

    {{--  MOBILE MENU TOGGLE (THIRD / FAR RIGHT) --}}
    <button
        id="mobileMenuToggle"
        class="mobile-menu-toggle"
        type="button"
        aria-controls="mobileNavigation"
        aria-expanded="false"
        aria-label="Open navigation menu"
    >
        <span class="mobile-menu-icon" aria-hidden="true">
            <span></span>
            <span></span>
            <span></span>
        </span>
    </button>

</div>        </nav>


        {{-- =========================================================
            MOBILE NAVIGATION
        ========================================================= --}}

        <div
            id="mobileNavigation"
            class="mobile-navigation"
            aria-hidden="true"
        >

            <div class="mobile-navigation-inner">

                <nav aria-label="Mobile navigation">

                    <ul class="mobile-nav-list">

                        {{-- Our Programs --}}
                        <li class="mobile-nav-item">

                            <button
                                type="button"
                                class="mobile-nav-link mobile-submenu-toggle"
                                aria-expanded="false"
                                aria-controls="mobileProgramsMenu"
                            >

                                <span>Our Programs</span>

                                <i
                                    class="fas fa-chevron-down mobile-chevron"
                                    aria-hidden="true"
                                ></i>

                            </button>


                            <div
                                id="mobileProgramsMenu"
                                class="mobile-submenu"
                                hidden
                            >

                                <a
                                    href="{{ route('products', ['type' => 'learning']) }}"
                                    class="mobile-submenu-link"
                                >
                                    Learning Programs
                                </a>

                                <a
                                    href="{{ route('products', ['type' => 'mlp']) }}"
                                    class="mobile-submenu-link"
                                >
                                    Micro Learning Programs
                                </a>

                                <a
                                    href="{{ route('products', ['type' => 'ctp']) }}"
                                    class="mobile-submenu-link"
                                >
                                    Core Training Programs
                                </a>

                                 <a
                                    href="{{ route('products', ['type' => 'icp']) }}"
                                    class="mobile-submenu-link"
                                >
                                    Intensive Crash Programs
                                </a>

                            </div>

                        </li>


                        {{-- Resources --}}
                        <li class="mobile-nav-item">

                            <button
                                type="button"
                                class="mobile-nav-link mobile-submenu-toggle"
                                aria-expanded="false"
                                aria-controls="mobileResourcesMenu"
                            >

                                <span>Resources</span>

                                <i
                                    class="fas fa-chevron-down mobile-chevron"
                                    aria-hidden="true"
                                ></i>

                            </button>


                            <div
                                id="mobileResourcesMenu"
                                class="mobile-submenu"
                                hidden
                            >

                                <a
                                    href="{{ url('blog') }}"
                                    class="mobile-submenu-link"
                                >
                                    Blogs
                                </a>

                            </div>

                        </li>


                        {{-- For Families --}}
                        <li class="mobile-nav-item">

                            <button
                                type="button"
                                class="mobile-nav-link mobile-submenu-toggle"
                                aria-expanded="false"
                                aria-controls="mobileFamiliesMenu"
                            >

                                <span>For Families</span>

                                <i
                                    class="fas fa-chevron-down mobile-chevron"
                                    aria-hidden="true"
                                ></i>

                            </button>


                            <div
                                id="mobileFamiliesMenu"
                                class="mobile-submenu"
                                hidden
                            >

                                <a
                                    href="{{ route('about.us') }}"
                                    class="mobile-submenu-link"
                                >
                                    About Us
                                </a>

                                <a
                                    href="{{ route('search.result.j') }}"
                                    class="mobile-submenu-link"
                                >
                                    Find Tutor
                                </a>

                                <a
                                    href="{{ url('faq') }}"
                                    class="mobile-submenu-link"
                                >
                                    FAQs
                                </a>

                                <a
                                    href="{{ url('terms-service') }}"
                                    class="mobile-submenu-link"
                                >
                                    Terms Of Service
                                </a>

                                <a
                                    href="{{ url('privacy-policy') }}"
                                    class="mobile-submenu-link"
                                >
                                    Privacy Policy
                                </a>

                                <a
                                    href="{{ url('contact-us') }}"
                                    class="mobile-submenu-link"
                                >
                                    Message Us
                                </a>

                            </div>

                        </li>


                        {{-- For Tutors --}}
                        <li class="mobile-nav-item">

                            <button
                                type="button"
                                class="mobile-nav-link mobile-submenu-toggle"
                                aria-expanded="false"
                                aria-controls="mobileTutorsMenu"
                            >

                                <span>For Tutors</span>

                                <i
                                    class="fas fa-chevron-down mobile-chevron"
                                    aria-hidden="true"
                                ></i>

                            </button>


                            <div
                                id="mobileTutorsMenu"
                                class="mobile-submenu"
                                hidden
                            >

                                <a
                                    href="{{ route('tutor_landing') }}"
                                    class="mobile-submenu-link"
                                >
                                    Be a V-Tutor
                                </a>

                                <a
                                    href="{{ url('faq') }}"
                                    class="mobile-submenu-link"
                                >
                                    FAQs
                                </a>

                                <a
                                    href="{{ url('contact-us') }}"
                                    class="mobile-submenu-link"
                                >
                                    Message Us
                                </a>

                            </div>

                        </li>
                        {{-- Subjects --}}
                        <li class="mobile-nav-item">

                            <button
                                type="button"
                                class="mobile-nav-link mobile-submenu-toggle"
                                aria-expanded="false"
                                aria-controls="mobileSubjectsMenu"
                            >
                                <span>Subjects</span>

                                <i
                                    class="fas fa-chevron-down mobile-chevron"
                                    aria-hidden="true"
                                ></i>
                            </button>

                            <div
                                id="mobileSubjectsMenu"
                                class="mobile-submenu"
                                hidden
                            >

                                @foreach(config('menu.subject', []) as $slug => $label)

                                <a
                                    href="{{ url('subject/' . $slug) }}"
                                    class="mobile-submenu-link"
                                >
                                    {{ $label }}
                                </a>

                                @endforeach

                            </div>

                        </li>


                        {{-- Years --}}
                        <li class="mobile-nav-item">

                            <button
                                type="button"
                                class="mobile-nav-link mobile-submenu-toggle"
                                aria-expanded="false"
                                aria-controls="mobileYearsMenu"
                            >
                                <span>Years</span>

                                <i
                                    class="fas fa-chevron-down mobile-chevron"
                                    aria-hidden="true"
                                ></i>
                            </button>

                            <div
                                id="mobileYearsMenu"
                                class="mobile-submenu"
                                hidden
                            >

                                @foreach(config('menu.year', []) as $slug => $label)

                                    <a
                                        href="{{ url('year/' . $slug) }}"
                                        class="mobile-submenu-link"
                                    >
                                        {{ $label }}
                                    </a>

                                @endforeach

                            </div>

                        </li>


                        {{-- States --}}
                        <li class="mobile-nav-item">

                        <button
                            type="button"
                            class="mobile-nav-link mobile-submenu-toggle"
                            aria-expanded="false"
                            aria-controls="mobileStatesMenu"
                        >
                            <span>States</span>

                            <i
                                class="fas fa-chevron-down mobile-chevron"
                                aria-hidden="true"
                            ></i>
                        </button>

                        <div
                            id="mobileStatesMenu"
                            class="mobile-submenu"
                            hidden
                        >

                            @foreach(config('menu.state', []) as $slug => $label)

                                <a
                                    href="{{ url('state/' . $slug) }}"
                                    class="mobile-submenu-link"
                                >
                                    {{ $label }}
                                </a>

                            @endforeach

                        </div>

                    </li>

                    </ul>

                </nav>


                {{-- =================================================
                    MOBILE ACCOUNT
                ================================================== --}}

                @auth

                    <div class="mobile-account-section">

                        <div class="mobile-account-title">
                            My Account
                        </div>


                        <ul class="mobile-nav-list">

                            {{-- Student --}}
                            @if (Auth::user()->user_type === 'U')

                                @if (Auth::user()->status === 'A')

                                    <li class="mobile-nav-item">
                                        <a
                                            href="{{ url('tutor-search-result?grade=' . ($myGrade->slug ?? '')) }}"
                                            class="mobile-nav-link mobile-direct-link"
                                        >
                                            Book a Session
                                        </a>
                                    </li>

                                    <li class="mobile-nav-item">
                                        <a
                                            href="{{ url('my-profile') }}"
                                            class="mobile-nav-link mobile-direct-link"
                                        >
                                            Profile
                                        </a>
                                    </li>

                                    <li class="mobile-nav-item">
                                        <a
                                            href="{{ route('student.my.classes') }}"
                                            class="mobile-nav-link mobile-direct-link"
                                        >
                                            Sessions
                                        </a>
                                    </li>

                                    <li class="mobile-nav-item">
                                        <a
                                            href="{{ route('list.of.favourite') }}"
                                            class="mobile-nav-link mobile-direct-link"
                                        >
                                            My Tutors
                                        </a>
                                    </li>

                                    <li class="mobile-nav-item">
                                        <a
                                            href="{{ route('student.my.review.no.slug') }}"
                                            class="mobile-nav-link mobile-direct-link"
                                        >
                                            My Reviews
                                        </a>
                                    </li>

                                    <li class="mobile-nav-item">
                                        <a
                                            href="{{ route('student.my.payments') }}"
                                            class="mobile-nav-link mobile-direct-link"
                                        >
                                            Payments
                                        </a>
                                    </li>

                                    <li class="mobile-nav-item">
                                        <a
                                            href="{{ route('student.my.academic.program') }}"
                                            class="mobile-nav-link mobile-direct-link"
                                        >
                                            Learning Programs
                                        </a>
                                    </li>

                                    @if (!Auth::user()->platform_id)

                                        <li class="mobile-nav-item">
                                            <a
                                                href="{{ route('student.reset.password.view') }}"
                                                class="mobile-nav-link mobile-direct-link"
                                            >
                                                Change Password
                                            </a>
                                        </li>

                                    @endif

                                @endif


                            {{-- Tutor --}}
                            @elseif (Auth::user()->user_type === 'T')

                                @if (
                                    Auth::user()->status === 'A' &&
                                    Auth::user()->subscription === 'S' &&
                                    Auth::user()->draft === 'N'
                                )

                                    <li class="mobile-nav-item">
                                        <a
                                            href="{{ route('teacher.profile') }}"
                                            class="mobile-nav-link mobile-direct-link"
                                        >
                                            Profile
                                        </a>
                                    </li>

                                    <li class="mobile-nav-item">
                                        <a
                                            href="{{ route('tutor.availability') }}"
                                            class="mobile-nav-link mobile-direct-link"
                                        >
                                            Schedule
                                        </a>
                                    </li>

                                    <li class="mobile-nav-item">
                                        <a
                                            href="{{ route('tutor.myclass') }}"
                                            class="mobile-nav-link mobile-direct-link"
                                        >
                                            Sessions
                                        </a>
                                    </li>

                                    <li class="mobile-nav-item">
                                        <a
                                            href="{{ route('tutor.my.payments') }}"
                                            class="mobile-nav-link mobile-direct-link"
                                        >
                                            Payments
                                        </a>
                                    </li>

                                    <li class="mobile-nav-item">
                                        <a
                                            href="{{ route('tutor.my.review') }}"
                                            class="mobile-nav-link mobile-direct-link"
                                        >
                                            Reviews
                                        </a>
                                    </li>

                                    @if (!Auth::user()->platform_id)

                                        <li class="mobile-nav-item">
                                            <a
                                                href="{{ route('teacher.reset.password.view') }}"
                                                class="mobile-nav-link mobile-direct-link"
                                            >
                                                Change Password
                                            </a>
                                        </li>

                                    @endif


                                @elseif (Auth::user()->status === 'A')

                                    <li class="mobile-nav-item">
                                        <a
                                            href="{{ route('teacher.profile') }}"
                                            class="mobile-nav-link mobile-direct-link"
                                        >
                                            Profile
                                        </a>
                                    </li>

                                    @if (!Auth::user()->platform_id)

                                        <li class="mobile-nav-item">
                                            <a
                                                href="{{ route('teacher.reset.password.view') }}"
                                                class="mobile-nav-link mobile-direct-link"
                                            >
                                                Change Password
                                            </a>
                                        </li>

                                    @endif

                                @endif

                            @endif


                            {{-- Logout --}}
                            <li class="mobile-nav-item mobile-logout-item">

                                <a
                                    href="{{ route('logout') }}"
                                    class="mobile-nav-link mobile-direct-link"
                                    onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();"
                                >
                                    Logout
                                </a>

                            </li>

                        </ul>

                    </div>


                    <form
                        id="logout-form-mobile"
                        action="{{ route('logout') }}"
                        method="POST"
                        class="d-none"
                    >
                        @csrf
                    </form>

                @endauth

            </div>

        </div>

    </div>

</header>
<script>
document.addEventListener('DOMContentLoaded', function () {

    'use strict';

/* =========================================================
   DESKTOP DROPDOWN
========================================================= */

const desktopDropdowns = document.querySelectorAll(
    '.desktop-nav-menu .dropdown'
);

desktopDropdowns.forEach(function (dropdown) {

    const toggle = dropdown.querySelector('.dropdown-toggle');
    const menu = dropdown.querySelector('.dropdown-menu');

    if (!toggle || !menu) {
        return;
    }

    toggle.addEventListener('click', function (event) {

        event.preventDefault();
        event.stopPropagation();

        // Close other dropdowns
        desktopDropdowns.forEach(function (otherDropdown) {

            if (otherDropdown !== dropdown) {

                const otherMenu =
                    otherDropdown.querySelector('.dropdown-menu');

                const otherToggle =
                    otherDropdown.querySelector('.dropdown-toggle');

                if (otherMenu) {
                    otherMenu.classList.remove('show');
                }

                if (otherToggle) {
                    otherToggle.setAttribute(
                        'aria-expanded',
                        'false'
                    );
                }
            }
        });

        const isOpen = menu.classList.contains('show');

        menu.classList.toggle('show', !isOpen);

        toggle.setAttribute(
            'aria-expanded',
            String(!isOpen)
        );
    });
});


/* Close desktop dropdown when clicking outside */

document.addEventListener('click', function (event) {

    if (!event.target.closest('.desktop-nav-menu .dropdown')) {

        desktopDropdowns.forEach(function (dropdown) {

            const menu =
                dropdown.querySelector('.dropdown-menu');

            const toggle =
                dropdown.querySelector('.dropdown-toggle');

            if (menu) {
                menu.classList.remove('show');
            }

            if (toggle) {
                toggle.setAttribute(
                    'aria-expanded',
                    'false'
                );
            }
        });
    }
});
    /* =========================================================
       MOBILE NAVIGATION
    ========================================================= */

    const menuToggle = document.getElementById('mobileMenuToggle');
    const mobileNavigation = document.getElementById('mobileNavigation');

    if (menuToggle && mobileNavigation) {

        const submenuToggles =
            mobileNavigation.querySelectorAll('.mobile-submenu-toggle');


        function closeAllSubmenus() {

            submenuToggles.forEach(function (toggle) {

                const submenuId =
                    toggle.getAttribute('aria-controls');

                const submenu =
                    document.getElementById(submenuId);

                toggle.classList.remove('is-open');

                toggle.setAttribute(
                    'aria-expanded',
                    'false'
                );

                if (submenu) {
                    submenu.hidden = true;
                }

            });

        }


        function closeMobileMenu() {

            mobileNavigation.classList.remove('is-open');

            menuToggle.classList.remove('is-open');

            menuToggle.setAttribute(
                'aria-expanded',
                'false'
            );

            menuToggle.setAttribute(
                'aria-label',
                'Open navigation menu'
            );

            mobileNavigation.setAttribute(
                'aria-hidden',
                'true'
            );

            closeAllSubmenus();

        }


        function openMobileMenu() {

            mobileNavigation.classList.add('is-open');

            menuToggle.classList.add('is-open');

            menuToggle.setAttribute(
                'aria-expanded',
                'true'
            );

            menuToggle.setAttribute(
                'aria-label',
                'Close navigation menu'
            );

            mobileNavigation.setAttribute(
                'aria-hidden',
                'false'
            );

        }


        /* Main menu toggle */

        menuToggle.addEventListener('click', function (event) {

            event.preventDefault();
            event.stopPropagation();

            const isOpen =
                mobileNavigation.classList.contains('is-open');

            if (isOpen) {
                closeMobileMenu();
            } else {
                openMobileMenu();
            }

        });


        /* Submenus */

        submenuToggles.forEach(function (toggle) {

            toggle.addEventListener('click', function () {

                const submenuId =
                    toggle.getAttribute('aria-controls');

                const submenu =
                    document.getElementById(submenuId);

                if (!submenu) {
                    return;
                }

                const isOpen =
                    toggle.classList.contains('is-open');


                /* Close other submenus */

                submenuToggles.forEach(function (otherToggle) {

                    if (otherToggle === toggle) {
                        return;
                    }

                    const otherId =
                        otherToggle.getAttribute('aria-controls');

                    const otherMenu =
                        document.getElementById(otherId);

                    otherToggle.classList.remove('is-open');

                    otherToggle.setAttribute(
                        'aria-expanded',
                        'false'
                    );

                    if (otherMenu) {
                        otherMenu.hidden = true;
                    }

                });


                /* Toggle selected submenu */

                toggle.classList.toggle(
                    'is-open',
                    !isOpen
                );

                toggle.setAttribute(
                    'aria-expanded',
                    String(!isOpen)
                );

                submenu.hidden = isOpen;

            });

        });


        /* Close after navigation */

        mobileNavigation
            .querySelectorAll('a.mobile-submenu-link, a.mobile-direct-link')
            .forEach(function (link) {

                link.addEventListener('click', function () {
                    closeMobileMenu();
                });

            });


        /* Click outside */

        document.addEventListener('click', function (event) {

            if (
                mobileNavigation.classList.contains('is-open') &&
                !mobileNavigation.contains(event.target) &&
                !menuToggle.contains(event.target)
            ) {
                closeMobileMenu();
            }

        });


        /* Escape */

        document.addEventListener('keydown', function (event) {

            if (event.key === 'Escape') {
                closeMobileMenu();
            }

        });


        /* Desktop breakpoint */

        window.addEventListener('resize', function () {

            if (window.innerWidth >= 992) {
                closeMobileMenu();
            }

        });

    }


    /* =========================================================
       NOTIFICATIONS
    ========================================================= */

    const bellButton =
        document.getElementById('bellButton');

    const bookingDropdown =
        document.getElementById('bookingDropdown');

    const bookingCount =
        document.getElementById('bookingCount');

    const markAllReadButton =
        document.getElementById('markAllReadBtn');


    if (
        bellButton &&
        bookingDropdown
    ) {

        function closeNotifications() {

            bookingDropdown.hidden = true;

            bellButton.setAttribute(
                'aria-expanded',
                'false'
            );

        }


        function openNotifications() {

            bookingDropdown.hidden = false;

            bellButton.setAttribute(
                'aria-expanded',
                'true'
            );

        }


        bellButton.addEventListener(
            'click',
            function (event) {

                event.preventDefault();
                event.stopPropagation();

                if (bookingDropdown.hidden) {
                    openNotifications();
                } else {
                    closeNotifications();
                }

            }
        );


        bookingDropdown.addEventListener(
            'click',
            function (event) {
                event.stopPropagation();
            }
        );


        document.addEventListener(
            'click',
            function (event) {

                if (
                    !bookingDropdown.contains(event.target) &&
                    !bellButton.contains(event.target)
                ) {
                    closeNotifications();
                }

            }
        );


        document.addEventListener(
            'keydown',
            function (event) {

                if (event.key === 'Escape') {
                    closeNotifications();
                }

            }
        );


        if (
            markAllReadButton &&
            bookingCount
        ) {

            markAllReadButton.addEventListener(
                'click',
                function () {

                    bookingCount.textContent = '0';

                    bookingCount.hidden = true;

                }
            );

        }

    }
     /* =========================================================
   MOBILE PROFILE
   Keep profile visible but disable desktop dropdown
========================================================= */

const profileLink = document.querySelector(
    '.header_book_user_drop .profile-user-name > a'
);

if (profileLink) {

    profileLink.addEventListener('click', function (event) {

        if (window.innerWidth < 992) {

            event.preventDefault();
            event.stopImmediatePropagation();

            return false;

        }

    }, true);

}

});
</script>