@extends('layouts.app')
@section('title')
<title>V-Tutor  | Tutor | Right to work</title>
@endsection
@section('left_part')
@include('include.header_menu_part')
{{-- for datatable --}}
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<style type="text/css">
    .textLimit {
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .gj_wwcc_tbl_desc {
        margin-top: 15px !important;
        margin-bottom: 10px;
        /* font-style: italic;
        font-weight: 600;
        font-size: 12px !important; */
    }

    .gj_wwcc_tbl_hd {
        color: #d73c5d;
        text-align: center;
    }
    td.gj_wwcc_hd {
        text-align: center;
        font-weight: 700;
    }
    .gj_wwcc_nnote {
        font-style: italic;
        font-size: 14px !important;
    }
</style>
@endsection

  @section('content')
  <!-- bannersec -->
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
                <li>
                  <a href="{{route('teacher.profile')}}">
                    <span><img src="{{ public_asset('assets/images/peri.png')}}" class="actt"><img src="{{ public_asset('assets/images/perih.png')}}" class="accth"></span>
                    Personal
                  </a>
                </li>
                <li>
                  <a href="{{route('tutorship.plan')}}">
                    <span><img src="{{ public_asset('assets/images/gar.png')}}" class="actt"><img src="{{ public_asset('assets/images/garh.png')}}" class="accth"></span>
                    Tutorship Plan
                  </a>
                </li>
                <li>
                  <a href="{{route('tutor.acadamic')}}">
                    <span><img src="{{ public_asset('assets/images/aca.png')}}" class="actt"><img src="{{ public_asset('assets/images/acah.png')}}" class="accth"></span>
                    Academics
                  </a>
                </li>
                <li >
                  <a href="{{route('tutor.exp')}}">
                    <span><img src="{{ public_asset('assets/images/ex.png')}}" class="actt"><img src="{{ public_asset('assets/images/exh.png')}}" class="accth"></span>
                  Experience </a>
                </li>
                <li>
                  <a href="{{route('tutor.recognization')}}">
                    <span><img src="{{ public_asset('assets/images/rec.png')}}" class="actt"><img src="{{ public_asset('assets/images/rech.png')}}" class="accth"></span>
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
                <li class="active">
                    <a href="{{route('tutor.right_to_work')}}">
                    <span><img src="{{ public_asset('assets/images/rec.png')}}" class="actt"><img src="{{ public_asset('assets/images/rech.png')}}" class="accth"></span>
                        Compliance
                    </a>
                </li>
                {{-- <li >
                  <a @if(@Auth::user()->platform_type != NULL) href="{{ route('teacher.close.account') }}" onclick="return confirm('We find that you have decided to close the account and we are sorry to see you go! We may need your account password to validate closure! If you have any issues / concerns that you would like to share, kindly use the Complaints link . Please be aware that this process is irreversible. Any data on this account will be retained as per our privacy policy and purged after a certain time')" @else href="#" data-toggle="modal" data-target="#myModalnes" @endif    class="" >Close my account</a>

                </li> --}}
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="turo-edit">
              <div class="user-right-top">

                {{-- <h2 class="profile-heading"><span class="per-info"><img src="{{ public_asset('assets/images/recog.png')}}"></span>Right to Work</h2> --}}
                <p>This section allows you to view your WWCC work authorisation.</p>

                <p class="gj_wwcc_nnote">To work with V-Tutor, your Working with Children Check (WWCC) must remain valid in the states and territories where you tutor. Please keep your details up to date and let us know at wwcc@v-tutor.com.au if anything changes. If a WWCC expires, you won’t be able to work in that region until it’s renewed. </p>

                @include('include.errors')
                    <form action="{{ route('tutor_application_form_save_tab7') }}" method="post" id="frm">
                        @csrf
                        <div class="user-account-info">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td colspan="4" class="gj_wwcc_hd">Working with Children Check (WWCC)</td>
                                        </tr>
                                        <tr>
                                            <th class="text-center">State</th>
                                            <th class="text-center">WWCC #</th>
                                            <th class="text-center">Date of Expiry</th>
                                            <th class="text-center">Authorised</th>
                                        </tr>

                                        @if (is_array(config('tutor_form.australian_states')))
                                            @php
                                                $wwccData = collect(@$tutor_wwcc ?? [])->keyBy('states');
                                            @endphp
                                            @foreach (config('tutor_form.australian_states') as $wwcc_chk_k => $wwcc_chk_v)
                                                @php
                                                    $ext_wwcc_chk_k = @$wwccData[$wwcc_chk_k] ?? null;
                                                @endphp

                                                <tr>
                                                    <td class="text-left">{{ $wwcc_chk_v }}</td>
                                                    <td class="text-left">{{ $ext_wwcc_chk_k['wwcc_no'] ?? '-' }}</td>
                                                    <td class="text-center">{{ (isset($ext_wwcc_chk_k['expiry_date']) && $ext_wwcc_chk_k['expiry_date']) ? date('d M Y', strtotime($ext_wwcc_chk_k['expiry_date'])) : '-' }}</td>
                                                    <td class="text-center">
                                                        @if (isset($ext_wwcc_chk_k['is_valid']) && $ext_wwcc_chk_k['is_valid'] == 3)
                                                            {{ 'Not Validated' }}
                                                        @elseif (isset($ext_wwcc_chk_k['is_valid']) && $ext_wwcc_chk_k['is_valid'] == 2)
                                                            {{ 'No' }}
                                                        @elseif (isset($ext_wwcc_chk_k['is_valid']) && $ext_wwcc_chk_k['is_valid'] == 1)
                                                            {{ 'Yes' }}
                                                        @else
                                                            {{ '-' }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12 col-12 mb-3">
                                    <div class="gj_wwcc_tbl_div">
                                        <p class="gj_wwcc_tbl_desc">Below is a list of official government websites
                                            where users can find information, apply, or check the status of a
                                            Working with Children Check (WWCC) (or its equivalent) in each
                                            Australian state and territory:</p>

                                        <h4 class="gj_wwcc_tbl_hd">WWCC Information by State and Territory –
                                            Official Websites </h4>

                                        <div class="table-responsive gj_tbl_resp">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>State / Territory</th>
                                                        <th> WWCC Name </th>
                                                        <th style="width: 450px;"> Official Website </th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @if (is_array(config('tutor_form.wwcc_australian_states')))
                                                        @foreach (config('tutor_form.wwcc_australian_states') as $aus_sts_k => $aus_sts_v)
                                                            <tr>
                                                                <td>{{ $aus_sts_v['states'] }}</td>

                                                                <td>{{ $aus_sts_v['wwcc'] }}</td>

                                                                <td>
                                                                    <a href="{{ $aus_sts_v['link'] }}"
                                                                        target="_blank">{{ $aus_sts_v['link_text'] }}</a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
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
<div class="modal res-modal newqusmo" id="myModalnes">
     <div class="modal-dialog modal-dialog-centered divPoMW tapDiv proClose">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
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
                    <p>We notice that you have decided to close your account. If there are any issues / concerns that you would like to share or discuss, kindly message us. Our backend team will review and respond over email or give you a call, if needed.</p>
                    <p>We require your account password to validate closure! Please be aware that this process is not reversible. Any data on this user account will be retained as per our policies and purged after a certain date. For more details, review our Privacy Policy.</p>
                    <p class="tutoracademiccor academic_team_bold">Academics Team</p>
                    {{-- <p>We are sorry to see you go (sad)
                    </p> --}}
                    <div class="next-btn1 newst_btn-pop">

                        <button type="button" class="btn btn-new btn-danger float-left change-new-link"  id="nextValueShow">Yes, please close</button>
                        <button type="button" class="btn btn-new btn-danger " data-dismiss="modal">No, don’t close </button>
                        <div class="clearfix"></div>
                    </div>
                </div>
               <div class="appome_input form_box_area cls2 " id="passwordForm" style="display:none;">
                @if(@Auth::user()->user_type == 'T')
                    <form action="{{route('teacher.close.account')}}" id="checkPassword" method="post">
                        @csrf
                @else
                <form action="{{route('teacher.close.account')}}" id="checkPassword" method="post">
                        @csrf
                @endif
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
    @endsection
    @section('script')
    @include('include.script')
    <script src="{{ public_asset('assets/js/chosen.jquery.js') }}" type="text/javascript"></script>
    <script src="{{ public_asset('assets/js/init.js') }}" type="text/javascript"></script>
    {{-- for datatable --}}
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    {{-- for validation --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js" integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg==" crossorigin="anonymous"></script>
    <script>
    oTable = $('#example').DataTable({
      "order": [
          [0, "desc"]
      ],
    "pageLength":5,
    "language": {
                "emptyTable": "No data available",
                "info": "",
                "infoEmpty": "",
                "infoFiltered": "" 
            },
            dom: '<"top"f>t<"bottom row"<"col-12 d-flex justify-content-end"p>>',
    columnDefs: [ { targets: '_all', type: 'natural' } ]
    });

    if (oTable.rows().data().length === 0) {
        $(oTable.table().container())
            .find('.dataTables_paginate')
            .hide();
    }
    </script>
    <script>
    $(document).ready(function(){
      $(document).on("click","#reset_btn",function(){
                    $(".reset_input_val").val("");
                });
    $('#frm').validate({
    rules:{
    organization:{
    required:true,
    },
    recg_title:{
    required:true,
    },
    year_of_recg:{
    required:true,
    },
    description:{
    // required:true,
    minlength:10,
    },

    },
    // messages:{
    //      qualification:{
    //         required:" Category name is mandatory",
    //     }
    // }
    submitHandler:function(form){
      check();
      form.submit();
    }
    });
      // jayatri 18-11-2021 for flagged words

      function check() {

          var badWords = [];
          @php
          $badwords = \DB::table('bad_words')->pluck('words')->toArray();
          @endphp
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


      }
      var textarea = $('.textarea_box');
      textarea.on({
          keyup: function(e) {
              if (e.which == 188) check();
              if (e.which == 32) check();
              // if (e.which == 13) check();
              // check();
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
    });
    </script>


    <script >
    function fun(id){
      $('.show-actions').slideUp();
      $("#show-action"+id).show();
      }
      function Cancel(id){
      $("#show-action"+id).hide();
      }
      $(document).mouseup(function(e)
      {
      var container = $(".show-actions");
      // if the target of the click isn't the container nor a descendant of the container
      if (!container.is(e.target) && container.has(e.target).length === 0)
      {
      container.hide();
      }
      });
    </script>
    <script>
      function readmore(id){
        //alert('j');
    $("#desc"+id).slideToggle("slow");
    $("#rr"+id).hide();
    $("#rrr"+id).show();
    $(".textLimit"+id).hide();

      }
      function readless(id){
        //alert('j');
    $("#desc"+id).slideToggle("slow");
    $("#rr"+id).show();
    $("#rrr"+id).hide();
    $(".textLimit"+id).show();

      }
    </script>
    {{-- jayatri for flageed words on 18-11-2021 --}}
<script type="text/javascript">
    function check() {
        var badWords = [];
        @php
        $badwords = \DB::table('bad_words')->pluck('words')->toArray();
        @endphp
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
</script>
    @endsection
