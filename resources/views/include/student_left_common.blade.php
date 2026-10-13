<style>
    .disabled-link {
        pointer-events: none;
        opacity: 0.5;
        cursor: not-allowed;
    }
</style>
@php
    use Illuminate\Support\Facades\Auth;
    use App\Models\LearningProgramAssessment;

    $user = Auth::user()->fresh();

     $hasCompletedAssessment = LearningProgramAssessment::where('student_id', $user->id)
        ->where('status', 'completed')
        ->exists();

    $isProfileComplete = (
        trim($user->f_name ?? '') !== '' &&
        trim($user->l_name ?? '') !== '' &&
        trim($user->parent_f_name ?? '') !== '' &&
        trim($user->parent_dob ?? '') !== '' &&
        trim($user->street ?? '') !== ''
    );


    $myGrade = \App\Models\Grade::where(['id' => $user->grade, 'status' => 'A'])->first();
    $totalClass = \App\Models\StudentClassBooking::where('student_id', $user->id)
        ->whereIn('booking_status', ['B', 'CM', 'C'])
        ->count();
@endphp

<div class="user-left sticky_left">
    <div class="dasbordLeftsec">
        <a href="#" class="showmeu"><i class="fa fa-bars"></i>Show Menus</a>
        <div class="dasbordLeft">
            <div class="user-left-info">
                <div class="user-left-top">
                    <em>
                        @if($user->profile_pic)
                            <img src="{{ public_asset('assets/images/all_avatars/' . $user->profile_pic) }}" alt="profile_img">
                        @elseif($user->avatar)
                            <img src="{{ $user->avatar }}" alt="profile_img">
                        @else
                            <img src="{{ public_asset('assets/images/blank1.png') }}" alt="profile_img">
                        @endif
                    </em>
                    <h2>{{ $user->f_name . ' ' . $user->l_name }}</h2>
                    <p>{{ $totalClass }} {{ $totalClass <= 1 ? 'class' : 'sessions' }}</p>
                </div>

                <div class="new-lft-bottom">
                    <div class="user-left-menu">
                        <ul>
                            {{-- Dashboard --}}
                            {{-- <li class="{{ request()->segment(1)=='home' ? 'active' : '' }}">
                                <a href="{{ $isProfileComplete ? route('home') : 'javascript:void(0)' }}"
                                   class="{{ !$isProfileComplete ? 'disabled-link' : '' }}"
                                   title="{{ !$isProfileComplete ? 'Please complete your profile to access Dashboard' : '' }}">
                                    <span>
                                        <img src="{{ public_asset('assets/images/ac1.png') }}" class="hovern">
                                        <img src="{{ public_asset('assets/images/ac1-h.png') }}" class="hovera">
                                    </span>
                                    Dashboard
                                </a>
                            </li> --}}

                            {{-- My Profile --}}
                            <li class="{{ request()->segment(1)=='my-profile' ? 'active' : '' }}">
                                <a href="{{ route('my.profile') }}">
                                    <span>
                                        <img src="{{ public_asset('assets/images/ac2.png') }}" class="hovern">
                                        <img src="{{ public_asset('assets/images/ac2-h.png') }}" class="hovera">
                                    </span>
                                    Profile
                                </a>
                            </li>

                            {{-- Book a Session --}}
                            <li class="{{ request()->is('studentbook-class') || request()->is('student-bookingconfirmation') ? 'active' : '' }}">
                                <a href="{{ $isProfileComplete ? url('tutor-search-result?grade=' . optional($myGrade)->slug) : 'javascript:void(0)' }}"
                                   class="{{ !$isProfileComplete ? 'disabled-link' : '' }}"
                                   title="{{ !$isProfileComplete ? 'Please complete your profile to book a session' : '' }}">
                                    <span>
                                        <img src="{{ public_asset('assets/images/ac5.png') }}" class="hovern">
                                        <img src="{{ public_asset('assets/images/ac5-h.png') }}" class="hovera">
                                    </span>
                                    Book a Session
                                </a>
                            </li>

                            {{-- Sessions --}}
                            <li class="{{ request()->segment(1)=='my-class' ? 'active' : '' }}">
                                <a href="{{ $isProfileComplete ? route('student.my.classes') : 'javascript:void(0)' }}"
                                   class="{{ !$isProfileComplete ? 'disabled-link' : '' }}"
                                   title="{{ !$isProfileComplete ? 'Please complete your profile to view sessions' : '' }}">
                                    <span>
                                        <img src="{{ public_asset('assets/images/ac3.png') }}" class="hovern">
                                        <img src="{{ public_asset('assets/images/ac3-h.png') }}" class="hovera">
                                    </span>
                                    Sessions
                                </a>
                            </li>

                            {{-- My Tutors --}}
                            <li class="{{ request()->segment(1)=='student-mytutors' ? 'active' : '' }}">
                                <a href="{{ $isProfileComplete ? route('list.of.favourite') : 'javascript:void(0)' }}"
                                   class="{{ !$isProfileComplete ? 'disabled-link' : '' }}"
                                   title="{{ !$isProfileComplete ? 'Please complete your profile to access tutors' : '' }}">
                                    <span>
                                        <img src="{{ public_asset('assets/images/ac4.png') }}" class="hovern">
                                        <img src="{{ public_asset('assets/images/ac4-h.png') }}" class="hovera">
                                    </span>
                                    Tutors
                                </a>
                            </li>

                            {{-- My Reviews --}}
                            <li class="{{ request()->segment(1)=='my-review' ? 'active' : '' }}">
                                <a href="{{ $isProfileComplete ? route('student.my.review.no.slug') : 'javascript:void(0)' }}"
                                   class="{{ !$isProfileComplete ? 'disabled-link' : '' }}"
                                   title="{{ !$isProfileComplete ? 'Please complete your profile to access reviews' : '' }}">
                                    <span>
                                        <img src="{{ public_asset('assets/images/ac4d.png') }}" class="hovern">
                                        <img src="{{ public_asset('assets/images/ac4d-h.png') }}" class="hovera">
                                    </span>
                                    Reviews
                                </a>
                            </li>
                            
                            <!-- {{-- Assessment --}}
                            @if(!$hasCompletedAssessment)
                                <li class="{{ request()->segment(1)=='student-my-assessment' ? 'active' : '' }}">
                                    <a href="{{ route('student.my.assessment') }}">
                                        <span>
                                            <img src="{{ public_asset('assets/images/ac3.png') }}" class="hovern">
                                            <img src="{{ public_asset('assets/images/ac3-h.png') }}" class="hovera">
                                            </span>
                                             Assessment
                                     </a>
                                </li>
                            @endif -->

                             

                            {{-- Payments --}}
                            <li class="{{ request()->segment(1)=='student-my-payments' ? 'active' : '' }}">
                                <a href="{{ $isProfileComplete ? route('student.my.payments') : 'javascript:void(0)' }}"
                                   class="{{ !$isProfileComplete ? 'disabled-link' : '' }}"
                                   title="{{ !$isProfileComplete ? 'Please complete your profile to access payments' : '' }}">
                                    <span>
                                        <img src="{{ public_asset('assets/images/ac6.png') }}" class="hovern">
                                        <img src="{{ public_asset('assets/images/ac6-h.png') }}" class="hovera">
                                    </span>
                                    Payments
                                </a>
                            </li>

                            {{-- Academic Program --}}
                                <li class="{{ request()->segment(1)=='student-my-academic' ? 'active' : '' }}">
                                    <a href="{{ route('student.my.academic.program') }}">
                                        <span>
                                            <img src="{{ public_asset('assets/images/ac3.png') }}" class="hovern">
                                            <img src="{{ public_asset('assets/images/ac3-h.png') }}" class="hovera">
                                            </span>
                                            Learning Programs
                                     </a>
                                </li>
                        </ul>

                        {{-- Logout --}}
                        <div class="log-menu">
                            <ul>
                                     <li class="">
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                    document.getElementById('logout-form-two').submit();">
                                            <span>
                                                <img src="{{ public_asset('assets/images/ac-7.png') }}" class="hovern">
                                            <img src="{{ public_asset('assets/images/ac7-h.png') }}" class="hovera">
                                            </span> Logout</a>
                                        <form id="logout-form-two" action="{{ route('logout') }}" method="POST"
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
</div>
