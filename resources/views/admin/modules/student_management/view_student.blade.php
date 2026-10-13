@extends('admin.layouts.app')
@section('title')
Student Personal Info
@endsection
@section('links')
@include('admin.includes.links')
<style type="text/css">
</style>
@endsection
@section('header')
@include('admin.includes.header')
@endsection
@section('sidebar')
@include('admin.includes.sidebar')
@endsection
@section('content')
<div class="content">
    <div class="wraper container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="pull-left page-title">
                    View Student Personal Info<br/>
                    <p class="small_tag">You can find information or view your profile in this section</p>
                </h1>
                <ol class="breadcrumb pull-right">
                    <li> <a href="{{ route('manage.students') }}"><i class="fas fa-angle-double-left"></i> Back</a></li>
                    <li> <a href="{{ route('edit.student.personal.info.step.1',@$user->id) }}"><i class="fas fa-angle-double-left"></i> Edit</a></li>
                </ol>
            </div>
        </div>
        <!-- Personal-Information -->
        <div class="panel panel-default panel-fill">
            <div class="panel-body rm02 rm04">
                @include('admin.includes.message')
                <div class="frm_admin">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <div class="user-account-info">
                                <h3>Student Profile</h3>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="f_name">Student First Name*</label>
                                <p class="text-muted">{{ @$user->f_name }}</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="l_name">Student Last Name*</label>
                                <p class="text-muted">{{ @$user->l_name }}</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="grade">Grade</label>
                                @php
                                $gradenm = \App\Models\Grade::where(['id'=>@$grade->id])->first();
                                @endphp
                                <p class="text-muted">
                                    {{ @$gradenm->grade_name }}
                                </p>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="school">School</label>
                                <p class="text-muted">
                                    @if(@$user->getSchool->school_name)
                                    {{ @$user->getSchool->school_name }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="school">School State</label>
                                <p class="text-muted">
                                    {{ @$user->getSchool->getState->state_name }}
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="school">School Suburb</label>
                                <p class="text-muted">
                                    {{ @$user->getSchool->getSuburb->name }}
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="school">School Postcode</label>
                                <p class="text-muted">
                                    @if(@$user->getSchool->postcode) {{ @$user->getSchool->postcode }} @endif
                                </p>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <div class="dash-d1">
                                    <label for="dob">Date of birth *</label>
                                    <p class="text-muted">
                                        {{ @$user->dob }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <p class="text-muted">
                                    @if(@$user->gender == 'M')
                                    Male
                                    @elseif(@$user->gender == 'F')
                                    Female
                                    @elseif(@$user->gender == 'P')
                                    Prefer not to say
                                    @elseif(@$user->gender == 'O')
                                    Neither
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <div class="checkBox new-cus tur-radio">
                                    <span>Are you a full-time student? *</span>
                                    <p class="text-muted">
                                        @if(@$user->is_full_time == 'Y')
                                        Yes
                                        @else
                                        No
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-6 col-sm-12 col-xs-12 tutor-c" @if(@$user->is_full_time == 'N') style="display:none;" @endif>
                        <div class="form-group">
                            <div class="checkBox new-cus tur-radio">
                                <span>Do you private school or home school?*</span>
                                <p class="text-muted">
                                    @if(@$user->private_or_home == 'Y')
                                    Yes
                                    @else
                                    No
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="about_me">About Me</label>
                            <p class="text-muted">
                                {!! strip_tags(@$user->about_me) !!}
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xs-12">
                        <div class="uplodimg form-group">
                            <div class="uplodimgfil">
                                <span>Profile Picture</span>
                            </div>
                            <div class="uplodimgfilimg">
                                <em>
                                @if(@$user->profile_pic)
                                <img id="img2" src="{{ URL::to('assets/images/all_avatars/'.@$user->profile_pic) }}" alt="">
                                @else
                                @if(@$user->avatar)
                                <img id="img2" src="{{@$user->avatar}}" alt="">
                                @else
                                <img id="img2" src="{{ public_asset('admin/assets/images/uplodimg.png') }}" alt="" style="display:none;">
                                @endif
                                @endif
                                </em>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-12 col-xs-12">
                        <div class="user-account-info">
                            <h3>Parent Details</h3>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="f_name">I'm a</label>
                            <p class="text-muted">
                                @if(@$user->student_type == "P")
                                Parent
                                @elseif(@$user->student_type == "G")
                                Guardian
                                @elseif(@$user->student_type == "S")
                                Student
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="f_name">Salutation*</label>
                            <p class="text-muted">
                                @if(@$user->salutation == "1")
                                Mr.
                                @elseif(@$user->salutation == "2")
                                Mrs.
                                @elseif(@$user->salutation == "3")
                                Ms.
                                @elseif(@$user->salutation == "4")
                                Dr.
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="parent_f_name">Parent First Name*</label>
                            <p class="text-muted">
                                {{ @$user->parent_f_name }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="parent_l_name">Parent Last Name*</label>
                            <p class="text-muted">
                                {{ @$user->parent_l_name }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="email">Email Address*</label>
                            <p class="text-muted">
                                {{ @$user->email }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="phone">Mobile Number*</label>
                            <p class="text-muted">
                                {{ @$user->phone }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12  ">
                        <div class="form-group">
                            <label for="annual_income">Annual Income<span tooltip="This is an optional choice used demographic analysis only. It is not shared with any third party and will not make a difference to services offered in the platform"><i class="qus-cir far fa-question-circle"></i></span></label>
                            <p class="text-muted">
                                @if(@$user->annual_income == 'A')
                                &lt; 100,000
                                @elseif(@$user->annual_income == 'B')
                                100,000 – 150,000
                                @elseif(@$user->annual_income == 'C')
                                150,000 –200,000
                                @elseif(@$user->annual_income == 'D')
                                200,000 &gt;
                                @elseif(@$user->annual_income == 'P')
                                Prefer not to say
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="f_name">Qualification*</label>
                            <p class="text-muted">
                                @if(@$user->qualification == "1")
                                Doctoral Degree
                                @elseif(@$user->qualification == "2")
                                Postgraduate
                                @elseif(@$user->qualification == "3")
                                Master's Degree (Research)
                                @elseif(@$user->qualification == "4")
                                Master's Degree
                                @elseif(@$user->qualification == "5")
                                Bachelor Honours Degree
                                @elseif(@$user->qualification == "6")
                                Bachelor’s Degree
                                @elseif(@$user->qualification == "7")
                                Associate Degree
                                @elseif(@$user->qualification == "8")
                                Advanced Diploma
                                @elseif(@$user->qualification == "9")
                                Diploma
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="clearfix"></div>
                    <div class="col-sm-12 col-xs-12">
                        <div class="user-account-info">
                            <h3>Residential Address</h3>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="country">Country</label>
                            <p class="text-muted">
                                {{-- @if(@$user->country == 1) --}}
                                Australia
                                {{-- @endif --}}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="state">State / Province / Region</label>
                            <p class="text-muted">
                                {{ @$user->getState->state_name }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="city">City</label>
                            <p class="text-muted">
                                {{ @$user->city }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="address">Unit & Street Address</label>
                            <p class="text-muted">
                                {!! strip_tags(@$user->address) !!}
                            </p>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="zip">Zip / Postal Code</label>
                            <p class="text-muted">
                                {{ @$user->zip }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="school">Timezone</label>
                            <p class="text-muted">
                                @if(@$user->getTimezone->time_zone_abbreviation)
                                {{ @$user->getTimezone->time_zone_abbreviation }},{{ @$user->getTimezone->time_zone_name }},{{ @$user->getTimezone->city }}({{ @$user->getTimezone->utc_offset }})
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@section('footer')
@include('admin.includes.footer')
@endsection
@section('script')
@include('admin.includes.script')


@endsection
