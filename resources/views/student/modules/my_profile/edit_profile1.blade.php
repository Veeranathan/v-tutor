@extends('layouts.app')
@section('title')
<title>V-Tutor  | Student | Profile</title>
@endsection
@section('left_part')
{{-- @include('include.student_top_common') --}}
@include('include.header_menu_part')

@endsection
@section('content')
<!-- bannersec -->
<!-- bannersec -->
<div class="top_mar"></div>
<!--- profile --->
<section class="user-account">
    <div class="container">
        <div class="row">
            <div class="zin">
                @include('include.student_left_common')
                <div class="user-right-panel">
                    <div class="user-right-top">
                        <h2 class="profile-heading">Profile <span><img src="{{ public_asset('assets/images/pencil.png')}}"></span></h2>
                        <p>You can find information or edit your profile in this section</p>
                        <br>
                            <a  href="#" style="display:none;" id="messageShow" data-toggle="modal" data-target="#popupModalStudentM1">Message</a>
                            <a  href="#" style="display:none;" id="messageShowUpd" data-toggle="modal" data-target="#popupModal1Upd">Message</a>
                        {{-- @include('include.errors') --}}
                        <form method="post" action="{{route('update.profile')}}" id="frm" enctype="multipart/form-data">
                            @csrf
                            <div class="user-account-info">
                                <h3>Profile Info</h3>
                                <div class="row new_rows no-gutters">

                                        <div class="clearfix"></div>
                                    </div>
                                <div class="row new_rows no-gutters">
                                    <div class="col-md-4 col-sm-6">
                                        <div class="form_box_area">
                                            <label>Student First Name*</label>
                                            <input type="text" placeholder="First Name " name="f_name" value="{{@$user->f_name}}" required="">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6">
                                        <div class="form_box_area">
                                            <label> Student Last Name*</label>
                                            <input type="text" placeholder="Last Name " name="l_name" value="{{@$user->l_name}}" required="">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6">
                                        <div class="form_box_area">
                                            <label>Grade*</label>
                                            @php
                                            $grade=DB::table('grades')->where('status','A')->get();
                                            @endphp
                                            <select required name="grade">
                                                <option value="">Select Grade</option>
                                                @foreach($grade as $val)
                                                <option value="{{$val->id}}" @if(@$user->grade==$val->id) selected @endif >{{@$val->grade_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    {{--
                                    <div class="col-md-5 col-sm-6">
                                        <div class="form_box_area">
                                            <label>School</label>
                                            <input type="text" placeholder="Where you currently study" name="school" value="{{@$user->school}}" >
                                        </div>
                                    </div>
                                     --}}
                                    <div class="col-md-4 col-sm-6">
                                        <div class="form_box_area">
                                            <label>School*</label>
                                            <div class="autocomplete">
                                                <input id="school" class="required" name="school" type="text" placeholder="Type school name" autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');" autocomplete="off" value="@if(@Auth::user()->school){{ @$user->getSchool->school_name }},{{ @$user->getSchool->getState->state_name }},{{ @$user->getSchool->getState->state_name }},{{ @$user->getSchool->getSuburb->name }},{{ @$user->getSchool->postcode }} @endif" >
                                                 <input type="hidden" name="school_id" id="school_id" value="{{ @$user->school }}">
                                                 <input type="hidden" name="school_name" id="school_name" value="{{ @$user->getSchool->school_name }},{{ @$user->getSchool->getState->state_name }},{{ @$user->getSchool->getSuburb->name }},{{ @$user->getSchool->postcode }}">
                                                <input type="hidden" name="state_name"  id="state_name" value="{{ @$user->getSchool->getState->state_name }}">
                                                {{-- <input type="hidden" name="search_tutor_slug_studentclass"  id="search_tutor_slug_studentclass" value="{{ @$vtutor->slug }}"> --}}

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 showSchoolInfo" >
                                        <div class="form_box_area">
                                            <label>School state*</label>
                                                {{-- <input type="text"  value="{{ @$user->getSchool->getState->state_name }}" readonly=""> --}}
                                                <select name="show_school_state" id="show_school_state" disabled=""  class="showhiderSchl">
                                                    <option value="" @if(@$user->getSchool->state_id==0) selected  @endif>Select State</option>
                                                    @if(@$state)
                                                    @foreach($state as $key=> $val)
                                                    <option value="{{@$val->id}}" @if(@$user->getSchool->state_id==@$val->id) selected  @endif>{{@$val->state_name}}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 showSchoolInfo" >
                                        <div class="form_box_area">
                                            <label>School suburb*</label>
                                            <input type="text" id="show_school_suburb" name="show_school_suburb"  value="{{ @$user->getSchool->getSuburb->name }}" readonly="" class="showhiderSchl">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 showSchoolInfo" >
                                        <div class="form_box_area">
                                            <label>School postcode*</label>
                                            <input type="text" id="show_school_postcode" name="show_school_postcode"  value="{{ @$user->getSchool->postcode }}" readonly="" class="showhiderSchl">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 otherschoolnamediv" style="display: none;">
                                        <div class="form_box_area">
                                            <label>Other school name*</label>
                                            <div class="autocomplete">
                                                 <input type="text" name="other_school_name" id="other_school_name" value="" class="showhiderSchl">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-4 col-sm-6">
                                        <div class="form_box_area">
                                            <label>Date of birth*</label>
                                            <!--<div class="dash-d">
                                                <input type="text" placeholder="Select Date" id="datepicker"required="">



                                                <span class="over_llp1"><img src="{{ public_asset('assets/images/cal.png')}}" alt=""></span>



                                                </div>-->
                                            <div class="ui calendar" id="exampledate">
                                                <div class="ui input left icon">
                                                    <input type="text" readonly="" placeholder="Select date"  required="" name="dob" value="{{@$user->dob}}" autocomplete="off">
                                                    <span class="over_llp1"><img src="{{ public_asset('assets/images/cal.png')}}" alt=""></span>
                                                </div>
                                                <label id="dob-error" class="error" for="dob"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-sm-6">
                                        <div class="form_box_area">
                                            <label>Gender*</label>
                                            <select name="gender" id="gender">
                                                <option value="">Select Gender</option>
                                                <option value="M"  @if(@$user->gender=="M") selected @endif>Male</option>
                                                <option value="F"  @if(@$user->gender=="F") selected @endif>Female</option>
                                                <option value="O"  @if(@$user->gender=="O") selected @endif>Neither</option>
                                                <option value="P"  @if(@$user->gender=="P") selected @endif>Prefer not to say</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6" >
                                        <div class="checkBox new-cus">
                                            <span>Are you a full-time student?</span>
                                            <ul style="margin-left: 10px">
                                                <li class="one_li_check">
                                                    <input type="radio" id="radio1" name="full_time_student" value="Y" @if(@$user->is_full_time=="Y") checked @endif>
                                                    <label for="radio1" onclick="yes()">Yes</label>
                                                </li>
                                                <li>
                                                    <input type="radio" id="radio2" name="full_time_student" value="N"  @if(@$user->is_full_time=="N") checked @endif>
                                                    <label for="radio2"  onclick="no()">No</label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form_box_area">
                                            <label>About the Student</label>
                                            <textarea placeholder="Write briefly on what they like, interests, hobbies etc. in about 200 words" name="about_me"  id="about_me" class="textarea_box">{{@$user->about_me}}</textarea>
                                            <div class="error_textarea error"></div>
                                            <span id="about_err" style="color: red"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="uplodimg text_sm_c" >
                                            <div class="uplodimgfil">
                                                {{-- <b>Profile Picture</b> --}}
                                                @php
                                                    $image_path = "assets/images/all_avatars/".@Auth::user()->profile_pic;
                                                @endphp
                                                @if(file_exists(@$image_path))
                                                    <input type="hidden" name="imgSelect" id="imgSelect" value="{{ @Auth::user()->profile_pic }}">
                                                @else
                                                <input type="hidden" name="imgSelect" id="imgSelect" value="">
                                                @endif

                                            </div>
                                            {{-- @if(@Auth::user()->profile_pic)
                                                <div class="uplodimgfilimg review_img" style="display: block;">
                                                    <em><img src="{{public_asset('assets/images/all_avatars/'.@Auth::user()->profile_pic)}}" alt="" id="img2"></em>
                                                </div>
                                            @else
                                                @if(@Auth::user()->avatar)
                                                    <div class="uplodimgfilimg review_img" style="display: block;">
                                                        <em><img src="{{@Auth::user()->avatar}}" alt="" id="img2"></em>
                                                    </div>
                                                @else
                                                    <div class="uplodimgfilimg review_img">
                                                        <em><img src="" alt="" id="img2"></em>
                                                    </div>
                                                @endif
                                            @endif   --}}
                                        </div>
                                        <div class="user-right-top-new ">
                                            <div class="account-area-tutor mt-0">
                                                <div class="fav_id" id="fav_ids">
                                                    <div class="owl-carousel">
                                                        @if(@Auth::user()->profile_pic)
                                                        @php
                                                        $image_path = 'assets/images/all_avatars/'.@Auth::user()->profile_pic;
                                                        @endphp
                                                        @if(file_exists(@$image_path))
                                                        <div class="item on_select_u  selectedImage " data-picname="{{ @Auth::user()->profile_pic }}" data-src="{{ public_asset('assets/images/all_avatars/'.@Auth::user()->profile_pic) }}">
                                                            <div class="meet_tutors_items">
                                                                <div class="meet_tutors_img">
                                                                    <span>
                                                                        <img class="on_select_u_pic" src="{{ public_asset('assets/images/all_avatars/'.@Auth::user()->profile_pic) }}" alt="" data-picname="{{ @Auth::user()->profile_pic }}">
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        @endif
                                                        @for($i=1;$i<=43;$i++)
                                                        @php
                                                        $image_path = 'assets/images/all_avatars/avatar'.$i.'.png';
                                                        @endphp
                                                        @if(file_exists(@$image_path))
                                                        @if(@Auth::user()->profile_pic !='avatar'.$i.'.png')
                                                        <div class="item on_select_u @if(@Auth::user()->profile_pic =='avatar'.$i.'.png') selectedImage @endif" data-picname="avatar{{$i}}.png" data-src="{{ public_asset('assets/images/all_avatars/avatar'.$i.'.png') }}">
                                                            <div class="meet_tutors_items">
                                                                <div class="meet_tutors_img">
                                                                    <span>
                                                                    <img class="on_select_u_pic" src="{{ public_asset('assets/images/all_avatars/avatar'.$i.'.png') }}" alt="" data-picname="avatar{{$i}}.png">
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        @endif
                                                        @endfor
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="select_profile_pic">
                                            <input type="button" name="" value="Set my pic" class="sub_btn select_profile_pic_btn sub_btn new-subbtn" id="select_profile_pic_btn">
                                        </div>
                                        <p class="note error_image selected_image_error"></p>
                                    </div>
                                    <div class="col-md-8 col-sm-6 new-diif"  @if($user->is_full_time=="Y") style="display: none !important;" @endif >
                                    <div class="checkBox new-cus" id="private_or_homee" @if($user->is_full_time=="Y") style="display: none !important;" @endif > <span>Do you private school or home school?</span>
                                    <ul>
                                        <li class="one_li_check">
                                            <input type="radio" id="radio3" name="private_or_home" value="Y"  @if(@$user->private_or_home=="Y") checked @endif>
                                            <label for="radio3">Yes</label>
                                        </li>
                                        <li>
                                            <input type="radio" id="radio4" name="private_or_home" value="N"   @if(@$user->private_or_home=="Y") checked @endif>
                                            <label for="radio4">No</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="user-account-info">
                <h3>Parent Details</h3>

                <div class="row new_rows no-gutters">
                    {{-- <div class="col-md-4 col-sm-6">
                        <div class="form_box_area">
                            <label for="close_my_account">Close My account</label>
                            <a href="{{ route('student.close.account') }}" class="pg_btn">Close my account</a>
                        </div>
                    </div> --}}
                <div class="col-md-4 col-sm-6">
                <div class="form_box_area">
                <label for="salutation">Salutation*</label>
                <select class="required " name="salutation" id="salutation">
                <option value="">Select Salutation</option>
                <option value="1" @if(@$user->salutation == '1')  selected=""  @endif>Mr.</option>
                <option value="2" @if(@$user->salutation == '2')  selected=""  @endif>Mrs.</option>
                <option value="3" @if(@$user->salutation == '3')  selected=""  @endif>Ms.</option>
                <option value="4" @if(@$user->salutation == '4')  selected=""  @endif>Dr.</option>
                </select>
                </div>
                </div>
                <div class="col-md-4 col-sm-6">
                <div class="form_box_area">
                <label>Parent First Name*</label>
                <input type="text" placeholder="First Name" name="parent_f_name" value="{{@$user->parent_f_name}}" required=""> </div>
                </div>
                <div class="col-md-4 col-sm-6">
                <div class="form_box_area">
                <label>Parent Last Name*</label>
                <input type="text" placeholder="Last Name" name="parent_l_name" value="{{@$user->parent_l_name}}" required=""> </div>
                </div>
                <div class="col-md-4 col-sm-6">
                <div class="form_box_area">
                <label>Email Address<span tooltip="To modify, you may email backend support at 'studentsupport@v-tutor.com.au">*<i class="qus-cir far fa-question-circle"></i></span></label>
                <input type="email" placeholder="myemailaddress@xyz.com" name="email" value="{{@$user->email}}" disabled class="addDisablePhone PointerEventsNone"> </div>
                </div>
                <div class="col-md-3 col-sm-6">
                <div class="form_box_area">
                <label>Mobile Number <span tooltip="To modify, you may email backend support at 'studentsupport@v-tutor.com.au">*<i class="qus-cir far fa-question-circle"></i></span></label>
                <input type="tel" placeholder="0123456789" name="ph" value="{{@$user->phone}}"  id="ph" readonly="" class="addDisablePhone PointerEventsNone"> </div>
                </div>
                <div class="col-md-4 col-sm-6">
                <div class="form_box_area">
                <label>Annual household income <span tooltip="This is an optional choice used demographic analysis only. It is not shared with any third party and will not make a difference to services offered in the platform"><i class="qus-cir far fa-question-circle"></i></span></label>
                <select name="income">
                <option value="A"  @if(@$user->annual_income=="A") selected @endif >< 100,000</option>
                <option value="B"  @if(@$user->annual_income=="B") selected @endif >100,000 – 150,000</option>
                <option value="C"  @if(@$user->annual_income=="C") selected @endif >150,000 –200,000</option>
                <option value="D"  @if(@$user->annual_income=="D") selected @endif > 200,000 ></option>
                <option value="P"  @if(@$user->annual_income=="P") selected @endif>Prefer not to say</option>
                </select>
                </div>
                </div>
                <div class="col-md-4 col-sm-6">
                <div class="form_box_area">
                <label for="qualification">Qualification*</label>
                <select class="required " name="qualification" id="qualification">
                <option value="">Select Qualification</option>
                <option value="1" @if(@$user->qualification == "1") selected="" @endif>Doctoral Degree</option>
                <option value="2" @if(@$user->qualification == "2") selected="" @endif>Postgraduate</option>
                <option value="3" @if(@$user->qualification == "3") selected="" @endif>Master's Degree (Research)</option>
                <option value="4" @if(@$user->qualification == "4") selected="" @endif>Master's Degree</option>
                <option value="5" @if(@$user->qualification == "5") selected="" @endif>Bachelor Honours Degree</option>
                <option value="6" @if(@$user->qualification == "6") selected="" @endif>Bachelor’s Degree</option>
                <option value="7" @if(@$user->qualification == "7") selected="" @endif>Associate Degree</option>
                <option value="8" @if(@$user->qualification == "8") selected="" @endif>Advanced Diploma</option>
                <option value="9" @if(@$user->qualification == "9") selected="" @endif>Diploma</option>
                </select>
                </div>
                </div>

                <div class="col-12">
                                        <h3>Residential Address</h3>
                                        </div>

                                        <div class="col-md-4 col-sm-6">
                                            <div class="form_box_area">
                                                <label>Country*</label>
                                                <select name="country">
                                                    <option value="1">Australia</option>
                                                </select>
                                            </div>
                                        </div>
                                        {{--  --}}
                                        <div class="col-md-4 col-sm-6">
                                            <div class="form_box_area">
                                                <label>State / Province / Region*</label>
                                                <select name="state">
                                                    @foreach($state as $key=> $val)
                                                    <option value="{{@$val->id}}" @if(@Auth::user()->state==$val->id) selected  @endif  >{{$val->state_name}}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-sm-6">
                                            <div class="form_box_area">
                                                <label for="city">City* </label>
                                                <input type="text" placeholder="Sydney" name="city" id="city" value="{{@Auth::user()->city}}" >
                                                <div class="error_city"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="form_box_area">
                                                <label for="address">Unit & Street Address *</label>
                                                <input type="text" placeholder="123, Sample St" name="address" id="address" value="{{@Auth::user()->address}}" >
                                                <div class="error_address"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="form_box_area">
                                                <label for="zip">Zip / Postal Code *</label>
                                                <input type="text" minlength="4" maxlength="4" pattern="\d{4}"  placeholder="1234" name="zip" id="zip" value="{{@Auth::user()->zip}}" onkeypress='validate(event)'>
                                                <div class="error_zip"></div>
                                            </div>
                                        </div>
                                        {{-- <div class="col-md-4 col-sm-6">
                                            <div class="form_box_area">
                                                <label>Timezone<span tooltip="Please choose carefully as this would impact booking of classes">*<i class="qus-cir far fa-question-circle"></i></span></label>
                                                <select name="timezone_id" class="required" id="timezone_id">
                                                    <option value="">Select timezone</option>
                                                    @if(@$timezonesLists)
                                                    @foreach(@$timezonesLists as $t)
                                                    <option value="{{ @$t->id }}" @if(@$t->id==@Auth::user()->timezone_id) selected  @endif >{{ @$t->time_zone_abbreviation }} {{ @$t->time_zone_name }}({{ @$t->utc_offset }})</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div> --}}
                                        <div class="col-md-4 col-sm-6">
                                            <div class="form_box_area">
                                                <label>Timezone<span tooltip="Please choose carefully as this would impact booking of classes">*<i class="qus-cir far fa-question-circle"></i></span></label>
                                                <select name="timezone_id" class="required" id="timezone_id">
                                                    <option value="">Select timezone</option>
                                                    @if(@$timezonesLists)
                                                    @foreach(@$timezonesLists as $t)
                                                    <option value="{{ @$t->id }}" @if(@$t->id==@Auth::user()->timezone_id) selected  @endif >{{ @$t->time_zone_abbreviation }},{{ @$t->time_zone_name }},{{ @$t->city }}({{ @$t->utc_offset }})</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                                <p class="note">Note: Please choose carefully as this would impact booking of classes!</p>
                                            </div>
                                        </div>
                                        {{-- <div class="col-md-4 col-sm-6">
                                            <div class="form_box_area">
                                                <label>subrurb<span tooltip="Please choose carefully as this would impact booking of classes">*<i class="qus-cir far fa-question-circle"></i></span></label>
                                                <select>
                                                    <option value="">Select subrurb</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="form_box_area">
                                                <label>State<span tooltip="Please choose carefully as this would impact booking of classes">*<i class="qus-cir far fa-question-circle"></i></span></label>
                                                <select>
                                                    <option value="">Select State</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="form_box_area">
                                                <label>Postcode<span tooltip="Please choose carefully as this would impact booking of classes">*<i class="qus-cir far fa-question-circle"></i></span></label>
                                                <select>
                                                    <option value="">Select postcode</option>

                                                </select>
                                            </div>
                                        </div> --}}
                                    </div>
                                    <div class="btn_3_cc">
                                        <input type="submit" name="" value="Save & Update"  class="sub_btn new-subbtn">
                                        {{-- {{ route('student.close.account') }} --}}
                                        <a @if(@Auth::user()->platform_type != NULL) href="{{ route('student.close.account') }}" onclick="return confirm('We find that you have decided to close the account and we are sorry to see you go! We may need your account password to validate closure! If you have any issues / concerns that you would like to share, kindly use the Complaints link . Please be aware that this process is irreversible. Any data on this account will be retained as per our privacy policy and purged after a certain time')" @else href="#" data-toggle="modal" data-target="#myModalnes" @endif    class="pg_btn sub_btn new-subbtn" >Close my account</a>
                                    </div>
                                    {{-- <div class="col-md-12 col-sm-12">
                                        <hr class="das-hr">
                                        <div class="footdashSec">
                                            <input type="submit" name="" value="Save & Update" class="sub_btn">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6">
                                    <div class="form_box_area">

                                        <a href="{{ route('student.close.account') }}"   class="pg_btn">Close my account</a>
                                    </div> --}}
                    </div>
                                </div>
                </div>

                </form>
            </div>
        </div>
    </div>
    </div>

</section>
<div class="modal res-modal newqusmo" id="myModalnes">
     <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Warning</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body ">
            <div class="">
                <div class=" " id="warningTextDi">
                    <p>We find that you have decided to close the account and we are sorry to see you go! We may need your account password to validate closure! If you have any issues / concerns that you would like to share, kindly use the Complaints link . Please be aware that this process is irreversible. Any data on this account will be retained as per our privacy policy and purged after a certain time.
                    </p>
                    <div class="next-btn1 newst_btn-pop">
                        <button type="button" class="btn btn-new btn-danger float-left" data-dismiss="modal">No, Don't Close </button>
                        <button type="button" class="btn btn-new btn-danger change-new-link"  id="nextValueShow">Yes, Please Close</button>
                        <div class="clearfix"></div>
                    </div>
                </div>
               <div class="appome_input form_box_area cls2 " id="passwordForm" style="display:none;">
                    <form action="{{route('student.close.account')}}" id="checkPassword" method="post">
                        @csrf
                       <span class="form_box_area mt-2" id="abcd">
                            <label>Password </label>
                            <span class="autocomplete">
                                <input id="mypassword" type="password" name="mypassword" placeholder="Password" autocomplete="off" required="" class="required">
                            </span>
                        </span>
                        <div class="next-btn1 newst_btn-pop">
                            <button type="submit" class="btn btn-new btn-danger change-new-link">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
      </div>
    </div>
</div>
@endsection
@section('footer')
@include('include.footer')
<div class="modal res-modal newqusmo" id="showModalPicShow">
     <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Message</h4>
              <button type="button" class="close" id="popupModalcloseSh" data-dismiss="modal" onclick="modalHideSh()">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body ">

                <div class="divs">

                    <label>Your profile pic is now set. </label>

                    <div class="next-btn1">
                        {{-- <button type="button" class="btn btn-new btn-danger" data-dismiss="modal" id="next">Next</button> --}}
                    </div>
                </div>
            </div>

      </div>
    </div>
</div>
</div>
{{-- feedback 21-12-2021 --}}
<div class="modal res-modal newqusmo" id="popupModalStudentM1">
     <div class="modal-dialog modal-dialog-centered divPoMW">
      <div class="modal-content">
        <div class="dvpro">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Message</h4>
          <button type="button" class="close" id="popupModalcloseM1" data-dismiss="modal" onclick="modalHideM1()">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body ">

            <div class="testPro">

                <div class="proDiv">
                    <h6>Welcome to V-Tutor! Congrats on your first login!</h6>
                    <p>Please fill in your profile details to access other session. </p>
                    <p>Wishing you all the best! </p>
                    <p class="student_pro_p">Regards,</p>
                    <p>Academics Coordinator.</p>
                </div>
            </div>
        </div>
        </div>
      </div>
    </div>
</div>
</div>
{{-- when update --}}
<div class="modal res-modal newqusmo" id="popupModal1Upd">
    <div class="modal-dialog modal-dialog-centered divPoMW">
        <div class="modal-content">
            <div class="dvpro">
                <!-- Modal Header -->
                <div class="modal-header">
                  <h4 class="modal-title">Message</h4>
                  <button type="button" class="close" id="popupModalclose1Upd" data-dismiss="modal" onclick="modalHide1Upd()">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body ">

                    <div class="testPro">

                        <div class="proDiv">
                            {{-- <h6>Welcome to V-Tutor! Congrats on your login!</h6>  --}}
                                    @php
                                    $myGrade = \App\Models\Grade::where(['id'=>@Auth::user()->grade,'status'=>'A'])->select('id','slug','status')->first();
                                    $myState = \App\Models\State::where(['id'=>@Auth::user()->state])->first();
                                    @endphp
                            <p>Congrats! Now that you have filled your profile, you may go ahead and explore other sections! </p>
                            <p>To start with click on <a href="{{ url('tutor-search-result?grade='.@$myGrade->slug) }}" class="red_link">'Book a Session'</a> to display results of tutors matching your grade. </p>
                            <p>You may filter the search to suit your requirements. But remember, you can book tutors only from your own State at the moment.</p>
                            <p>And don't forget to fill out assessments to share your feedback after each section. You may also reach out to us via Support --> Message Us section.
                            </p>
                            <p>We are happy that you are onboard and wishing you all the best!</p>

                            <p class="student_pro_p">Regards,</p>
                            <p>Academics Coordinator.</p>
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
<script >
    function modalHideSh(){
        $("#showModalPicShow").hide();
    }
    $('#exampledate').calendar({



    type: 'date',



    maxDate:new Date({{strtotime(date('Y-m-d H:i:s'))}}*1000),



    });



</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js" integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg==" crossorigin="anonymous"></script>
<script type="text/javascript">
    $(document).ready(function(){
        // $("#nextValueShow").click(function(){
        //     $("#passwordForm").show();
        //     $("#warningTextDi").hide();
        // });
        var owl = $('#fav_ids .owl-carousel');
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

  })


</script>
<script>
    $(document).ready(function(){
        @if(@Auth::user()->is_login == '0' || @session('is_first')==0)
            $("#messageShow").trigger("click");
            // $("#popupModalStudentM1").show();
        @else
        @if(session()->has('success') || session()->has('error') || $errors->any())
            @if(@Auth::user()->grade != 0)
            $("#messageShowUpd").trigger("click");
            // $("#popupModal1Upd").show();
            @endif
        @endif
        @endif



        jQuery.validator.addMethod("emailonly", function(value, element) {
            return this.optional(element) || /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/.test(value.toLowerCase());
        }, "Enter valid email");
        jQuery.validator.addMethod("mobileonly", function(value, element) {
            return this.optional(element) ||  /^[+]?\d+$/.test(value.toLowerCase());
        }, "Enter valid number");

        // select avatar
        // $(document).on("click","#myProfileCloseSubmitBtn",function(){
        $(document).on("click",".on_select_u",function(){
            $(".selectedImage").removeClass("selectedImage");
            $("#img2").attr('src',$(this).attr("data-src"));
            $("#imgSelect").val($(this).attr("data-picname"));
            $(".selectedImage").removeClass("selectedImage");
            $(this).addClass("selectedImage");
        });

        // update avatar
        $(document).on("click","#select_profile_pic_btn",function(){
            var profile_pic_val = $("#imgSelect").val();
            // var profile_pic = $("#imgSelect").attr("data-picname");
            if(profile_pic_val != ""){
                uploadAvatar(profile_pic_val);

            }else{
                $(".selected_image_error").html("Please select avatar");
            }
        });

        function uploadAvatar(profile_pic_val){
            var reqData = {
                'jsonrpc' : '2.0',
                '_token'  : '{{csrf_token()}}',
                'data'    : {
                'profile_pic'      : profile_pic_val
                }
            };
            if(confirm("Are you sure you want to set this avatar as your profile pic?")){
                $.ajax({
                    url:"{{ route('student.avatar.update') }}",
                    dataType: 'json',
                    data: reqData,
                    type: 'post',
                    success:function(resp){
                        if(resp.s == 1){
                            var imgP = "{{ url('/assets/images/all_avatars') }}/"+profile_pic_val;
                            $(".selected_avatar_upd").attr("src",imgP);
                            $("#showModalPicShow").show();
                        }
                        // $(".selected_image_error").html(resp.message);

                        // location.reload();
                    }
                });
            }
        }
        $('#frm').validate({
            rules:{
                f_name:{
                    required:true,
                    minlength:3,
                },
                l_name:{
                    required:true,
                    minlength:3,
                },
                grade:{
                    required:true,
                },
                suburb:{
                    required:true,
                },
                city:{
                    required:true,
                },
                state:{
                    required:true,
                },
                address:{
                    required:true,
                },
                zip:{
                    required:true,
                    number:true,
                    minlength:4,
                    maxlength:4
                },
                show_school_postcode:{
                    number:true,
                    minlength:4,
                    maxlength:4
                },
                email:{
                    required:true,
                    emailonly: true,
                    remote: {
                      url:  '{{route('check.email')}}',
                      type: "get",
                      data: {
                        email: function() {
                          return $( "#email" ).val();
                        }
                      }



                    }



                },



                ph:{



                     required:true,



                     mobileonly:true,



                     minlength:10,



                     maxlength:10,



                     remote: {



                  url:  '{{route('check.mobile.two')}}',



                  type: "get",



                  data: {



                    ph: function() {



                      return $( "#ph" ).val();



                    }



                  }



                }



                },



                 dob:{



                    required:true,







                },



                //  school:{



                //     required:true,



                //     minlength:5,







                // },



                gender:{



                    required:true,







                },



                 full_time_student:{



                    required:true,







                },







                parent_f_name:{



                    required:true,



                    minlength:3,



                },



                  parent_l_name:{



                    required:true,



                    minlength:3,







                },



                //  income:{



                //     required:true,







                // },



            },



            messages:{



                ph:{



                    required:'Please a valid 10 digit mobile number',



                    minlength:'Mobile number can have minimum 10 digits',



                    maxlength:'Mobile number can have maximum 10 digits',



                    mobileonly:'Enter a valid 10 digit mobile number',



                    remote:"This mobile number already exists.!",



                },



                email:{



                    remote:'Email address is in use. Login or use a different one'



                }



            },



            submitHandler: function(form){
                var badWords = [];
                @php
                $badwords = \DB::table('bad_words')->pluck('words')->toArray();
                @endphp
                @foreach(@$badwords as $value)
                    badWords.push('{{$value}}');
                @endforeach
                // console.log(badWords);
                var wordInput = textarea.val();
                wordInput = wordInput.toLowerCase();
                var arr = wordInput.split(" ");
                var foundBadWords = arr.filter(el => badWords.includes(el));

                if(foundBadWords.length>0){
                    $(".error_textarea").html('Kindly refrain from using email, phone or flagged words on the description!');
                    textarea.val("");
                    return false;

                }

                // email & phone word
                var flaggedWord = ['email','phone'];
                var wordInput = textarea.val();
                wordInput = wordInput.toLowerCase();
                var arr = wordInput.split(" ");
                var foundFlaggedWords = arr.filter(el => flaggedWord.includes(el));

                if(foundFlaggedWords.length>0){
                    textarea.val("");
                    $(".error_textarea").html('Kindly refrain from using email, phone or flagged words on the description!');
                    return false;
                }else{
                    var v = textarea.val();
                    if(v != ""){
                        $(".error_textarea").html('');
                    }

                }


                    var textareas = $('#about_me').val();
                    var words = $.trim(textareas).length ? textareas.match(/\S+/g).length : 0;
                    if(words==0) {
                         form.submit();
                    }
                    else if( words>200 ){
                        $("#about_err").html('Please enter maximum 200 words');
                        return false;
                    }
                    else{
                        form.submit();
                    }
                },



        });

        $('#gradeform').on('keyup keypress keydown', function(e) {
      var keyCode = e.keyCode || e.which;
      if (keyCode === 13) {
        e.preventDefault();
        return false;
      }
    });
    // $("#myProfileCloseSubmitBtn").click(function(){


    // });

    $(document).on("keyup","#school",function(){
        if($.trim($(this).val()) == ""){
            $(".otherschoolnamediv").hide();
            $("#other_school_name").removeClass("required");
            $("#show_school_state").val("");
            $("#show_school_postcode").val("");
            $("#show_school_suburb").val("");
            $(".showhiderSchl").attr("disabled",true);
            $(".showhiderSchl").attr("readonly",true);
            $(".showhiderSchl").removeClass("required");
        }
        // var school = $.trim($("#school").val());
        // if(school_id == 0){
        //     $(".otherschoolnamediv").show();
        // }else{
        //     $(".otherschoolnamediv").hide();
        // }

    });
    $(document).on("blur","#school",function(){
        if($.trim($("#school_name").val()) != $.trim($(this).val())){
            $(this).val("");
        }
        var school = $.trim($("#school").val());
        var school_id = $.trim($("#school_id").val());

        if(school_id == 0){
            $(".otherschoolnamediv").show();
            $("#other_school_name").addClass("required");
            $("#show_school_state").val("");
            $("#show_school_postcode").val("");
            $("#show_school_suburb").val("");
            $(".showhiderSchl").attr("disabled",false);
            $(".showhiderSchl").attr("readonly",false);
            $(".showhiderSchl").addClass("required");

        }else{
            $(".otherschoolnamediv").hide();
            $("#other_school_name").removeClass("required");
            $(".showhiderSchl").attr("disabled",true);
            $(".showhiderSchl").attr("readonly",true);
            $(".showhiderSchl").removeClass("required");

        }
    });
    // $(document).on("change","#school",function(){
    //     var school_id = $.trim($("#school_id").val());
    //     var school = $.trim($("#school").val());
    //     if(school_id == 0){
    //         $(".otherschoolnamediv").show();
    //     }else{
    //         $(".otherschoolnamediv").hide();
    //     }
    // });


    });



</script>
<script>
    function yes(){



        //$(".new-diif").slideDown();();



        $("#private_or_homee").hide(3);



     //alert('k');



    }







    function no(){



        $("#private_or_homee").show();



     //alert('k2');



    }



    function fun(){



        var i=document.getElementById('file-1').files[0];



        console.log(i);



        var b=URL.createObjectURL(i);



        $(".review_img").show();



        $("#img2").attr("src",b);



    }







</script>
<script type="text/javascript">
    function check() {
        // $(".error_textarea").html('');
        var badWords = [];
        @php
        $badwords = \DB::table('bad_words')->pluck('words')->toArray();
        @endphp
        @foreach(@$badwords as $value)
            badWords.push('{{$value}}');
        @endforeach
        // console.log(badWords);
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

        if(foundBadWords.length>0){
            $(".error_textarea").html('Kindly refrain from using email, phone or flagged words on the description!');
            textarea.val("");
            return false;
        }
        var wordInput = textarea.val();
        wordInput = wordInput.toLowerCase();
        var arr = wordInput.split(" ");

        $.each(arr, function(_,t) {
            if(/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/.test(t.toLowerCase())){
                $(".error_textarea").html('Kindly refrain from using email, phone or flagged words on the description!');
                textarea.val("");
            }

            if(/^[+]?\d+$/.test(t.toLowerCase()) && t.length == 10){
                $(".error_textarea").html('Kindly refrain from using email, phone or flagged words on the description!');
                textarea.val("");
            }

            // if(t.match("\d{10}")){
            //     $(".error_textarea").html('Kindly refrain from using email, phone or flagged words on the description!');
            //     textarea.val("");
            // }
        });
        // var wordInput = textarea.val();
        // wordInput = wordInput.toLowerCase();
        // var arr = wordInput.split(" ");
        // var foundBadWords = arr.filter(el => badWords.includes(el));

        // if(foundBadWords.length>0){
        //     $(".error_textarea").html('Kindly refrain from using email, phone or flagged words on the description!');
        //     textarea.val("");

        // }

        // email & phone word
        // var flaggedWord = ['email','phone'];
        // var wordInput = textarea.val();
        // wordInput = wordInput.toLowerCase();
        // var arr = wordInput.split(" ");
        // var foundFlaggedWords = arr.filter(el => flaggedWord.includes(el));

        // if(foundFlaggedWords.length>0){
        //     textarea.val("");
        //     $(".error_textarea").html('Kindly refrain from using email, phone or flagged words on the description!');
        // }else{
        //     var v = textarea.val();
        //     if(v != ""){
        //         $(".error_textarea").html('');
        //     }

        // }

    }
    var textarea = $('.textarea_box');
    textarea.on({
        keyup: function(e) {

            if (e.which === 188) check();
            if (e.which === 32) check();

            var words = 0;
                if((this.value.match(/\S+/g)) != null) {
                    words = this.value.match(/\S+/g).length;
                }
                if(words > 100){
                    var trimmed = $(this).val().split(/\s+/, 100).join(" ");
                    $(this).val(trimmed + " ");
                }
        },
        blur: check
    });
    $("#checkPassword").validate();
    $("#checkPro").click(function(){
        if(confirm('We find that you have decided to close the account and we are sorry to see you go! We may need your account password to validate closure! If you have any issues / concerns that you would like to share, kindly use the Complaints link . Please be aware that this process is irreversible. Any data on this account will be retained as per our privacy policy and purged after a certain time')){
            $("#checkPassword").submit();
        }
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
        if( !regex.test(key) ) {
            theEvent.returnValue = false;
            if(theEvent.preventDefault) theEvent.preventDefault();
        }
    }
</script>
<script type="text/javascript">
    function datastudentautocomplete(inp, arr) {

    /*the autocomplete function takes two arguments,

    the text field element and an array of possible autocompleted values:*/

    var currentFocus;

    /*execute a function when someone writes in the text field:*/

    inp.addEventListener("input", function(e) {

        var a, b, i, val = this.value;

        /*close any already open lists of autocompleted values*/

        closeaAllLists();

        if (!val) { return false;}

        currentFocus = -1;

        /*create a DIV element that will contain the items (values):*/

        a = document.createElement("DIV");

        a.setAttribute("id", this.id + "autocomplete-list");

        a.setAttribute("class", "autocomplete-items");

        /*append the DIV element as a child of the autocomplete container:*/

        this.parentNode.appendChild(a);

        $.ajax({

          url:"{{ route('get.all.schools') }}",

          dataType: 'json',

          data: {
            "search_school_name":val
          },

          type: 'GET',

          success:function(resp){

              /*for each item in the array...*/



                for (i = 0; i < resp.schools.length; i++) {

                    /*check if the item starts with the same letters as the text field value:*/

                    if ((resp.schools[i].school_name+" , "+resp.schools[i].get_state.state_name+" , "+resp.schools[i].get_suburb.name+","+resp.schools[i].postcode).substr(0, val.length).toUpperCase() == val.toUpperCase()) {

                        /*create a DIV element for each matching element:*/

                        b = document.createElement("DIV");

                        /*make the matching letters bold:*/

                        b.innerHTML = "<strong>" + (resp.schools[i].school_name +","+resp.schools[i].get_state.state_name+" , "+resp.schools[i].get_suburb.name+","+resp.schools[i].postcode).substr(0, val.length) + "</strong>";

                        b.innerHTML += (resp.schools[i].school_name+","+resp.schools[i].get_state.state_name+" , "+resp.schools[i].get_suburb.name+","+resp.schools[i].postcode).substr(val.length);

                        /*insert a input field that will hold the current array item's value:*/

                        b.innerHTML += "<input type='hidden' data-sid='"+resp.schools[i].id+"' id='"+resp.schools[i].id+"' value='" + resp.schools[i].school_name    +' '+resp.schools[i].get_state.state_name+' '+resp.schools[i].get_suburb.name+' '+resp.schools[i].postcode+ "' data-state_name='"+resp.schools[i].get_state.state_name+"' data-postcode='"+resp.schools[i].postcode+"' data-suburb='"+resp.schools[i].get_suburb.name+"' data-state_id='"+resp.schools[i].state_id+"'>";

                        // b.innerHTML += "<input type='hidden' name='ttuor_hidden' value='" + resp.schools[i].f_name + "'>";

                        /*execute a function when someone clicks on the item value (DIV element):*/

                        b.addEventListener("click", function(e) {

                            /*insert the value for the autocomplete text field:*/
                            // alert($(this).attr("id"));
                            inp.value = this.getElementsByTagName("input")[0].value;
                            // $("#show_school_state").val(this.getElementsByTagName("input")[0].attr("data-state_name"));
                            $("#school_id").val(this.getElementsByTagName("input")[0].id);
                            $("#school_name").val(this.getElementsByTagName("input")[0].value);
                            var schl_state_name = $("#"+this.getElementsByTagName("input")[0].id).attr("data-state_name");
                            var schl_state_id = $("#"+this.getElementsByTagName("input")[0].id).attr("data-state_id");

                            var schl_postcode = $("#"+this.getElementsByTagName("input")[0].id).attr("data-postcode");
                            var schl_suburb = $("#"+this.getElementsByTagName("input")[0].id).attr("data-suburb");

                            $("#show_school_state").val(schl_state_id);


                            $("#show_school_suburb").val(schl_suburb);
                            $("#show_school_postcode").val(schl_postcode);
                            // console.log(this.getElementsByTagName("input")[0].attr("data-state_name"));

                            // $("#state_name").val(resp.schools[i].get_state.state_name);

                            // console.log(this.getElementsByTagName("input")[0].data-sid);

                            var sid = $("#"+this.getElementsByTagName("input")[0].id).attr("data-sid");

                            // $("#search_tutor_slug_studentclass").val(sid);

                            // inp.id = this.getElementsByTagName("input")[0].id;

                            // $(".otherschoolnamediv").hide();
                            var school_id = $.trim($("#school_id").val());
                            if(school_id == 0){
                                $(".otherschoolnamediv").show();
                                $("#show_school_state").val("");
                                $("#show_school_postcode").val("");
                                $("#show_school_suburb").val("");
                                $(".showhiderSchl").attr("disabled",false);
                                $(".showhiderSchl").attr("readonly",false);
                                $(".showhiderSchl").addClass("required");
                            }else{
                                $(".otherschoolnamediv").hide();
                                $(".showhiderSchl").attr("disabled",true);
                                $(".showhiderSchl").attr("readonly",true);
                                $(".showhiderSchl").removeClass("required");
                                // $("#show_school_state").val("");
                                // $("#show_school_postcode").val("");
                                // $("#show_school_suburb").val("");
                            }
                            /*close the list of autocompleted values,

                            (or any other open lists of autocompleted values:*/

                            closeaAllLists();

                        });

                        a.appendChild(b);

                    }else{

                    }

                }
                /*create a DIV element for each matching element:*/

                        b = document.createElement("DIV");

                        /*make the matching letters bold:*/

                        b.innerHTML = "<strong>" + ("Other") + "</strong>";

                        // b.innerHTML += ("Other");

                        /*insert a input field that will hold the current array item's value:*/

                        b.innerHTML += "<input type='hidden' data-sid='"+0+"' id='"+0+"' value='" +'Other'+ "'>";

                        // b.innerHTML += "<input type='hidden' name='ttuor_hidden' value='" + resp.schools[i].f_name + "'>";

                        /*execute a function when someone clicks on the item value (DIV element):*/

                        b.addEventListener("click", function(e) {

                            /*insert the value for the autocomplete text field:*/
                            inp.value = this.getElementsByTagName("input")[0].value;
                            $("#school_id").val(0);
                            $("#school_name").val("Other");
                            // $("#state_name").val("Other");
                            // $(".otherschoolnamediv").show();
                            $("#other_school_name").addClass("required");
                            // console.log(this.getElementsByTagName("input")[0].data-sid);
                            // var sid = $("#"+this.getElementsByTagName("input")[0].id).attr("data-sid");
                            var school_id = $.trim($("#school_id").val());
                            if(school_id == 0){
                                $(".otherschoolnamediv").show();
                                $("#show_school_state").val("");
                                $("#show_school_postcode").val("");
                                $("#show_school_suburb").val("");
                                $(".showhiderSchl").attr("disabled",false);
                                $(".showhiderSchl").attr("readonly",false);
                                $(".showhiderSchl").addClass("required");
                            }else{
                                $(".otherschoolnamediv").hide();
                                $("#show_school_state").val("");
                                $("#show_school_postcode").val("");
                                $("#show_school_suburb").val("");
                                $(".showhiderSchl").attr("disabled",true);
                                $(".showhiderSchl").attr("readonly",true);
                                $(".showhiderSchl").removeClass("required");
                            }
                            // inp.id = this.getElementsByTagName("input")[0].id;
                            /*close the list of autocompleted values,

                            (or any other open lists of autocompleted values:*/

                            closeaAllLists();

                        });

                        a.appendChild(b);


              // console.log(resp);

          },

          error:function(){

          }

        });



    });

    /*execute a function presses a key on the keyboard:*/

    inp.addEventListener("keydown", function(e) {

        var x = document.getElementById(this.id + "autocomplete-list");

        if (x) x = x.getElementsByTagName("div");

        if (e.keyCode == 40) {

          /*If the arrow DOWN key is pressed,

          increase the currentFocus variable:*/

          currentFocus++;

          /*and and make the current item more visible:*/

          addaActive(x);

        } else if (e.keyCode == 38) { //up

          /*If the arrow UP key is pressed,

          decrease the currentFocus variable:*/

          currentFocus--;

          /*and and make the current item more visible:*/

          addaActive(x);

        } else if (e.keyCode == 13) {

          /*If the ENTER key is pressed, prevent the form from being submitted,*/

          e.preventDefault();

          if (currentFocus > -1) {

            /*and simulate a click on the "active" item:*/

            if (x) x[currentFocus].click();

          }

        }

    });

    function addaActive(x) {

      /*a function to classify an item as "active":*/

      if (!x) return false;

      /*start by removing the "active" class on all items:*/

      removeaActive(x);

      if (currentFocus >= x.length) currentFocus = 0;

      if (currentFocus < 0) currentFocus = (x.length - 1);

      /*add class "autocomplete-active":*/

      x[currentFocus].classList.add("autocomplete-active");

    }

    function removeaActive(x) {

      /*a function to remove the "active" class from all autocomplete items:*/

      for (var i = 0; i < x.length; i++) {

        x[i].classList.remove("autocomplete-active");

      }

    }

    function closeaAllLists(elmnt) {

      /*close all autocomplete lists in the document,

      except the one passed as an argument:*/

      var x = document.getElementsByClassName("autocomplete-items");

      for (var i = 0; i < x.length; i++) {

        if (elmnt != x[i] && elmnt != inp) {

          x[i].parentNode.removeChild(x[i]);

        }

      }

    }

    /*execute a function when someone clicks in the document:*/

    document.addEventListener("click", function (e) {

        closeaAllLists(e.target);

    });
    }
    datastudentautocomplete(document.getElementById("school"),[]);
</script>
<script type="text/javascript">
    function modalHideM1(){
        $("#popupModalStudentM1").hide();
    }
    function modalHide1Upd(){
        $("#popupModal1Upd").hide();
    }
</script>

@endsection
