@extends('layouts.app')

@section('title')

<title>V-Tutor  | Student | Session Feedback</title>

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



                            <h2 class="profile-heading">Session Feedback <span>
                                {{-- <img src="{{ public_asset('assets/images/pencil.png')}}"> --}}
                                <i class="fas fa-desktop" aria-hidden="true"></i>
                            </span></h2>

                            <p>Please fill out the feedback to help us understand more about the session</p>

                            <form method="post" action="{{ route('student.class.end.assesment.save',$id) }}" id="frm" enctype="multipart/form-data">
                                @csrf
                                <div class="user-account-info student_cls_end_assesment">
                                    @if(@$questions)
                                            @foreach(@$questions as $key=>$q)
                                    <div class="row new_rows no-gutters">
                                            <div class="col-md-12 col-sm-12">
                                                <div class="form_box_area">
                                                    <input type="hidden" name="questions[]" value="{{ @$q->id }}"/>
                                                    @if($q->answer_type == 'radio')
                                                        @if($key == 5)
                                                        <div class="checkBox new-cus chkClassEnd"> <span>{{ $key+1 }}. {{ @$q->question }}<br/>@if(@$q->question_description)<em class="t_small_intalic">({{ @$q->question_description }})</em>@endif</span>
                                                                @if(@$q->getAnswerOptions)
                                                                <ul class="submn star_ul_cls_end">
                                                                @foreach(@$q->getAnswerOptions as $key=>$a)
                                                                <li class="one_li_check">
                                                                    <input type="radio" id="radio12{{ $a->id }}" name="answers[{{ @$q->id }}]" value="{{ $a->id }}" @if($a->answer == 3) checked="" @endif>
                                                                    <label for="radio12{{ $a->id }}"></label>
                                                                    @if($a->answer == 5)
                                                                    <span>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        &nbsp;&nbsp;&nbsp;&nbsp;Excellent</span>

                                                                    @endif
                                                                    @if($a->answer == 4)
                                                                    <span>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star rre_star" style="color:grey;"></i>
                                                                        &nbsp;&nbsp;&nbsp;&nbsp;Good</span>

                                                                    @endif
                                                                    @if($a->answer == 3)
                                                                    <span>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star rre_star" style="color:grey;"></i>
                                                                        <i class="fa fa-star rre_star" style="color:grey;"></i>
                                                                        &nbsp;&nbsp;&nbsp;&nbsp;Neutral</span>

                                                                    @endif
                                                                    @if($a->answer == 2)
                                                                    <span>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star rre_star" style="color:grey;"></i>
                                                                        <i class="fa fa-star rre_star" style="color:grey;"></i>
                                                                        <i class="fa fa-star rre_star" style="color:grey;"></i>
                                                                          &nbsp;&nbsp;&nbsp;&nbsp;Fair</span>

                                                                    @endif
                                                                    @if($a->answer == 1)
                                                                    <span>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star rre_star" style="color:grey;"></i>
                                                                        <i class="fa fa-star rre_star" style="color:grey;"></i>
                                                                        <i class="fa fa-star rre_star" style="color:grey;"></i>
                                                                        <i class="fa fa-star rre_star" style="color:grey;"></i>
                                                                         &nbsp;&nbsp;&nbsp;&nbsp;Poor
                                                                        </span>

                                                                    @endif
                                                                </li>
                                                                @endforeach
                                                                </ul>
                                                                @endif
                                                        </div>
                                                        @else
                                                        <div class="checkBox new-cus"> <span>{{ $key+1 }}. {{ @$q->question }}<br/>@if(@$q->question_description)<em class="t_small_intalic">({{ @$q->question_description }})</em>@endif</span>
                                                                @if(@$q->getAnswerOptions)
                                                                @foreach(@$q->getAnswerOptions as $key=>$a)
                                                                <ul class="submn">
                                                                <li class="one_li_check">
                                                                    <input type="radio" id="radio12{{ $a->id }}" name="answers[{{ @$q->id }}]" value="{{ $a->id }}" @if($key == 0 && @$q->id != 15) checked="" @elseif($key == 1 && @$q->id == 15) checked="" @endif>
                                                                    <label for="radio12{{ $a->id }}">{{ $a->answer }}</label>
                                                                </li>
                                                                </ul>
                                                                @endforeach
                                                                @endif
                                                        </div>
                                                        @endif
                                                    @elseif($q->answer_type == 'textbox')
                                                    <label>{{ $key+1 }}. {{ @$q->question }}@if(@$q->question_description)<br/><em class="t_small_intalic">({{ @$q->question_description }})</em>@endif</label>
                                                    <textarea maxlength="1000" placeholder="Give your feedback in about 100 words" name="answers[{{ @$q->id }}]" value=""  class="100_words_checking textarea_box" maxlength="1000"></textarea>
                                                    <div class="error_textarea error"></div>
                                                    {{-- <p class="note">Note: A WWC pass is an essential criterion to onboard</p> --}}
                                                    @else
                                                    <label>{{ $key+1 }}. {{ @$q->question }}@if(@$q->question_description)({{ @$q->question_description }})@endif</label>
                                                    <textarea maxlength="1000" placeholder=" " name="answers[{{ @$q->id }}]" value="" class="required" class="100_words_checking textarea_box" maxlength="1000"></textarea>
                                                    <div class="error_textarea error"></div>
                                                    @endif
                                                    {{-- <input type="text" placeholder=" " name="question" value="" required=""> --}}
                                                </div>
                                            </div>

                                    </div>
                                    @endforeach
                                        @endif
                                </div>
                                <div class="user-account-info">
                                    <div class="row new_rows no-gutters">
                                        <div class="col-md-12 col-sm-12">
                                        <hr class="das-hr">
                                        <div class="footdashSec">
                                            <input type="submit" name="" value="Submit Review " class="sub_btn">
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </section>

