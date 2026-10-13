@extends('layouts.app')
@section('title')
    <title>V-Tutor | Tutor | My Review</title>
@endsection
@section('left_part')
    @include('include.header_menu_part')
    {{-- for datatable --}}
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <style type="text/css">
        .table-head {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .start-flex {
            display: flex;
            align-items: center
        }

        .description-wdth {
            width: 40%;
        }

        .table-content {
            vertical-align: baseline !important;
        }
    </style>
@endsection

@section('content')
    <section class="makes_special_sec faq-sec">
        <div class="makes_special_inr">
            <!-- bannersec -->
            <div class="top_mar"></div>
            <!--- profile --->
            <section class="user-account">
                <div class="container">
                    <div class="row">
                        <div class="zin">
                            @include('include.teacher_left_common'){{-- left common part --}}
                            {{--  addDisablePhone pointerEventsNone --}}
                            <div class="user-right-panel tutor-right">



                                <div class="turo-edit">

                                    <div class="user-right-top">
                                        <h2 class="profile-heading">Reviews</h2>
                                        <p>You can find information about your ratings and reviews in this section</p>



                                    </div>
                                    <div class="user-right-top">
                                        <div class="main-tabels">
                                            <!-- Nav tabs -->

                                            <!-- Tab panes -->

                                            <div class="custom-table">
                                                {{-- start --}}
                                                <table id="example" class="cell-border table table-responsive">
                                                    <thead>
                                                        <tr>

                                                            <th>
                                                                <div class="table-head">Student <img
                                                                        src="{{ public_asset('assets/images/sort.png') }}">
                                                                </div>
                                                            </th>
                                                            <th>
                                                                <div class="table-head">Review Date <img
                                                                        src="{{ public_asset('assets/images/sort.png') }}">
                                                                </div>
                                                            </th>
                                                            <th>
                                                                <div class="table-head">Rating <img
                                                                        src="{{ public_asset('assets/images/sort.png') }}">
                                                                </div>
                                                            </th>
                                                            <th class="description-wdth">
                                                                <div class="table-head">Comments <img
                                                                        src="{{ public_asset('assets/images/sort.png') }}">
                                                                </div>
                                                            </th>

                                                            <th> </th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($reviews as $key => $val)
                                                            <tr>

                                                                <td class="table-content" data-label="Name">
                                                                    {{ @$val->student->f_name }}
                                                                    {{ @$val->student->l_name }}
                                                                </td>

                                                                <td class="table-content" data-label="Name">
                                                                    {{ date('d.m.Y', strtotime(@$val->created_at)) }} </td>

                                                                <td class="table-content" data-label="Name ">
                                                                    <div class="start-flex">
                                                                        {{-- for gold star --}}
                                                                        @for ($i = 0; $i <= @$val->ratting - 1; $i++)
                                                                            <a href="#url"><img
                                                                                    src="{{ public_asset('assets/images/star.png') }}"
                                                                                    style="width: 10px"></a>
                                                                        @endfor
                                                                        {{-- blank --}}
                                                                        @for ($i = 0; $i < 5 - @$val->ratting; $i++)
                                                                            <a href="#url"><img
                                                                                    src="{{ public_asset('assets/images/star1.png') }}"
                                                                                    style="width: 10px"></a>
                                                                        @endfor
                                                                    </div>
                                                                </td>
                                                                {{--  <td data-label="Name">{{@$val->message}}</td> --}}
                                                                <td class="table-content" data-label="Name">
                                                                    <p class="add_ttrr desi">
                                                                        {{ substr(@$val->message, 0, 120) }}</p>
                                                                    <a class="{{-- moreless-button2 --}}  allread"
                                                                        onclick="readmore({{ $val->id }})"
                                                                        id="rr{{ $val->id }}">Read More +</a>
                                                                    <p class="moretext2 desi" style="display: none;"
                                                                        id="desc{{ $val->id }}">
                                                                        {{ substr(@$val->message, 120) }}
                                                                        <a class="{{-- moreless-button2 --}}  allread"
                                                                            style="display: none;"
                                                                            onclick="readless({{ $val->id }})"
                                                                            id="rrr{{ $val->id }}">Read less -</a>
                                                                    </p>
                                                                </td>


                                                                <td>
                                                                    <div class="add_ttrr actions-main">
                                                                        <a href="javascript:void(0);" class="action-dots"
                                                                            id="action{{ $val->id }}"><img
                                                                                src="{{ public_asset('assets/images/action-dots.png') }}"
                                                                                alt=""
                                                                                onclick="fun({{ $val->id }})"></a>
                                                                        <div class="show-actions"
                                                                            id="show-action{{ $val->id }}"
                                                                            style="display: none;"> <span
                                                                                class="angle"><img
                                                                                    src="{{ public_asset('assets/images/angle.png') }}"
                                                                                    alt=""></span>
                                                                            <ul>
                                                                                <li><a
                                                                                        href="{{ route('review.details', $val->id) }}">View
                                                                                        Review</a></li>

                                                                            </ul>
                                                                        </div>
                                                                        {{-- <div class="add_ttrr actions-main"> --}}
                                                                        {{-- <a href="javascript:void(0);" class="action-dots"  id="action{{$val->id}}"><img src="{{ public_asset('assets/images/action-dots.png')}}" alt="" onclick="fun({{$val->id}})"></a>
                                                                <div class="show-actions" id="show-action{{$val->id}}" style="display: none;"> <span class="angle"><img src="{{ public_asset('assets/images/angle.png')}}" alt=""></span>
                                                                <ul> --}}
                                                                        {{--  <li><a href="{{route('aced.edit.page',$val->id)}}">Edit</a></li>
                                                                    <li><a onclick="return confirm('Are you sure want to delete this?')" href="{{route('aced.dlt',$val->id)}}">Delete</a></li> --}}
                                                                        {{-- </ul>
                                                                    --}}


                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach

                                                    </tbody>
                                                </table>

                                            </div>





                                        </div>
                                        <div class="clearfix"></div>
                                    </div>

                                </div>
                            </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"
        integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg=="
        crossorigin="anonymous"></script>
    <script>
        oTable = $('#example').DataTable({
            "pageLength": 10,
            "language": {
                "emptyTable": "No data available",
                "info": "",
                "infoEmpty": "",
                "infoFiltered": "" 
            },
            dom: '<"top"f>t<"bottom row"<"col-12 d-flex justify-content-end"p>>',
        });
        if (oTable.rows().data().length === 0) {
            $(oTable.table().container())
                .find('.dataTables_paginate')
                .hide();
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#frm').validate({
                rules: {
                    qualification: {
                        required: true,
                    },
                    field_of_study: {
                        required: true,
                    },
                    university: {
                        required: true,
                    },
                    qualification_status: {
                        required: true,
                    },
                    effective_date: {
                        required: true,
                    }
                },
                // messages:{
                //      qualification:{
                //         required:" Category name is mandatory",
                //     }
                // }
            });
        });
    </script>
    <script>
        function fun(id) {
            $('.show-actions').slideUp();
            $("#show-action" + id).show();
        }

        function Cancel(id) {
            $("#show-action" + id).hide();
        }
        $(document).mouseup(function(e) {
            var container = $(".show-actions");
            // if the target of the click isn't the container nor a descendant of the container
            if (!container.is(e.target) && container.has(e.target).length === 0) {
                container.hide();
            }
        });
    </script>


    {{--  <script>
//var d = new Date();
$('#frm').validate({
    submitHandler: function (form) {
      var val1 = new Date($('#from_date').val());
      var val2 = new Date($('#to_date').val());


console.log($('#from').val());
console.log(val2);
//return false;

         if(val1 == "Invalid Date" && val2 == "Invalid Date") {
          alert("select both dates");
        return false;

      }
       else if(val1 == "Invalid Date" && val2 != "Invalid Date" ) {
         alert("select from date");
           return false;
      }
       else if(val1 != "Invalid Date" && val2 == "Invalid Date" ) {
          alert("select to date");
           return false;
      }
       else if(val1 > val2) {
        console.log('max');
        console.log(val1);
        console.log(val2);

        alert('From date cannot be greater than to date');
      }
       else{
         form.submit();
      }

    }
  });
 </script> --}}

    {{--  <script >
    $('#from').calendar({
  type: 'date',
   maxDate:new Date({{strtotime(date('Y-m-d H:i:s') . "-1 days")}}*1000),
});
</script>
<script >
    $('#to').calendar({
  type: 'date',
   maxDate:new Date({{strtotime(date('Y-m-d H:i:s') . "-1 days" )}}*1000),
});
</script> --}}
    <script>
        function readmore(id) {
            //alert('j');
            $("#desc" + id).slideToggle("slow");
            $("#rr" + id).hide();
            $("#rrr" + id).show();

        }

        function readless(id) {
            //alert('j');
            $("#desc" + id).slideToggle("slow");
            $("#rr" + id).show();
            $("#rrr" + id).hide();

        }
    </script>
@endsection
