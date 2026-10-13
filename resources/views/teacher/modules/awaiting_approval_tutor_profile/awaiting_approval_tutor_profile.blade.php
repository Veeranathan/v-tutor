@extends('layouts.app')
@section('title')
    <title>V-Tutor  | Tutor | Personal Details</title>
@endsection
@section('left_part')
    @include('include.header_menu_part')
    <style type="text/css">
        .user-right-panel {
            width: 100% !important;
        }
    </style>
    <style type="text/css">
        .addDisablePhone {
            opacity: 0.5 !important;
        }

        .pointerEventsNone {
            pointer-events: none !important;
        }
    </style>
@endsection
@section('content')
    <!-- bannersec -->
    {{--
<div>
    --}}
    <!--- profile --->
    <div class="top_mar"></div>
    <!--- profile --->
    <section class="user-account">
        <div class="container">
            <div class="row">
                {{--
                <div class="zin">
                    --}}
                @if (@Auth::user()->status == 'A')
                    @include('include.teacher_left_common'){{-- left common part --}}
                @endif
                <div class="user-right-panel tutor-right">
                    <div class="step_tab">
                        <ul>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="turo-edit">
                        <div class="user-right-top">
                            <h2 class="profile-heading"><span class="per-info"><img
                                        src="{{ public_asset('assets/images/per-info.png') }}"></span> Personal Details</h2>
                            <p>You can find information or edit your profile in this section</p>
                            <br>
                            <form method="post" action="{{ route('tutor.awaiting.approval.profile.update') }}"
                                enctype="multipart/form-data" id="frm">
                                @csrf
                                <div class="user-account-info">
                                    <div class="row new_rows no-gutters">
                                        <div class="col-md-4 col-sm-6">
                                            <div class="form_box_area">
                                                <label>First Name*</label>
                                                <input type="text" placeholder="First Name " name="f_name"
                                                    value="{{ @$teacher->f_name }}"
                                                    class="required inputfiels required_fields">
                                                <div class="error_f_name"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="form_box_area">
                                                <label>Last Name*</label>
                                                <input type="text" placeholder="Last Name " name="l_name"
                                                    value="{{ @$teacher->l_name }}"
                                                    class="required inputfiels required_fields">
                                                <div class="error_l_name"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="form_box_area">
                                                <label>Email Address<span
                                                        tooltip="Please ensure details are accurate to avoid delays in processing the application">*<i
                                                            class="qus-cir far fa-question-circle"></i></span></label>
                                                <input class="inputfiels" type="email"
                                                    placeholder="myemailaddress@xyz.com" value="{{ @$teacher->email }}"
                                                    disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="form_box_area">
                                                <label>Mobile Number<span
                                                        tooltip="Please ensure details are accurate to avoid delays in processing the application">*<i
                                                            class="qus-cir far fa-question-circle"></i></span></label>
                                                <input type="tel" placeholder="0123456789"
                                                    value="{{ @$teacher->phone }}" name="ph" id="ph"
                                                    class="inputfiels required required_fields">
                                                <div class="error_ph"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="form_box_area">
                                                <label for="teacher_emp_status">Employment Status*</label>
                                                <select name="teacher_emp_status" id="teacher_emp_status"
                                                    class="required inputfiels required_fields">
                                                    <option value="">Select Status</option>
                                                    <option value="A"
                                                        @if (@$teacher->teacher_emp_status == 'A') selected @endif>Yes, I'm a
                                                        full-time teacher</option>
                                                    <option value="B"
                                                        @if (@$teacher->teacher_emp_status == 'B') selected @endif>No, but I have
                                                        teaching experience</option>
                                                    <option value="C"
                                                        @if (@$teacher->teacher_emp_status == 'C') selected @endif>Yes, but I'm not a
                                                        teacher</option>
                                                    <option value="D"
                                                        @if (@$teacher->teacher_emp_status == 'D') selected @endif>No, but I have
                                                        passion for teaching</option>
                                                </select>
                                                <div class="error_teacher_emp_status"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="form_box_area">
                                                <label for="hours">How many hours can you commit?*</label>
                                                <select name="hours" id="hours"
                                                    class="required inputfiels required_fields">
                                                    <option value="">Select hours</option>
                                                    <option value="1-4"
                                                        @if (@$teacher->hours == '1-4') selected @endif>
                                                        < 5 hrs a week</option>
                                                    <option value="5-10"
                                                        @if (@$teacher->hours == '5-10') selected @endif>5 – 10 hrs a week
                                                    </option>
                                                    <option value="10-20"
                                                        @if (@$teacher->hours == '10-20') selected @endif>10 – 20 hrs a week
                                                    </option>
                                                    <option value="20-40"
                                                        @if (@$teacher->hours == '20-40') selected @endif>20 – 40 hrs a week
                                                    </option>
                                                    <option value="40+"
                                                        @if (@$teacher->hours == '40+') selected @endif> > 40 hrs a week
                                                    </option>
                                                </select>
                                                <div class="error_hours"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="form_box_area">
                                                <label for="why_tutor">Why do you want to be a Tutor?*</label>
                                                <select name="why_tutor" id="why_tutor"
                                                    class="required inputfiels required_fields">
                                                    <option value="">Select</option>
                                                    <option
                                                        value="A"@if (@$teacher->why_tutor == 'A') selected @endif>
                                                        Leverage my teaching experience</option>
                                                    <option value="B"
                                                        @if (@$teacher->why_tutor == 'B') selected @endif>Looking for
                                                        after-hours gig</option>
                                                    <option value="C"
                                                        @if (@$teacher->why_tutor == 'C') selected @endif>To make more
                                                        money by teaching</option>
                                                    <option value="D"
                                                        @if (@$teacher->why_tutor == 'D') selected @endif>Teaching is my
                                                        passion, money secondary</option>
                                                    <option
                                                        value="E"@if (@$teacher->why_tutor == 'E') selected @endif>
                                                        Safe way to make money from home</option>
                                                </select>
                                                <div class="error_hours"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 inputfiels">
                                            <div class="form_box_area">
                                                <label>Languages Spoken*</label>
                                                <select
                                                    class="chosen-select form-control language inputfiels required_fields"
                                                    multiple name="language[]"
                                                    @if (@Auth::user()->draft == 'N') disabled @endif>
                                                    @foreach ($lan as $val)
                                                        <option value="{{ @$val->id }}"
                                                            @foreach (@$tutor_to_lan as $tt) @if ($tt->tutor_id == @$teacher->id && $tt->language_id == $val->id)selected  @endif @endforeach>
                                                            {{ @$val->language }}</option>
                                                    @endforeach
                                                </select>
                                                <label id="language[]-error" class="error" for="language[]"></label>
                                            </div>
                                        </div>
                                        <div class="col-12 p-0">
                                            <div class="row new_rows no-gutters">
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="checkBox new-cus tur-radio">
                                                        <span>Do you have experience working with children?</span>
                                                        <ul>
                                                            <li class="one_li_check">
                                                                <input type="radio" id="radio1"
                                                                    name="work_with_child" value="Y"
                                                                    @if (@$teacher->work_with_child == 'Y') checked @endif
                                                                    class="inputfiels required_fields">
                                                                <label for="radio1">Yes</label>
                                                            </li>
                                                            <li>
                                                                <input type="radio" id="radio2"
                                                                    name="work_with_child" value="N"
                                                                    @if (@$teacher->work_with_child == 'N') checked @endif
                                                                    class="inputfiels required_fields"
                                                                    @if (!@$teacher->work_with_child == 'Y' && !@$teacher->work_with_child == 'N') checked @endif>
                                                                <label for="radio2">No</label>
                                                            </li>
                                                        </ul>
                                                        <p class="note">Note: A WWCC pass is an essential criterion to
                                                            onboard</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-6">
                                                    <div class="form_box_area">
                                                        <label>WWCC number</label>
                                                        <input type="text" id="wwc_number"
                                                            placeholder="Enter WWCC number"
                                                            value="{{ @$teacher->wwc_number }}" name="wwc_number"
                                                            class="inputfiels required_fields">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="checkBox new-cus tur-radio">
                                                        <span>Do you have a history or pending criminal court cases or
                                                            charges laid against you?</span>
                                                        <ul>
                                                            <li class="one_li_check">
                                                                <input type="radio" id="radio3" name="criminal_case"
                                                                    value="Y"
                                                                    @if (@$teacher->criminal_case == 'Y') checked @endif
                                                                    onclick="yes()" class="inputfiels required_fields">
                                                                <label for="radio3">Yes</label>
                                                            </li>
                                                            <li>
                                                                <input type="radio" id="radio4" name="criminal_case"
                                                                    value="N"
                                                                    @if (@$teacher->criminal_case == 'N') checked @endif
                                                                    onclick="no()" class="inputfiels required_fields">
                                                                <label for="radio4">No</label>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-6 {{-- tutor-c --}}"
                                                    @if (@$teacher->criminal_case == 'N') style="display: none" @endif
                                                    id="criminal_detail">
                                                    <div class="form_box_area">
                                                        <label>Share more details</label>
                                                        <input type="text" id="criminal_det" placeholder="Enter here"
                                                            value="{{ @$teacher->criminal_details }}"
                                                            name="criminal_details" i class="inputfiels required_fields">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12">
                                            <div class="form_box_area">
                                                <label>What makes you an awesome V-Tutor?*</label>
                                                <textarea onfocus placeholder="Describe your key areas, strengths, interests in about 200 words." name="about_me"
                                                    id="about_me" class="inputfiels textarea_box required_fields" maxlength="2000">{{ @$teacher->about_me }}</textarea>
                                                <div class="error_about_me error error_textarea"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 inputfiels">
                                            <div class="uplodimg text_sm_c">
                                                <div class="uplodimgfil">
                                                    <b>Profile Picture*</b>
                                                    <input type="file" name="img" id="file-1"
                                                        class="inputfile inputfiels inputfile-1 imgValue required_fields   @if (!@Auth::user()->profile_pic && !@Auth::user()->avatar)  @endif"
                                                        data-multiple-caption="{count} files selected" onChange="fun();">
                                                    <label for="file-1">Upload Profile Pic<img
                                                            src="{{ public_asset('assets/images/up.png') }}"
                                                            alt=""></label>
                                                </div>
                                                @if (@Auth::user()->profile_pic)
                                                    <div class="uplodimgfilimg review_img" style="display: block;">
                                                        <em><img src="{{ env('STORAGE_URL') . '/teacher_profile_pic/' . @Auth::user()->profile_pic }}"
                                                                alt="" id="img2"></em>
                                                    </div>
                                                @else
                                                    @if (@Auth::user()->avatar)
                                                        <div class="uplodimgfilimg review_img" style="display: block;">
                                                            <em><img src="{{ @Auth::user()->avatar }}" alt=""
                                                                    id="img2"></em>
                                                        </div>
                                                    @else
                                                        <div class="uplodimgfilimg review_img" style="display: none">
                                                            <em><img src="" alt="" id="img2"></em>
                                                        </div>
                                                    @endif
                                                @endif
                                                <label data-toggle="modal" class="onhover"
                                                    data-target="#instructionModal">
                                                    <p class="ensure_text">Please ensure to upload a profile pic that meets
                                                        the <a href="javascript:void(0);" style="color:#b80f0a;">standards
                                                            and requirements </a>of V-Tutor.</p>
                                                </label>
                                            </div>
                                            <p class="note error_image"></p>
                                        </div>
                                        <div class="col-md-12 col-sm-12">
                                            <div class="form_box_area">
                                                <label>Profile Video</label>
                                                <input type="text" placeholder="Enter or paste YouTube URL here"
                                                    id="youtube_link" value="{{ @$teacher->profile_video }}"
                                                    class="urli inputfiels required_fields" name="youtube_link">
                                            </div>
                                            <span id="youtube_err" style="color: red"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="user-account-info">
                                    <div class="row new_rows no-gutters">
                                        <div class="col-12">
                                            <h3>Residential Address</h3>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="form_box_area">
                                                <label>Country*</label>
                                                <select name="country" class="inputfiels required_fields">
                                                    <option value="1">Australia</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="form_box_area">
                                                <label>State / Province / Region*</label>
                                                <select name="state" class="inputfiels required_fields">
                                                    @foreach ($state as $key => $val)
                                                        <option value="{{ @$val->id }}"
                                                            @if (Auth::user()->state == $val->id) selected @endif>
                                                            {{ $val->state_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="form_box_area">
                                                <label>City* </label>
                                                <input type="text" placeholder="Sydney" name="city"
                                                    value="{{ @$teacher->city }}" class="inputfiels required_fields">
                                                <div class="error_city"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="form_box_area">
                                                <label>Unit & Street Address *</label>
                                                <input type="text" placeholder="123, Sample St" name="address"
                                                    value="{{ @$teacher->address }}" class="inputfiels required_fields">
                                                <div class="error_address"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="form_box_area">
                                                <label>Zip / Postal Code *</label>
                                                <input type="text" minlength="4" maxlength="4" placeholder="1234"
                                                    name="zip" value="{{ @$teacher->zip }}"
                                                    class="inputfiels required_fields" onkeypress='validate(event)'
                                                    pattern="\d{4}">
                                                <div class="error_zip"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 inputfiels">
                                            <div class="form_box_area">
                                                <label>Timezone<span
                                                        tooltip="Please choose carefully as this would impact booking of sessions">*<i
                                                            class="qus-cir far fa-question-circle"></i></span></label>
                                                <select name="timezone_id" class="required required_fields"
                                                    id="timezone_id">
                                                    <option value="">Select timezone</option>
                                                    @if (@$timezonesLists)
                                                        @foreach (@$timezonesLists as $t)
                                                            <option value="{{ @$t->id }}"
                                                                @if (@$t->id == @Auth::user()->timezone_id) selected @endif>
                                                                {{ @$t->time_zone_abbreviation }},{{ @$t->time_zone_name }},{{ @$t->city }}
                                                                @if ($t->id == 6)
                                                                    ,Melbourne
                                                                @endif ({{ @$t->utc_offset }})
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <p class="note">Note: Please choose carefully as this would impact
                                                    booking of sessions!</p>

                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-xs-12">
                                            <div class="user-account-info">
                                                <h3>References</h3>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-xs-12">
                                            <div class="user-account-info">
                                                <h3>Add Reference 1</h3>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                                            <div class="form_box_area">
                                                <label>First Name*</label>
                                                <input type="text" id="ref_1_f_name" name="ref_1_f_name"
                                                    class="form-control inputfiels remove_error required required_fields"
                                                    placeholder="First Name" value="{{ @$tutor_to_ref->ref_1_f_name }}"
                                                    maxlength="255">
                                                <div class="error_ref_1_f_name error"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                                            <div class="form_box_area">
                                                <label>Last Name*</label>
                                                <input type="text" id="ref_1_l_name" name="ref_1_l_name"
                                                    class="form-control inputfiels remove_error required required_fields"
                                                    placeholder="Last Name" value="{{ @$tutor_to_ref->ref_1_l_name }}"
                                                    maxlength="255">
                                                <div class="error_ref_1_l_name error"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                                            <div class="form_box_area">
                                                <label>Email<span
                                                        tooltip="Please ensure details are accurate to avoid delays in processing the application">*<i
                                                            class="qus-cir far fa-question-circle"></i></span></label>
                                                <input type="text" id="ref_1_email" name="ref_1_email"
                                                    class="form-control remove_error inputfiels" placeholder="Email"
                                                    value="{{ @$tutor_to_ref->ref_1_email }}" maxlength="255">
                                                <div class="error_ref_1_email error"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                                            <div class="form_box_area">
                                                <label>Phone<span
                                                        tooltip="Please ensure details are accurate to avoid delays in processing the application">*<i
                                                            class="qus-cir far fa-question-circle"></i></span></label>
                                                <input type="text" minlength="10" maxlength="10" id="ref_1_phone"
                                                    name="ref_1_phone"
                                                    class="form-control inputfiels remove_error required_fields"
                                                    placeholder="Phone" value="{{ @$tutor_to_ref->ref_1_phone }}"
                                                    onkeypress='validate(event)' pattern="\d{10}">
                                                <div class="error_ref_1_phone error"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-6">
                                            <div class="form_box_area">
                                                <label for="ref_1_relation">Relationship</label>
                                                <select name="ref_1_relation"
                                                    class="inputfiels remove_error required_fields" id="ref_1_relation">
                                                    <option value="">Select Relationship</option>
                                                    <option value="1"
                                                        @if (@$tutor_to_ref->ref_1_relation == 1) selected="" @endif>Partner
                                                    </option>
                                                    <option value="2"
                                                        @if (@$tutor_to_ref->ref_1_relation == 2) selected="" @endif>Family
                                                    </option>
                                                    <option value="3"
                                                        @if (@$tutor_to_ref->ref_1_relation == 3) selected="" @endif>Friend
                                                    </option>
                                                    <option value="4"
                                                        @if (@$tutor_to_ref->ref_1_relation == 4) selected="" @endif>Colleague
                                                    </option>
                                                </select>
                                                <div class="error_ref_1_relation error"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-xs-12">
                                            <div class="user-account-info">
                                                <h3>Add Reference 2</h3>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                                            <div class="form_box_area">
                                                <label>First Name*</label>
                                                <input type="text" id="ref_2_f_name" name="ref_2_f_name"
                                                    class="form-control inputfiels remove_error required"
                                                    placeholder="First Name" value="{{ @$tutor_to_ref->ref_2_f_name }}"
                                                    maxlength="255">
                                                <div class="error_ref_1_f_name error"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                                            <div class="form_box_area">
                                                <label>Last Name*</label>
                                                <input type="text" id="ref_2_l_name" name="ref_2_l_name"
                                                    class="form-control inputfiels remove_error required"
                                                    placeholder="Last Name" value="{{ @$tutor_to_ref->ref_2_l_name }}"
                                                    maxlength="255">
                                                <div class="error_ref_2_l_name error"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                                            <div class="form_box_area">
                                                <label>Email<span
                                                        tooltip="Please ensure details are accurate to avoid delays in processing the application">*<i
                                                            class="qus-cir far fa-question-circle"></i></span></label>
                                                <input type="text" id="ref_2_email" name="ref_2_email"
                                                    class="form-control inputfiels remove_error" placeholder="Email"
                                                    value="{{ @$tutor_to_ref->ref_2_email }}" maxlength="255">
                                                <div class="error_ref_2_email error"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                                            <div class="form_box_area">
                                                <label>Phone<span
                                                        tooltip="Please ensure details are accurate to avoid delays in processing the application">*<i
                                                            class="qus-cir far fa-question-circle"></i></span></label>
                                                <input type="text" minlength="10" maxlength="10" id="ref_2_phone"
                                                    name="ref_2_phone" class="form-control inputfiels remove_error"
                                                    placeholder="Phone" value="{{ @$tutor_to_ref->ref_2_phone }}"
                                                    onkeypress='validate(event)' pattern="\d{10}">
                                                <div class="error_ref_2_phone error"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-6">
                                            <div class="form_box_area">
                                                <label for="ref_2_relation">Relationship</label>
                                                <select name="ref_2_relation" class="inputfiels remove_error"
                                                    id="ref_2_relation">
                                                    <option value="">Select Relationship</option>
                                                    <option value="1"
                                                        @if (@$tutor_to_ref->ref_2_relation == 1) selected="" @endif>Partner
                                                    </option>
                                                    <option value="2"
                                                        @if (@$tutor_to_ref->ref_2_relation == 2) selected="" @endif>Family
                                                    </option>
                                                    <option value="3"
                                                        @if (@$tutor_to_ref->ref_2_relation == 3) selected="" @endif>Friend
                                                    </option>
                                                    <option value="4"
                                                        @if (@$tutor_to_ref->ref_2_relation == 4) selected="" @endif>Colleague
                                                    </option>
                                                </select>
                                                <div class="error_ref_2_relation error"></div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="check-box check-box-cu">
                                                <input type="checkbox" class="" id="checkbox1" name="checkbox1"
                                                    value="all" @if (@Auth::user()->draft == 'N') checked="" @endif
                                                    class="inputfiels">
                                                <label for="checkbox1" class="checklabeel">I authorise V-Tutor to
                                                    undertake background,
                                                    reference and other related checks with respective agencies.</label>
                                                <input type="checkbox" class="" id="checkbox2" name="checkbox2"
                                                    value="all" @if (@Auth::user()->draft == 'N') checked="" @endif
                                                    class="inputfiels">
                                                <label for="checkbox2" class="checklabeel">I have read and agree to
                                                    V-Tutor <a href="{{ url('privacy-policy') }}" target="_blank">
                                                        Privacy Policy </a> and <a href="{{ url('terms-conditions') }}"
                                                        target="_blank"> Terms &amp; Conditions </a>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="row">
                                        <div class="clearfix"></div>
                                        <div class="col-12">
                                            <div class="btn_3_cc new_cc_btns">
                                                <input type="hidden" name="draft" value="{{ @Auth::user()->draft }}"
                                                    id="draft">
                                                <input onclick="onCLickApply()"
                                                    @if (@Auth::user()->draft == 'N') type="submit" name="applyvtutor" class="sub_btn2 disable-left readonlyfields" id="applyvtutor"
                                                @else
                                                type="submit" name="applyvtutor" class="sub_btn2 submit-login disable-input" @endif
                                                    value="Apply as V-Tutor ">
                                                @if (@Auth::user()->draft == 'Y')
                                                    <input onclick="onCLickSaveAsDraft()"
                                                        @if (@Auth::user()->draft == 'N') type="submit" name="saveAsDraft" class="sub_btn new-subbtn " id="saveAsDraft"
                                                @else
                                                type="submit" name="saveAsDraft"  class="sub_btn new-subbtn" @endif
                                                        value="Save as Draft">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <hr class="das-hr">
                                            <div class="footdashSec">
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
                    <h4 class="modal-title">Instructions</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body instructionModal">
                    <form action="">
                        <div class="divs">
                            <div class="appome_input form_box_area cls1 ">
                                <label>
                                </label>
                                <div class=" new-cus  b-block">
                                    <ul class="submn">
                                        <li class="">
                                            - Ensure your face is visible clearly and occupies 80% of photo
                                        </li>
                                        <li class="">
                                            - Make sure to smile, look cheerful but do not over do
                                        </li>
                                        <li class="">
                                            - Make sure to wear formal attire and look professional
                                        </li>
                                        <li class="">
                                            - Ensure the picture has a white or a lighter background so face in the
                                            foreground is clearly visible
                                        </li>
                                        <li class="">
                                            - Upload latest or recently taken picture to ensure it matches in video session
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    @include('include.footer')
    <div class="modal res-modal newqusmo" id="newMessage">
        <div class="modal-dialog modal-dialog-centered divPoMW tapDiv">
            <div class="modal-content">
                <div class="dvpro">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">
                            @if (Session::get('success') == 'Your profile is updated')
                                Profile update
                            @else
                                {{ @session('m') }}
                            @endif
                        </h4>
                        <button type="button" class="close" id="popupModalclose" data-dismiss="modal"
                            onclick="modalHidePM1()">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body ">
                        <div class="testPro">
                            <div class="proDiv tutorawaitingDiv">
                                {!! Session::get('success') !!}
                                {{--
                            <h6>Welcome to V-Tutor! We are happy that you would like to join us!</h6>
                            <p>Please fill-in this page and submit to apply as a tutor.</p>
                            <p>You will be contacted over email or phone on next steps.</p>
                            <p>Wishing you all the best!</p>
                            <p class="student_pro_p tutorawaitingp">Regards,</p>
                            <p class="tutoracademiccor">Academics Coordinator.</p>
                            --}}
                            </div>
                        </div>
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
        @if (session()->has('success') || session()->has('error') || $errors->any())

            $('#newMessage').modal('show');
        @endif
    </script>
    <script type="text/javascript">
        function modalHidePM1() {
            $("#newMessage").hide();
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            var owl = $('#fav_ids .owl-carousel');
            if (owl.length > 0) {
                owl.owlCarousel({
                    margin: 0,
                    nav: true,
                    autoplay: false,
                    loop: true,
                    responsive: {
                        0: {
                            items: 1
                        },
                        575: {
                            items: 2
                        },
                        991: {
                            items: 2
                        },
                        1199: {
                            items: 3
                        },
                        1200: {
                            items: 4
                        }
                    }
                });
            }

        });
    </script>
    <script>
        $(document).ready(function() {
            $(document).on("click", ".on_select_u", function() {
                $("#img2").attr('src', $(this).attr("data-src"));
                $("#imgSelect").val($(this).attr("data-picname"));
                $(".uplodimgfilimg").show();
                $(".selectedImage").removeClass("selectedImage");
                $(this).addClass("selectedImage");
            });

            function check() {
                var badWords = [];
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
                wordInput = wordInput.toLowerCase();
                var arr = wordInput.split(" ");
                var foundBadWords = arr.filter(el => badWords.includes(el));

                if (foundBadWords.length > 0) {
                    $(".error_textarea").html(
                        'Kindly refrain from using email, phone or flagged words on the description!');
                    textarea.val("");
                    return false;
                }
                var wordInput = textarea.val();
                wordInput = wordInput.toLowerCase();
                var arr = wordInput.split(" ");

                $.each(arr, function(_, t) {
                    if (/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/.test(t.toLowerCase())) {
                        $(".error_textarea").html(
                            'Kindly refrain from using email, phone or flagged words on the description!'
                            );
                        textarea.val("");
                    }

                    if (/^[+]?\d+$/.test(t.toLowerCase()) && t.length == 10) {
                        $(".error_textarea").html(
                            'Kindly refrain from using email, phone or flagged words on the description!'
                            );
                        textarea.val("");
                    }

                    // if(t.match("\d{10}")){
                    //     $(".error_textarea").html('Kindly refrain from using email, phone or flagged words on the description!');
                    //     textarea.val("");
                    // }
                });

            }

            var textarea = $('.textarea_box');
            textarea.on({
                keyup: function(e) {
                    $(".error_textarea").html('');
                    if (e.which === 188) check();
                    if (e.which === 32) check();
                    // check();
                    var words = 0;
                    if ((this.value.match(/\S+/g)) != null) {
                        words = this.value.match(/\S+/g).length;
                    }
                    if (words > 200) {
                        var trimmed = $(this).val().split(/\s+/, 200).join(" ");
                        $(this).val(trimmed + " ");
                    }
                },
                blur: check
            });

            jQuery.validator.addMethod("mobileonly", function(value, element) {
                return this.optional(element) || /^[+]?\d+$/.test(value.toLowerCase());
            }, "Enter valid number");

            jQuery.validator.addMethod("emailonly", function(value, element) {
                return this.optional(element) || /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/.test(
                    value.toLowerCase());
            }, "Enter a valid email address");


            var isCls = $("#applyvtutor").hasClass("readonlyfields");
            if (isCls) {
                // $(".inputfiels").attr("readonly",true);
                $(".inputfiels").attr("disabled", true);
                $(".inputfiels").addClass('addDisablePhone');
                $(".inputfiels").addClass('pointerEventsNone');
            }
            $('#checkbox1').change(function() {
                var obj = $('#checkbox2');
                var obj1 = $('#checkbox1');

                if ($(this).prop('checked') == true && obj.prop('checked') == true && obj1.prop(
                    'checked') == true) {
                    $('.disable-input').prop("disabled", false);
                    $('.submit-login').removeClass('disable-input');

                } else {
                    $('.submit-login').addClass('disable-input');
                    $('.disable-input').prop("disabled", true);

                }
            });
            $('#checkbox4').change(function() {
                var obj = $('#checkbox2');
                var obj1 = $('#checkbox1');

                if ($(this).prop('checked') == true && obj.prop('checked') == true && obj1.prop(
                    'checked') == true) {
                    $('.disable-input').prop("disabled", false);
                    $('.submit-login').removeClass('disable-input');


                } else {
                    $('.submit-login').addClass('disable-input');
                    $('.disable-input').prop("disabled", true);


                }
            });
            $('#checkbox2').change(function() {
                var obj = $('#checkbox2');
                var obj1 = $('#checkbox1');
                if ($(this).prop('checked') == true && obj.prop('checked') == true && obj1.prop(
                    'checked') == true) {
                    $('.disable-input').prop("disabled", false);
                    $('.submit-login').removeClass('disable-input');

                } else {
                    $('.submit-login').addClass('disable-input');
                    $('.disable-input').prop("disabled", true);


                }
            });
            $(document).on("keyup", ".remove_error", function() {
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
            $(document).on("change", ".remove_error", function() {
                var id = $(this).attr("id");
                $(".error_" + id).html("");
            });
            // update avatar
            // $(document).on("click","#select_profile_pic_btn",function(){
            // var profile_pic_val = $("#imgSelect").val();
            // var profile_pic = $("#imgSelect").attr("data-picname");
            // if(profile_pic_val != ""){
            // uploadAvatar(profile_pic_val);
            // }else{
            // $(".selected_image_error").html("Please select avatar");
            // }
            // });
            function uploadAvatar(profile_pic_val) {
                // var reqData = {
                //     'jsonrpc' : '2.0',
                //     '_token'  : '{{ csrf_token() }}',
                //     'data'    : {
                //     'profile_pic'      : profile_pic_val
                //     }
                // };
                // if(confirm("Are you sure you want to set this avatar as your profile pic?")){
                //     $.ajax({
                //         url:"{{ route('tutor.avatar.update') }}",
                //         dataType: 'json',
                //         data: reqData,
                //         type: 'post',
                //         success:function(resp){
                //             $(".selected_image_error").html(resp.message);

                //         }
                //     });
                // }
            }
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
        $(document).on("change keyup", ".inputfiels", function() {
            $(this).removeClass("error");
        });
    </script>
    <script type="text/javascript">
        // $(".modal").modal('hide');
        // if(confirm("DO you want to discard changes")){
        //     console.log('yes');
        // }else{
        //     console.log('no');
        //     $("#beforeUnloadEvent").modal('show');
        // }
        @if (@Auth::user()->draft == 'Y')
            window.addEventListener("beforeunload", function(e) {

                var confirmationMessage = 'It looks like you have been editing something. ' +
                    'If you leave before saving, your changes will be lost.';

                (e || window.event).returnValue = confirmationMessage; //Gecko + IE

                return true; //Gecko + Webkit, Safari, Chrome etc.
            });
        @endif
        function onCLickSaveAsDraft() {
            $(".required").removeClass("required");
        }

        function onCLickApply() {
            $(".required").addClass("required");

            $('#frm').validate({
                ignore: [],
                rules: {
                    // f_name:{
                    //     required:true,
                    // },
                    // checkbox1:{
                    //     required:true
                    // },
                    // checkbox2:{
                    //     required:true
                    // },

                    // l_name:{
                    //     required:true,
                    // },
                    // timezone_id:{
                    //     required:true,
                    // },
                    // hours:{
                    //     required:true,
                    // },
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
                    ref_1_email: {
                        required: true,
                        email: true,
                        emailonly: true
                    },
                    ref_2_email: {
                        required: true,
                        email: true,
                        emailonly: true
                    },
                    ref_1_phone: {
                        required: true,
                        minlength: 10,
                        maxlength: 10,
                        mobileonly: true
                    },
                    ref_2_phone: {
                        required: true,
                        minlength: 10,
                        maxlength: 10,
                        mobileonly: true
                    },
                    teacher_emp_status: {
                        required: true,
                    },
                    why_tutor: {
                        required: true,
                    },
                    country: {
                        required: true,
                    },
                    state: {
                        required: true,
                    },
                    city: {
                        required: true,
                    },
                    zip: {
                        required: true,
                        number: true,
                        minlength: 4,
                        maxlength: 4
                    },
                    about_me: {
                        required: true,
                        minlength: 10,
                    },
                    'language[]': {
                        required: true,
                    },
                    address: {
                        required: true,
                        minlength: 4,
                    },
                    profile_video: {
                        required: true,
                        minlength: 4,
                    },
                    ref_1_f_name: {
                        required: true
                    },
                    ref_1_l_name: {
                        required: true
                    },
                    ref_2_f_name: {
                        required: true
                    },
                    ref_2_l_name: {
                        required: true
                    }
                },
                messages: {
                    ph: {
                        required: 'Please enter a valid 10 digit mobile number',
                        minlength: 'Mobile number can have minimum 10 digits',
                        maxlength: 'Mobile number can have maximum 10 digits',
                        mobileonly: 'Enter a valid 10 digit mobile number',
                        remote: "This mobile number already exists.!"
                    },
                    ref_1_phone: {
                        minlength: 'Mobile number can have minimum 10 digits',
                        maxlength: 'Mobile number can have maximum 10 digits',
                        mobileonly: 'Enter a valid 10 digit mobile number',
                        required: 'This field is required'
                    },
                    ref_2_phone: {
                        minlength: 'Mobile number can have minimum 10 digits',
                        maxlength: 'Mobile number can have maximum 10 digits',
                        mobileonly: 'Enter a valid 10 digit mobile number',
                        required: 'This field is required'
                    },
                    ref_1_email: {
                        email: 'Please provide valid email-id',
                        required: 'This field is required'
                    },
                },
                submitHandler: function(form) {
                    check();
                    var youtube_link = $('#youtube_link').val();

                    // var checkbox1 = $("#checkbox1").val();
                    // var checkbox2 = $("#checkbox2").val();
                    // $("#checkbox1").addClass("required");
                    // $("#checkbox2").addClass("required");
                    @if (!@Auth::user()->profile_pic && !@Auth::user()->avatar)
                        // var proImgT = $.trim($("#file-1").val());

                        // if(proImgT == ""){
                        //     $(".error_image").html("This field is required!");
                        //     return false;
                        // }
                    @endif
                    if (youtube_link != "") {
                        var _url = $('#youtube_link').val();
                        if (_url.includes("www.youtube.com/watch?") || _url.includes("https://youtu.be/")) {
                            form.submit();
                        } else {
                            $("#youtube_err").html("Please enter valid youtube link");
                            return false;
                        }
                    }
                    var badWords = [];
                    @php
                        $badwords = \DB::table('bad_words')->pluck('words')->toArray();
                    @endphp
                    @foreach (@$badwords as $value)
                        badWords.push('{{ $value }}');
                    @endforeach
                    // console.log(badWords);
                    var wordInput = textarea.val();
                    wordInput = wordInput.toLowerCase();
                    var arr = wordInput.split(" ");
                    var foundBadWords = arr.filter(el => badWords.includes(el));

                    if (foundBadWords.length > 0) {
                        $(".error_textarea").html(
                            'Kindly refrain from using email, phone or flagged words on the description!');
                        textarea.val("");
                        return false;
                    }
                    // email & phone word
                    var flaggedWord = ['email', 'phone'];
                    var wordInput = textarea.val();
                    wordInput = wordInput.toLowerCase();
                    var arr = wordInput.split(" ");
                    var foundFlaggedWords = arr.filter(el => flaggedWord.includes(el));

                    if (foundFlaggedWords.length > 0) {
                        textarea.val("");
                        $(".error_textarea").html(
                            'Kindly refrain from using email, phone or flagged words on the description!');
                        return false;
                    } else {
                        var v = textarea.val();
                        if (v != "") {
                            $(".error_textarea").html('');
                        }
                    }
                    form.submit();
                },
            });
        }
    </script>
@endsection
