{{-- this is the login , registration, and landing page header html load --}}
@php
	use App\Models\TutorApplicationFormsModel;
	$taf_data = TutorApplicationFormsModel::Where('tutor_id', @Auth::user()->id)->orderby('id', 'desc')->first();	
@endphp

@section('head')
    @include('include.tutor_head')
@endsection

<header class="header_section">
	<div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav class="navbar navbar-expand-lg navbar-light nav_top">
                    <a class="navbar-brand" href="{{ url('/') }}"><img src="{{ public_asset('assets/tutor_landing/v-tutor-header-logo.svg') }}" alt="logo" /></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                        <ul class="navbar-nav menu_sec branch_show_ul">
                            {{-- <li><a href="{{ route('about.us') }}">Blog</a></li> --}}

                            <li><a href="{{ route('about.us') }}" class="{{ (request()->routeIs('about.us')) ? 'active' : '' }}">About Us</a></li>
                            <li><a href="{{ route('faq') }}" class="{{ (request()->routeIs('faq')) ? 'active' : '' }}">FAQ</a></li>

                            @if (request()->routeIs('tutor_landing'))
                                @if(!@Auth::check())
                                    <li><a href="{{route('reg.home')}}" class="gj_apply_now active">Apply Now</a></li>
                                @else
                                    @if(@Auth::user()->user_type == 'T')
                                        <li><a href="{{route('tutor_application_form')}}" class="gj_apply_now active">Apply Now</a></li>
                                    @endif
                                @endif
                            @else
                                @if(!@Auth::check())
                                    <li><a href="{{route('tutor_landing')}}" class="gj_be_a_vtutor {{ (request()->routeIs('tutor_landing')) ? 'active' : '' }}">Be a V-Tutor</a></li>
                                @else
                                @endif
                            @endif

                            @if(@Auth::check())
                                <div class="login_menu after_log header_book_user_drop">
                                    <ul class="click_open">
                                        <li>
                                            <a href="#">  <em>
                                            @if(@Auth::user()->profile_pic)
                                            @if(@Auth::user()->user_type == 'T')
                                                <img src="{{url('/')}}/storage/teacher_profile_pic/{{@Auth::user()->profile_pic}}" alt="profile_img" style="width: 100%;height: 100%">
                                                {{-- @php
                                                    @$image_path = 'assets/images/all_avatars/'.@Auth::user()->profile_pic;
                                                @endphp
                                                @if(file_exists(@$image_path))
                                                    <img src="{{ public_asset('assets/images/all_avatars/' . @Auth::user()->profile_pic) }}" alt="profile_img" style="width: 100%;height: 100%">
                                                @else
                                                    <img src="{{ public_asset('assets/images/blank1.png')}}" alt="profile_img" style="width: 100%">
                                                @endif --}}
                                            @else
                                                <img src="{{ public_asset('assets/images/all_avatars/' . @Auth::user()->profile_pic) }}" alt="profile_img" style="width: 100%;height: 100%">
                                            @endif
                                            @elseif(!@Auth::user()->profile_pic && @Auth::user()->avatar)
                                            <img src="{{@Auth::user()->avatar}}" alt="profile_img" style="width: 100%">
                                            @else
                                            <img src="{{ public_asset('assets/images/blank1.png')}}" alt="profile_img" style="width: 100%">
                                            @endif

                                            </em> <span>Hi, {{@Auth::user()->f_name}} <i class="fas fa-angle-down" aria-hidden="true"></i></span> </a>
                                        </li>
                                    </ul>
                                    <div class="open_menu" style="display: none;">
                                            <ul>
                                                @if(@Auth::user()->user_type == 'T')
                                                    @if((@Auth::user()->status == 'A') && (@Auth::user()->subscription == 'S') && (@Auth::user()->draft == 'N'))
                                                        {{-- <li class="{{request()->segment(2)=='home'?'acv':''}} ">
                                                            <a href="{{route('teacher.home')}}"> Dashboard</a>
                                                        </li> --}}
                                                        <li class="{{request()->segment(2)=='my-profile'?'acv':''}} ">

                                                            <a href="{{route('teacher.profile')}}">Profile</a>

                                                        </li>
                                                        <li class="{{request()->segment(2)=='my-availablity'?'acv':''}} ">
                                                            <a href="{{route('tutor.availability')}}"> Schedule </a>
                                                        </li>
                                                        <li class="{{request()->segment(2)=='my-class'?'acv':''}} ">
                                                            <a href="{{route('tutor.myclass')}}">  Sessions  </a>
                                                        </li>
                                                        <li class="{{request()->segment(2)=='payment-history'?'acv':''}} ">
                                                            <a href="{{ route('tutor.my.payments') }}"> Payments  </a>
                                                        </li>
                                                        <li class="">
                                                            <a href="{{route('tutor.my.review')}}"> Reviews </a>
                                                        </li>
                                                        
                                                        @if(!@Auth()->user()->platform_id)
                                                            <li class="">

                                                                <a href="{{route('teacher.reset.password.view')}}">Change Password</a>
                                                            </li>
                                                        @endif
                                                    @elseif((@Auth::user()->status == 'A'))
                                                        <li class="{{request()->segment(2)=='my-profile'?'acv':''}} ">
                                                            <a href="{{route('teacher.profile')}}">Profile</a>
                                                        </li>

                                                        @if(!@Auth()->user()->platform_id)
                                                            <li class="">

                                                                <a href="{{route('teacher.reset.password.view')}}">Change Password</a>
                                                            </li>
                                                        @endif
                                                    @endif
                                                @endif

                                                <li class="">
                                                    <a href="{{ route('logout') }}"
                                                                onclick="event.preventDefault();
                                                                document.getElementById('logout-form').submit();"> <span></span> Logout</a>
                                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                                    @csrf

                                                                </form>
                                                </li>
                                            </ul>
                                        </div>
                                </div>
                            @else
                                <li>
                                    {{-- {{ request()->route()->getName() }} --}}
                                    <a href="{{ url('login') }}" class="gj_tut_land_but d-flex {{ request()->routeIs('reg.home', 'login') ? 'active' : '' }}">
                                        @if (request()->routeIs('reg.home', 'login'))
                                            <img src="{{ public_asset('assets/tutor_landing/header_login_icon.svg') }}" alt="login_icon" class="gj_login_icon_normal" style="display: none"> 
                                            <img src="{{ public_asset('assets/tutor_landing/header_login_hover_icon.svg') }}" alt="login_icon" class="gj_login_icon_hover"> 
                                        @else
                                            <img src="{{ public_asset('assets/tutor_landing/header_login_icon.svg') }}" alt="login_icon" class="gj_login_icon_normal"> 
                                            <img src="{{ public_asset('assets/tutor_landing/header_login_hover_icon.svg') }}" alt="login_icon" class="gj_login_icon_hover" style="display: none"> 
                                        @endif
                                        Login
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>			  
                </nav>
            </div>
        </div>
	</div>
</header>

<div class="top_mar_div"></div>

@include('include.common_modal')

