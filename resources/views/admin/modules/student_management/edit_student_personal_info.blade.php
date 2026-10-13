@extends('admin.layouts.app')
@section('title')
Student Personal Info
@endsection
@section('links')
@include('admin.includes.links')
<link href="{{ public_asset('admin/assets/css/owl.carousel.css') }}" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="{{ public_asset('admin/assets/libs/css/chosen.css') }}">
<style type="text/css">
    .addDisablePhone{
        opacity: 0.5 !important;
    }
    .pointerEventsNone{
        pointer-events: none !important;
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
                <h1 class="pull-left page-title">
                    Edit Student Personal Info<br/>
                    <p class="small_tag">You can find information or edit your profile in this section</p>
                </h1>
                <ol class="breadcrumb pull-right">
                    <li> <a href="{{ route('manage.students') }}"><i class="fas fa-angle-double-left"></i> Back</a></li>
                    <li> <a href="{{ route('view.student',@$user->id) }}"><i class="fas fa-angle-double-left"></i> View</a></li>
                </ol>
            </div>
        </div>
        <!-- Personal-Information -->
        <div class="panel panel-default panel-fill">
            <div class="panel-body rm02 rm04">
                @include('admin.includes.message')
                <form id="updateStudentPersonalInfo" method="post" action="{{ route('edit.student.personal.info.step.1',@$user->id) }}" enctype="multipart/form-data">
                    @csrf
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
                                    <input type="text" id="f_name" name="f_name" placeholder="First Name " class="form-control @if(@$user->f_name) addDisablePhone pointerEventsNone @endif addDisablePhone pointerEventsNone"     value="{{ @$user->f_name }}" autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="l_name">Student Last Name*</label>
                                    <input type="text" placeholder="Last Name" id="l_name" name="l_name" class="form-control        @if(@$user->l_name) addDisablePhone pointerEventsNone @endif addDisablePhone pointerEventsNone" value="{{ @$user->l_name }}" autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="grade">Grade</label>
                                    <select class="form-control rm06 required" name="grade" id="grade">
                                        <option value="">Select Grade</option>
                                        @if(@$grades)
                                        @foreach(@$grades as $grade)
                                        <option value="{{ @$grade->id }}" @if(@$grade->id == @$user->grade) selected="" @endif>{{ @$grade->grade_name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="school">School</label>
                                    {{-- choosen chosen slct --}}
                                    <select class="form-control   required" id="school" name="school">
                                        <option value="">Select School</option>
                                        @if(@$schoolList)
                                        @foreach(@$schoolList as $sch)
                                        <option value="{{ @$sch->id }}" @if(@$user->school == $sch->id) selected="" @endif>{{ @$sch->school_name }},{{ @$sch->getState->state_name }},{{ @$sch->getSuburb->name }},{{ @$sch->postcode }}</option>
                                        @endforeach
                                        @endif
                                    </select>

                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <div class="dash-d1">
                                        <label for="dob">Date of birth *</label>
                                        <div class="ui calendar" id="from_date">
                                            <div class="ui input left icon">
                                                <input type="text" id="dob" name="dob" placeholder="Select Date" class="form-control  @if(@$user->dob) addDisablePhone pointerEventsNone @endif addDisablePhone pointerEventsNone" autocomplete="off" readonly="" value="{{ @$user->dob }}" autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');">
                                                <span class="over_llp1"><img src="{{ public_asset('admin/assets/images/cal.png') }}" alt=""></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="gender">Gender</label>
                                    <select class="form-control rm06 " name="gender" id="gender">
                                        <option value="">Select Gender</option>
                                        <option value="M" @if(@$user->gender == 'M')  selected=""  @endif>Male</option>
                                        <option value="F" @if(@$user->gender == 'F')  selected=""  @endif>Female</option>
                                        <option value="O" @if(@$user->gender == 'O')  selected=""  @endif>Neither</option>
                                        <option value="P" @if(@$user->gender == 'P')  selected=""  @endif>Prefer not to say</option>
                                    </select>
                                </div>
                            </div>

                            <div class="clearfix"></div>
                            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <div class="checkBox new-cus tur-radio">
                                        <span>Are you a full-time student? *</span>
                                        <ul>
                                            <li class="one_li_check">
                                                <input type="radio" id="radio1" name="is_full_time" value="Y" @if(@$user->is_full_time == 'Y')  checked=""  @endif onclick="yes()">
                                                <label for="radio1">Yes</label>
                                            </li>
                                            <li>
                                                <input type="radio" id="radio2" name="is_full_time" value="N" @if(@$user->is_full_time == 'N')  checked=""  @endif onclick="no()">
                                                <label for="radio2">No</label>
                                            </li>
                                        </ul>

                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 tutor-c" @if(@$user->is_full_time == 'N')  checked="" style="display:none;" @endif>
                            <div class="form-group">
                                <div class="checkBox new-cus tur-radio">
                                    <span>Do you private school or home school?*</span>
                                    <ul>
                                        <li class="one_li_check">
                                            <input type="radio" id="radio3" name="private_or_home" value="Y" class="required private_or_home" @if(@$user->private_or_home == 'Y')  checked=""  @endif >
                                            <label for="radio3">Yes</label>
                                        </li>
                                        <li>
                                            <input type="radio" id="radio4"  name="private_or_home" value="N" @if(@$user->private_or_home == 'N')  checked=""  @endif class="required private_or_home">
                                            <label for="radio4" >No</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="about_me">About the Student</label>
                                <textarea maxlength="2000" autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');" minlength="10" id="about_me" name="about_me" placeholder="Write briefly about you, what you like, hobbies and interests in about 200 words" class="from-text textarea_box">{!! strip_tags(@$user->about_me) !!}</textarea>
                                <div class="error error_textarea"></div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-12 col-xs-12">
                            <div class="uplodimg form-group">
                                <div class="uplodimgfil">

                                    <input type="hidden" name="imgSelect" id="imgSelect" value="{{ @$user->profile_pic }}">

                                    <span class="error_image error"></span>

                                </div>
                                <div class="uplodimgfilimg">
                                    <em>

                                    </em>
                                </div>
                            </div>
                            <div class="uplodpic scrollListSPic_inr scrollListSPic " style="width: 100%;float: left;">
                                <div class="scrollListSPic_inr">
                                    <div class="uplodpic gallery" style="width: 100%;float: left;">
                                        <div class="cat_slid_bx_top">
                                            <div class="cat_slid">

                                                <div class="owl-carousel">
                                                    @if(@$user->profile_pic)
                                                    <div class="item on_select_u @if(@$user->profile_pic) selectedImage @endif" data-picname="{{ @$user->profile_pic }}" data-src="{{ public_asset('assets/images/all_avatars/'.@$user->profile_pic) }}">
                                                    <div class="cat_slid_bx">
                                                        <img src="{{ public_asset('assets/images/all_avatars/'.@$user->profile_pic) }}" alt="">
                                                    </div>
                                                    </div>
                                                    @endif
                                                @for($i=1;$i<43;$i++)
                                                @if(@$user->profile_pic != 'avatar'.$i.'.png')
                                                <div class="item on_select_u @if(@$user->profile_pic == 'avatar'.$i.'.png') selectedImage @endif" data-picname="avatar{{$i}}.png" data-src="{{ public_asset('assets/images/all_avatars/avatar'.$i.'.png') }}">
                                                    <div class="cat_slid_bx">
                                                        <img src="{{ public_asset('assets/images/all_avatars/avatar'.$i.'.png') }}" alt="">
                                                    </div>
                                                </div>
                                                @endif
                                                @endfor
                                            </div>

                                </div>
                            </div>
                            <div class="select_profile_pic">
                                <input type="button" name="" value="Set my pic" class="btn btn-primary select_profile_pic_btn " id="select_profile_pic_btn">
                            </div>
                            <p class="note error_image selected_image_error"></p>

                        </div>
                        <div class="col-sm-12 col-xs-12">
                                <div class="user-account-info">
                                    <h3>Residential Address</h3>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="country">Country</label>
                                    <select class="form-control rm06 required" name="country" id="country">
                                        <option value="1" @if(@$user->country == 1) selected="" @endif>Australia</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="state">State / Province / Region</label>
                                    <select class="form-control rm06 required" name="state" id="state">
                                        <option value="">Select State</option>
                                        @if(@$states)
                                        @foreach(@$states as $state)
                                        <option value="{{ @$state->id }}" @if(@$user->state == @$state->id) selected="" @endif>{{ @$state->state_name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="text" id="city" name="city" class="form-control required" placeholder="Sydney" value="{{ @$user->city }}">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="address">Unit & Street Address</label>
                                    <input type="text" id="address" name="address" class="form-control required" placeholder="123, Sample St" value="{!! strip_tags(@$user->address) !!}">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="zip">Zip / Postal Code</label>
                                    <input type="number" id="zip" name="zip" class="form-control required" placeholder="1234" value="{{ @$user->zip }}" minlength="4">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="timezone_id">Timezone</label>
                                    <select name="timezone_id" class="required form-control" id="timezone_id">
                                        <option value="">Select timezone</option>
                                        @if(@$timezonesLists)
                                        @foreach(@$timezonesLists as $t)
                                        <option value="{{ @$t->id }}" @if(@$t->id==@$user->timezone_id) selected=""  @endif >{{ @$t->time_zone_abbreviation }},{{ @$t->time_zone_name }},{{ @$t->city }} @if($t->id == 6),Melbourne @endif ({{ @$t->utc_offset }})</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                    </div>
            </div>
        </div>
        <div class="col-sm-12 col-xs-12">
        <div class="user-account-info">
        <h3>Parental Information</h3>
        </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
        <label for="salutation">Salutation</label>
        <select class="form-control rm06 required" name="salutation" id="salutation">
        <option value="">Select Salutation</option>
        <option value="1" @if(@$user->salutation == '1')  selected=""  @endif>Mr.</option>
        <option value="2" @if(@$user->salutation == '2')  selected=""  @endif>Mrs.</option>
        <option value="3" @if(@$user->salutation == '3')  selected=""  @endif>Ms.</option>
        <option value="4" @if(@$user->salutation == '4')  selected=""  @endif>Dr.</option>
        </select>
        </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
        <label for="parent_f_name">Parent First Name*</label>
        <input type="text" id="parent_f_name" name="parent_f_name" class="form-control required addDisablePhone pointerEventsNone @if(@$user->parent_f_name) addDisablePhone pointerEventsNone @endif" placeholder="First Name" value="{{ @$user->parent_f_name }}" autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');">
        </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
        <label for="parent_l_name">Parent Last Name*</label>
        <input type="text" id="parent_l_name" name="parent_l_name" class="form-control required addDisablePhone pointerEventsNone @if(@$user->parent_l_name) addDisablePhone pointerEventsNone @endif" placeholder="Last Name" value="{{ @$user->parent_l_name }}" autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');">
        </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
        <label for="email">Email Address*</label>
        <input type="email" id="email" name="email" placeholder="myemailaddress@xyz.com" class="form-control required addDisablePhone pointerEventsNone @if(@$user->email) addDisablePhone pointerEventsNone @endif" value="{{ @$user->email }}" autocomplete="off"  readonly="">
        </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
        <label for="phone">Mobile Number*</label>
        <input type="number" class="form-control required @if(@$user->phone) addDisablePhone pointerEventsNone @endif addDisablePhone pointerEventsNone" placeholder="" id="phone" name="phone" value="{{ @$user->phone }}" minlength="10" maxlength="10" onkeypress='validate(event)' autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');">
        </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12  ">
        <div class="form-group">
        <label for="annual_income">Annual Income<span tooltip="This is an optional choice used demographic analysis only. It is not shared with any third party and will not make a difference to services offered in the platform"><i class="qus-cir far fa-question-circle"></i></span></label>
        <select name="annual_income" id="annual_income" class="form-control ">
        <option value="A" @if(@$user->annual_income == 'A') selected="" @endif>&lt; 100,000</option>
        <option value="B" @if(@$user->annual_income == 'B') selected="" @endif>100,000 – 150,000</option>
        <option value="C" @if(@$user->annual_income == 'C') selected="" @endif>150,000 –200,000</option>
        <option value="D" @if(@$user->annual_income == 'D') selected="" @endif> 200,000 &gt;</option>
        <option value="P" @if(@$user->annual_income == 'P') selected="" @endif>Prefer not to say</option>
        </select>
        </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
        <label for="qualification">Qualification*</label>
        <select class="form-control  rm06 required" name="qualification" id="qualification">
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
        <div class="clearfix"></div>
        <div class="col-sm-12">
        <div class="ad_btn">
        <button class="btn btn-primary waves-effect waves-light w-md c_save_edit_student_personal_info" id="save_edit_student_personal_info" type="button">Save</button>
        </div>
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
@include('admin.includes.footer')
@endsection
@section('script')
@include('admin.includes.script')
<script src="{{ url('/') }}/public/admin/assets/js/owl.carousel.js"></script>
<script src="{{ public_asset('admin/assets/libs/js/chosen.jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.slct').chosen();
        var owl = $('.cat_slid .owl-carousel');
        owl.owlCarousel({
          margin: 10,
          nav: true,
          autoplay:false,
          loop: true,
          responsive: {
            0: {
              items: 2
            },
            991: {
              items: 5
            },
             1199: {
              items: 5
            },
            1200: {
              items: 6

            }
          }

        });

        // select avatar
        $(document).on("click",".on_select_u",function(){
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
                'profile_pic'      : profile_pic_val,
                'id'      : {{ @$user->id }}
                }
            };
            if(confirm("Are you sure you want to set this avatar as your profile pic?")){
                $.ajax({
                    url:"{{ route('update.student.avatar') }}",
                    dataType: 'json',
                    data: reqData,
                    type: 'post',
                    success:function(resp){
                        // $(".selected_image_error").html(resp.message);


                    }
                });
            }
        }
      });



</script>
<script type="text/javascript">

    function check() {
        var badWords = [];
        @php
        $badwords = \DB::table('bad_words')->pluck('words')->toArray();
        @endphp
        @foreach(@$badwords as $value)
            badWords.push('{{$value}}');
        @endforeach
        // console.log(badWords);
        var wordInput = $.trim(textarea.val());
        wordInput = wordInput.toLowerCase();
        var arr = wordInput.split(" ");
        var foundBadWords = arr.filter(el => badWords.includes(el));

        if(foundBadWords.length>0){
            $(".error_textarea").html('Kindly refrain from using email, phone or flagged words on the description!');
            textarea.val("");

        }

        // email & phone word
        var flaggedWord = ['email','phone'];
        var fwordInput = textarea.val();
        fwordInput = fwordInput.toLowerCase();
        var arr = fwordInput.split(" ");
        var foundFlaggedWords = arr.filter(el => flaggedWord.includes(el));

        if(foundFlaggedWords.length>0){
            textarea.val("");
            $(".error_textarea").html('Kindly refrain from using email, phone or flagged words on the description!');
        }else{
            var v = textarea.val();
            if(v != ""){
                $(".error_textarea").html('');
            }

        }

    }
    var textarea = $('.textarea_box');
    textarea.on({
        keyup: function(e) {
            if (e.which == 188) check();
            if (e.which == 32) check();
            check();
            var words = 0;
                if((this.value.match(/\S+/g)) != null) {
                    words = this.value.match(/\S+/g).length;
                }
                if(words > 200){
                    var trimmed = $(this).val().split(/\s+/, 200).join(" ");
                    $(this).val(trimmed + " ");
                }
        },
        blur: check
    });
</script>
<script type="text/javascript">
    var isvalidator = $('#updateStudentPersonalInfo').validate({



            rules: {



                // f_name: {



                //     required: true



                // },


                timezone_id:{
                    required:true
                },
                // l_name: {



                //     required: true



                // },

                // suburb: {



                //     required: true



                // },

                country: {



                    required: true



                },

                state: {



                    required: true



                },

                city: {



                    required: true



                },

                zip: {



                    required: true



                },



                // phone:{



                //     required:true,



                //     number:true,



                //     remote:{



                //         url:"{{route('ajax.tutor.duplicate.phone.check')}}",



                //         type:"POST",



                //         data: {



                //             grade_name: function() {



                //                 return $("#phone").val();



                //             },



                //             id: function() {



                //                 return {{ @$user->id }};



                //             },



                //             _token: '{{ csrf_token() }}'



                //         }



                //     }



                // },



                // email:{



                //     required:true,



                //     email:true,



                //     remote:{



                //         url:"{{route('ajax.tutor.duplicate.email.check')}}",



                //         type:"POST",



                //         data: {



                //             grade_name: function() {



                //                 return $("#email").val();



                //             },



                //             id: function() {



                //                 return {{ @$user->id }};



                //             },



                //             _token: '{{ csrf_token() }}'



                //         }



                //     }



                // }



            },



            messages: {



                email:{



                   remote:'Email-id has already been taken'



                },



                phone:{



                   remote:'Phone no has already been taken'



                }



            }



        });



    $("#save_edit_student_personal_info").click(function(){



        if(isvalidator.form()){



        if(isvalidator.valid()){



            var obj = $("#save_edit_student_personal_info"),



            tId = obj.attr("id"),



            tName = "c_save_edit_student_personal_info",



            tFrmId = "updateStudentPersonalInfo";



            $("#type_popup_next").val("R");



            isAuthorizedByAdmin(tName,tId,tFrmId);



        }else{



            $('#instructionModal').modal('hide');



        }



        }







    });



    $('#updateStudentPersonalInfo').on('keyup keypress keydown', function(e) {



      var keyCode = e.keyCode || e.which;



      if (keyCode === 13) {



        e.preventDefault();



        return false;



      }



    });



    function yes(){



        $(".tutor-c").hide();



    }



    function no(){



      $(".tutor-c").show();



    }



    $(document).ready(function(){



        $("#from_date").calendar({



            type: 'date',



            maxDate:new Date(),



            formatter: {



                date: function (date, settings) {



                    if (!date) return '';



                    var day = date.getDate() + '';



                    if (day.length < 2) {



                        day = '0' + day;



                    }



                    var month = (date.getMonth() + 1) + '';



                    if (month.length < 2) {



                        month = '0' + month;



                    }



                    var year = date.getFullYear();



                    return year + '-' + month + '-' + day;



                }



            }



        });






        $(document).on("change","#file-1",function(){



            var i=document.getElementById('file-1').files[0];



            var b=URL.createObjectURL(i);



            // $(".review_img").show();



            $("#img2").show();



            $("#img2").attr("src",b);



        });







        $("#about_me").on('keyup', function() {



            var words = 0;



            if((this.value.match(/\S+/g)) != null) {



                words = this.value.match(/\S+/g).length;



            }



            if(words > 200){



                var trimmed = $(this).val().split(/\s+/, 200).join(" ");



                $(this).val(trimmed + " ");



            }



        });







                  $(document).on("click",".on_select_u",function(){

                    $("#img2").attr('src',$(this).attr("data-src"));

                    $("#imgSelect").val($(this).attr("data-picname"));

                  });
                  $(document).on("change","#gender",function(){

                    var value = $(this).val();

                    if(value == 'M'){
                        $(".femaleGender").hide();
                        $(".maleGender").show();
                        $(".noGender").hide();
                    }

                    else if(value == 'F'){

                        $(".femaleGender").show();
                        $(".maleGender").hide();
                        $(".noGender").hide();

                    }else{

                        $(".femaleGender").hide();
                        $(".maleGender").hide();
                        $(".noGender").show();

                    }

                  });


    });



</script>
<script type="text/javascript">
    function checkDob(){







    }



    function fun(){



        var i=document.getElementById('file-1').files[0];



        var b=URL.createObjectURL(i);



        $(".review_img").show();



        $("#img2").show();



        $("#img2").attr("src",b);



    }



    function validate(evt) {



        var theEvent = evt || window.event;



          // Handle paste



          if (theEvent.type === 'paste') {



              key = event.clipboardData.getData('text/plain');



          } else {



          // Handle key press



          var key = theEvent.keyCode || theEvent.which;



          key = String.fromCharCode(key);



      }



      var regex = /[0-9]/;



      if( !regex.test(key) ) {



        theEvent.returnValue = false;



        if(theEvent.preventDefault) theEvent.preventDefault();



    }







</script>
@endsection
