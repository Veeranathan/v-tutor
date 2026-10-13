{{-- resources/views/student/include/student_header.blade.php --}}

@section('head')
    @include('include.head')
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .disabled-link {
            pointer-events: none;
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>
@endsection

<header class="header_sec">
    {{-- START OF NEW TODAY'S SESSION ALERT / BANNER CODE --}}
    <div id="todaySessionAlertBanner"
        class="w-full bg-red-100 border-l-4 border-red-500 text-red-700 p-4 text-center hidden" role="alert">
        <div class="flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 mr-2">
                <path fill-rule="evenodd"
                    d="M9.401 3.003c1.155-2.001 4.045-2.001 5.2 0 .65 1.123 1.034 2.596 1.114 4.226H19.75c1.03 0 1.943.682 2.217 1.616.425 1.487-.406 3.015-1.748 3.403L15.4 12.446c-.573.136-.957.6-.993 1.116-.07.995.301 1.905 1.043 2.458l.128.097c1.397 1.066 1.972 3.056 1.134 4.542-.23.4-.606.746-1.026.974C13.254 22.955 12 23 12 23s-1.254-.045-2.527-.704c-.42-.228-.796-.574-1.026-.974-.838-1.486-.263-3.476 1.134-4.542l.128-.097c.742-.553 1.113-1.463 1.043-2.458-.036-.516-.42-.98-1.006-1.116L4.832 9.048c-1.342-.388-2.173-1.916-1.748-3.403A2.353 2.353 0 0 1 5.25 5.003h4.036c.08-.857.306-1.673.65-2.001Z"
                    clip-rule="evenodd" />
            </svg>
            <span id="alertMessage" class="font-bold"></span>
        </div>
    </div>
    {{-- END OF NEW TODAY'S SESSION ALERT / BANNER CODE --}}

    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light nav_top">
            <a class="navbar-brand" href="{{ url('/') }}"><img src="{{ public_asset('assets/images/logo.png') }}"
                    alt="logo" /></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> <span
                    class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                <ul class="navbar-nav menu_sec after-login flex items-center space-x-4">
                    @php
                        $myGrade = \App\Models\Grade::where(['id' => @Auth::user()->grade, 'status' => 'A'])
                            ->select('id', 'slug', 'status')
                            ->first();
                    @endphp
                    <li class="dropdown nav-item">
                        <a href="{{ url('tutor-search-result?grade=' . @$myGrade->slug) }}"
                            class="dropdown-toggle drop-arw">Find V-Tutor</a>
                    </li>
                    <li class="dropdown nav-item">
                        <a href="#" class="dropdown-toggle drop-arw" data-toggle="dropdown">Support</a>
                        <span class="dropdown-toggle drop-arw" data-toggle="dropdown">
                            <i class="fas fa-angle-down"></i>
                        </span>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('faq') }}">FAQ’s</a></li>
                            <!--li><a href="{{ route('help') }}">Help Section</a></li-->
                            <li><a href="{{ route('contact.us') }}">Message Us</a></li>
                        </ul>
                    </li>

                    {{-- START OF NEW NOTIFICATION BELL SECTION --}}
                    <li class="dropdown nav-item relative">
                        <button id="bellButton"
                            class="relative p-2 text-gray-600 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <!-- Red Bell Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="red" viewBox="0 0 24 24" class="w-6 h-6">
                                <path
                                    d="M12 2a6 6 0 0 0-6 6v4.586l-.707.707A1 1 0 0 0 6 15h12a1 1 0 0 0 .707-1.707L18 12.586V8a6 6 0 0 0-6-6zm0 20a2.5 2.5 0 0 0 2.45-2h-4.9a2.5 2.5 0 0 0 2.45 2z" />
                            </svg>

                            <!-- Red Notification Badge -->
                            <span id="bookingCount"
                                class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold text-white bg-red-600 rounded-full transform translate-x-1/2 -translate-y-1/2 hidden">
                                0
                            </span>
                        </button> {{-- Dropdown Menu --}}
                        <div id="bookingDropdown"
                            class="absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg z-50 ring-1 ring-black ring-opacity-5 hidden">
                            <!-- Header -->
                            <div class="flex items-center justify-between px-4 py-2 border-b border-gray-200">
                                <span class="font-semibold text-gray-800">Notifications</span>
                                <button id="markAllReadBtn"
                                    class="text-sm text-blue-600 hover:text-blue-800 focus:outline-none">
                                    Mark all as read
                                </button>
                            </div>
                            <ul id="bookingList" class="py-1">
                                <li class="px-4 py-2 text-gray-500 text-sm">No new notifications</li>
                                {{-- Bookings will be dynamically added here by JavaScript --}}
                            </ul>
                        </div>
                    </li>

                    <div class="login_menu after_log">
                        <ul class="click_open">
                            <li>
                                <a href="#">
                                    <em>
                                        @if (@Auth::user()->profile_pic)
                                            <img src="{{ public_asset('assets/images/all_avatars/' . @Auth::user()->profile_pic) }}"
                                                alt="profile_img" style="width: 100%;height: 100%"
                                                class="selected_avatar_upd">
                                        @elseif(!@Auth::user()->profile_pic && @Auth::user()->avatar)
                                            <img src="{{ @Auth::user()->avatar }}" alt="profile_img" style="width: 100%"
                                                class="selected_avatar_upd">
                                        @else
                                            <img src="{{ public_asset('assets/images/blank1.png') }}" alt="profile_img"
                                                style="width: 100%" class="selected_avatar_upd">
                                        @endif
                                    </em>
                                    @php
                                        $user = Auth::user()->fresh();

                                        $isProfileComplete =
                                            trim($user->f_name ?? '') !== '' &&
                                            trim($user->l_name ?? '') !== '' &&
                                            trim($user->parent_f_name ?? '') !== '' &&
                                            trim($user->parent_dob ?? '') !== '' &&
                                            trim($user->street ?? '') !== '';
                                        $myGrade = \App\Models\Grade::where([
                                            'id' => $user->grade,
                                            'status' => 'A',
                                        ])->first();
                                        $totalClass = \App\Models\StudentClassBooking::where('student_id', $user->id)
                                            ->whereIn('booking_status', ['B', 'CM', 'C'])
                                            ->count();
                                    @endphp

                                    <span>Hi, {{ @Auth::user()->f_name }} <i class="fas fa-angle-down"
                                            aria-hidden="true"></i></span>
                                </a>
                            </li>
                        </ul>
                        <div class="open_menu">

                            <ul>
                                {{-- Dashboard --}}
                                {{-- <li class="{{ request()->segment(1)=='home' ? 'active' : '' }}">
                                <a href="{{ $isProfileComplete ? route('home') : 'javascript:void(0)' }}"
                                   class="{{ !$isProfileComplete ? 'disabled-link' : '' }}"
                                   title="{{ !$isProfileComplete ? 'Please complete your profile to access Dashboard' : '' }}">

                                    Dashboard
                                </a>
                            </li> --}}

                                {{-- My Profile --}}
                                <li class="{{ request()->segment(1) == 'my-profile' ? 'active' : '' }}">
                                    <a href="{{ route('my.profile') }}">

                                        Profile
                                    </a>
                                </li>

                                {{-- Book a Session --}}
                                <li
                                    class="{{ request()->is('studentbook-class') || request()->is('student-bookingconfirmation') ? 'active' : '' }}">
                                    <a href="{{ $isProfileComplete ? url('tutor-search-result?grade=' . optional($myGrade)->slug) : 'javascript:void(0)' }}"
                                        class="{{ !$isProfileComplete ? 'disabled-link' : '' }}"
                                        title="{{ !$isProfileComplete ? 'Please complete your profile to book a session' : '' }}">

                                        Book a Session
                                    </a>
                                </li>

                                {{-- Sessions --}}
                                <li class="{{ request()->segment(1) == 'my-class' ? 'active' : '' }}">
                                    <a href="{{ $isProfileComplete ? route('student.my.classes') : 'javascript:void(0)' }}"
                                        class="{{ !$isProfileComplete ? 'disabled-link' : '' }}"
                                        title="{{ !$isProfileComplete ? 'Please complete your profile to view sessions' : '' }}">

                                        Sessions
                                    </a>
                                </li>

                                {{-- My Tutors --}}
                                <li class="{{ request()->segment(1) == 'student-mytutors' ? 'active' : '' }}">
                                    <a href="{{ $isProfileComplete ? route('list.of.favourite') : 'javascript:void(0)' }}"
                                        class="{{ !$isProfileComplete ? 'disabled-link' : '' }}"
                                        title="{{ !$isProfileComplete ? 'Please complete your profile to access tutors' : '' }}">

                                        Tutors
                                    </a>
                                </li>

                                {{-- My Reviews --}}
                                <li class="{{ request()->segment(1) == 'my-review' ? 'active' : '' }}">
                                    <a href="{{ $isProfileComplete ? route('student.my.review.no.slug') : 'javascript:void(0)' }}"
                                        class="{{ !$isProfileComplete ? 'disabled-link' : '' }}"
                                        title="{{ !$isProfileComplete ? 'Please complete your profile to access reviews' : '' }}">

                                        Reviews
                                    </a>
                                </li>

                                {{-- Payments --}}
                                <li class="{{ request()->segment(1) == 'student-my-payments' ? 'active' : '' }}">
                                    <a href="{{ $isProfileComplete ? route('student.my.payments') : 'javascript:void(0)' }}"
                                        class="{{ !$isProfileComplete ? 'disabled-link' : '' }}"
                                        title="{{ !$isProfileComplete ? 'Please complete your profile to access payments' : '' }}">
                                        Payments
                                    </a>
                                </li>
                            </ul>

                            <ul>
                                <li>
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form-two').submit();">

                                        Logout
                                    </a>
                                    <form id="logout-form-two" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            </ul>

                        </div>
        </nav>
    </div>
</header>
@include('include.common_modal')