@endsection

@section('footer')

@include('include.footer')



@endsection

@section('script')

@include('include.script')

 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js" integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg==" crossorigin="anonymous"></script>
<script type="text/javascript">
    $('#frm').validate({
        submitHandler: function(form){
            var badWords = [];
            @foreach(@$badwords as $value)
                badWords.push('{{$value}}');
            @endforeach
            badWords.push('email');
            badWords.push('phone');
            badWords.push('reach');
            badWords.push('call');
            badWords.push('gmail');
            badWords.push('.net');
            badWords.push('.com');

            var wordInput = $.trim($('.textarea_box').val());
            wordInput = wordInput.toLowerCase();
            var arr = wordInput.split(" ");

            var foundBadWords = arr.filter(el => badWords.includes(el));

            if(foundBadWords.length>0){
                $(".error_textarea").html('Kindly refrain from using email, phone or flagged words on the description!');
                textarea.val("");
                return false;
            }
            // by e
            arr = wordInput.split("\n");
            var foundBadWords = arr.filter(el => badWords.includes(el));
            if(foundBadWords.length>0){
                $(".error_textarea").html('Kindly refrain from using email, phone or flagged words on the description!');
                textarea.val("");
                return false;
            }
            arr = wordInput.split(",");
            foundBadWords = arr.filter(el => badWords.includes(el));
            if(foundBadWords.length>0){
                $(".error_textarea").html('Kindly refrain from using email, phone or flagged words on the description!');
                textarea.val("");
                return false;
            }
            // email & phone word
            var flaggedWord = ['email','phone'];
            var wordInput = textarea.val();
            wordInput = wordInput.toLowerCase();
            var arr3 = wordInput.split(" ");
            var foundFlaggedWords = arr3.filter(el => flaggedWord.includes(el));

            if(foundFlaggedWords.length>0){
                textarea.val("");
                $(".error_textarea").html('Kindly refrain from using email, phone or flagged words on the description!');
                return false;
            }else{
                var wordInput = textarea.val();
                wordInput = wordInput.toLowerCase();
                var arr = wordInput.split(" ");
                var isChec = 1;
                $.each(arr, function(_,t) {
                    if(/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/.test(t.toLowerCase())){
                        isChec = 0;
                        $(".error_textarea").html('Kindly refrain from using email, phone or flagged words on the description!');
                        textarea.val("");
                        return false;

                    }

                    if(/^[+]?\d+$/.test(t.toLowerCase())){
                        isChec = 0;
                        $(".error_textarea").html('Kindly refrain from using email, phone or flagged words on the description!');
                        textarea.val("");
                        return false;
                    }
                    if(t.includes(".net")){
                        isChec = 0;
                        $(".error_textarea").html('Kindly refrain from using email, phone or flagged words on the description!');
                        textarea.val("");
                        return false;
                    }
                    if(t.includes(".com")){
                        isChec = 0;
                        $(".error_textarea").html('Kindly refrain from using email, phone or flagged words on the description!');
                        textarea.val("");
                        return false;
                    }
                    if(t.includes("gmail")){
                        isChec = 0;
                        $(".error_textarea").html('Kindly refrain from using email, phone or flagged words on the description!');
                        textarea.val("");
                        return false;
                    }
                    if(t.match("\d{10}")){
                        isChec = 0;
                        $(".error_textarea").html('Kindly refrain from using email, phone or flagged words on the description!');
                        textarea.val("");
                        return false;
                    }
                });
                if(isChec == 1){
                        form.submit();
                }
                // form.submit();
            }
        }
    });

    function check() {
        var badWords = [];
        @foreach(@$badwords as $value)
            badWords.push('{{$value}}');
        @endforeach
        badWords.push('email');
        badWords.push('phone');
        badWords.push('reach');
        badWords.push('call');
        badWords.push('gmail');
        badWords.push('.net');
        badWords.push('.com');
        var wordInput = $.trim($('.textarea_box').val());
        wordInput = wordInput.toLowerCase();
        var arr = wordInput.split(" ");

        var foundBadWords = arr.filter(el => badWords.includes(el));

        if(foundBadWords.length>0){
            $(".error_textarea").html('Kindly refrain from using email, phone or flagged words on the description!');
            textarea.val("");

        }
        // by e
        arr = wordInput.split("\n");
        var foundBadWords = arr.filter(el => badWords.includes(el));
        if(foundBadWords.length>0){
            $(".error_textarea").html('Kindly refrain from using email, phone or flagged words on the description!');
            textarea.val("");

        }
        arr = wordInput.split(",");
        foundBadWords = arr.filter(el => badWords.includes(el));
        if(foundBadWords.length>0){
            $(".error_textarea").html('Kindly refrain from using email, phone or flagged words on the description!');
            textarea.val("");

        }
        // email & phone word
        var wordInput = textarea.val();
        wordInput = wordInput.toLowerCase();
        var arr = wordInput.split(" ");

        $.each(arr, function(_,t) {
            if(/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/.test(t.toLowerCase())){
                $(".error_textarea").html('Kindly refrain from using email, phone or flagged words on the description!');
                textarea.val("");
            }

            if(/^[+]?\d+$/.test(t.toLowerCase())){
                $(".error_textarea").html('Kindly refrain from using email, phone or flagged words on the description!');
                textarea.val("");
            }
            if(t.includes(".net")){
                $(".error_textarea").html('Kindly refrain from using email, phone or flagged words on the description!');
                textarea.val("");
            }
            if(t.includes(".com")){
                $(".error_textarea").html('Kindly refrain from using email, phone or flagged words on the description!');
                textarea.val("");
            }
            if(t.includes("gmail")){
                $(".error_textarea").html('Kindly refrain from using email, phone or flagged words on the description!');
                textarea.val("");
            }
            if(t.match("\d{10}")){
                $(".error_textarea").html('Kindly refrain from using email, phone or flagged words on the description!');
                textarea.val("");
            }
        });
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
        blur: function(e) {
            // if (e.which === 188) check();
            // if (e.which === 32) check();
            check();
            var words = 0;
                if((this.value.match(/\S+/g)) != null) {
                    words = this.value.match(/\S+/g).length;
                }
                if(words > 100){
                    var trimmed = $(this).val().split(/\s+/, 100).join(" ");
                    $(this).val(trimmed + " ");
                }
        }
    });
    $(document).ready(function(){

        // $(".100_words_checking").on('keyup', function() {
        //     var words = 0;
        //     if((this.value.match(/\S+/g)) != null) {
        //         words = this.value.match(/\S+/g).length;
        //     }
        //     if(words > 100){
        //         var trimmed = $(this).val().split(/\s+/, 100).join(" ");
        //         $(this).val(trimmed + " ");
        //     }
        // });
    });

</script>
@endsection
