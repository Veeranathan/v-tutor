<div class="topbar">
            <div class="topbar-left">
                <div class="text-center">
                    <a href="{{ route('admin.login') }}" class="logo"><img src="{{ public_asset('admin/assets/images/v_tutor_admin_logo.svg') }}" alt=""></a>
                    {{-- <a href="{{ route('admin.login') }}" class="logo"><img src="{{ public_asset('admin/assets/images/logo.png') }}" alt=""></a> --}}
                </div>
            </div>
            <!-- Button mobile view to collapse sidebar menu -->
            <div class="navbar navbar-default" role="navigation">
                <div class="container">
                    <div class="">
                        <div class="pull-left">
                            <button class="button-menu-mobile open-left">
                                <i class="fa fa-bars"></i>
                            </button>
                            <span class="clearfix"></span>
                        </div>
                        <ul class="nav navbar-nav navbar-right pull-right">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle profile" data-toggle="dropdown" aria-expanded="true">
                                 @php $admin = Auth::guard('admin')->user(); @endphp

@if($admin && $admin->image)
    <img src="{{ env('STORAGE_URL') . 'admin/profileImage/' . $admin->image }}" alt="user-img" class="img-circle">

@else
    <img src="{{ asset('admin/assets/images/users/avatar-1.jpg') }}" alt="user-img" class="img-circle">
@endif
                                    {{-- <img src="{{ public_asset('admin/assets/images/users/avatar-1.jpg') }}" alt="user-img" class="img-circle"> --}}
                                     </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        @if (@Auth::guard('admin')->user()->email == 'academics.admin@v-tutor.com.au')
                                            <a href="{{ route('edit.admin.profile') }}" class="gj_adm_mnu_disabled"><i class="fas fa-user-circle"></i> Profile</a>
                                        @elseif (@Auth::guard('admin')->user()->email == 'operations.admin@v-tutor.com.au')
                                            <a href="{{ route('edit.admin.profile') }}" class="gj_adm_mnu_disabled"><i class="fas fa-user-circle"></i> Profile</a>
                                        @else
                                            <a href="{{ route('edit.admin.profile') }}"><i class="fas fa-user-circle"></i> Profile</a>
                                        @endif
                                    </li>

                                    <li><a href="{{ route('admin.change.password') }}"><i class="fas fa-cog"></i> Change Password</a></li>

                                    <li>
                                        <a href="javascript" onclick="event.preventDefault(); document.getElementById('logout-form-two').submit();" href="javascript::void(0);"><i class="fas fa-power-off"></i> Logout</a>
                                        <form id="logout-form-two" action="{{ url('/admin/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
