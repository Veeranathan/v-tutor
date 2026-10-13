@extends('layouts.app')
@section('title')
    <title>V-Tutor | Tutor | Personal Details</title>
@endsection
@section('left_part')
    @include('include.header_menu_part')
    <style type="text/css">
        .addDisablePhone {
            opacity: 0.5 !important;
        }

        .pointerEventsNone {
            pointer-events: none !important;
        }

        .uplodimg label img {
            margin-top: 13px;
        }

        .ensure_text, .uplodimgfilimg {
            padding-top: 0px !important;
        }
      
    </style>
@endsection

@section('content')
    <section class="makes_special_sec faq-sec">
        <div class="makes_special_inr">
            <div class="top_mar"></div>
            <!--- profile --->
            <section class="user-account">
                <div class="container">
                    <div class="row">
                        <div class="zin">
                            @include('include.teacher_left_common'){{-- left common part --}}

                            <div class="user-right-panel tutor-right">

                                <div class="step_tab">
                                    <ul>
                                        <li class="active">
                                            <a href="{{ route('teacher.profile') }}">
                                                <span><img src="{{ public_asset('assets/images/peri.png') }}"
                                                        class="actt"><img
                                                        src="{{ public_asset('assets/images/perih.png') }}"
                                                        class="accth"></span>
                                                Personal
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('tutorship.plan') }}">
                                                <span><img src="{{ public_asset('assets/images/gar.png') }}"
                                                        class="actt"><img
                                                        src="{{ public_asset('assets/images/garh.png') }}"
                                                        class="accth"></span>
                                                Tutoring Plan
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('tutor.acadamic') }}">
                                                <span><img src="{{ public_asset('assets/images/aca.png') }}"
                                                        class="actt"><img
                                                        src="{{ public_asset('assets/images/acah.png') }}"
                                                        class="accth"></span>
                                                Academics
                                            </a>
                                        </li>
                                        <li>
                                            <a class="disable_class" href="{{ route('tutor.exp') }}">
                                                <span><img src="{{ public_asset('assets/images/ex.png') }}"
                                                        class="actt"><img
                                                        src="{{ public_asset('assets/images/exh.png') }}"
                                                        class="accth"></span>
                                                Experience </a>
                                        </li>
                                        <li>
                                            <a class="disable_class" href="{{ route('tutor.recognization') }}">
                                                <span><img src="{{ public_asset('assets/images/rec.png') }}"
                                                        class="actt"><img
                                                        src="{{ public_asset('assets/images/rech.png') }}"
                                                        class="accth"></span>
                                                Recognitions
                                            </a>
                                        </li>
                                          <li>
                                            <a class="disable_class" href="{{ route('tutorship.academic.program') }}">
                                                <span><img src="{{ public_asset('assets/images/rec.png') }}"
                                                        class="actt"><img
                                                        src="{{ public_asset('assets/images/rech.png') }}"
                                                        class="accth"></span>
                                                Program
                                            </a>
                                        </li>
                                        <li>
                                            <a class="disable_class" href="{{ route('tutor.right_to_work') }}">
                                                <span><img src="{{ public_asset('assets/images/rec.png') }}"
                                                        class="actt"><img
                                                        src="{{ public_asset('assets/images/rech.png') }}"
                                                        class="accth"></span>
                                                Compliance
                                            </a>
                                        </li>
                                        <!--li >
                                                        <a @if (@Auth::user()->platform_type != null) href="{{ route('teacher.close.account') }}" onclick="return confirm('We find that you have decided to close the account and we are sorry to see you go! We may need your account password to validate closure! If you have any issues / concerns that you would like to share, kindly use the Complaints link . Please be aware that this process is irreversible. Any data on this account will be retained as per our privacy policy and purged after a certain time')" @else href="#" data-toggle="modal" data-target="#myModalnes" @endif    class="" ></a>
                                                        {{-- <a href="#" data-toggle="modal" data-target="#myModalnes"   > --}}
                                                        {{-- Close my account</a> --}}
                                                        {{-- <a class="" href="{{route('teacher.close.account')}}"> --}}
                                                            {{-- <span><i class="fa fa-user acttrr" ar*ia-hidden="true"></i></span>
                                    Close Account
                                    </a> --}}
                                                    </li-->
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="turo-edit">

                                    <div class="user-right-top tranhis">
                                        {{-- <div class="float-right">
                                <a href="{{route('tutor.public.profile',@Auth::user()->slug)}}" target="_blank"  class="add_btn select_profile_pic_btn">My Profile Page</a>
                                </div> --}}
                                        {{-- <h2 class="profile-heading">
                                        <span class="per-info">
                                            <img src="{{ public_asset('assets/images/per-info.png') }}" class="mr-0">
                                        </span>
                                        Personal Details
                                    </h2> --}}
                                        <p>Use this section to view information and manage your profile settings.</p>

                                        <a href="#" style="display:none;" id="messageShow" data-toggle="modal"
                                            data-target="#popupModal1">Message</a>
                                        <a href="#" style="display:none;" id="messageShowUpd" data-toggle="modal"
                                            data-target="#popupModal">Message</a>

                                        <a href="javascript:void(0);" data-toggle="modal"
                                            data-target="#close_accountInform_modal"
                                            class="gj_tut_close_account_link text-danger">Close my Account</a>

                                        {{-- <div class="advance_new_profile">
                                        <ul>
                                            <li>
                                                <a class="deen" target="_blank"
                                                    href="{{ route('tutor.public.profile', @Auth::user()->slug) }}"
                                                    style="color: white;">View Profile</a>
                                            </li>
                                            <li>
                                        <a class="deen" target="_blank" href="{{ route('teacher.advance.page') }}">Advanced</a>
                                    </li>
                                        </ul>


                                    </div> --}}

                                        {{-- @include('include.errors') --}}
                                        <form method="post" action="{{ route('teacher.profile.update') }}"
                                            enctype="multipart/form-data" id="frm">
                                            @csrf
                                            <input type="hidden" name="check_password" id="check_password" value="">
                                            <div class="user-account-info">
                                                <div class="row new_rows no-gutters">
                                                    {{-- <div class="col-md-4 col-sm-6">
                                                <div class="form_box_area">
                                                    <label>Timezone<span tooltip="Please choose carefully as this would impact booking of classes">*<i class="qus-cir far fa-question-circle"></i></span></label>
                                                    <select name="timezone_id" class="required" id="timezone_id">
                                                        <option value="">Select timezone</option>
                                                        @if (@$timezonesLists)
                                                        @foreach (@$timezonesLists as $t)
                                                        <option value="{{ @$t->id }}" @if (@$t->id == @Auth::user()->timezone_id) selected  @endif >{{ @$t->tz }}(UTC{{ @$t->utc_offset }})</option>
                                                        @endforeach
                                                        @endif
                                                    </select>

                                                </div>
                                            </div> --}}
                                                    {{-- <div class="clearfix"></div> --}}
                                                </div>
                                                <div class="row new_rows no-gutters">
                                                    {{-- <div class="col-md-4 col-sm-6">
                                                <div class="form_box_area">
                                                    <label for="timezone_id">Timezone*</label>
                                                    <select name="timezone_id" class="required" id="timezone_id">
                                                        <option value="">Select timezone</option>
                                                        @if (@$timezonesLists)
                                                        @foreach (@$timezonesLists as $t)
                                                        <option value="{{ @$t->id }}" @if (@$t->id == @Auth::user()->timezone_id) selected  @endif >{{ $t->tz }}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                            </div> --}}


                                                    <div class="col-md-4 col-sm-6">
                                                        <div class="form_box_area">
                                                            <label>First Name*</label>
                                                            <input type="text" placeholder="First Name " name="f_name"
                                                                value="{{ @$teacher->f_name }}" required="">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 col-sm-6">
                                                        <div class="form_box_area">
                                                            <label>Middle Name</label>
                                                            <input type="text" placeholder="Middle Name " name="m_name"
                                                                value="{{ @$teacher->m_name }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-6">
                                                        <div class="form_box_area">
                                                            <label> Last Name*</label>
                                                            <input type="text" placeholder="Last Name " name="l_name"
                                                                value="{{ @$teacher->l_name }}" required="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-6">
                                                        <div class="form_box_area">
                                                            <label>Primary Email<span
                                                                    tooltip="To modify, you may email backend support at 'tutorsupport@v-tutor.com.au">*<i
                                                                        class="qus-cir far fa-question-circle"></i></span></label>
                                                            <input type="email" placeholder="myemailaddress@xyz.com"
                                                                value="{{ @$teacher->email }}" disabled
                                                                class="addDisablePhone PointerEventsNone">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-6">
                                                        <div class="form_box_area">
                                                            <label>Primary Phone*</span></label>
                                                            <input type="text"
                                                                onfocus="this.removeAttribute('readonly');" readonly=""
                                                                onclick="this.removeAttribute('readonly');"
                                                                onblur="this.removeAttribute('readonly');" placeholder=""
                                                                value="{{ @$teacher->phone }}" name="ph"
                                                                required="" id="ph" class="remove_error"
                                                                autocomplete="off">
                                                        </div>
                                                    </div>
                                                    {{-- <!--div class="col-md-4 col-sm-6">
                                                <div class="form_box_area">
                                                    <label>Employment Status*</label>
                                                    <select name="teacher_emp_status">
                                                        <option value="">Select Status</option>
                                                        <option value="A" @if (@$teacher->teacher_emp_status == 'A') selected  @endif >Yes, I'm a full-time teacher</option>
                                                        <option value="B" @if (@$teacher->teacher_emp_status == 'B') selected  @endif>No, but I have teaching experience</option>
                                                        <option value="C" @if (@$teacher->teacher_emp_status == 'C') selected  @endif>Yes, but I'm not a teacher</option>
                                                        <option value="D" @if (@$teacher->teacher_emp_status == 'D') selected  @endif>No, but I have passion for teaching</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!---<div class="col-md-4 col-sm-6">
                                                <div class="form_box_area">
                                                    <label>Teaching experience</label>
                                                    <select >
                                                        <option value="">Yes, I'm a full-time teacher</option>
                                                        <option value="option1">No, but I have teaching experience</option>
                                                        <option value="option2">Yes, but I'm not a teacher</option>
                                                        <option value="option2">No, but I have passion for teaching</option>
                                                    </select>
                                                </div>
                                            </div>--->
                                            <!--div class="col-md-4 col-sm-6">
                                                <div class="form_box_area">
                                                    <label>How many hours can you commit?*</label>
                                                    <select name="hours">
                                                        <option value="">Select hours</option>
                                                        <option value="1-4" @if (@$teacher->hours == '1-4') selected  @endif  >< 5 hrs a week</option>
                                                        <option value="5-10" @if (@$teacher->hours == '5-10') selected  @endif >5 – 10 hrs a week</option>
                                                        <option value="10-20" @if (@$teacher->hours == '10-20') selected  @endif >10 – 20 hrs a week</option>
                                                        <option value="20-40" @if (@$teacher->hours == '20-40') selected  @endif >20 – 40 hrs a week</option>
                                                        <option value="40+" @if (@$teacher->hours == '40+') selected  @endif> > 40 hrs a week</option>
                                                    </select>
                                                </div>
                                            </div--> --}}


                                                    {{-- <div class="col-md-4 col-sm-6">
                                                <div class="form_box_area">
                                                    <label>Why do you want to be a Tutor?*</label>
                                                    <select name="why_tutor">
                                                        <option value="">Select</option>
                                                        <option value="A"@if (@$teacher->why_tutor == 'A') selected  @endif >Leverage my teaching experience</option>
                                                        <option value="B" @if (@$teacher->why_tutor == 'B') selected  @endif >Looking for after-hours gig</option>
                                                        <option value="C" @if (@$teacher->why_tutor == 'C') selected  @endif >To make more money by teaching</option>
                                                        <option value="D" @if (@$teacher->why_tutor == 'D') selected  @endif >Teaching is my passion, money secondary</option>
                                                        <option value="E"@if (@$teacher->why_tutor == 'E') selected  @endif > Safe way to make money from home</option>
                                                    </select>
                                                </div>
                                            </div> --}}


                                                    {{-- language --}}

                                                    {{-- <div class="col-md-4 col-sm-6">
                                                <div class="form_box_area">
                                                    <label>Languages Spoken*</label>
                                                <!--  <input type="text" placeholder="Language "  name="language" value="{{@$teacher->language}}" required=""> </div> -->

                                                    <select class="chosen-select form-control language remove_error" multiple name="language[]">
                                                        @if (@$lan)
                                                        @foreach (@$lan as $val)
                                                        <option value="{{@$val->id}}" @foreach (@$tutor_to_lan as $tt) @if ($tt->tutor_id == @$teacher->id && $tt->language_id == $val->id)selected  @endif @endforeach>{{@$val->language}}</option>
                                                        @endforeach
                                                        @endif
                                                            </select>
                                                            <label id="language[]-error" class="error" for="language[]"></label>
                                                </div>
                                            </div> --}}

                                                    {{-- <div class="col-md-4 col-sm-6">
                                                <div class="form_box_area">
                                                    <label>State / Province / Region*</label>
                                                    <select name="state" class="required">
                                                        <option value="">Select State</option>
                                                        @if (@$state)
                                                        @foreach ($state as $key => $val)

                                                        <option value="{{@$val->id}}" @if (Auth::user()->state == $val->id) selected  @endif  >{{$val->state_name}}</option>

                                                        @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div> --}}
                                                    {{-- end --}}

                                                    {{-- <div class="col-md-4 col-sm-6">
                                                    <div class="form_box_area">
                                                        <label>First Language*</span></label>
                                                        <input type="text" onfocus="this.removeAttribute('readonly');"
                                                            readonly="" onclick="this.removeAttribute('readonly');"
                                                            onblur="this.removeAttribute('readonly');" placeholder=""
                                                            value="{{ @$teacher->mother_tongue }}" name="mother_tongue"
                                                            required="" id="mother_tongue" class="remove_error"
                                                            autocomplete="off">
                                                    </div>
                                                </div> --}}

                                                    {{-- <div class="col-md-4 col-sm-6">
                                                    <div class="form_box_area">
                                                        <label>Primary Communication Language*</span></label>
                                                        <input type="text" onfocus="this.removeAttribute('readonly');"
                                                            readonly="" onclick="this.removeAttribute('readonly');"
                                                            onblur="this.removeAttribute('readonly');" placeholder=""
                                                            value="{{ @$teacher->primary_communication_lang }}"
                                                            name="primary_communication_language" required=""
                                                            id="primary_communication_language" class="remove_error"
                                                            autocomplete="off">
                                                    </div>
                                                </div> --}}

                                                    <div class="col-md-4 col-sm-6">
                                                        <div class="form_box_area">
                                                            <label>Nationality*</span></label>
                                                            <input type="text"
                                                                onfocus="this.removeAttribute('readonly');" readonly=""
                                                                onclick="this.removeAttribute('readonly');"
                                                                onblur="this.removeAttribute('readonly');" placeholder=""
                                                                value="{{ @$teacher->nationality }}"
                                                                name="select_nationality" required=""
                                                                id="country_selector" class="remove_error"
                                                                autocomplete="off">

                                                            <input type="hidden" id="nationality"
                                                                value="{{ @$teacher->phone ?? '' }}" name="nationality">
                                                        </div>
                                                    </div>

                                                    {{-- <div class="col-12 p-0">
                                                    <div class="row new_rows no-gutters">
                                                        <div class="col-md-6 col-sm-6">
                                                            <div class="checkBox new-cus tur-radio"> <span>Do you have
                                                                    experience working with children?</span>
                                                                <ul>
                                                                    <li class="one_li_check">
                                                                        <input type="radio" id="radio1"
                                                                            name="work_with_child" class="required"
                                                                            value="Y"
                                                                            @if (@$teacher->work_with_child == 'Y') checked @endif>
                                                                        <label for="radio1">Yes</label>
                                                                    </li>
                                                                    <li>
                                                                        <input type="radio" id="radio2"
                                                                            name="work_with_child" class="required"
                                                                            value="N"
                                                                            @if (!@$teacher->work_with_child) checked="" @endif
                                                                            @if (@$teacher->work_with_child == 'N') checked @endif>
                                                                        <label for="radio2">No</label>
                                                                    </li>
                                                                </ul>
                                                                <p class="note">Note: A WWCC pass is an essential criterion
                                                                    to onboard</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-sm-6">
                                                            <div class="form_box_area">
                                                                <label>WWCC number</label>
                                                                <input type="text" id="wwc_number"
                                                                    placeholder="Enter WWCC number"
                                                                    value="{{ @$teacher->wwc_number }}" name="wwc_number"
                                                                    class="inputfiels">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-6">
                                                            <div class="checkBox new-cus tur-radio">
                                                                <span><!-- Do you have any criminal cases or charges against you? --> Do you have a history or pending
                                                                    criminal court cases or charges laid against you?</span>
                                                                <ul>
                                                                    <li class="one_li_check">
                                                                        <input type="radio" id="radio3"
                                                                            name="criminal_case" value="Y"
                                                                            @if (@$teacher->criminal_case == 'Y') checked @endif
                                                                            onclick="yes()">
                                                                        <label for="radio3">Yes</label>
                                                                    </li>
                                                                    <li>
                                                                        <input type="radio" id="radio4"
                                                                            name="criminal_case" value="N"
                                                                            @if (@$teacher->criminal_case == 'N') checked @endif
                                                                            onclick="no()">
                                                                        <label for="radio4">No</label>
                                                                    </li>
                                                                </ul>

                                                            </div>
                                                        </div>



                                                        <div class="col-md-4 col-sm-6 <!-- tutor-c -->"
                                                            @if (@$teacher->criminal_case == 'N') style="display: none" @endif
                                                            id="criminal_detail">
                                                            <div class="form_box_area">
                                                                <label>Share more details</label>
                                                                <input type="text" id="criminal_det"
                                                                    placeholder="Enter here"
                                                                    value="{{ @$teacher->criminal_details }}"
                                                                    name="criminal_details" i>

                                                            </div>
                                                        </div>


                                                    </div>
                                                </div> --}}

                                                    <div class="col-md-12 col-sm-12">
                                                        <div class="form_box_area">
                                                            <label>What makes you an awesome V-Tutor?*</label>
                                                            {{-- placeholder="Write something cool about yourself in about 100 words." --}}
                                                            <textarea id="about_me"
                                                                placeholder="Write a short, resume-style headline parents will see in search results. Highlight your teaching experience, subject focus, and what makes you unique. Example: 'Passionate English tutor with 5+ years helping high school students excel'."
                                                                name="about_me" class="textarea_box">{{ @$teacher->about_me }}</textarea>
                                                            <div class="error_about_me error_textarea error"
                                                                id="flaggedwordsError"></div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-12">
                                                        <div class="d-flex">
                                                            <b class="pb-3">Profile Picture</b> <label data-toggle="modal"
                                                                class="onhover" data-target="#instructionModal">
                                                                <p class="ensure_text">(Please ensure to upload a
                                                                    profile
                                                                    pic that
                                                                    meets the <a href="javascript:void(0);"
                                                                        style="color:#b80f0a;">standards and
                                                                        requirements
                                                                    </a>of
                                                                    V-Tutor.)</p>
                                                            </label>
                                                        </div>
                                                        <div class="uplodimg text_sm_c">
                                                            <div class="uplodimgfil">
                                                                <input type="file" name="img" id="file-1"
                                                                    class="inputfile inputfile-1 imgValue"
                                                                    data-multiple-caption="{count} files selected"
                                                                    onChange="fun();">
                                                                <label for="file-1">Upload Profile Pic<img
                                                                        src="{{ public_asset('assets/images/up.png') }}"
                                                                        alt=""></label>
                                                            </div>
                                                            @if (@Auth::user()->profile_pic)
                                                                <div class="uplodimgfilimg review_img"
                                                                    style="display: block;">
                                                                    <em><img src="{{ url('/') }}/storage/teacher_profile_pic/{{ @Auth::user()->profile_pic }}"
                                                                            alt="" id="img2"></em>
                                                                </div>
                                                            @else
                                                                @if (@Auth::user()->avatar)
                                                                    <div class="uplodimgfilimg review_img"
                                                                        style="display: block;">
                                                                        <em><img src="{{ @Auth::user()->avatar }}"
                                                                                alt="" id="img2"></em>
                                                                    </div>
                                                                @else
                                                                    <div class="uplodimgfilimg review_img"
                                                                        style="display: none">
                                                                        <em><img src="" alt=""
                                                                                id="img2"></em>
                                                                    </div>
                                                                @endif
                                                            @endif


                                                        </div>

                                                        <p class="note error_image"></p>

                                                    </div>
                                                    {{-- <div class="col-md-12 col-sm-12">
                                                    <div class="form_box_area">
                                                        <input type="hidden" name="draft_value" id="draft_value"
                                                            value="">
                                                        <label>Profile Video</label>
                                                        <input type="text" placeholder="Enter or paste YouTube URL here"
                                                            id="youtube_link" value="{{ @$teacher->profile_video }}"
                                                            class="urli" name="youtube_link">
                                                    </div>
                                                    <span id="youtube_err" style="color: red"></span>
                                                </div> --}}

                                                    <div class="row new_rows no-gutters gj_res_addr_row">
                                                        <div class="col-12">
                                                            <h3 class="gj_res_addr_hd">Residential Address</h3>
                                                        </div>

                                                        @if (isset($approved) && $approved == 1)
                                                            <p class="gj_res_addr_dis_note">*Note: Changing your
                                                                residential address may impact your current bookings and is
                                                                therefore restricted. If you need to update your address for
                                                                valid reasons, please <a
                                                                    href="{{ route('contact.us') }}">Message Us</a> or
                                                                contact <a
                                                                    href="https://mail.google.com/mail/?view=cm&fs=1&to=support@v-tutor.com.au&cc=academics.admin@v-tutor.com.au"
                                                                    target="_blank"> support@v-tutor.com.au</a> for
                                                                assistance.</p>
                                                        @endif

                                                        <div class="col-md-4 col-sm-6">
                                                            <div class="form_box_area">
                                                                <label>State / Territory*</label>
                                                                <select name="state"
                                                                    style="{{ isset($approved) && $approved == 1 ? 'pointer-events:none;' : '' }}"
                                                                    id="state" class="form-control" class="required">
                                                                    <option value="">Select State</option>
                                                                    @foreach ($state as $st)
                                                                        <option value="{{ $st->id }}"
                                                                            data-timezone="{{ $st->time_zone }}"
                                                                            {{ @Auth::user()->state == $st->id || @Auth::user()->state_id == $st->id ? 'selected' : '' }}>
                                                                            {{ $st->state_name }}
                                                                        </option>
                                                                    @endforeach

                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 col-sm-6">
                                                            <div class="form_box_area">
                                                                <label>Suburb* </label>
                                                                <input type="text"
                                                                    {{ isset($approved) && $approved == 1 ? 'readonly' : '' }}
                                                                    class="required" placeholder="Sydney" name="city"
                                                                    value="{{ @$teacher->city }}">
                                                                <div class="error_city"></div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 col-sm-6">
                                                            <div class="form_box_area">
                                                                <label>Street *</label>
                                                                <input type="text"
                                                                    {{ isset($approved) && $approved == 1 ? 'readonly' : '' }}
                                                                    class="required" placeholder="123, Sample St"
                                                                    name="address" value="{{ @$teacher->address }}">
                                                                <div class="error_address"></div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 col-sm-6">
                                                            <div class="form_box_area">
                                                                <label>Postcode *</label>
                                                                <input type="text"
                                                                    {{ isset($approved) && $approved == 1 ? 'readonly' : '' }}
                                                                    minlength="4" maxlength="4" class="required"
                                                                    placeholder="1234" name="zip"
                                                                    value="{{ @$teacher->zip }}"
                                                                    onkeypress='validate(event)' pattern="\d{4}">
                                                                <div class="error_zip"></div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 col-sm-6">
                                                            <div class="form_box_area">
                                                                <label>Country*</label>
                                                                <select
                                                                    style="{{ isset($approved) && $approved == 1 ? 'pointer-events:none;' : '' }}"
                                                                    name="country">
                                                                    <option value="1">Australia</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 col-sm-6">
                                                            <div class="form_box_area">

                                                                <label for="time_zone">Time Zone</label>
                                                                <input type="text" id="timezone_id" name="timezone_id"
                                                                    class="form-control" readonly
                                                                    value="{{ @Auth::user()->timezone_id ?? '' }}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="user-account-info">

                                                <div class="row new_rows no-gutters">


                                                    <div class="clearfix"></div>
                                                    <div class="col-12">
                                                        <div class="check-box check-box-cu">


                                                        </div>
                                                    </div>




                                                    <div class="col-12">
                                                        <hr class="das-hr">
                                                    </div>
                                                    {{-- <div class="col-12">
                                                    <div class="check-box check-box-cu">
                                                        <label><strong>To apply as V-Tutor you need to complete the section on
                                                                ‘Advanced’ profile and submit.</strong></label>
                                                    </div>
                                                </div> --}}
                                                    <div class="col-12">
                                                        <div class="btn_3_cc gj_center">
                                                            @if (@Auth::user()->platform_type != null)
                                                                <input type="submit" name="save"
                                                                    value="Save & Update"
                                                                    class="sub_btn2 new-subbtn gj_sub_pf_but">
                                                            @else
                                                                {{-- <input type="button" name="save" value="Save & Update"
                                                                class="sub_btn2 new-subbtn" id="updateTutorProfile"> --}}
                                                                <input type="submit" name="save"
                                                                    value="Save & Update"
                                                                    class="sub_btn2 new-subbtn gj_sub_pf_but">
                                                            @endif

                                                            <a href="{{ route('tutor.public.profile', @Auth::user()->slug) }}"
                                                                class="sub_btn2 gj_vw_profile_but" target="_blank">View Profile</a>

                                                            {{-- <a href="{{ route('teacher.advance.page') }}"
                                                            class="sub_btn2 new-subbtn">Advanced</a> --}}

                                                            {{-- <input type="button" name="draft" value="Save as Draft" class="sub_btn2 new-subbtn" id="updateTutorProfile2"> --}}
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="footdashSec">
                                                            <input type="hidden" id="tutor_upd_my_pro"
                                                                data-toggle="modal" data-target="#tutorUpdatePopup">

                                                            <div class="sub2-lap">
                                                                <img src="{{ public_asset('assets/images/cona.png') }}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>




                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <div class="modal res-modal newqusmo instructionModal" id="instructionModal">
                <div class="modal-dialog modal-dialog-centered instructionModal">
                    <div class="modal-content instructionModal">

                        <!-- Modal Header -->
                        <div class="modal-header instructionModal">
                            <h4 class="modal-title">Profile Photo Guidelines</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body instructionModal">
                            <form action="">
                                <div class="divs">
                                    <div class="appome_input form_box_area cls1 ">
                                        <label>
                                            {{-- - When clicked, add a pop-up with following instructions:
                            - Ensure your face is visible clearly and occupies 80% of photo
                            - Make sure to smile, look cheerful but do not over do
                            - Make sure to wear formal attire and look professional
                            - Ensure the picture has a white or a lighter background so face in the foreground is clearly visible
                            - Upload latest or recently taken picture to ensure it matches in video session --}}
                                        </label>

      <div class="new-cus b-block" style="font-size: 10px; line-height: 1.5;">
    <ul class="submn" style="padding-left: 16px; margin-bottom: 13px;">
        <li><strong>Show your face clearly – </strong>it should take up about <strong>80% of the frame</strong>.</li>
        <li><strong>Dress professionally – </strong>formal or smart attire is required; avoid casual or distracting outfits.</li>
        <li><strong>Frame properly – </strong>your face and upper chest should be visible, centred, and in focus.</li>
        <li><strong>Smile naturally – </strong>look friendly, confident, and approachable.</li>
        <li><strong>Use a clean, light background – </strong>white or soft colours help your face stand out.</li>
        <li><strong>Ensure good lighting – </strong>face the light to keep your features bright and clear.</li>
        <li><strong>Avoid filters or effects – </strong>keep your photo natural and true to life.</li>
        <li><strong>Upload a recent photo – </strong>it should reflect your current appearance for video sessions.</li>
        <li><strong>Image size – </strong>for best display, use an image sized <strong>312 × 312 pixels</strong>.</li>
    </ul>


