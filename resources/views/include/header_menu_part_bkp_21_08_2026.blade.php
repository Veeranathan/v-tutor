{{-- this is the login , registration, and landing page header html load --}}
@php
    use App\Models\TutorApplicationFormsModel;
    $taf_data = TutorApplicationFormsModel::Where('tutor_id', @Auth::user()->id)
        ->orderby('id', 'desc')
        ->first();
@endphp

@section('head')

    <style>
        .profile-user-name a i,
        .profile-user-name a span {
            color: white !important;
        }

        .profile-user-name a em {
            background-color: white !important;

        }
        @media only screen and (max-width: 768px) {
        .primary-button.book-resp {
            font-size: 9px !important;
            padding: 2px 2px !important;
            margin-top: 4px;
        }
}
    </style>

    @include('include.head')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- <link href="{{ public_asset('assets/faro_font/stylesheet.css') }}" rel="stylesheet"> --}}
    <link href="{{ public_asset('assets/css/landing_animation.css') }}" rel="stylesheet" type="text/css">
@endsection

<header class="header_sec shadow-none gj_hdr_sec">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-custom p-0 d-flex justify-content-between align items-center">
            <div class=" p-0">
                <div class="top-menu-container">
                    <div class="top-menu">
                        <img src="{{ public_asset('assets/images/top-menu.svg') }}" alt="V-Tutor online tutors Australia" />
                    </div>

                    <div class="top-menu-popup">
                        <div class="vtutor-section">
                            <div class="">
                                <div class="row  mx-0">
                                    <div class="col-lg-2 col-md-3 col-sm-6 col-6 mb-4 order-1">
                                            <h5>Our Programs</h5>
                                        <ul class="list-group vtutor-list">
                                            <li class="list-group-item">
                                                <a href="{{ route('products',['type'=>'learning']) }}">Learning Programs</a>
                                            </li>
                                            <li class="list-group-item">
                                                <a href="{{ route('products',['type'=>'mlp']) }}">Micro Learning Programs</a>
                                            </li>
                                            <li class="list-group-item">
                                                <a href="{{ route('products',['type'=>'ctp']) }}">Core Training Programs</a>
                                            </li>
                                            <li class="list-group-item">
                                                <a href="{{ route('products',['type'=>'oc']) }}">OC Programs</a>
                                            </li>
                                            <li class="list-group-item">
                                                <a href="{{ route('products',['type'=>'naplan']) }}">NAPLAN</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-1 col-md-2 col-sm-6 col-6 mb-4 order-1">
                                        <h5>Subjects</h5>
                                            <ul class="list-group vtutor-list">
                                                 @foreach(config('menu.subject', []) as $slug => $label)
                                                <li class="list-group-item">
                                                    <a href="{{ url('subject/'.$slug) }}">{{ $label }}</a>
                                                </li>
                                                 @endforeach
                                            </ul>
                                    </div>
                                    <div class="col-lg-1 col-md-2 col-sm-6 col-6 mb-4 order-1">
                                        <h5>Year</h5>
                                        <ul class="list-group vtutor-list">
                                            @foreach(config('menu.year', []) as $slug => $label)
                                            <li class="list-group-item">
                                                <a href="{{ url('year/'.$slug) }}">{{ $label }}</a>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <!-- <div class="col-lg-2 col-md-3 col-sm-6 col-6 mb-4 order-1">
                                        <h5>Curriculum</h5>
                                            <ul class="list-group vtutor-list">
                                                 @foreach(config('menu.curriculum', []) as $slug => $label)
                                                <li class="list-group-item">
                                                    <a href="{{ url('curriculum/'.$slug) }}">{{ $label }}</a>
                                                </li>
                                                @endforeach
                                            </ul>
                                    </div> -->
                                    <div class="col-lg-2 col-md-3 col-sm-6 col-6 mb-4 order-1">
                                        <h5>States</h5>
                                            <ul class="list-group vtutor-list">
                                                 @foreach(config('menu.state', []) as $slug => $label)
                                                <li class="list-group-item">
                                                    <a href="{{ url('state/'.$slug) }}">{{ $label }}</a>
                                                </li>
                                                 @endforeach
                                            </ul>
                                    </div>
                                    <div class="col-lg-2 col-md-3 col-sm-6 col-6 mb-4 order-1">
                                        <h5>V-Tutor</h5>
                                        <ul class="list-group vtutor-list">
                                            <li class="list-group-item active"><a href="{{ url('/') }}">Home</a>
                                            </li>
                                            <li class="list-group-item"><a href="{{ route('about.us') }}">About Us</a>
                                            </li>
                                            <li class="list-group-item"><a href="{{ route('search.result.j') }}">Find Tutors</a></li>
                                            <li class="list-group-item"><a href="{{ url('faq') }}">FAQs</a></li>
                                            <li class="list-group-item"><a href="{{ url('terms-service') }}">Terms Of Service
                                                    </a></li>
                                            <li class="list-group-item"><a href="{{ url('privacy-policy') }}">Privacy
                                                    Policy</a></li>
                                            <li class="list-group-item"><a href="{{ url('terms-conditions') }}">Terms &
                                                    Conditions</a></li>
                                        </ul>
                                    </div>

                                    <!-- <div class="col-lg-2 col-md-3 col-sm-6 col-6 mb-4 order-4 order-lg-2 px-0">
                                        <h5>Resources</h5>
                                        <ul class="list-group vtutor-list">
                                            <li class="list-group-item"><a href="{{ url('faq') }}">FAQs</a></li>
                                            <li class="list-group-item"><a href="{{ url('terms-service') }}">Terms Of Service
                                                    </a></li>
                                            <li class="list-group-item"><a href="{{ url('privacy-policy') }}">Privacy
                                                    Policy</a></li>
                                            <li class="list-group-item"><a href="{{ url('terms-conditions') }}">Terms &
                                                    Conditions</a></li>
                                        </ul>
                                    </div> -->
                                    <div class="col-lg-4 col-md-5 col-sm-6 col-6 mb-4 order-1">
                                        <h6 class="mb-4">Turn Passion Into Purpose</h6>
                                        <div class="ratio ratio-16x9 mb-3 "
                                            style="background-image: url({{ public_asset('assets/images/landing_tutor/menu_banner.png') }}); background-size: cover; background-position: center; min-height: 180px; border-radius:20px;">

                                        </div>
                                        <div class="cta-content">
                                            <h2 class="pt-2">Teach Your Way. Join Today!</h2>
                                            <p class="py-3">Join a community of educators making a difference</p>
                                            <div class="pt-1">
                                                <a href="{{ route('tutor_landing') }}" class="cta-link">
                                                    Be a V-Tutor <i class="fas fa-chevron-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4 ">
                                <div
                                    class="d-flex flex-wrap justify-content-start g-2 align-items-center menu-footer mb-2">
                                    <div class="key_img"> <img
                                            src="{{ public_asset('assets/images/landing_tutor/key.png') }}"
                                            class="" alt="V-Tutor online tutoring Australia key icon"></div>
                                    <p class="mb-0">Give your child the best start with Australia’s most trusted
                                        tutoring platform —
                                        book your first session now.</p>

                                    @if (!@Auth::check())
                                        @if (@$disable_booking_details->disable_booking == 'Y')
                                            <a data-toggle="modal" data-target="#admin_disabled_bookings_popup"
                                                class="bk_btn_mm_link">
                                                <button class="  primary-button mr-3">Book a Session</button>
                                            </a>
                                        @else
                                            <a
                                                @if (!@Auth::check()) href="javascript:void(0);" data-id="{{ @$tutor->id }}" data-toggle="modal" data-target="#log_modal{{ @$tutor->id }}" class="bk_btn_mm_link" data-type="B"   @else href="{{ url('studentbook-class?search_tutor_slug_studentclass=' . @$tutor->slug . '&search_tutor_id_studentclass=' . @$tutor->id) }}" @endif>
                                                <button class="  primary-button mr-3">Book a Session</button>
                                            </a>
                                        @endif
                                    @else
                                        @if (@Auth::user()->user_type == 'U')
                                            @php
                                                $myGrade = \App\Models\Grade::where([
                                                    'id' => @Auth::user()->grade,
                                                    'status' => 'A',
                                                ])
                                                    ->select('id', 'slug', 'status')
                                                    ->first();
                                                $myState = \App\Models\State::where([
                                                    'id' => @Auth::user()->state,
                                                ])->first();
                                            @endphp

                                            <a href="{{ url('tutor-search-result?grade=' . @$myGrade->slug) }}"
                                                class="bk_btn_mm_link"><button class="  primary-button mr-3">Book A
                                                    Session</button></a>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <a class="navbar-brand" href="{{ url('/') }}"><img
                        src="{{ public_asset('assets/images/landing_tutor/logo_white.svg') }}" alt="V-Tutor online tutoring Australia logo"
                        class="main-logo" /></a>

                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav d-none d-lg-flex me-3">
                    </ul>
                </div>

            </div>
            <div class="d-flex align-items-center ">
                @if (Request::url() === url('/tutor-landing'))
                    @if (!@Auth::check())
                        <li><a href="{{ route('reg.home') }}"
                                class="gj_apply_now active primary-button mr-3 d-none d-md-block">Apply Now</a></li>
                    @else
                        @if (@Auth::user()->user_type == 'T')
                            <li><a href="{{ route('tutor_application_form') }}"
                                    class="gj_apply_now active primary-button mr-3 d-none d-md-block">Apply
                                    Now</a></li>
                        @endif
                    @endif
                @else
                    <!-- <a href="{{ url('tutor-search-result') }}" class="bk_btn_hdr_link"><button class="primary-button mr-3 d-none d-md-block">Find Tutors</button></a>         -->
                    @if (!@Auth::check())
                        {{-- @if (@$disable_booking_details->disable_booking == 'Y')
                        <a data-toggle="modal" data-target="#admin_disabled_bookings_popup" class="bk_btn_hdr_link">
                            <button class="  primary-button book-resp mr-3 d-md-block">Book a Session</button>
                        </a>
                    @else --}}
                        <!-- <a
                            @if (!@Auth::check()) href="javascript:void(0);" data-id="{{ @$tutor->id }}" data-toggle="modal" data-target="#log_modal{{ @$tutor->id }}" class="bk_btn_hdr_link" data-type="B"   @else href="{{ url('studentbook-class?search_tutor_slug_studentclass=' . @$tutor->slug . '&search_tutor_id_studentclass=' . @$tutor->id) }}" @endif>
                            <button class="  primary-button book-resp mr-3 d-md-block">Book a Session</button>
                        </a> -->
                         <a
                            href="{{ route('products',['type'=>'learning']) }}"  class="bk_btn_hdr_link">
                            <button class=" primary-button book-resp mr-3 d-md-block">Get Programs</button>
                        </a>
                        {{-- @endif --}}
                    @else
                        @if (@Auth::user()->user_type == 'U')
                            @php
                                $myGrade = \App\Models\Grade::where(['id' => @Auth::user()->grade, 'status' => 'A'])
                                    ->select('id', 'slug', 'status')
                                    ->first();
                                $myState = \App\Models\State::where(['id' => @Auth::user()->state])->first();
                            @endphp

                            <!-- <a href="{{ url('tutor-search-result?grade=' . @$myGrade->slug) }}"
                                class="bk_btn_hdr_link"><button class="  primary-button d-none book-resp mr-3 d-md-block">Book A
                                    Session</button></a> -->
                             <a href="{{ route('products',['type'=>'learning']) }}"  class="bk_btn_hdr_link">
                                <button class=" primary-button book-resp mr-3 d-md-block">Get Programs</button>
                            </a>
                        @endif
                    @endif


                    @if (@Auth::check())
                        <a href="{{ route('contact.us') }}" class="be_a_tut_hdr_link"><button
                                class="  primary-button mr-3 d-none d-md-block">Support</button></a>
                    @else
                        <a href="{{ route('tutor_landing') }}" class="be_a_tut_hdr_link"><button
                                class="  thrid-button mr-3 d-none d-md-block">Be a V-Tutor</button></a>
                    @endif
                @endif


                @if (@Auth::check())
                    <ul class="navbar-nav menu_sec after-login flex items-center space-x-4">
                        <li class="dropdown nav-item relative">
                            <button id="bellButton"
                                 class="relative p-2 text-gray-600 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <!-- Red Bell Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 24 24"
                                    class="w-6 h-6">
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
                    </ul>
                    <div class="login_menu after_log header_book_user_drop">
                        <ul class="click_open">
                            <li class="text-white hover:text-white profile-user-name">
                                <a href="#"> <em>
                                        @if (@Auth::user()->profile_pic)
                                            @if (@Auth::user()->user_type == 'T')
                                                <img src="{{ url('/') }}/storage/teacher_profile_pic/{{ @Auth::user()->profile_pic }}"
                                                    alt="profile_img" class="profile_img" style="width: 100%;height: 100%">
                                            @else
                                                <img src="{{ public_asset('assets/images/all_avatars/' . @Auth::user()->profile_pic) }}"
                                                    alt="profile_img" class="profile_img" style="width: 100%;height: 100%">
                                            @endif
                                        @elseif(!@Auth::user()->profile_pic && @Auth::user()->avatar)
                                            <img src="{{ @Auth::user()->avatar }}" alt="profile_img" class="profile_img"
                                                style="width: 100%">
                                        @else
                                            <img src="{{ public_asset('assets/images/user_login.png') }}"
                                                alt="profile_img" class="profile_img" style="width: 100%">
                                            {{-- <img src="{{ public_asset('assets/images/blank1.png') }}" alt="profile_img" class="profile_img" style="width: 100%"> --}}
                                        @endif

                                    </em> <span>Hi, {{ @Auth::user()->f_name }} <i class="fas fa-angle-down"
                                            aria-hidden="true"></i></span> </a>
                            </li>
                        </ul>
                        @if (@Auth::user()->user_type == 'U')
                            <div class="open_menu" style="display: none;">
                                <ul>
                                    @if (@Auth::user()->status == 'A')
                                        {{-- <li  class="acv">
                                    <a href="{{ url('home') }}"> Dashboard</a>
                                </li> --}}
                                        <li>
                                            <a href="{{ url('tutor-search-result?grade=' . @$myGrade->slug) }}">Book a
                                                Session</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('my-profile') }}"> Profile</a>
                                        </li>
                                        @if (@Auth::user()->user_type == 'U')
                                            <li>
                                                <a href="{{ route('student.my.classes') }}"> Sessions</a>
                                            </li>
                                        @elseif(@Auth::user()->user_type == 'T')
                                            <li>
                                                <a href="{{ route('tutor.myclass') }}"> Sessions</a>
                                            </li>
                                        @endif
                                        <li>
                                            <a href="{{ route('list.of.favourite') }}">My Tutors</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('student.my.review.no.slug') }}">My Reviews</a>
                                        </li>

                                        <li>
                                            <a href="{{ route('student.my.payments') }}"> Payments </a>
                                        </li>

                                        <li>
                                            <a href="{{ route('student.my.academic.program') }}"> Learning Programs </a>
                                        </li>

                                        @if (!@Auth()->user()->platform_id)
                                            <li>

                                                <a href="{{ route('student.reset.password.view') }}">Change
                                                    Password</a>
                                            </li>
                                        @endif
                                    @endif

                                    <li class="">
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                    document.getElementById('logout-form-two').submit();">
                                            <span></span> Logout</a>
                                        <form id="logout-form-two" action="{{ route('logout') }}" method="POST"
                                            style="display: none;">
                                            @csrf

                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <div class="open_menu" style="display: none;">
                                <ul>
                                    @if (@Auth::user()->user_type == 'T')
                                        @if (@Auth::user()->status == 'A' && @Auth::user()->subscription == 'S' && @Auth::user()->draft == 'N')
                                            {{-- <li class="{{request()->segment(2)=='home'?'acv':''}} ">
                                                <a href="{{route('teacher.home')}}"> Dashboard</a>
                                            </li> --}}
                                            <li class="{{ request()->segment(2) == 'my-profile' ? 'acv' : '' }} ">

                                                <a href="{{ route('teacher.profile') }}">Profile</a>

                                            </li>
                                            <li class="{{ request()->segment(2) == 'my-availablity' ? 'acv' : '' }} ">
                                                <a href="{{ route('tutor.availability') }}"> Schedule </a>
                                            </li>
                                            <li class="{{ request()->segment(2) == 'my-class' ? 'acv' : '' }} ">
                                                <a href="{{ route('tutor.myclass') }}"> Sessions </a>
                                            </li>
                                            <li
                                                class="{{ request()->segment(2) == 'payment-history' ? 'acv' : '' }} ">
                                                <a href="{{ route('tutor.my.payments') }}"> Payments </a>
                                            </li>
                                            <li class="">
                                                <a href="{{ route('tutor.my.review') }}"> Reviews </a>
                                            </li>

                                            @if (!@Auth()->user()->platform_id)
                                                <li class="">

                                                    <a href="{{ route('teacher.reset.password.view') }}">Change
                                                        Password</a>
                                                </li>
                                            @endif
                                        @elseif(@Auth::user()->status == 'A')
                                            <li class="{{ request()->segment(2) == 'my-profile' ? 'acv' : '' }} ">
                                                <a href="{{ route('teacher.profile') }}">Profile</a>
                                            </li>

                                            @if (!@Auth()->user()->platform_id)
                                                <li class="">

                                                    <a href="{{ route('teacher.reset.password.view') }}">Change
                                                        Password</a>
                                                </li>
                                            @endif
                                        @endif
                                    @endif

                                    <li class="">
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                    document.getElementById('logout-form-two').submit();">
                                            <span></span> Logout</a>
                                        <form id="logout-form-two" action="{{ route('logout') }}" method="POST"
                                            style="display: none;">
                                            @csrf

                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @endif
                    </div>
                @else
                    <a href="{{ url('login') }}" class="login_hdr_link notlogin_hdr_link">
                        <button class="  secondary-button mr-0 d-flex justify-content-center align-items-center">
                            <div class="d-flex mr-2">
                                <img src="{{ public_asset('assets/images/landing_tutor/user.svg') }}"
                                    alt="Best online tutoring Australia" />
                            </div> Login
                        </button>
                    </a>
                @endif
            </div>
        </nav>
    </div>
    <div class="modal log_modal_bx xxx" id="log_modal{{ @$tutor->id }}">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title"> Please signup or login to continue</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="modal_button search_nt_cls">
                        <ul>
                            <li><a href="{{ route('login') }}" style="color: #fff !important;"
                                    class="pg_btn">Login</a>
                            </li>
                            <li><a href="{{ route('register') }}" style="color: #fff !important;"
                                    class="pg_btn">Signup</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

@include('include.common_modal')
