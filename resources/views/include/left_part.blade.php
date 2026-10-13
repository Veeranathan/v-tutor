{{-- this is the login , registration, and landing page header html load --}}
@php
    use App\Models\TutorApplicationFormsModel;
    $taf_data = TutorApplicationFormsModel::Where('tutor_id', @Auth::user()->id)
        ->orderby('id', 'desc')
        ->first();
@endphp

@section('head')
    @include('include.head')
    <style>
        /* Center the modal vertically & horizontally */
        .modal-dialog.modal-dialog-centered {
            display: flex;
            align-items: center;
            min-height: calc(100vh - 1rem);
        }

        /* Optional fallback centering if Bootstrap doesn’t handle it */
        .log_modal_bx .modal {
            position: fixed;
            top: 50% !important;
            left: 50% !important;
            transform: translate(-50%, -50%) !important;
        }

        /* Modal content styling */
        .log_modal_bx .modal-content {
            border-radius: 8px;
            overflow: hidden;
            max-width: 500px;
            /* adjust width as needed */
            width: 90%;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        /* Modal header */
        .log_modal_bx .modal-header {
            background-color: #fff;
            border-bottom: 1px solid #e5e5e5;
            padding: 1rem 1.5rem;
        }

        .log_modal_bx .modal-header .modal-title {
            font-size: 1.25rem;
            font-weight: bold;
            margin: 0;
            color: #000;
        }

        .log_modal_bx .modal-header .btn-close {
            background: none;
            border: none;
            font-size: 1.25rem;
        }

        /* Modal body */
        .log_modal_bx .modal-body {
            padding: 1.5rem;
            text-align: center;
        }

        .log_modal_bx .modal-body p {
            font-size: 1rem;
            margin: 0 0 1rem 0;
            color: #333;
        }

        /* Button group: centered and spaced */
        .log_modal_bx .button-group {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        /* Button styles */
        .log_modal_bx .btn-login,
        .log_modal_bx .btn-signup {
            min-width: 140px;
            padding: 0.65rem 1.2rem;
            font-size: 1rem;
            font-weight: 600;
            /* Removed uppercase transform */
            text-transform: none;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        /* Red buttons */
        .log_modal_bx .btn-login {
            background-color: #c00;
            /* your brand red */
        }

        .log_modal_bx .btn-login:hover {
            background-color: #a00;
        }

        /* If both should have same color */
        .log_modal_bx .btn-signup {
            background-color: #c00;
        }

        .log_modal_bx .btn-signup:hover {
            background-color: #a00;
        }

        /* Responsive: stack buttons on very small screens */
        @media (max-width: 400px) {
            .log_modal_bx .button-group {
                flex-direction: column;
                gap: 0.75rem;
            }

            .log_modal_bx .btn-login,
            .log_modal_bx .btn-signup {
                width: 100%;
                min-width: auto;
            }
        }
       
    </style>
@endsection
<header class="header_sec">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light nav_top">
            <a class="navbar-brand" href="{{ url('/') }}"><img src="{{ public_asset('assets/images/logo.png') }}"
                    alt="logo" /></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                <ul class="navbar-nav menu_sec branch_show_ul">

                    @if (!@Auth::check() || @Auth::user()->user_type == 'U')
                        <li class="dropdown">
                            <a class="dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Find V-Tutor
                            </a>
                            <span class="dropdown-toggle drop-arw" data-toggle="dropdown">
                                <i class="fas fa-angle-down"></i>
                            </span>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <li class="dropdown-submenu"><a class="dropdown-toggle" href="#">By Grade</a>
                                    <ul class="dropdown-menu grade_new_cls_d">
                                        @php
                                            $grades = \App\Models\Grade::where(['status' => 'A'])
                                                ->select('id', 'slug', 'grade_name', 'capture_code', 'status')
                                                ->get();
                                            $subjects = \App\Models\Subject::where(['status' => 'A'])
                                                ->select('slug', 'subject', 'capture_code', 'status')
                                                ->orderBy('display_order', 'asc')
                                                ->get();
                                            $branches = \App\Models\Branch::with(['getAllSubjects'])
                                                ->where(['status' => 'A'])
                                                ->orderBy('display_order', 'asc')
                                                ->orderBy('display_order', 'asc')
                                                ->get();
                                            $disable_booking_details = \App\Models\AdminDisableBookings::first();
                                            $all_disabled_booking_dates = \App\Models\AdminDisableBookingDates::where(
                                                'status',
                                                'A',
                                            )
                                                ->pluck('disable_booking_date')
                                                ->toArray();
                                        @endphp
                                        @if (@$grades)
                                            @foreach (@$grades as $grade)
                                                <li><a class=""
                                                        href="{{ url('tutor-search-result?grade=') }}{{ @$grade->slug }}">Tutors
                                                        for {{ @$grade->grade_name }}</a></li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </li>
                                <li class="dropdown-submenu">
                                    <a class="dropdown-toggle" href="#">
                                        By Subject
                                    </a>
                                    <ul class="dropdown-menu grade_new_cls_d">
                                        @if (@$branches)
                                            @foreach (@$branches as $b)
                                                <li class="dropdown-submenu branch_show_li fgdt">
                                                    <a class=" "
                                                        href="{{ url('tutor-search-result?branch_id%5B%5D=') }}{{ @$b->slug }}">
                                                        {{ @$b->branch_name }}
                                                    </a>

                                                </li>
                                            @endforeach
                                        @endif

                                    </ul>
                                </li>

                            </ul>
                        </li>
                    @endif

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle drop-arw" data-toggle="dropdown">About Us</a><span
                            class="dropdown-toggle drop-arw" data-toggle="dropdown">
                            <i class="fas fa-angle-down"></i>
                        </span>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('about.us') }}">About V-Tutor</a></li>

                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle drop-arw" data-toggle="dropdown">Support</a><span
                            class="dropdown-toggle drop-arw" data-toggle="dropdown">
                            <i class="fas fa-angle-down"></i>
                        </span>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('faq') }}">FAQ’s</a></li>
                            <!--li><a href="{{ route('help') }}">Help</a></li!-->
                            <li><a href="{{ route('contact.us') }}">Message Us</a></li>

                        </ul>
                    </li>
                </ul>
            </div>
            <div class="hed_btn">
                <ul>
                    @if (!@Auth::check())
                        <li><a href="{{ url('login') }}" class="pg_btn">Log me in</a></li>
                    @endif

                    @if (!@Auth::check())
                        @if (@$disable_booking_details->disable_booking == 'Y')
                            <li><a data-toggle="modal" data-target="#admin_disabled_bookings_popup" class="pg_btn">Book
                                    a session</a></li>
                        @else
                            <a
                                @if (!@Auth::check()) href="javascript:void(0);" data-id="{{ @$tutor->id }}" data-toggle="modal" data-target="#log_modal{{ @$tutor->id }}" class="pg_btn" data-type="B"   @else href="{{ url('studentbook-class?search_tutor_slug_studentclass=' . @$tutor->slug . '&search_tutor_id_studentclass=' . @$tutor->id) }}" @endif>Book
                                a session</a>
                        @endif
                    @else
                        @if (@Auth::user()->user_type == 'U')
                            @php
                                $myGrade = \App\Models\Grade::where(['id' => @Auth::user()->grade, 'status' => 'A'])
                                    ->select('id', 'slug', 'status')
                                    ->first();
                                $myState = \App\Models\State::where(['id' => @Auth::user()->state])->first();
                            @endphp
                            <li><a href="{{ url('tutor-search-result?grade=' . @$myGrade->slug) }}" class="pg_btn">Book
                                    a
                                    session</a></li>
                        @endif
                    @endif

                    @if (request()->routeIs('tutor_landing'))
                        @if (Auth::user()->user_type !== 'U')
                            @if (!@Auth::check())
                                <li><a href="{{ route('reg.home') }}" class="pg_btn gj_taf_lb gj_taf_nlogin">Apply
                                        Now</a></li>
                            @else
                                <li><a href="{{ route('tutor_application_form') }}"
                                        class="pg_btn gj_taf_lb gj_taf_login">Apply Now</a></li>
                            @endif
                        @endif
                    @else
                        @if (!@Auth::check())
                            <li><a href="{{ route('tutor_landing') }}" class="pg_btn">Be a V-Tutor</a></li>
                            {{-- <li><a href="{{route('reg.home')}}" class="pg_btn">Be a V-Tutor</a></li> --}}
                        @else
                        @endif
                    @endif
                </ul>
            </div>
            @if (@Auth::check())
   <div>
    <button id="bellButton"
        class="relative p-2 text-gray-600 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
        <!-- Bell Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" fill="red" viewBox="0 0 24 24" class="w-6 h-6">
            <path
                d="M12 2a6 6 0 0 0-6 6v4.586l-.707.707A1 1 0 0 0 6 15h12a1 1 0 0 0 .707-1.707L18 12.586V8a6 6 0 0 0-6-6zm0 20a2.5 2.5 0 0 0 2.45-2h-4.9a2.5 2.5 0 0 0 2.45 2z" />
        </svg>

        <!-- Notification Badge -->
        <span id="bookingCount"
            class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold text-white bg-red-600 rounded-full transform translate-x-1/2 -translate-y-1/2 hidden">
            0
        </span>
    </button>

    <!-- 🔹 Dropdown Menu -->
    <div id="bookingDropdown" style="display:none"
        class="hidden absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg z-50 ring-1 ring-black ring-opacity-5">

        <!-- Header -->
       xzcxzcxzcxzcz <div class="flex items-center justify-between px-4 py-2 border-b border-gray-200">
            <span class="font-semibold text-gray-800">Notifications</span>
            <button id="markAllReadBtn"
                class="text-sm text-blue-600 hover:text-blue-800 focus:outline-none">
                Mark all as read
            </button>
        </div>

        <!-- Scrollable List -->
        <ul id="bookingList" class="max-h-64 overflow-y-auto py-1">
            <!-- Notifications will be loaded dynamically -->
        </ul>
    </div>
