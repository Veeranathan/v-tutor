<div class="user-left sticky_left">
    <div class="dasbordLeftsec"> <a href="#" class="showmeu"><i class="fa fa-bars"></i>Show Menus</a>
        <div class="dasbordLeft">
            <div class="user-left-info">
                <div class="user-left-top"><em>
                        @if (Auth::user()->profile_pic)
                            <img src="{{ url('/') }}/storage/teacher_profile_pic/{{ @Auth::user()->profile_pic }}"
                                alt="profile_img" style="width: 100%;height: 100%">
                        @elseif(!@Auth::user()->profile_pic && @Auth::user()->avatar)
                            <img src="{{ @Auth::user()->avatar }}" alt="profile_img" style="width: 100%"
                                class="selected_avatar_upd">
                        @else
                            <img src="{{ public_asset('assets/images/blank1.png') }}" alt="profile_img"
                                style="width: 100%" class="selected_avatar_upd">
                        @endif
                    </em>
                    @php
                        $totalClass = \App\Models\StudentClassBooking::where(['tutor_id' => @Auth::user()->id])
                            ->whereIn('booking_status', ['B', 'CM', 'C'])
                            ->count();
                    @endphp
                    <h2>{{ @Auth::user()->f_ame . ' ' . @Auth::user()->l_name }}</h2>
                    <p>
                        @if (@$totalClass <= 1)
                            {{ @$totalClass }} session
                        @else
                            {{ @$totalClass }} sessions
                        @endif
                    </p>
                </div>
                <!--h3 class="w-100 text-center fw-400">
                    {{ \Carbon\Carbon::now(Auth::user()->timezone_id ?? config('app.timezone'))->format('Y-m-d H:i:s') }}
                </h3-->
                <div class="new-lft-bottom">
                    <div class="user-left-menu">
                        <ul>
                            {{--  <li class="{{request()->segment(2)=='home'?'active':''}} {{ ((@Auth::user()->status == 'A') && (@Auth::user()->subscription == 'S') && (@Auth::user()->draft == 'N')) ? '' : 'gj_menu_disabled' }}"><a href="{{ ((@Auth::user()->status == 'A') && (@Auth::user()->subscription == 'S') && (@Auth::user()->draft == 'N')) ? route('teacher.home') : 'javascript:void(0)' }}"><span><img src="{{ public_asset('assets/images/ac1.png')}}" class="hovern"> <img src="{{ public_asset('assets/images/ac1-h.png')}}" class="hovera"></span>Dashboard</a></li> --}}

                            <li class="{{ request()->segment(2) == 'my-profile' ? 'active' : '' }}">
                                <a href=" {{ route('teacher.profile') }} "> <span><img
                                            src="{{ public_asset('assets/images/ac2.png') }}"" class="hovern"> <img
                                            src="{{ public_asset('assets/images/ac2-h.png') }}"
                                            class="hovera"></span>Profile</a>
                            </li>

                            <li
                                class="{{ request()->segment(2) == 'my-availablity' ? 'active' : '' }} {{ @Auth::user()->status == 'A' && @Auth::user()->subscription == 'S' && @Auth::user()->draft == 'N' ? '' : 'gj_menu_disabled' }}">
                                <a
                                    href="{{ @Auth::user()->status == 'A' && @Auth::user()->subscription == 'S' && @Auth::user()->draft == 'N' ? route('tutor.availability') : 'javascript:void(0)' }}">
                                    <span><img src="{{ public_asset('assets/images/man1.png') }}" class="hovern"> <img
                                            src="{{ public_asset('assets/images/man1-h.png') }}"
                                            class="hovera"></span>Schedule </a>
                            </li>

                            <li
                                class="{{ request()->segment(2) == 'my-class' ? 'active' : '' }} {{ @Auth::user()->status == 'A' && @Auth::user()->subscription == 'S' && @Auth::user()->draft == 'N' ? '' : 'gj_menu_disabled' }}">
                                <a
                                    href="{{ @Auth::user()->status == 'A' && @Auth::user()->subscription == 'S' && @Auth::user()->draft == 'N' ? route('tutor.myclass') : 'javascript:void(0)' }}">
                                    <span><img src="{{ public_asset('assets/images/ac4.png') }}" class="hovern"> <img
                                            src="{{ public_asset('assets/images/ac4-h.png') }}" class="hovera"></span>
                                    Sessions </a>
                            </li>

                            <li
                                class="{{ request()->segment(2) == 'tutor-my-payments' ? 'active' : '' }} {{ @Auth::user()->status == 'A' && @Auth::user()->subscription == 'S' && @Auth::user()->draft == 'N' ? '' : 'gj_menu_disabled' }}">
                                <a
                                    href="{{ @Auth::user()->status == 'A' && @Auth::user()->subscription == 'S' && @Auth::user()->draft == 'N' ? route('tutor.my.payments') : 'javascript:void(0)' }}">
                                    <span><img src="{{ public_asset('assets/images/ac5.png') }}" class="hovern"> <img
                                            src="{{ public_asset('assets/images/ac5-h.png') }}"
                                            class="hovera"></span>Payments </a>
                            </li>

                            <li
                                class="{{ request()->segment(2) == 'my-review' ? 'active' : '' }} {{ @Auth::user()->status == 'A' && @Auth::user()->subscription == 'S' && @Auth::user()->draft == 'N' ? '' : 'gj_menu_disabled' }}">
                                <a
                                    href="{{ @Auth::user()->status == 'A' && @Auth::user()->subscription == 'S' && @Auth::user()->draft == 'N' ? route('tutor.my.review') : 'javascript:void(0)' }}"><span><img
                                            src="{{ public_asset('assets/images/rat1.png') }}" class="hovern"> <img
                                            src="{{ public_asset('assets/images/rat1-h.png') }}"
                                            class="hovera"></span> Reviews </a>
                            </li>
                        </ul>
                    </div>

                    {{-- <div class="user-left-menu">
                        <ul>
                            <li class="disable-left"><a href="javascript:void(0);"><span><img src="{{ public_asset('assets/images/ac1.png')}}"" class="hovern"> <img src="{{ public_asset('assets/images/ac1-h.png')}}" class="hovera"></span>Dashboard</a></li>
                          <li class="disable-left">
                                <a href="javascript:void(0);"> <span><img src="{{ public_asset('assets/images/ac2.png')}}"" class="hovern"> <img src="{{ public_asset('assets/images/ac2-h.png')}}" class="hovera"></span>My Profile</a>
                            </li>
                            <li class="disable-left">
                                <a href="javascript:void(0);"> <span><img src="{{ public_asset('assets/images/man1.png')}}" class="hovern"> <img src="{{ public_asset('assets/images/man1-h.png')}}" class="hovera"></span>Schedule </a>
                            </li>
                            <li class="disable-left">
                                <a href="javascript:void(0);"> <span><img src="{{ public_asset('assets/images/ac4.png')}}"" class="hovern"> <img src="{{ public_asset('assets/images/ac4-h.png')}}" class="hovera"></span> Sessions </a>
                            </li>
                            <li class="disable-left">
                                <a href="javascript:void(0);"> <span><img src="{{ public_asset('assets/images/ac5.png')}}"" class="hovern"> <img src="{{ public_asset('assets/images/ac5-h.png')}}" class="hovera"></span>Payment History </a>
                            </li>
                            <li class="disable-left">
                                <a href="javascript:void(0);"><span><img src="{{ public_asset('assets/images/rat1.png')}}" class="hovern"> <img src="{{ public_asset('assets/images/rat1-h.png')}}" class="hovera"></span>Rating & Review </a>
                            </li>
                        </ul>
                    </div>
 --}}

                    <div class="log-menu">
                        <ul>
                            <li>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    <span><img src="{{ public_asset('assets/images/ac-7.png') }}" class="hovern"> <img
                                            src="{{ public_asset('assets/images/ac7-h.png') }}" class="hovera"></span>
                                    Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf

                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