<p class="new-cus b-block" style="font-size: 10px; margin-top: 12px;">
    <strong>Note:</strong> 
    <em>Your profile photo may be featured on the V-Tutor homepage or promotional displays.  
    If you do not wish your photo to be used publicly, please contact  
        <a href="mailto:tutor.support@v-tutor.com.au" style="color: red;">
            tutor.support@v-tutor.com.au
        </a>.
    </em>
</p>









</div>


                                        {{-- <div class="next-btn1">
                            <button type="button" class="btn btn-new btn-danger" data-dismiss="modal" id="next">Ok</button>
                        </div> --}}
                                    </div>



                                </div>

                            </form>
                        </div>


                    </div>
                </div>
            </div>

            <div class="modal res-modal newqusmo" id="myModalnes">
                <div class="modal-dialog modal-dialog-centered divPoMW tapDiv proClose">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            {{-- <em class="procloseicon"><i class="fas fa-times"></i></em> --}}
                            <h4 class="modal-title">Warning</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body ">
                            <div class="testPro">
                                <div class="proDiv " id="warningTextDi">
                                    {{-- <h6>We are sorry to se</h6> --}}
                                    <span class="proclosespan">We are sorry to see you go</span>😔
                                    <h6></h6>
                                    <p>We notice that you have decided to close your account. If there are any issues /
                                        concerns
                                        that you would like to share or discuss, kindly <a
                                            href="{{ route('contact.us') }}">message us</a>. Our backend team will review
                                        and
                                        respond over email or give you a call, if needed.</p>
                                    <p>We require your account password to validate closure! Please be aware that this
                                        process is
                                        not reversible. Any data on this user account will be retained as per our policies
                                        and
                                        purged after a certain date. For more details, review our Privacy Policy.</p>

                                    <p class="tutoracademiccor">Academics Team</p>
                                    {{-- <p>We are sorry to see you go (sad)
                        </p> --}}
                                    <div class="next-btn1 newst_btn-pop">

                                        <button type="button" class="btn btn-new btn-danger float-left change-new-link"
                                            id="nextValueShow">Yes, please close</button>
                                        <button type="button" class="btn btn-new btn-danger " data-dismiss="modal">No,
                                            don’t
                                            close </button>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="appome_input form_box_area cls2 " id="passwordForm" style="display:none;">
                                    @if (@Auth::user()->user_type == 'T')
                                        <form action="{{ route('teacher.close.account') }}" id="checkPassword"
                                            method="post">
                                            @csrf
                                        @else
                                            <form action="{{ route('teacher.close.account') }}" id="checkPassword"
                                                method="post">
                                                @csrf
                                    @endif
                                    <span class="form_box_area mt-2" id="abcd">
                                        <label>Enter Password </label>
                                        <span class="autocomplete">
                                            <input id="mypassword" type="password" name="mypassword"
                                                placeholder="Enter your password" autocomplete="off" required=""
                                                class="required">
                                        </span>
                                    </span>
                                    <div class="next-btn1 newst_btn-pop">
                                        <button type="submit"
                                            class="btn btn-new btn-danger change-new-link">Submit</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footer')
    @include('include.footer')
    <div class="modal res-modal newqusmo" id="popupModal1">
        <div class="modal-dialog modal-dialog-centered divPoMW">
            <div class="modal-content">
                <div class="dvpro">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Welcome to V-Tutor!</h4>
                        <button type="button" class="close" id="popupModalclose" data-dismiss="modal"
                            onclick="modalHidePM1()">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body ">

                        <div class="testPro">

                            <div class="proDiv">
                                {{-- <h6>Congrats on your login!</h6> --}}

                                <p>We’re excited to have you on board. It’s time to start building your tutoring profile:
                                </p>

                                <span><strong>Tutoring Plan - </strong> Add the grades and subjects you can teach (Years
                                    1–12). </span>
                                <span><strong>Set Your Rates - </strong> Choose your session pricing within the available
                                    range (you can adjust anytime).</span>
                                <span><strong>Availability - </strong> Add your preferred days and times between 6 am – 8 pm
                                    local time.</span>

                                <p class="xxctopnn">(Please note: Availability settings will be enabled once your tutor
                                    application is fully approved.) </p>

                                <p>We wish you every success and hope you enjoy your tutoring journey with V-Tutor! </p>
                                <p>For assistance, visit our <b>Help Section</b> or contact us at
                                    <b>tutorsupport@v-tutor.com.au</b>.
                                </p>

                                <p class="student_pro_p">Warm regards,</p>
                                <p>The Academics Team </p>
                                {{-- <p>Start building your Tutor profile to get maximum visibility by performing the following,
                                </p>

                                <span><strong>Add Tutorship plan - </strong> Choose your pricing per session by adding more
                                    sessions </span>
                                <span><strong>Add Academics - </strong> Go on and add your academic achievements and
                                    awards</span>
                                <span><strong>Add Experience - </strong> Add on and let everyone know how experienced you
                                    are</span>
                                <span><strong>Add Recognitions - </strong> Mention your recognitions so we know how capable
                                    you are</span>

                                <p class="xxctopnn">Don't forget to fill in availability to start your tutoring journey as
                                    V-Tutor. </p>

                                <p>All the best! For additional support, visit the ‘Help Section’</p>

                                <p class="student_pro_p">Regards,</p>
                                <p>Academics Team</p> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    {{-- profile update popup --}}
    <div class="modal res-modal newqusmo studentUpdatePopupModal" id="tutorUpdatePopup">
        <div class="modal-dialog modal-dialog-centered divPoMW tapDiv proClose">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Password Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body ">
                    <div class="testPro">
                        <div class="proDiv">

                            <span class="form_box_area mt-2">
                                <label>Confirm your password</label>
                                <span class="autocomplete">
                                    <input id="pmypassword" type="password" name="pmypassword"
                                        placeholder="Enter your password" autocomplete="off" class="required">
                                    <span class="error_pmypassword error"></span>
                                </span>
                            </span>
                            {{-- <div class="col-12">
                        <div class="btn_3_cc">
                            <input type="submit" name="save" value="Submit & Apply" class="sub_btn2 " id="save" >
                            <input type="submit" name="draft" value="Save as Draft" class="sub_btn2 " id="draft">
                        </div>
                    </div> --}}
                            <div class="next-btn1 newst_btn-pop">
                                <input type="button" id="updatePro" class="btn btn-new btn-danger change-new-link"
                                    value="Submit">
                                {{-- <button type="button" class="btn btn-new btn-danger change-new-link" id="updatePro">Submit</button> --}}
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal res-modal newqusmo" id="close_accountInform_modal">
        <div class="modal-dialog modal-dialog-centered tapDiv proClose">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    {{-- <em class="procloseicon"><i class="fas fa-times"></i></em> --}}
                    <h4 class="modal-title">Warning</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body ">
                    <div class="testPro">
                        <div class="proDiv " id="closeWarningTextDi">
                            {{-- <h6>We are sorry to se</h6> --}}
                            <span class="proclosespan">We are sorry to see you go</span>😔
                            <h6></h6>
                            <p>We notice that you have decided to close your account. If there are any issues / concerns
                                that you would like to share or discuss, kindly <a
                                    href="{{ route('contact.us') }}">message us</a>. Our backend team will review and
                                respond over email or give you a call, if needed.</p>
                            <p>We require your account password to validate closure! Please be aware that this process is
                                not reversible. Any data on this user account will be retained as per our policies and
                                purged after a certain date. For more details, review our Privacy Policy.</p>

                            <p class="tutoracademiccor">Academics Team</p>
                            {{-- <p>We are sorry to see you go (sad) </p> --}}
                            <div class="next-btn1 newst_btn-pop">
                                <button type="button" class="btn btn-new btn-danger float-left change-new-link"
                                    id="yes_close">Yes, please close</button>
                                <button type="button" class="btn btn-new btn-danger " data-dismiss="modal">No, don’t
                                    close </button>
                                <div class="clearfix"></div>
                            </div>
                        </div>

                        <div class="proDiv" id="closePwConfirm" style="display: none">

                            <span class="form_box_area mt-2">
                                <label>Confirm your password</label>
                                <span class="autocomplete">
                                    <input id="close_acc_pw" type="password" name="close_acc_pw"
                                        placeholder="Enter your password" autocomplete="off" class="required">
                                    <span class="error_close_acc_pw error"></span>
                                </span>
                            </span>

                            <div class="next-btn1 newst_btn-pop">
                                <input type="button" id="submit_close_acc"
                                    class="btn btn-new btn-danger change-new-link" value="Submit">
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal res-modal newqusmo studentUpdatePopupModal" id="close_account_modal">
        <div class="modal-dialog modal-dialog-centered divPoMW tapDiv proClose">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Password Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body ">
                    <div class="testPro">
                        <div class="proDiv">

                            <span class="form_box_area mt-2">
                                <label>Confirm your password</label>
                                <span class="autocomplete">
                                    <input id="close_acc_pw" type="password" name="close_acc_pw"
                                        placeholder="Enter your password" autocomplete="off" class="required">
                                    <span class="error_close_acc_pw error"></span>
                                </span>
                            </span>

                            <div class="next-btn1 newst_btn-pop">
                                <input type="button" id="submit_close_acc"
                                    class="btn btn-new btn-danger change-new-link" value="Submit">
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal res-modal newqusmo studentUpdatePopupModal" id="close_account_success_modal">
        <div class="modal-dialog modal-dialog-centered divPoMW tapDiv proClose">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Success</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body ">
                    <div class="testPro">
                        <div class="proDiv">

                            <p>Your V-Tutor account is closed!</p>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal res-modal newqusmo studentUpdatePopupModal" id="waitPopup">
        <div class="modal-dialog modal-dialog-centered tapDiv proClose">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Saving</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body ">
                    <div class="testPro">
                        <div class="proDiv">

                            <p>Your information is being saved</p>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    @include('include.script')
    {{-- select2 --}}
    <script src="{{ public_asset('assets/js/chosen.jquery.js') }}" type="text/javascript"></script>
    <script src="{{ public_asset('assets/js/init.js') }}" type="text/javascript"></script>

    {{-- select2 end --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"
        integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg=="
        crossorigin="anonymous"></script>
    <script>
        $("#country_selector").countrySelect({
            defaultCountry: "au",
            responsiveDropdown: true
        });

        $('#nationality').val($("#country_selector").countrySelect("getSelectedCountryData").name);

        @if (isset($taf_data->nationality) && $taf_data->nationality)
            $("#country_selector").countrySelect("setCountry", "{{ $taf_data->nationality }}");
            $('#nationality').val($("#country_selector").countrySelect("getSelectedCountryData").name);
        @endif

        $(document).on('change', '#country_selector', function() {
            var country = $(this).countrySelect("getSelectedCountryData");
            // console.log(country.name);
            $('#nationality').val(country.name);
        });

        $(document).on('change', '#state', function() {
            let tz = $(this).find(':selected').data('timezone');
            // alert(tz);
            if (tz) {
                $('#timezone_id').val(tz);
            }
        });

        $(document).on('click', '#submit_close_acc', async function() {
            var close_acc_pw = $('#close_acc_pw').val();
            $.ajax({
                url: "{{ route('tutor_close_account') }}",
                method: "POST",
                data: {
                    close_acc_pw: close_acc_pw,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response && response == 1) {
                        $('.error_close_acc_pw').text('');
                        // $("#close_account_modal").modal('hide');
                        $("#close_account_modal .close").trigger('click');
                        $("#close_account_success_modal").modal('show');

                        setTimeout(function() {
                            window.location.href = "{{ route('login') }}";
                        }, 10000);
                    } else if (response && response == 2) {
                        $('.error_close_acc_pw').text('Your tutor account close request is failed');
                    } else if (response && response == 3) {
                        $('.error_close_acc_pw').text('Wrong Password');
                    } else if (response && response == 4) {
                        $('.error_close_acc_pw').text('Password is required');
                    } else {
                        $('.error_close_acc_pw').text('Your tutor account close request is failed');
                    }
                },
                error: function(xhr) {
                    $('.gj_action_alert_msg').html(
                        '<div class="alert alert-danger alert-dismissible" style="text-align: center;"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>Something wrong, please try again later</div>'
                    );
                }
            });
        });

        $(document).on('click', '#yes_close', function() {
            $('#closeWarningTextDi').hide();
            $('#closePwConfirm').show();
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#updatePro").on("click", function() {
                var pmypassword = $.trim($("#pmypassword").val());
                $("#check_password").val(pmypassword);

                if (pmypassword != "") {
                    $("#frm").submit();
                } else {
                    $(".error_pmypassword").text("Please provide password");
                }

            });
            $("#proPasswordValidate").validate();
            $('#checkbox2').change(function() {
                var obj = $('#checkbox2');

                if ($(this).prop('checked') == true) {
                    $('.disable-input').prop("disabled", false);
                    $('.submit-login').removeClass('disable-input');

                } else {
                    $('.submit-login').addClass('disable-input');
                    $('.disable-input').prop("disabled", true);

                }
            });

            jQuery.validator.addMethod("emailonly", function(value, element) {
                return this.optional(element) || /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/.test(
                    value.toLowerCase());
            }, "Enter a valid email address");

            jQuery.validator.addMethod("mobileonly", function(value, element) {
                return this.optional(element) || /^[+]?\d+$/.test(value.toLowerCase());
            }, "Enter valid number");

            jQuery.validator.addMethod("maxWords", function(value, element, max) {
                if ($.trim(value).length === 0) return false; // empty = invalid
                var words = $.trim(value).split(/\s+/); // split by spaces
                return words.length <= max;
            }, "Please enter maximum 100 words.");


            $('#frm').validate({
                ignore: [],
                rules: {
                    f_name: {
                        required: true,
                    },
                    l_name: {
                        required: true,
                    },

                    ph: {
                        required: true,
                        minlength: 10,
                        maxlength: 10,
                        mobileonly: true,
                        remote: {
                            url: '{{ route('check.mobile.two') }}',
                            type: "get",
                            data: {
                                ph: function() {
                                    return $("#ph").val();
                                }
                            }
                        }
                    },
                    @if (!@Auth::user()->email)
                        email: {
                            required: true,
                            email: true,
                            emailonly: true
                        },
                    @endif

                    about_me: {
                        required: true,
                        // minlength: 10,
                        maxWords: 100,
                    },
                    address: {
                        required: true,
                        minlength: 4,
                    },

                },
                messages: {
                    ph: {
                        required: 'Please enter a valid 10 digit mobile number',
                        minlength: 'Mobile number can have minimum 10 digits',
                        maxlength: 'Mobile number can have maximum 10 digits',
                        mobileonly: 'Enter a valid 10 digit mobile number',
                        remote: "This mobile number already exists.!"
                    },
                },

                submitHandler: function(form) {
                    $("#waitPopup").modal({
                        closable: false,
                        autofocus: false
                    }).modal("show");

                    form.submit();


                },



            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $(document).on("keyup", ".remove_error", function() {
                var id = $(this).attr("id");
                $(".error_" + id).html("");
            });
            $(document).on("change", ".remove_error", function() {
                var id = $(this).attr("id");
                $(".error_" + id).html("");
            });
            $(document).on("keyup", "#ref_1_email", function() {

                $(".error_ref_1_phone").html("");
            });
            $(document).on("keyup", "#ref_1_phone", function() {

                $(".error_ref_1_email").html("");
            });
            $(document).on("keyup", "#ref_2_email", function() {

                $(".error_ref_2_phone").html("");
            });
            $(document).on("keyup", "#ref_2_phone", function() {

                $(".error_ref_2_email").html("");
            });
            $(document).on("click", "#updateTutorProfile", function() {
                $("#draft_value").val("Y");
                var isvalidator = $("#frm").validate();
                if (isvalidator.form()) {
                    if (isvalidator.valid()) {
                        $("#tutor_upd_my_pro").trigger("click");
                    }
                }

            });
            $(document).on("click", "#updateTutorProfile2", function() {
                $("#draft_value").val("N");
                var isvalidator = $("#frm").validate();
                if (isvalidator.form()) {
                    if (isvalidator.valid()) {
                        $("#tutor_upd_my_pro").trigger("click");
                    }
                }

            });
            $(document).on("click", "#nextValueShow", function() {

                $("#myModalnes").addClass("studentUpdatePopupModal");
            });
            // jayatri 19-11-2021 select avatar
            $(document).on("click", ".on_select_u", function() {
                $("#img2").attr('src', $(this).attr("data-src"));
                $("#imgSelect").val($(this).attr("data-picname"));
                $(".selectedImage").removeClass("selectedImage");
                $(this).addClass("selectedImage");
            });
            // update avatar
            $(document).on("click", "#select_profile_pic_btn", function() {
                var profile_pic_val = $("#imgSelect").val();
                // var profile_pic = $("#imgSelect").attr("data-picname");
                if (profile_pic_val != "") {
                    uploadAvatar(profile_pic_val);
                } else {
                    $(".selected_image_error").html("Please select avatar");
                }
            });

            function uploadAvatar(profile_pic_val) {
                var reqData = {
                    'jsonrpc': '2.0',
                    '_token': '{{ csrf_token() }}',
                    'data': {
                        'profile_pic': profile_pic_val
                    }
                };
                if (confirm("Are you sure you want to set this avatar as your profile pic?")) {
                    $.ajax({
                        url: "{{ route('tutor.avatar.update') }}",
                        dataType: 'json',
                        data: reqData,
                        type: 'post',
                        success: function(resp) {
                            $(".selected_image_error").html(resp.message);
                            location.reload();
                        }
                    });
                }
            }
            $(document).on("change keyup blur", ".remove_error", function() {
                var isvalidator = $("#frm").validate();
                if (isvalidator.form()) {
                    if (isvalidator.valid()) {}
                }
            });
        });
    </script>
    <script>
        function fun() {
            var i = document.getElementById('file-1').files[0];
            console.log(i);
            var b = URL.createObjectURL(i);
            $(".review_img").show();
            $("#img2").attr("src", b);
        }

        function yes() {
            $("#criminal_det").val('{{ @$teacher->criminal_details }}');
            $("#criminal_detail").show();
        }

        function no() {

            $("#criminal_det").val('');
            $("#criminal_detail").hide();
        }
    </script>

    <script>
        @if (@Auth::user()->is_login == 0)
            {{-- @if (session()->has('success') || session()->has('error') || $errors->any()) --}}
            $("#messageShow").trigger("click");
            // $("#popupModal1").modal('show');
        @elseif (session()->has('success') || session()->has('error') || $errors->any())
            $("#messageShowUpd").trigger("click");
            // $("#popupModal").modal('show');
        @endif
        // $("#popupModal1").show();
    </script>
    {{-- jayatri for flageed words on 18-11-2021 --}}
    <script type="text/javascript">
        function checkEmailPhone() {
            // function check() {
            var val = $.trim(textarea.val()),
                err = '';

            if (!val.length) {
                err = 'No input ?';
                return;
            }

            var emails = val.split(','),
                notvalid = [],
                temp = [];

            $.each(emails, function(_, mail) {
                mail = $.trim(mail);
                if (mail.length) {
                    var m = mail.match(/([a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z0-9._-]+)/gi);
                    if (m) {
                        temp.push(m);
                        textarea.val("");
                        $(".error_textarea").html(
                            "Kindly refrain from using email, phone or flagged words on the description!");
                        // alert("1 :"+m);
                    } else {
                        var p = mail.match(/[0-9]{10}\d{10}/);
                        if (p) {
                            textarea.val("");
                            $(".error_textarea").html(
                                "Kindly refrain from using email, phone or flagged words on the description!");
                        }
                        if (mail.includes("email") || mail.includes("phone") || mail.includes(".com") || mail
                            .includes("gmail") || mail.includes(".net") || mail.includes("call") || mail.includes(
                                "reach")) {
                            textarea.val("");
                            $(".error_textarea").html(
                                "Kindly refrain from using email, phone or flagged words on the description!");
                        }
                        // alert("2 :"+mail);
                        temp.push(mail);
                        notvalid.push(mail)
                    }
                } else {
                    // alert("3 :"+mail);
                    temp.push(mail);
                }

                if (notvalid.length) err = 'Not valid emails : ' + notvalid.join(', ');
            });

            // $('#error').html(err);

        }

        function check() {
            var badWords = [];
            var foundBadWords = [];
            @php
                $badwords = \DB::table('bad_words')->pluck('words')->toArray();
            @endphp
            @foreach (@$badwords as $value)
                badWords.push('{{ $value }}');
            @endforeach
            badWords.push('email');
            badWords.push('phone');
            badWords.push('reach');
            badWords.push('call');
            badWords.push('gmail');
            badWords.push('.net');
            badWords.push('.com');
            var wordInput = textarea.val();
            if (wordInput) {
                wordInput = wordInput.toLowerCase();
                var arr = wordInput.split(" ");
                var foundBadWords = arr.filter(el => badWords.includes(el));
            }

            if (foundBadWords.length > 0) {
                $(".error_textarea").html('Kindly refrain from using email, phone or flagged words on the description!');
                textarea.val("");
                return false;
            }
            var wordInput = textarea.val();
            if (wordInput) {
                wordInput = wordInput.toLowerCase();
                var arr = wordInput.split(" ");
                $.each(arr, function(_, t) {
                    if (/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/.test(t.toLowerCase())) {
                        $(".error_textarea").html(
                            'Kindly refrain from using email, phone or flagged words on the description!');
                        textarea.val("");
                    }

                    if (/^[+]?\d+$/.test(t.toLowerCase()) && t.length == 10) {
                        $(".error_textarea").html(
                            'Kindly refrain from using email, phone or flagged words on the description!');
                        textarea.val("");
                    }

                    // if(t.match("\d{10}")){
                    //     $(".error_textarea").html('Kindly refrain from using email, phone or flagged words on the description!');
                    //     textarea.val("");
                    // }
                });
            }
        }
        var textarea = $('.textarea_box');
        textarea.on({
            keyup: function(e) {
                $(".error_textarea").html('');
                if (e.which == 188) check();
                if (e.which == 32) check();
                // check();
                var words = 0;
                if ((this.value.match(/\S+/g)) != null) {
                    words = this.value.match(/\S+/g).length;
                }
                if (words > 100) {
                    var trimmed = $(this).val().split(/\s+/, 100).join(" ");
                    $(this).val(trimmed + " ");
                }
            },
            blur: check
        });

        function validate(evt) {
            var theEvent = evt || window.event;
            // Handle paste
            if (theEvent.type === 'paste') {
                key = event.clipboardData.getData('text/plain');
            } else {
                var key = theEvent.keyCode || theEvent.which;
                key = String.fromCharCode(key);
            }
            var regex = /[0-9]/;
            if (!regex.test(key)) {
                theEvent.returnValue = false;
                if (theEvent.preventDefault) theEvent.preventDefault();
            }
        }
    </script>

    <script type="text/javascript">
        function modalHidePM1() {
            $("#popupModal1").hide();
        }
    </script>
@endsection
