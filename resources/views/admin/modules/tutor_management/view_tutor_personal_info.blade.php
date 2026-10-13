@extends('admin.layouts.app')
@section('title')
Personal Details
@endsection
@section('links')
@include('admin.includes.links')
<style type="text/css">
/*this is excel button needs to hide as we have already download option*/
    .buttons-excel{
    display: none;
}
.step_tab ul {
    display: flex;
    flex-wrap: nowrap !important;
    padding-left: 0;
    margin-bottom: 10px;
}

.step_tab ul li {
    margin-right: 6px;
}

.step_tab ul li a {
    font-size: 11px !important;       /* Smaller font */
    padding: 5px 10px !important;      /* Reduce tab width */
    border-radius: 6px !important;     /* Slightly smaller curve */
    white-space: nowrap;
    display: flex;
    align-items: center;
    gap: 4px;                          /* Reduce icon + text gap */
}

.step_tab ul li a span img {
    width: 15px !important;           /* Reduce icon size */
    height: auto;
}


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
                <h1 class="pull-left page-title">Personal Details<br/><p class="small_tag">You can find information or view tutor profile in this section  </p></h1>
                <ol class="breadcrumb pull-right">
                    <li> <a href="{{ route('manage.tutors') }}"><i class="fas fa-backward"></i> Back</a></li>
                    {{-- <li> <a href="{{ route('edit.tutor.personal.info.step.1',$user->id) }}"><i class="fas fa-pen"></i> Edit</a></li> --}}
                    @if(@$previous_id)
                    <li> <a href="{{ route('view.tutor.personal.info.step.1',@$previous_id) }}"><i class="fas fa-angle-double-left"></i> Previous</a></li>
                    @endif
                    @if(@$next_id)
                    <li> <a href="{{ route('view.tutor.personal.info.step.1',@$next_id) }}"><i class="fas fa-angle-double-right"></i> Next</a></li>
                    @endif
                </ol>
            </div>
        </div>
        <div class="step_tab">
            <ul>
                <li class="active">
                    <a href="javascript:void(0);" id="clickHere" data-toggle="modal" data-target="#instructionModal" style="display:none;">Click</a>
                    <a href="{{ route('view.tutor.personal.info.step.1',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/peri.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/perih.png') }}" class="accth"></span>
                    Personal Details
                    </a>
                </li>
                <li>
                    <a href="{{ route('view.tutor.tutorship.plans',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/gar.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/garh.png') }}" class="accth"></span>
                    Tutorship Plan
                    </a>
                </li>
                <li>
                    <a href="{{ route('view.tutor.academics',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/aca.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/acah.png') }}" class="accth"></span>
                    Academics
                    </a>
                </li>
                <li>
                    <a href="{{ route('view.tutor.experience',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/ex.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/exh.png') }}" class="accth"></span>
                    Experience </a>
                </li>
                <li>
                    <a href="{{ route('view.tutor.recognitions',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/rec.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/rech.png') }}" class="accth"></span>
                    Recognitions
                    </a>
                </li>
                <li>
                    <a href="{{ route('view.tutor.right.to.work',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/rec.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/rech.png') }}" class="accth"></span>
                    Right to Work
                    </a>
                </li>
                <li>
                    <a href="{{ route('view.tutor',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/rec.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/checked.png') }}" class="accth"></span>
                    Availability
                    </a>
                </li>
                 {{--<li>
                    <a href="{{ route('view.tutor.advance.page',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/rec.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/rech.png') }}" class="accth"></span>
                    Advanced
                    </a>
                </li> --}}

                <div class="clearfix"></div>
            </ul>
        </div>
        <!-- Personal-Information -->
        <div class="panel panel-default panel-fill">
            <div class="panel-body rm02 rm04">
                @include('admin.includes.message')

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <h2 class="gj_pd_hd">Personal Details</h2>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td class="text-left">
                                                <b>First Name</b>
                                                <p>{{ @$user->f_name }}</p>
                                            </td>

                                            <td class="text-left">
                                                <b>Middle Name</b>
                                                <p>{{ @$user->m_name }}</p>
                                            </td>

                                            <td class="text-left">
                                                <b>Last Name</b>
                                                <p>{{ @$user->l_name }}</p>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="text-left">
                                                <b>Primary Email</b>
                                                <p>{{ @$user->email }}</p>
                                            </td>

                                            <td class="text-left">
                                                <b>Primary Phone</b>
                                                <p>{{ @$user->phone }}</p>
                                            </td>

                                            <td class="text-left">
                                                <b>Nationality</b>
                                                <p>{{ @$user->nationality }}</p>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="3" class="text-left">
                                                <b>Profile Picture</b>
                                                <div class="img_prof_div">
                                                    @if(@$user->profile_pic)
