@extends('layouts.app')
@section('title')
    <title>V-Tutor | Student | My review </title>
@endsection
@section('left_part')
    {{-- @include('include.student_top_common') --}}
@include('include.header_menu_part')
    {{-- for datatable --}}
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
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
                            @include('include.student_left_common'){{-- left common part --}}
                            <div class="user-right-panel tutor-right">



                                <div class="turo-edit">

                                    <div class="user-right-top">
                                        @include('include.errors')
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
                                                                <span class="d-flex align-items-center justify-content-start gap-2">
                                                                    Tutor <div class="sort_img"> <img
                                                                            src="{{ public_asset('assets/images/sort.png') }}">
                                                                    </div>
                                                                </span>
                                                            </th>
                                                            <th>
                                                                <span class="d-flex align-items-center justify-content-start gap-2">
                                                                    Review Date <div class="sort_img"> <img
                                                                            src="{{ public_asset('assets/images/sort.png') }}">
                                                                    </div>
                                                                </span>
                                                            </th>
                                                            <th style="white-space: nowrap;">

                                                                <span class="d-flex align-items-center justify-content-start gap-2">
                                                                    Rating <div class="sort_img"> <img
                                                                            src="{{ public_asset('assets/images/sort.png') }}">
                                                                    </div>
                                                                </span>
                                                            </th>
                                                            <th>
                                                                <span class="d-flex align-items-center justify-content-start gap-2">
                                                                    Comments <div class="sort_img"> <img
                                                                            src="{{ public_asset('assets/images/sort.png') }}">
                                                                    </div>
                                                                </span>
                                                            </th>

                                                            <th> </th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($reviews as $key => $val)
                                                            <tr>

                                                                <td data-label="Name">
                                                                    {{ @$val->tutor->f_name }} {{ @$val->tutor->l_name }}
                                                                </td>

                                                                <td data-label="Name">
                                                                    {{ date('d.m.Y', strtotime(@$val->created_at)) }} </td>

                                                                <td data-label="Name" style="white-space: nowrap;">
                                                                    <div class="d-flex align-items-center">
                                                                    {{-- for gold star --}}
                                                                    @for ($i = 0; $i <= @$val->ratting - 1; $i++)
                                                                        <a href="#url"><img
                                                                                src="{{ public_asset('assets/images/star.png') }}"></a>
                                                                    @endfor
                                                                    {{-- blank --}}
                                                                    @for ($i = 0; $i < 5 - @$val->ratting; $i++)
                                                                        <a href="#url"><img
                                                                                src="{{ public_asset('assets/images/star1.png') }}"></a>
                                                                    @endfor
                                                                        </div>
                                                                </td>
                                                                <td data-label="Name">
                                                                    <p class="add_ttrr desi">{{ substr(@$val->message, 0, 120) }}</p>
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
                                                                            style="display: none;"> <span class="angle"><img
                                                                                    src="{{ public_asset('assets/images/angle.png') }}"
                                                                                    alt=""></span>
                                                                            <ul>
                                                                                <li><a onclick="return confirm('Are you sure you want to delete?')"
                                                                                        href="{{ route('student.del.review', $val->id) }}">Delete</a>
                                                                                </li>

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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"
        integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg=="
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/localization/messages_he.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#frm').validate({
                ignore: "",
                rules: {
                    ratting: {
                        required: true,
                        //minlength:3
                    },

                    message: {
                        required: true,

                    },


                },
                messages: {

                    ratting: {
                        required: "This field is required",
                        //minlength:3
                    },
                    text: {
                        required: "This field is required",
                    },

                }
                /////////


            });

        });
    </script>

    <script type="text/javascript">
        function fair(id) {
            console.log(id);
            if (id == 1) {
                document.getElementById('f1').src = '{{ public_asset('assets/images/rating/rating1.png') }}';
                document.getElementById('f2').src = '{{ public_asset('assets/images/rating/rating2.png') }}';
                document.getElementById('f3').src = '{{ public_asset('assets/images/rating/rating2.png') }}';
                document.getElementById('f4').src = '{{ public_asset('assets/images/rating/rating2.png') }}';
                document.getElementById('f5').src = '{{ public_asset('assets/images/rating/rating2.png') }}';
                $('#ratting').val(id);
            }
            if (id == 2) {
                document.getElementById('f1').src = '{{ public_asset('assets/images/rating/rating1.png') }}';
                document.getElementById('f2').src = '{{ public_asset('assets/images/rating/rating1.png') }}';
                document.getElementById('f3').src = '{{ public_asset('assets/images/rating/rating2.png') }}';
                document.getElementById('f4').src = '{{ public_asset('assets/images/rating/rating2.png') }}';
                document.getElementById('f5').src = '{{ public_asset('assets/images/rating/rating2.png') }}';
                $('#ratting').val(id);
            }
            if (id == 3) {
                document.getElementById('f1').src = '{{ public_asset('assets/images/rating/rating1.png') }}';
                document.getElementById('f2').src = '{{ public_asset('assets/images/rating/rating1.png') }}';
                document.getElementById('f3').src = '{{ public_asset('assets/images/rating/rating1.png') }}';
                document.getElementById('f4').src = '{{ public_asset('assets/images/rating/rating2.png') }}';
                document.getElementById('f5').src = '{{ public_asset('assets/images/rating/rating2.png') }}';
                $('#ratting').val(id);
            }
            if (id == 4) {
                document.getElementById('f1').src = '{{ public_asset('assets/images/rating/rating1.png') }}';
                document.getElementById('f2').src = '{{ public_asset('assets/images/rating/rating1.png') }}';
                document.getElementById('f3').src = '{{ public_asset('assets/images/rating/rating1.png') }}';
                document.getElementById('f4').src = '{{ public_asset('assets/images/rating/rating1.png') }}';
                document.getElementById('f5').src = '{{ public_asset('assets/images/rating/rating2.png') }}';
                $('#ratting').val(id);
            }
            if (id == 5) {
                document.getElementById('f1').src = '{{ public_asset('assets/images/rating/rating1.png') }}';
                document.getElementById('f2').src = '{{ public_asset('assets/images/rating/rating1.png') }}';
                document.getElementById('f3').src = '{{ public_asset('assets/images/rating/rating1.png') }}';
                document.getElementById('f4').src = '{{ public_asset('assets/images/rating/rating1.png') }}';
                document.getElementById('f5').src = '{{ public_asset('assets/images/rating/rating1.png') }}';
                $('#ratting').val(id);
            }

        }
    </script>

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