</div>

                <div class="login_menu after_log header_book_user_drop">
                    <ul class="click_open">
                        <li>
                            <a href="#"> <em>
                                    @if (@Auth::user()->profile_pic)
                                        @if (@Auth::user()->user_type == 'T')
                                            <img src="{{ url('/') }}/storage/teacher_profile_pic/{{ @Auth::user()->profile_pic }}"
                                                alt="profile_img" style="width: 100%;height: 100%">
                                            {{-- @php
                                    @$image_path = 'assets/images/all_avatars/'.@Auth::user()->profile_pic;
                                @endphp
                                @if (file_exists(@$image_path))
                            		<img src="{{ public_asset('assets/images/all_avatars/' . @Auth::user()->profile_pic) }}" alt="profile_img" style="width: 100%;height: 100%">
                            	@else
                            		<img src="{{ public_asset('assets/images/blank1.png')}}" alt="profile_img" style="width: 100%">
                            	@endif --}}
                                        @else
                                            <img src="{{ public_asset('assets/images/all_avatars/' . @Auth::user()->profile_pic) }}"
                                                alt="profile_img" style="width: 100%;height: 100%">
                                        @endif
                                    @elseif(!@Auth::user()->profile_pic && @Auth::user()->avatar)
                                        <img src="{{ @Auth::user()->avatar }}" alt="profile_img"
                                            style="width: 100%">
                                    @else
                                        <img src="{{ public_asset('assets/images/blank1.png') }}" alt="profile_img"
                                            style="width: 100%">
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

                                    @if (!@Auth()->user()->platform_id)
                                        <li>

                                            <a href="{{ route('student.reset.password.view') }}">Change Password</a>
                                        </li>
                                    @endif
                                @endif

                                <li>
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                        <span></span> Logout</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
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
                                        <li class="{{ request()->segment(2) == 'payment-history' ? 'acv' : '' }} ">
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
												document.getElementById('logout-form').submit();">
                                        <span></span> Logout</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf

                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endif
                </div>
            @endif
        </nav>
    </div>
    <div class="modal fade log_modal_bx" id="log_modal{{ @$tutor->id }}">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Login / Sign up</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <p>Click on Login or Sign up to continue</p>
                    <div class="button-group">
                        <a href="{{ route('login') }}" class="btn btn-login">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-signup">Sign up</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</header>

@include('include.common_modal')
