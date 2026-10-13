@section('head')
@include('include.head')
@endsection
<header class="header_sec">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light nav_top">
            <a class="navbar-brand" href="{{route('landing.page')}}"><img src="{{ public_asset('assets/images/logo.png')}}" alt="logo" /></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                <!-- <ul class="mr-auto">
                </ul> -->
                <ul class="navbar-nav menu_sec after-login new-affter">

                    <li class="dropdown"> <a href="#" class="dropdown-toggle drop-arw" data-toggle="dropdown">Support</a><span class="dropdown-toggle drop-arw" data-toggle="dropdown">
                    <i class="fas fa-angle-down"></i>
                </span>
                <ul class="dropdown-menu">
                    {{-- <li><a href="{{ route('faq') }}">FAQ’s</a></li> --}}
                             <!--li><a href="{{ route('help') }}">Help Section</a></li-->
                            <li><a href="{{ route('contact.us') }}">Message Us</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <div class="login_menu after_log ">
        <ul class="click_open">
            <li>
                <a href="#"> <em>  @if(Auth::user()->profile_pic)
                    <img src="{{url('/')}}/storage/teacher_profile_pic/{{@Auth::user()->profile_pic}}" alt="profile_img" style="width: 100%;height: 100%">

                    @elseif(!@Auth::user()->profile_pic && @Auth::user()->avatar)
                    <img src="{{@Auth::user()->avatar}}" alt="profile_img" style="width: 100%" class="selected_avatar_upd">
                    @else
                    <img src="{{ public_asset('assets/images/blank1.png')}}" alt="profile_img" style="width: 100%" class="selected_avatar_upd">
                    @endif</em> <span>Hi, {{@Auth::user()->f_name}} <i class="fas fa-angle-down" aria-hidden="true"></i></span> </a>
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
                                <a href="{{route('tutor.myclass')}}">   Sessions </a>
                            </li>
                            <li class="{{request()->segment(2)=='tutor-my-payments'?'acv':''}} ">
                                <a href="{{route('tutor.my.payments')}}"> Payments  </a>
                            </li>
                            <li class=" {{request()->segment(2)=='my-review'?'active':''}} ">
                                <a href="{{ route('tutor.my.review') }}"> Reviews </a>
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

                    {{-- @if(@Auth::user()->user_type == 'T' && @Auth::user()->status == 'AA')
                    <li class="{{request()->segment(2)=='tutor-awaiting-approval-my-profile'?'acv':''}} ">
                        <a href="{{route('tutor.awaiting.approval.profile')}}">My Profile</a>
                    </li>
                    @endif --}}
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
    </nav>
</div>
</header>
