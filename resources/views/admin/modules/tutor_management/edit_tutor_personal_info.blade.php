@extends('admin.layouts.app')
@section('title')
Personal Details
@endsection
@section('links')
@include('admin.includes.links')
<link rel="stylesheet" type="text/css" href="{{ public_asset('admin/assets/libs/css/chosen.css') }}">
<link href="{{ public_asset('admin/assets/css/owl.carousel.css') }}" rel="stylesheet" type="text/css">
<style type="text/css">
/*this is excel button needs to hide as we have already download option*/
    .buttons-excel{
        display: none;
    }
    .dt-buttons{
        display: none;
    }
</style>
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
                <h1 class="pull-left page-title">Personal Details<br/><p class="small_tag">You can find information or edit your profile in this section</p></h1>
                <ol class="breadcrumb pull-right">
                    <li> <a href="{{ route('manage.tutors') }}"><i class="fas fa-backward"></i> Back</a></li>
                    <li><a href="{{ route('view.tutor.personal.info.step.1',$user->id) }}"><i class="fas fa-eye"></i> View</a></li>


                    @if(@$previous_id)
                        <li>
                            <a href="{{ route('edit.tutor.personal.info.step.1',@$previous_id) }}"><i class="fas fa-angle-double-left"></i> Previous</a>
                        </li>
                    @endif
                    @if(@$next_id)
                        <li>
                            <a href="{{ route('edit.tutor.personal.info.step.1',@$next_id) }}"><i class="fas fa-angle-double-right"></i> Next</a>
                        </li>
                    @endif
                </ol>
            </div>
        </div>
        <div class="step_tab">
            <ul>
                <li class="active">
                    <a href="javascript:void(0);" id="clickHere" data-toggle="modal" data-target="#instructionModal" style="display:none;">Click</a>
                    <a href="{{ route('edit.tutor.personal.info.step.1',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/peri.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/perih.png') }}" class="accth"></span>
                    Personal Details
                    </a>
                </li>
                <li>
                    <a href="{{ route('edit.tutor.tutorship.plans',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/gar.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/garh.png') }}" class="accth"></span>
                    Tutorship Plan
                    </a>
                </li>
                <li>
                    <a href="{{ route('edit.tutor.academics',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/aca.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/acah.png') }}" class="accth"></span>
                    Academics
                    </a>
                </li>
                <li>
                    <a href="{{ route('edit.tutor.experience',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/ex.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/exh.png') }}" class="accth"></span>
                    Experience </a>
                </li>
                <li>
                    <a href="{{ route('edit.tutor.rec',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/rec.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/rech.png') }}" class="accth"></span>
                    Recognitions
                    </a>
                </li>
                <li>
                    <a href="{{ route('edit.tutor.availablity',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/rec.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/rech.png') }}" class="accth"></span>
                    Availability
                    </a>
                </li>
                <li>
                    <a href="{{ route('edit.tutor.advance.page',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/rec.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/rech.png') }}" class="accth"></span>
                    Advanced
                    </a>
                </li>
                <div class="clearfix"></div>
            </ul>
        </div>
        <!-- Personal-Information -->
        <div class="panel panel-default panel-fill">
            <div class="panel-body rm02 rm04">
                @include('admin.includes.message')
                <form id="updatePersonalInfo" method="post" action="{{ route('edit.tutor.personal.info.step.1',@$user->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="frm_admin">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="f_name">First Name*</label>
                                    <input type="text" id="f_name" name="f_name" placeholder="First Name" class="form-control        @if(@$user->f_name) addDisablePhone pointerEventsNone @endif addDisablePhone pointerEventsNone" value="{{ @$user->f_name }}">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="l_name"> Last Name*</label>
                                    <input type="text" placeholder="Last Name" id="l_name" name="l_name" class="form-control         @if(@$user->f_name) addDisablePhone pointerEventsNone @endif addDisablePhone pointerEventsNone" value="{{ @$user->l_name }}">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="email">Email Address*</label>
                                    <input type="email" id="email" name="email" placeholder="myemailaddress@xyz.com" class="form-control  @if(@$user->email) addDisablePhone pointerEventsNone @else required @endif " value="{{ @$user->email }}" @if(@$user->email) readonly="" @endif>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="phone">Mobile Number*</label>
                                    <input type="text" class="form-control  @if(@$user->phone) addDisablePhone pointerEventsNone @else required @endif " placeholder="" id="phone" name="phone" value="{{ @$user->phone }}" minlength="10" maxlength="10"  @if(@$user->phone) readonly="" @endif  onkeypress='validate(event)'>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="teacher_emp_status">Employment Status*</label>
                                    <select class="form-control rm06 required" name="teacher_emp_status" id="teacher_emp_status">
                                        <option value="">Select Status</option>
                                        <option value="A" @if(@$user->teacher_emp_status == 'A')  selected=""  @endif>Yes, I'm a full-time teacher</option>
                                        <option value="B" @if(@$user->teacher_emp_status == 'B')  selected=""  @endif>No, but I have teaching experience</option>
                                        <option value="C" @if(@$user->teacher_emp_status == 'C')  selected=""  @endif>Yes, but I'm not a teacher</option>
                                        <option value="D" @if(@$user->teacher_emp_status == 'D')  selected=""  @endif>No, but I have passion for teaching</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="hours">How many hours can you commit?*</label>
                                    <select class="form-control rm06 required" name="hours" id="hours">
                                        <option value="">Select hours</option>
                                        <option value="1-4" @if(@$user->hours == '1-4')  selected=""  @endif> < 5 hrs a week</option>
                                        <option value="5-10" @if(@$user->hours == '5-10')  selected=""  @endif>5 – 10 hrs a week</option>
                                        <option value="10-20" @if(@$user->hours == '10-20')  selected=""  @endif>10 – 20 hrs a week</option>
                                        <option value="20-40" @if(@$user->hours == '20-40')  selected=""  @endif>20 – 40 hrs a week</option>
                                        <option value="40+" @if(@$user->hours == '40+')  selected=""  @endif>> 40 hrs a week</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="why_tutor">Why do you want to be a Tutor?*</label>
                                    <select class="form-control rm06 required" name="why_tutor">
                                        <option value="">Select</option>
                                        <option value="A" @if(@$user->why_tutor == 'A')  selected=""  @endif>Leverage my teaching experience</option>
                                        <option value="B" @if(@$user->why_tutor == 'B')  selected=""  @endif>Looking for after-hours gig</option>
                                        <option value="C" @if(@$user->why_tutor == 'C')  selected=""  @endif>To make more money by teaching</option>
                                        <option value="D" @if(@$user->why_tutor == 'D')  selected=""  @endif>Teaching is my passion, money secondary</option>
                                        <option value="E" @if(@$user->why_tutor == 'E')  selected=""  @endif> Safe way to make money from home</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="language">Language*</label>
                                    <select class=" form-control language slct required" id="language" multiple name="language[]" >
                                    @foreach($lan as $val)
                                     <option value="{{@$val->id}}" @foreach(@$tutor_to_lan as $tt) @if( ($tt->tutor_id==@$user->id)  && ($tt->language_id==$val->id))selected  @endif @endforeach>{{@$val->language}}</option>
                                    @endforeach
                                        </select>
                                        <label id="language[]-error" class="error error_language_text" for="language[]"></label>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <div class="checkBox new-cus tur-radio">
                                        <span>Do you have experience working with children?</span>
                                        <ul>
                                            <li class="one_li_check">
                                                <input type="radio" id="radio1" name="work_with_child" value="Y" @if(@$user->work_with_child == 'Y')  checked=""  @endif>
                                                <label for="radio1">Yes</label>
                                            </li>
                                            <li>
                                                <input type="radio" id="radio2" name="work_with_child" value="N" @if(@$user->work_with_child == 'N')  checked=""  @endif>
                                                <label for="radio2">No</label>
                                            </li>
                                        </ul>
                                        <p class="note">Note: A WWCC pass is an essential criterion to onboard</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="wwc_number">WWCC number</label>
                                    <input type="text" class="form-control criminal_case" placeholder="Enter WWCC number" id="wwc_number" name="wwc_number" value="{{ @$user->wwc_number }}" >
                                </div>
                            </div>
                            {{-- <div class="col-md-4 col-sm-6">
                                <div class="form_box_area"  >
                                    <label>WWC number</label>
                                    <input type="text" id="wwc_number" placeholder="Enter wwc number" value="{{@$user->wwc_number}}"  name="wwc_number" class="inputfiels">
                                </div>
                            </div> --}}
                            <div class="col-lg-5 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <div class="checkBox new-cus tur-radio">
                                        <span>Do you have a history or pending criminal court cases or charges laid against you?</span>
                                        <ul>
                                            <li class="one_li_check">
                                                <input type="radio" id="radio3" name="criminal_case" value="Y" class=" criminal_case" @if(@$user->criminal_case == 'Y')  checked=""  @endif onclick="yes()">
                                                <label for="radio3">Yes</label>
                                            </li>
                                            <li>
                                                <input type="radio" id="radio4" name="criminal_case" value="N" @if(@$user->criminal_case == 'N')  checked=""  @endif class=" criminal_case" onclick="no()">
                                                <label for="radio4" >No</label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 tutor-c criminal_details_hide_show">
                                <div class="form-group">
                                    <label for="criminal_details">Share more details</label>
                                    <input type="text" class="form-control criminal_case" placeholder="Enter here" id="criminal_details" name="criminal_details" value="{{ @$user->criminal_details }}" style="display:block;">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="about_me">What makes you an awesome V-Tutor?</label>
                                    <textarea maxlength="2000" id="about_me" minlength="10" name="about_me" placeholder="Write briefly on what they like, interests, hobbies etc. in about 200 words" class="from-text required textarea_box">{!! strip_tags(@$user->about_me) !!}</textarea>
                                    <div class="error_about_me error error_textarea"></div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-sm-12 col-xs-12">
                                <div class="uplodimg form-group">
                                    <div class="uplodimgfil">
                                        <input type="hidden" name="imgSelect" id="imgSelect" value="{{ @$user->profile_pic }}">
                                        {{-- <span>Profile Picture</span> --}}
                                        <input type="file" name="img" id="file-1" class="inputfile inputfile-1 " data-multiple-caption="{count} files selected">
                                        <label for="file-1">Upload Profile Pic<img src="{{ public_asset('admin/assets/images/up.png') }}" alt=""></label>
                                        {{-- <span class="error_image error"></span> --}}
                                        {{-- <span data-toggle="modal" class="onhover" data-target="#instructionModal"><p class="" style="padding: 25px;">Please ensure to upload a profile pic that meets the  <a href="javascript:void(0);" style="color:#b80f0a;">standards and requirements </a>of V-Tutor.</p></span>   --}}
                                    </div>
                                    <div class="uplodimgfilimg">
                                        <em>
                                            @if(@$user->profile_pic)
                                                <img id="img2" src="{{ URL::to('storage/teacher_profile_pic/'.@$user->profile_pic) }}" alt="">
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

                            <p class="note error_image selected_image_error"></p>
                            </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="profile_video">Profile Video</label>
                                    <input type="url" id="profile_video" name="profile_video" placeholder="Enter or paste YouTube URL here"  class="form-control urli" value="{{ @$user->profile_video }}" onblur="checkYoutubeUrl();" maxlength="255">
                                    <span class="error_youtube_url error" id="error_youtube_url"></span>
                                </div>
                            </div>

                            <div class="clearfix"></div>



                            <div class="col-sm-12">
                                <div class="ad_btn">
                                    <button class="btn btn-primary waves-effect waves-light w-md c_save_edit_tutor_personal_info onpopupclickopne" data-formId="updatePersonalInfo" type="button" id="save_edit_tutor_personal_info">Save</button>
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
<script src="{{ public_asset('admin/assets/libs/js/chosen.jquery.min.js') }}"></script>
<script src="{{public_asset('admin/assets/js/jquery.validate.js')}}"></script>
<script src="{{ url('/') }}/public/admin/assets/js/owl.carousel.js"></script>
<script>
    $(document).ready(function() {
        var owl = $('.cat_slid .owl-carousel');
        owl.owlCarousel({
          margin: 10,
          nav: true,
          autoplay:true,
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
      });



</script>
<script type="text/javascript">
$('.slct').chosen();
$.validator.setDefaults({ ignore: ":hidden:not(.slct)" });
    var isvalidator = $('#updatePersonalInfo').validate({
            rules: {
                timezone_id:{
                    required:true
                },
                // language[]:{
                //     required:true
                // },
                // img: {
                //     required: true
                // },
                phone:{
                    required:true,
                    number:true,
                    remote:{
                        url:"{{route('ajax.tutor.duplicate.phone.check')}}",
                        type:"POST",
                        data: {
                            phone: function() {
                                return $("#phone").val();
                            },
                            id: function() {
                                return {{ @$user->id }};
                            },
                            _token: '{{ csrf_token() }}'
                        }
                    }
                },
                email:{
                    required:true,
                    email:true,
                    remote:{
                        url:"{{route('ajax.tutor.duplicate.email.check')}}",
                        type:"POST",
                        data: {
                            email: function() {
                                return $("#email").val();
                            },
                            id: function() {
                                return {{ @$user->id }};
                            },
                            _token: '{{ csrf_token() }}'
                        }
                    }
                },
                // 'language[]':{
                //     required:true,
                // },
            },
            messages: {
                email:{
                   remote:'Email-id has already been taken'
                },
                phone:{
                   remote:'Phone no has already been taken'
                },
                // ref_1_phone:{
                //     minlength:'Mobile number can have minimum 10 digits',
                //     maxlength:'Mobile number can have maximum 10 digits',
                //     mobileonly:'Enter a valid 10 digit mobile number'
                // },
                // ref_2_phone:{
                //     minlength:'Mobile number can have minimum 10 digits',
                //     maxlength:'Mobile number can have maximum 10 digits',
                //     mobileonly:'Enter a valid 10 digit mobile number'
                // },
                // ref_1_email:{
                //     email:'Please provide valid email-id'
                // },
            },
            submitHandler: function(form){
                var youtube_link = $('#youtube_link').val();

                form.submit();

             },
        });
    $("#save_edit_tutor_personal_info").click(function(){
        var vcheck = 0;
        var youtube_link = $('#profile_video').val();
        if(youtube_link!="") {
          var _url = $('#profile_video').val();
          if (_url.includes("www.youtube.com/watch?") || _url.includes("https://youtu.be/") ) {

          }else{

            $("#error_youtube_url").html("Please enter valid youtube link");
            vcheck = 1;

          }
        }else{
            var img = $.trim($("#file-1").val());
            if($("#file-1").hasClass("required")){
                if(img == ""){
                    var error = '<span generated="true" class="error" style="color:#f85d2c;border:none!important;background:none!important;">'+'This field is required!'+'</span>';
                    $('.error_image').html(error);
                    vcheck = 1;
                }else{
                }
            }

        }
        var value = $("#language").val();
        if(value == ""){
            vcheck == 1;
            $(".error_language_text").html("Please select atleast one language");
        }
        if(vcheck == 0){
            if(isvalidator.form()){
                if(isvalidator.valid()){
                    var obj = $("#save_edit_tutor_personal_info"),
                    tId = obj.attr("id"),
                    tName = "c_save_edit_tutor_personal_info",
                    tFrmId = "updatePersonalInfo";
                    $("#type_popup_next").val("R");

                    isAuthorizedByAdmin(tName,tId,tFrmId);
                }else{
                    $('#instructionModal').modal('hide');
                }
            }
        }
    });
    $('#updatePersonalInfo').on('keyup keypress keydown', function(e) {
      var keyCode = e.keyCode || e.which;
      if (keyCode === 13) {
        e.preventDefault();
        return false;
      }
    });

    function checkYoutubeUrl(){
        // https://youtu.be/Tvt0apBcjvs
        // https://www.youtube.com/watch?v=Tvt0apBcjvs

        // var url = $.trim($("#profile_video").val());
        // if(url != ""){
        //     var shareUrl = url.split("/");
        //     var linkUrl = url.split("=");
        //     // var shareYoutubeUrl = "https://youtu.be/Tvt0apBcjvs";
        //     var shareYoutubeUrl = "https://youtu.be";
        //     var linkYoutubeUrl = "https://www.youtube.com/watch?v";
        //     if(linkYoutubeUrl == linkUrl[0]){
        //         if(linkUrl[1] != ""){
        //             $(".error_youtube_url").html("");
        //         }else{
        //             $("#profile_video").val("");
        //             $(".error_youtube_url").html("Please provide valid youtube url only!Ex: https://youtu.be/_UoBJDWKQbw https://www.youtube.com/watch?v=ImtZ5yENzgE");
        //         }
        //     }else if(shareUrl[0] == shareYoutubeUrl){
        //         if(shareUrl[1] != ""){
        //             $(".error_youtube_url").html("");
        //         }else{
        //             $("#profile_video").val("");
        //             $(".error_youtube_url").html("Please provide valid youtube url only!Ex: https://youtu.be/_UoBJDWKQbw https://www.youtube.com/watch?v=ImtZ5yENzgE");
        //         }
        //     }else{
        //         $("#profile_video").val("");
        //         $(".error_youtube_url").html("Please provide valid youtube url only!Ex: https://youtu.be/_UoBJDWKQbw https://www.youtube.com/watch?v=ImtZ5yENzgE");
        //     }
        //     return false;
        // }
    }
    $(document).ready(function(){

        @if(@$user->criminal_case == 'Y')
            $("#criminal_det").val('');
            $(".criminal_details_hide_show").show();
        @elseif(@$user->criminal_case == 'N')
            $("#criminal_det").val('');
            $(".criminal_details_hide_show").hide();
        @else
            $(".criminal_details_hide_show").show();
        @endif

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
        $(document).on("change","#file-1",function(){
            var i=document.getElementById('file-1').files[0];
            var b=URL.createObjectURL(i);
            // $(".review_img").show();
            $("#img2").show();
            $("#img2").attr("src",b);
        });
        function check() {
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
                'profile_pic'      : profile_pic_val
                }
            };
            if(confirm("Are you sure you want to set this avatar as your profile pic?")){
                $.ajax({
                    url:"{{ route('update.tutor.avatar') }}",
                    dataType: 'json',
                    data: reqData,
                    type: 'post',
                    success:function(resp){
                        $(".selected_image_error").html(resp.message);
                        location.reload();
                    }
                });
            }
        }
    });
</script>
<script type="text/javascript">

    function fun(){
        var i=document.getElementById('file-1').files[0];
        var b=URL.createObjectURL(i);
        // $(".review_img").show();
        $("#img2").show();
        $("#img2").attr("src",b);
    }
    function yes(){
        $("#criminal_det").val('');
        $(".criminal_details_hide_show").show();
    }
    function no(){
      $("#criminal_det").val('');
      $(".criminal_details_hide_show").hide();
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
        if( !regex.test(key) ) {
            theEvent.returnValue = false;
            if(theEvent.preventDefault) theEvent.preventDefault();
        }
    }
</script>
@endsection
