@extends('layouts.app')
@section('title')
<title>V-Tutor | Session Link</title>
@endsection
@section('left_part')
{{-- @include('include.left_part') --}}
@include('include.header_menu_part')
<style>
/*p {
  text-align: center;
  font-size: 60px;
  margin-top: 0px;
}*/
/*.studentUpdatePopupModal .divPoMW {
    max-width: 642px !important;
}*/
.classLink .divPoMW {
    max-width: 642px !important;
}
</style>
@endsection
@section('content')
<section class="makes_special_sec faq-sec">
    <div class="makes_special_inr">
        <!-- bannersec -->
        <div class="top_mar"></div>
        <section class="gj_sess_sec">
            <div>
                <div class="login-details">

                    {{-- @include('include.errors') --}}
                    <div class="login-from">
                        <div class="or-area">
                            <span> {{ @$title }}</span>
                        </div>

                        <div class="form_area text-center" >
                            <h2>Session Link for {{ @$booking->booking_no }}</h2>
                            {{-- <label id="demo"></label> --}}
                        </div>



                            <div class="fort-pass">
                                @if(@$booking->booking_status == 'B' && @$booking->booking_date_user <= date('Y-m-d') && @$booking->from_time <= date('H:i:s',strtotime(date('H:i:s'))+(60*5)) && @$booking->to_time >= date('H:i:s'))
                                <a href="" onclick="myfunction()"> Link can be accessed  </a>
                                @elseif(@$booking->booking_status == 'B' && @$booking->booking_date_user <= date('Y-m-d') && @$booking->from_time <= date('H:i:s') && @$booking->to_time >= date('H:i:s'))
                                <a href="" onclick="myfunction()"> Link can be accessed  </a>
                                @elseif(@$booking->booking_status == 'CM')
                                <a href="javascript:void(0);"> Your session is completed</a>
                                @elseif(@$booking->booking_status == 'C')
                                <a href="javascript:void(0);"> Your session was cancelled. Refer email for more details.</a>
                                @else
                                <a href="javascript:void(0);"> {!!Session::get('success')!!}</a>
                                @endif
                            </div>
                            <div class="bottom-account-div">
                            {{-- <p>Don't have an account? <a href="{{ route('register') }}">Sign up</a></p> --}}
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            @if(@$booking->booking_status == 'B' && @$booking->booking_date_user == date('Y-m-d') && @$booking->to_time > date('H:i:s'))
                            <label id="demo1"></label>
                            @endif
                            @if(@$booking->booking_status == 'B' && @$booking->booking_date_user > date('Y-m-d'))
                            <label id="demo2"></label>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</section>
@endsection
@section('footer')
    @include('include.footer')
    <div class="modal res-modal newqusmo classLink" id="popupModalsessionLinkShow">
     <div class="modal-dialog modal-dialog-centered divPoMW ">
      <div class="modal-content">
        <div class="dvpro">
            <!-- Modal Header -->
            <div class="modal-header messageDivTxt">
                <h4 class="modal-title">
                Upcoming Session
                <!-- Session Details -->
                </h4>
            </div>

            <!-- Modal body -->
            <div class="modal-body ">
                <div class="testPro">
                    <div class="proDiv messageDivTxt">
                        <!-- <h6>{{ @$title }}</h6> -->
                        <p class="leftAlginText">{!!Session::get('success')!!}</p>
                        @if(@$booking->booking_status == 'B' && @$booking->booking_date_user == date('Y-m-d') && @$booking->to_time > date('H:i:s'))
                        <p class="leftAlginText">Meeting link will be active only before 5 minutes of the session</p>
                        @endif
                        @if(@$booking->booking_status == 'B' && @$booking->booking_date_user > date('Y-m-d'))
                        <p class="leftAlginText">Meeting link will be active only before 5 minutes of the session</p>
                        @endif
                        <p class="leftAlginText">
                            @php
                                $myGrade = \App\Models\Grade::where(['id'=>@Auth::user()->grade,'status'=>'A'])->select('id','slug','status')->first();
                                $myState = \App\Models\State::where(['id'=>@Auth::user()->state])->first();
                            @endphp
                            @if(@Auth::user()->user_type != 'T')
                            <a href="{{ url('tutor-search-result?grade='.@$myGrade->slug) }}" style="font-style: italic;">Book again</a>
                            @endif
                        </p>
                        <!-- @if(@$booking->booking_status == 'B' && @$booking->booking_date_user == date('Y-m-d') && @$booking->to_time >= date('H:i:s'))
                        <p id="demo">
                        @endif -->
                        </p>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js" integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg==" crossorigin="anonymous"></script>
<script type="text/javascript">
    $('#waitFor1').modal('hide');
    $("#popupModalsessionLinkShow").modal('show');
    // $("#popupModalsessionLinkShow").show();
</script>
<script>
@php
        $date=explode("-",@$booking->booking_date_user);
        $from=explode(":",@$booking->from_time);
        $val['year']=$date[0];
        $val['month']=$date[1];
        $val['day']=$date[2];

        $val['from_hour']=$from[0];
        $val['from_min']=$from[1];

        $Cdate=explode("-",date('Y-m-d'));
        $Cfrom=explode(":",date('H:i:s'));
        $Cval['year']=$Cdate[0];
        $Cval['month']=$Cdate[1];
        $Cval['day']=$Cdate[2];

        $Cval['from_hour']=$Cfrom[0];
        $Cval['from_min']=$Cfrom[1];
@endphp
var countDownDate = new Date({{(int)($val['year'])}}, {{(int)($val['month'])-1}},{{(int)($val['day'])}} , {{(int)($val['from_hour'])}}, {{(int)($val['from_min'])}}, 0).getTime();
// Update the count down every 1 second
var x = setInterval(function() {
  // Get today's date and time

  // var now = new Date({{ date('Y') }},{{ date('m') }},{{ date('d') }},{{ date('H') }},{{ date('m') }}).getTime();
  // var now = new Date().getTime();
    var now = new Date({{(int)($Cval['year'])}}, {{(int)($Cval['month'])-1}},{{(int)($Cval['day'])}} , {{(int)($Cval['from_hour'])}}, {{(int)($Cval['from_min'])}}, 0).getTime();
  // Find the distance between now and the count down date
  var distance = countDownDate - now;

  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  // Output the result in an element with id="demo"
  document.getElementById("demo").innerHTML = days + "d " + hours + "h "
  + minutes + "m " + seconds + "s ";

  // If the count down is over, write some text
  if (distance < 0) {
    clearInterval(x);
    // location.reload();
    document.getElementById("demo").innerHTML = "EXPIRED";
  }
}, 1000);
function myfunction(){
    location.reload();
}
</script>
@endsection
