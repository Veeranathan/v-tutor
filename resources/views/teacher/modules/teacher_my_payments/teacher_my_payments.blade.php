@extends('layouts.app')
@section('title')
    <title>V-Tutor | Tutor | Payments </title>
@endsection
@section('left_part')
    @include('include.header_menu_part')
    {{-- for datatable --}}
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://kendo.cdn.telerik.com/2021.3.914/styles/kendo.default-main.min.css" />

    <script src="https://kendo.cdn.telerik.com/2021.3.914/js/jquery.min.js"></script>
    <style type="text/css">
        .table-head {
            display: flex;
            align-items: center;
            gap: 4px;
        }
    </style>
@endsection

@section('content')
    <section class="makes_special_sec faq-sec">
        <div class="makes_special_inr">
            <div class="top_mar"></div>
            <section class="user-account">
                <div class="container">
                    <div class="row">
                        <div class="zin">
                            @include('include.teacher_left_common'){{-- left common part --}}
                            <div
                                class="user-right-panel @if (@Auth::user()->status == 'AA') addDisablePhone pointerEventsNone @endif">
                                <div class="user-right-top-new tranhis">
                                    {{-- @include('include.errors') --}}
                                    <h2 class="profile-heading">Payments </h2>
                                    <p class="w-100">You can find information about your payments in this section</p>
                                    {{-- <div class="float-right" style="margin-right: 10px">
                                    <a class="deen @if (@$tot_payments <= 0) addDisablePhone pointerEventsNone @endif"
                                        href="{{ route('transaction.history') }}" style="color: white;">Transaction History</a>
                                </div> --}}
                                </div>
                                <form method="get" action="{{ route('download.tutor.my.payments') }}" id="frm">
                                    <div class="class-feild">
                                        <div class="row new_rows no-gutters">
                                            <div class="col-sm-6">
                                                <div class="form_box_area">
                                                    <div class="dash-d1 from_time_value book_f_t_v @if (@$tot_payments <= 0) addDisablePhone pointerEventsNone @endif"
                                                        data-column="1">
                                                        <label>From Date</label>
                                                        {{-- <div class="ui calendar" id="from"> --}}
                                                        {{-- <div class="ui input left icon"> --}}
                                                        <input type="text" placeholder="Select date" id="col1_filter"
                                                            name="from_date" autocomplete="off"
                                                            class="reset_val datepickeropen">
                                                        {{-- <span class="over_llp1"><img src="{{ public_asset('assets/images/cal.png')}}" alt=""></span> --}}
                                                        {{-- </div> --}}
                                                        {{-- </div> --}}
                                                        <span class="error error_col1_filter"></span>
                                                    </div>
                                                    <div class="dash-d1 from_time_value book_f_t_v @if (@$tot_payments <= 0) addDisablePhone pointerEventsNone @endif"
                                                        data-column="2">
                                                        <label>To Date</label>
                                                        {{-- <div class="ui calendar" id="to"> --}}
                                                        {{-- <div class="ui input left icon"> --}}
                                                        <input type="text" placeholder="Select date" id="col2_filter"
                                                            name="to_date" autocomplete="off"
                                                            class="reset_val datepickeropen">
                                                        {{-- <span class="over_llp1"><img src="{{ public_asset('assets/images/cal.png')}}" alt=""></span> --}}
                                                        {{-- </div> --}}
                                                        {{-- </div> --}}
                                                        <span class="error error_col2_filter"></span>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <a href="javascript:void(0);"
                                                    class="dash-btn rest_btn2 search_click @if (@$tot_payments <= 0) addDisablePhone pointerEventsNone @endif"><img
                                                        src="{{ public_asset('assets/images/ser.png') }}">Search</a>
                                                {{-- <button class="dash-btn search_click"> <img src="{{ public_asset('assets/images/ser.png')}}"> Search </button> --}}
                                            </div>
                                            <div class="col-sm-2">
                                                <a href="javascript:void(0)"
                                                    class="dash-btn rest_btn2 reset_search @if (@$tot_payments <= 0) addDisablePhone pointerEventsNone @endif">Reset
                                                </a>
                                                {{-- <a href="{{ route('student.my.payments') }}"  class="dash-btn rest_btn2"><img src="{{ public_asset('assets/images/ser.png') }}">Reset Search</a> --}}
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="submit" name=""
                                                    class="dash-btn @if (@$tot_payments <= 0) addDisablePhone pointerEventsNone @endif"
                                                    value="Download" id="dwnload">

                                            </div>
                                        </div>

                                    </div>
                                    <div class="user-right-top-new">
                                        <div class="main-tabels w-100">
                                            <!-- Nav tabs -->
                                            <div class="tab-rii">
                                                {{--
                                    <div class="float-right">
                                        <form method="post" action="{{route('student.class.export')}}">
                                            @csrf
                                            <input type="hidden" name="session" value="present">
                                            <input type="hidden" name="status" value="{{request('status')}}">
                                            <button class="deen" type="submit">Download</button>
                                        </form>
                                    </div>
                                    --}}
                                            </div>
                                            <!-- Tab panes -->
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="today">

                                                    <div class="custom-table">
                                                        {{-- start --}}
                                                        <table id="example" class="cell-border table table-responsive">
                                                            <thead>
                                                                <tr>
                                                                    <th>
                                                                        <div class="table-head">Booking ID <img
                                                                                src="{{ public_asset('assets/images/sort.png') }}">
                                                                        </div>
                                                                    </th>
                                                                    <th>
                                                                        <div class="table-head">Tutor <img
                                                                                src="{{ public_asset('assets/images/sort.png') }}">
                                                                        </div>
                                                                    </th>
                                                                    <th class="white_space_nowrap">
                                                                        <div class="table-head">Date <img
                                                                                src="{{ public_asset('assets/images/sort.png') }}">
                                                                        </div>
                                                                    </th>
                                                                    <th class="white_space_nowrap">
                                                                        <div class="table-head">Time <img
                                                                                src="{{ public_asset('assets/images/sort.png') }}">
                                                                        </div>
                                                                    </th>
                                                                    <th>
                                                                        <div class="table-head">Grade <img
                                                                                src="{{ public_asset('assets/images/sort.png') }}">
                                                                        </div>
                                                                    </th>
                                                                    <th>
                                                                        <div class="table-head">Subject <img
                                                                                src="{{ public_asset('assets/images/sort.png') }}">
                                                                        </div>
                                                                    </th>
                                                                    <th>
                                                                        <div class="table-head">Status <img
                                                                                src="{{ public_asset('assets/images/sort.png') }}">
                                                                        </div>
                                                                    </th>
                                                                    <th>
                                                                        <div class="table-head">Amount <img
                                                                                src="{{ public_asset('assets/images/sort.png') }}">
                                                                    </th>
                                                                    <th> <img
                                                                            src="{{ public_asset('assets/images/sort.png') }}">
                                                                    </th>
                                                                    {{-- <th >Transaction ID <img src="{{ public_asset('assets/images/sort.png')}}"></th> --}}
                                                                    {{-- <th >Invoice ID<img src="{{ public_asset('assets/images/sort.png')}}"></th> --}}
                                                                    {{-- <th></th> --}}
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                {{-- @if (@$myPayments)
                                                    @foreach (@$myPayments as $key => $val)
                                                    <tr>
                                                        <td data-label="Name">
                                                            {{@$val->booking_no}}
                                                        </td>
                                                        <td data-label="Name"> {{date('Y.m.d', strtotime(@$val->booking_date))}}</td>
                                                        <td data-label="Name">{{@$val->getStudentGrade->grade_name}}</td>
                                                        <td data-label="Name">{{@$val->getSubject->subject}}</td>
                                                        <td data-label="Name">{{@$val->getTutor->f_name}}  {{@$val->getTutor->l_name}}</td>
                                                        <td data-label="Name">
                                                            ${{@$val->booking_amount}}
                                                        </td>
                                                        <td data-label="Name">
                                                            {{@$val->getPaymentsInfo->txn_id}}
                                                        </td>
                                                        <td data-label="Name">
                                                            {{@$val->getPaymentsInfo->invoice_id}}
                                                        </td>
                                                        <td>
                                                            <div class="add_ttrr actions-main">
                                                                <a href="javascript:void(0);" class="action-dots"  id="action{{$val->id}}"><img src="{{ public_asset('assets/images/action-dots.png')}}" alt="" onclick="fun({{$val->id}})"></a>
                                                                <div class="show-actions" id="show-action{{$val->id}}" style="display: none;">
                                                                    <span class="angle"><img src="{{ public_asset('assets/images/angle.png')}}" alt=""></span>
                                                                    <ul>
                                                                        <li><a href="#">Download Invoice</a></li>
                                                                    </ul>
                                                                </div>

                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    @endif --}}
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                {{-- end --}}
                                                <div class="testPro">
                                                    {{-- <div class="proDiv">
                                            <h6>Please note:</h6>
                                            <p>1. You may click to join the session at your scheduled time. The tutor or meeting link may not be available in case you join early.</p>
                                            <p>2. You need an active Zoom account to join classes. If you don’t have one already, kindly create one and stay logged in.</p>
                                            <p>3. In case you fail to join the class within 10 minutes from the start time, it will be considered as ‘no show’ and you stand to forfeit charges for the session</p>
                                            <p>4. Session timings are fixed and cannot be extended for any reasons, though legitimate. If the session is interrupted due to technical reasons from tutor’s end or due to unavailability of the learning platform, the session will be considered as ‘cancelled’ and session charges would be refunded.</p>
                                        </div> --}}
                                                </div>
                                            </div>
                                            {{-- table panel end --}}
                                        </div>
                                    </div>
                            </div>
                            </form>
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

    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    {{-- for validation --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"
        integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg=="
        crossorigin="anonymous"></script>

    <script type="text/javascript">
        function filterColumn(i) {
            $('#example').DataTable().column(i).search(
                $('#col' + i + '_filter').val(),
            ).draw();
        }
        // oTable = $('#example').DataTable({
        // "pageLength":10,
        // "order": [
        //         [0, "desc"]
        // ]
        // });
        // student.g.my.payments
        var oTable = $('#example').DataTable({
            stateSave: false,
            // "pageLength":2,
            "order": [
                [2, "desc"]
            ],
            "language": {
                "emptyTable": "No data available",
                "info": "",
                "infoEmpty": "",
                "infoFiltered": "" 
            },
            dom: '<"top"f>t<"bottom row"<"col-12 d-flex justify-content-end"p>>',
            "stateLoadParams": function(settings, data) {
                // $('#col1_filter').val(data.search.grade_name);
            },
            stateSaveParams: function(settings, data) {
                // data.search.grade_name = $('#col1_filter').val();
            },
            "processing": true,
            "serverSide": true,
            'serverMethod': 'post',
            "createdRow": function(row, data, dataIndex) {
                // var id = (JSON.stringify(data.id)),
                // r = JSON.stringify(dataIndex);
                // $(row).addClass("tr_class_"+id);
                // $(row).addClass("table");
                // $(row).children(':nth-child(1)').addClass('rm07');
                $(row).children(':nth-child(3)').addClass('white_space_nowrap');
                $(row).children(':nth-child(4)').addClass('white_space_nowrap');
                // $(row).children(':nth-child(3)').attr('data-id',r);
            },
            "ajax": {
                "url": "{{ route('tutor.g.my.payments') }}",
                "data": function(d) {
                    console.log(d);
                    d.myKey = "myValue";
                    d._token = "{{ @csrf_token() }}";
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Do something here
                    console.log("'error in datatable");
                }
            },
            'columns': [{
                    data: "booking_no",
                    render: function(data, type, full, meta) {
                        return data;
                    }
                },
                {
                    data: "booking_no",
                    render: function(data, type, full, meta) {
                        return full.get_tutor.f_name + " " + full.get_tutor.l_name;
                    }
                },

                {
                    data: "booking_date",
                    render: function(data, type, full, meta) {
                        if (full.booking_date != null) {
                            var date = new Date(full.booking_date);
                            var day = date.getDate();
                            var month = date.getMonth();
                            var year = date.getFullYear();
                            // var booking_date = year+'-'+("0" + (month+ 1)).slice(-2)+'-'+("0" + day).slice(-2);
                            var booking_date = ("0" + day).slice(-2) + '-' + ("0" + (month + 1)).slice(-2) +
                                '-' + year;
                            return booking_date;
                        } else {
                            return ' ';
                        }
                        return data;
                    }
                },
                {
                    data: "booking_no",
                    render: function(data, type, full, meta) {
                        if (full.booking_date) {
                            var date = new Date(full.booking_date);
                            var day = date.getDate();
                            var month = date.getMonth();
                            var year = date.getFullYear();
                            // var booking_date = year+'-'+("0" + (month+ 1)).slice(-2)+'-'+("0" + day).slice(-2);
                            var booking_date = ("0" + day).slice(-2) + '-' + ("0" + (month + 1)).slice(-2) +
                                '-' + year;

                            date = new Date(full.booking_date + " " + full.from_time);
                            var hours = date.getHours();
                            var minutes = date.getMinutes();
                            var ampm = hours >= 12 ? 'pm' : 'am';
                            hours = hours % 12;
                            hours = hours ? hours : 12; // the hour '0' should be '12'
                            minutes = minutes < 10 ? '0' + minutes : minutes;
                            var strFromTime = hours + ':' + minutes + ' ' + ampm;


                            date = new Date(full.booking_date + " " + full.to_time);
                            hours = date.getHours();
                            minutes = date.getMinutes();
                            ampm = hours >= 12 ? 'pm' : 'am';
                            hours = hours % 12;
                            hours = hours ? hours : 12; // the hour '0' should be '12'
                            minutes = minutes < 10 ? '0' + minutes : minutes;
                            var strToTime = hours + ':' + minutes + ' ' + ampm;

                            return " " + strFromTime + " - " + strToTime;
                        } else {
                            return ' ';
                        }
                    }
                },
                {
                    data: "student_grade_id",
                    render: function(data, type, full, meta) {
                        return full.get_student_grade.grade_name;
                    }
                },
                {
                    data: "subject_id",
                    render: function(data, type, full, meta) {
                        return full.get_subject.subject;
                    }
                },
                {
                    data: "booking_status",
                    render: function(data, type, full, meta) {
                        // if(data == 'B'){
                        //     return "Booked";
                        // }
                        // if(data == 'C'){
                        //     return "Cancelled";
                        // }
                        // if(data == 'CM'){
                        //     return "Completed";
                        // }
                        // return data;
                        var ch = data;
                        /*if (data == 'B') {
                            ch = "Booked";
                        }
                        if (data == 'C') {
                            ch = "Cancelled";
                        }*/
                        if (data == 'CM' && full.class_assessment_student == 'N') {
                            ch = "Review";
                        }
                        if (data == 'CM' && full.class_assessment_student == 'Y') {
                            ch = "Completed";
                        }
                        var sp = '<span class="Booked">' + ch + '</span>';
                        /* if (full.booking_status == 'B') {
                             var sp = '<span class="Booked">' + ch + '</span>';
                         }
                         if (full.booking_status == 'C') {
                             var sp = '<span class="cancelled_red_color">' + ch + '</span>';
                         }*/
                        if (full.booking_status == 'CM' && full.class_assessment_student == 'N') {

                            var sp =
                                '<span class="cancelled_red_color"><a class="cancelled_red_color" href="tutor-class-end-assesment/' +
                                full.booking_no + '">' + ch + '</a></span>';
                        }
                        if (full.booking_status == 'CM' && full.class_assessment_student == 'Y') {

                            var sp = '<span class="completed_green_color">' + ch + '</span>';
                        }
                        return sp;
                    }
                },
                {
                    data: "tutor_earnings",
                    render: function(data, type, full, meta) {
                        // if(full.booking_status == 'C'){
                        //     if(full.get_payments_info != null){
                        //         var refund_amount = full.get_payments_info.refund_amount;
                        //         return '$'+data+' ( $'+refund_amount+' refunded )';
                        //     }else{
                        //         return '$'+data;
                        //     }

                        // }else{
                        //     return '$'+data;
                        // }
                        return '$' + data;
                        // return '$'+data;
                    }
                },
                // {
                //     data: "id",
                //     render: function(data, type, full, meta){
                //         if(full.get_payments_info != null){
                //             if(full.get_payments_info.txn_id != null){
                //                 return full.get_payments_info.txn_id;
                //             }else{
                //                 return '';
                //             }
                //         }else{
                //             return '';
                //         }


                //     }
                // },
                // {
                //     data: "id",
                //     render: function(data, type, full, meta){
                //         if(full.get_payments_info != null){
                //             if(full.get_payments_info.invoice_id != null){
                //                 return full.get_payments_info.invoice_id;
                //             }else{
                //                 return '';
                //             }
                //         }else{
                //             return '';
                //         }
                //     }
                // },
                {
                    data: "id",
                    render: function(data, type, full, meta) {
                        var a = '';
                        a += '<div class="add_ttrr actions-main">\n\
                                                <a href="javascript:void(0);" class="action-dots"  id="action' + full.id +
                            '"><img src="{{ public_asset('assets/images/action-dots.png') }}" alt="" onclick="fun(' +
                            full.id + ')"></a>\n\
                                                <div class="show-actions" id="show-action' + full.id + '" style="display: none;">\n\
                                                    <span class="angle"><img src="{{ public_asset('assets/images/angle.png') }}" alt=""></span>\n\
                                                    <ul>\n\
                                                        <li><a href="{{ url('/tutor/teacher-view-class-booking') }}' +
                            '/' +
                            full
                            .booking_no + '">View Details</a></li>\n\
                                                    </ul>\n\
                                                </div>\n\
                                                \n\
                                            </div>';
                        return a;
                    }
                },
            ]
        });

        if (oTable.rows().data().length === 0) {
            $(oTable.table().container())
                .find('.dataTables_paginate')
                .hide();
        }
        
        document.addEventListener("DOMContentLoaded", function() {
            // Replace Semantic UI calendar & Kendo DatePickers with Flatpickr
            flatpickr("#from", {
                dateFormat: "Y-m-d"
            });

            flatpickr("#to", {
                dateFormat: "Y-m-d"
            });

            const userCreatedAt = new Date({{ strtotime(Auth::user()->created_at) }} * 1000); // min date

            flatpickr("#col1_filter", {
                dateFormat: "Y-m-d",
                minDate: userCreatedAt,
                allowInput: true
            });

            flatpickr("#col2_filter", {
                dateFormat: "Y-m-d",
                minDate: userCreatedAt,
                allowInput: true
            });

            // Open Flatpickr manually on click
            document.querySelector("#col1_filter").addEventListener("click", function() {
                this._flatpickr.open();
            });

            document.querySelector("#col2_filter").addEventListener("click", function() {
                this._flatpickr.open();
            });

            // Also for dynamic element using .k-select
            $(document).on("click", ".k-select", function() {
                var obj = $(this).parent().find(".start_end_time");
                obj[0]._flatpickr.open();
            });

            // Reset filters
            $('body').on('click', '.reset_search', function() {
                $(".reset_val").val(""); // clear inputs
                $('#example').DataTable().search('').columns().search('').draw();
            });

            // Apply filters on search click
            $('body').on('click', '.search_click', function() {
                var col1_filter = $("#col1_filter").val(),
                    col2_filter = $("#col2_filter").val();

                $(".error_col1_filter, .error_col2_filter").html(""); // clear previous errors

                if (col1_filter && col2_filter) {
                    filterColumn(1);
                    filterColumn(2);
                } else {
                    if (!col1_filter) {
                        $(".error_col1_filter").html("This field is required");
                    }
                    if (!col2_filter) {
                        $(".error_col2_filter").html("This field is required");
                    }
                }
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
@endsection