<img id="img2" src="{{ URL::to('storage/teacher_profile_pic/'.@$user->profile_pic) }}" alt="">

                                                    @else
                                                        @if(@$user->avatar)

                                                                  <img id="img2" src="{{@$user->avatar}}" alt="">

                                                        @else
                                                            <img id="img2" src="{{ public_asset('admin/assets/images/uplodimg.png') }}" alt="" style="display:none;">
                                                        @endif
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-left">
                                                <b>About Tutor</b>
                                                <p>{{ @$user->about_me }}</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <h2 class="gj_res_addr_hd">Residential Address</h2>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td class="text-left">
                                                <b>State / Territory</b>
                                                <p>{{ @$user->getState->state_name }}</p>
                                            </td>

                                            <td class="text-left">
                                                <b>Suburb</b>
                                                <p>{{ @$user->city }}</p>
                                            </td>

                                            <td class="text-left">
                                                <b>Street</b>
                                                <p>{{ @$user->address }}</p>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="text-left">
                                                <b>Postcode</b>
                                                <p>{{ @$user->zip }}</p>
                                            </td>

                                            <td class="text-left">
                                                <b>Country</b>
                                                <p>{{ 'Australia' }}</p>
                                            </td>

                                            <td class="text-left">
                                                <b>Time Zone</b>
                                                <p>{{ @$user->timezone_id }}</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <form id="updatePersonalInfo" method="post" action="{{ route('edit.tutor.personal.info.step.1',@$user->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="frm_admin">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="f_name">First Name</label>
                                    <p class="text-muted">{{ @$user->f_name }}</p>

                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="f_name">Middle Name</label>
                                    <p class="text-muted">{{ @$user->m_name }}</p>

                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="l_name"> Last Name</label>
                                    <p class="text-muted">{{ @$user->l_name }}</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="email">Primary Email</label>
                                    <p class="text-muted">{{ @$user->email }}</p>

                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="phone">Primary Phone</label>
                                    <p class="text-muted">{{ @$user->phone }}</p>

                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="phone">Nationality</label>
                                    <p class="text-muted">{{ @$user->nationality }}</p>

                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="subscription">Suscription</label>
                                    <p class="text-muted">
                                        @if(@$user->subscription == 'S')
                                        Suscribed
                                        @else
                                        Unsuscribed
                                        @endif
                                    </p>

                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="subscription">Document Score</label>
                                    <p class="text-muted">
                                        {{ @$user->document_score }}
                                    </p>

                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="teacher_emp_status">Employment Status</label>
                                    <p class="text-muted">
                                        @if(@$user->teacher_emp_status == 'A')
                                        Yes, I'm a full-time teacher
                                        @elseif(@$user->teacher_emp_status == 'B')
                                        No, but I have teaching experience
                                        @elseif(@$user->teacher_emp_status == 'C')
                                        Yes, but I'm not a teacher
                                        @elseif(@$user->teacher_emp_status == 'D')
                                        No, but I have passion for teaching
                                        @endif
                                    </p>

                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="hours">How many hours can you commit?</label>
                                    <p class="text-muted">
                                        @if(@$user->hours == '1-4')
                                        < 5 hrs a week
                                        @elseif(@$user->hours == '5-10')
                                        5 – 10 hrs a week
                                        @elseif(@$user->hours == '10-20')
                                        10 – 20 hrs a week
                                        @elseif(@$user->hours == '20-40')
                                        20 – 40 hrs a week
                                        @elseif(@$user->hours == '40+')
                                        > 40 hrs a week
                                        @endif
                                    </p>

                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="why_tutor">Why do you want to be a Tutor?</label>
                                    <p class="text-muted">
                                        @if(@$user->why_tutor == 'A')
                                        Leverage my teaching experience
                                        @elseif(@$user->why_tutor == 'B')
                                        Looking for after-hours gig
                                        @elseif(@$user->why_tutor == 'C')
                                        To make more money by teaching
                                        @elseif(@$user->why_tutor == 'D')
                                        Teaching is my passion, money secondary
                                        @elseif(@$user->why_tutor == 'E')
                                        Safe way to make money from home
                                        @endif
                                    </p>

                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="language">Language</label>
                                    <p class="text-muted">
                                        @foreach(@$tutor_to_lan as $l)
                                        {{ @$l->languageName->language }}
                                        @endforeach
                                    </p>
                                </div>
                            </div>

                            <div class="clearfix"></div>
                            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <div class="checkBox new-cus tur-radio">
                                        <span>Do you have experience working with children?</span>
                                        <p class="text-muted">
                                            @if(@$user->work_with_child == 'Y')
                                            Yes
                                            @else
                                            No
                                            @endif
                                        </p>

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <div class="checkBox new-cus tur-radio">
                                        <span>WWCC number</span>
                                        <p class="text-muted">
                                            {{ @$user->wwc_number }}
                                        </p>

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <div class="checkBox new-cus tur-radio">
                                        <span>Do you have a history or pending criminal court cases or charges laid against you?</span>
                                        <p class="text-muted">
                                            @if(@$user->criminal_case == 'Y')
                                            Yes
                                            @else
                                            No
                                            @endif
                                        </p>

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 tutor-c criminal_details_hide_show">
                                <div class="form-group">
                                    <label for="criminal_details">Share more details</label>
                                    <p class="text-muted">
                                        {{ @$user->criminal_details }}
                                    </p>

                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="about_me">What makes you an awesome V-Tutor?</label>
                                    <p class="text-muted">
                                        {!! strip_tags(@$user->about_me) !!}
                                    </p>

                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="col-sm-12 col-xs-12">
                                <div class="uplodimg form-group">
                                    <div class="uplodimgfil">
                                        <span>Profile Picture</span>


                                    </div>
                                    <div class="uplodimgfilimg">
                                        <em>

                                            @if(@$user->profile_pic)
                                                <img id="img2" src="{{ env('STORAGE_URL') . '/teacher_profile_pic/' . @$user->profile_pic }}" alt="">
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
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="profile_video">Profile Video</label>
                                    <p class="text-muted">
                                        {!! strip_tags(@$user->profile_video) !!}
                                    </p>

                                </div>
                            </div> --}}

                            {{-- <div class="col-sm-12 col-xs-12">
                                <div class="user-account-info">
                                    <h3>References</h3>
                                </div>
                            </div>
                            <div class="col-sm-12 col-xs-12">
                                <div class="user-account-info">
                                    <h3>Add Reference 1</h3>
                                </div>
                            </div>


                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form_box_area">
                                    <label for="ref_2_name">First Name</label>
                                    <p class="text-muted">
                                        {{ @$tutor_to_ref->ref_1_f_name }}
                                    </p>

                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form_box_area">
                                    <label for="ref_2_name">Last Name</label>
                                    <p class="text-muted">
                                        {{ @$tutor_to_ref->ref_1_l_name }}
                                    </p>

                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form_box_area">
                                    <label>Email</label>
                                    <p class="text-muted">
                                        {{ @$tutor_to_ref->ref_1_email }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form_box_area">
                                    <label>Phone</label>
                                    <p class="text-muted">
                                        {{ @$tutor_to_ref->ref_1_phone }}
                                    </p>

                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form_box_area">
                                    <label for="ref_2_relation">Relationship</label>
                                    <p class="text-muted">
                                        @if(@$tutor_to_ref->ref_1_relation == 1)Partner @endif
                                        @if(@$tutor_to_ref->ref_1_relation == 2)Family @endif
                                        @if(@$tutor_to_ref->ref_1_relation == 3)Friend @endif
                                        @if(@$tutor_to_ref->ref_1_relation == 4)Colleague @endif
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-12 col-xs-12">
                                <div class="user-account-info">
                                    <h3>Add Reference 2</h3>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form_box_area">
                                    <label for="ref_2_name">First Name</label>
                                    <p class="text-muted">
                                        {{ @$tutor_to_ref->ref_2_f_name }}
                                    </p>

                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form_box_area">
                                    <label for="ref_2_name">Last Name</label>
                                    <p class="text-muted">
                                        {{ @$tutor_to_ref->ref_2_l_name }}
                                    </p>

                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form_box_area">
                                    <label>Email</label>
                                    <p class="text-muted">
                                        {{ @$tutor_to_ref->ref_2_email }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form_box_area">
                                    <label>Phone</label>
                                    <p class="text-muted">
                                        {{ @$tutor_to_ref->ref_2_phone }}
                                    </p>

                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form_box_area">
                                    <label for="ref_2_relation">Relationship</label>
                                    <p class="text-muted">
                                        @if(@$tutor_to_ref->ref_2_relation == 1)Partner @endif
                                        @if(@$tutor_to_ref->ref_2_relation == 2)Family @endif
                                        @if(@$tutor_to_ref->ref_2_relation == 3)Friend @endif
                                        @if(@$tutor_to_ref->ref_2_relation == 4)Colleague @endif
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-12 col-xs-12">
                                <div class="user-account-info">
                                    <h3>Bank Information</h3>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="zip">Bank Name</label>
                                    <p class="text-muted">
                                        {{ @$user->bank_name }}
                                    </p>

                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="zip">Account No</label>
                                    <p class="text-muted">
                                        {{ @$user->account_no }}
                                    </p>

                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="zip">Account Name</label>
                                    <p class="text-muted">
                                        {{ @$user->account_name }}
                                    </p>

                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="zip">BSB Code</label>
                                    <p class="text-muted">
                                        {{ @$user->bsb_code }}
                                    </p>

                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-sm-12">
                                <div class="ad_btn">

                                </div>
                            </div>
                            <div class="clearfix"></div>
                            Residential Address
                            <div class="col-sm-12">
                                <div class="res_addr_div">
                                    <h2>Residential Address</h2>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="f_name">State / Territory</label>
                                    <p class="text-muted">{{ @$user->getState->state_name }}</p>

                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="f_name">Suburb</label>
                                    <p class="text-muted">{{ @$user->city }}</p>

                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="f_name">Street </label>
                                    <p class="text-muted">{{ @$user->address }}</p>

                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="f_name">Postcode  </label>
                                    <p class="text-muted">{{ @$user->zip }}</p>

                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="f_name">Country   </label>
                                    <p class="text-muted">{{ 'Australia' }}</p>

                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="f_name">Time Zone  </label>
                                    <p class="text-muted">{{ @$user->timezone_id }}</p>

                                </div>
                            </div>
                        </div>
                    </div>
                </form> --}}
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
<script src="{{public_asset('admin/assets/js/jquery.validate.js')}}"></script>

@endsection
