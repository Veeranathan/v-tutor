@extends('layouts.app')
@section('title')
    <title>V-Tutor | Student | Payments </title>
@endsection
@section('left_part')
    {{-- @include('include.student_top_common') --}}
    @include('include.header_menu_part')
    {{-- for datatable --}}
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://kendo.cdn.telerik.com/2021.3.914/styles/kendo.default-main.min.css" />

    <script src="https://kendo.cdn.telerik.com/2021.3.914/js/jquery.min.js"></script>
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
                        <div class="user-right-panel">
                            <div class="user-right-top-new ">
                                {{-- @include('include.errors') --}}
                                <h2 class="profile-heading">Payments </h2>
                                <p class="gj_sub_hd">You can find information about your payments in this section</p>
                            </div>
                            <form method="get" action="{{ route('student.ga.my.payments') }}" id="frm">
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
                                                        class="reset_val datepickeropen start_end_time">

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
                                                        class="reset_val datepickeropen start_end_time">
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
                                    <div class="main-tabels">
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
                                                <div class="float-right">

                                                    {{-- <a href="#" class="deen" id="download_my_payments">Download</a> --}}
                                                    {{-- <button class="deen" type="submit">Download</button> --}}

                                                    {{-- <a href="#" class="deen" id="download_my_payments">Download</a> --}}
                                                </div>
                                                <div class="custom-table">
                                                    {{-- start --}}
                                                    <table id="example" class="cell-border table table-responsive">
                                                        <thead>
                                                            <tr>
                                                                <th>
                                                                    <span
                                                                        class="d-flex align-items-center justify-content-start gap-2">
                                                                        Booking ID <div class="sort_img"> <img
                                                                                src="{{ public_asset('assets/images/sort.png') }}">
                                                                        </div>
                                                                    </span>
                                                                </th>
                                                                <th>
                                                                    <span
                                                                        class="d-flex align-items-center justify-content-start gap-2">
                                                                        Tutor<div class="sort_img"> <img
                                                                                src="{{ public_asset('assets/images/sort.png') }}">
                                                                        </div>
                                                                    </span>
                                                                </th>
                                                                {{-- <th class="white_space_nowrap">Session Date <img
                                                                        src="{{ public_asset('assets/images/sort.png') }}"></th>
                                                                <th class="white_space_nowrap">Session Time <img
                                                                        src="{{ public_asset('assets/images/sort.png') }}"></th> --}}
                                                                <th>
                                                                    <span
                                                                        class="d-flex align-items-center justify-content-start gap-2">
                                                                        Grade<div class="sort_img"> <img
                                                                                src="{{ public_asset('assets/images/sort.png') }}">
                                                                        </div>
                                                                    </span>
                                                                </th>
                                                                <th>
                                                                    <span
                                                                        class="d-flex align-items-center justify-content-start gap-2">
                                                                        Subject<div class="sort_img"> <img
                                                                                src="{{ public_asset('assets/images/sort.png') }}">
                                                                        </div>
                                                                    </span>
                                                                </th>
                                                                <th>
                                                                    <span
                                                                        class="d-flex align-items-center justify-content-start gap-2">
                                                                        Status<div class="sort_img"> <img
                                                                                src="{{ public_asset('assets/images/sort.png') }}">
                                                                        </div>
                                                                    </span>
                                                                </th>
                                                                <th>
                                                                    <span
                                                                        class="d-flex align-items-center justify-content-start gap-2">
                                                                        Amount<div class="sort_img"> <img
                                                                                src="{{ public_asset('assets/images/sort.png') }}">
                                                                        </div>
                                                                    </span>
                                                                </th>
                                                                <th>
                                                                    <span
                                                                        class="d-flex align-items-center justify-content-start gap-2">
                                                                        Booked On<div class="sort_img"> <img
                                                                                src="{{ public_asset('assets/images/sort.png') }}">
                                                                        </div>
                                                                    </span>
                                                                </th>
                                                                <th> <img src="{{ public_asset('assets/images/sort.png') }}">
                                                                </th>


                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            {{-- end --}}
                                            {{-- <div class="testPro">
                                                <div class="proDiv px-2">
                                                    <h6>Please note:</h6>
                                                    <p>1. You may click to join the session at your scheduled time. The tutor or
                                                        meeting link may not be available in case you join early.</p>
                                                    <p>2. You need an active Zoom account to join sessions. If you don’t have
                                                        one already, kindly create one and stay logged in.</p>
                                                    <p>3. In case you fail to join the session within 10 minutes from the start
                                                        time, it will be considered as ‘no show’ and you stand to forfeit
                                                        charges for the session</p>
                                                    <p>4. Session timings are fixed and cannot be extended for any reasons,
                                                        though legitimate. If the session is interrupted due to technical
                                                        reasons from tutor’s end or due to unavailability of the learning
                                                        platform, the session will be considered as ‘cancelled’ and session
                                                        charges would be refunded.</p>
                                                </div>
                                            </div> --}}
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
    <script src="https://kendo.cdn.telerik.com/2021.3.914/js/kendo.all.min.js"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
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

        function formatTime(timeStr) {
            if (!timeStr) return '';
            const [hour, minute] = timeStr.split(':');
            const h = parseInt(hour);
            const suffix = h >= 12 ? 'PM' : 'AM';
            const hour12 = ((h + 11) % 12 + 1); // converts 0-23 to 1-12
            return hour12 + ':' + minute + ' ' + suffix;
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

                // $(row).children(':nth-child(7)').addClass('test_color');
                // $(row).children(':nth-child(3)').attr('data-id',r);
            },
            "ajax": {
                "url": "{{ route('student.g.my.payments') }}",
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
                // {
                //     data: "booking_date", // Date Column
                //     render: function(data, type, full, meta) {
                //         if (!data) return '';
                //         let dateObj = new Date(data);
                //         return dateObj.toLocaleDateString('en-AU', {
                //             year: 'numeric',
                //             month: 'short',
                //             day: '2-digit'
                //         });
                //     }
                // },
                // {
                //     data: "from_time_user", // Time Column
                //     render: function(data, type, full, meta) {
                //         if (!data || !full.to_time_user) return '';
                //         let fromTime = new Date(full.from_time_user);
                //         let toTime = new Date(full.to_time_user);
                //         return `${fromTime.toLocaleTimeString('en-AU', { hour: '2-digit', minute: '2-digit' })} - ${toTime.toLocaleTimeString('en-AU', { hour: '2-digit', minute: '2-digit' })}`;
                //     }
                // },


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
                        var ch = data;
                        if (data == 'B') {
                            ch = "Booked";
                        }
                        if (data == 'C') {
                            ch = "Cancelled";
                        }
                        if (data == 'CM' && full.class_assessment_student == 'N') {
                            ch = "Review";
                        }
                        if (data == 'CM' && full.class_assessment_student == 'Y') {
                            ch = "Completed";
                        }
                        var sp = '<span class="Booked">' + ch + '</span>';
                        if (full.booking_status == 'B') {
                            var sp = '<span class="Booked">' + ch + '</span>';
                        }
                        if (full.booking_status == 'C') {
                            var sp = '<span class="cancelled_red_color">' + ch + '</span>';
                        }
                        if (full.booking_status == 'CM' && full.class_assessment_student == 'N') {

                            var sp =
                                '<span class="cancelled_red_color"><a class="cancelled_red_color" href="student-class-end-assesment/' +
                                full.booking_no + '">' + ch + '</a></span>';
                        }
                        if (full.booking_status == 'CM' && full.class_assessment_student == 'Y') {

                            var sp = '<span class="completed_green_color">' + ch + '</span>';
                        }
                        return sp;
                    }
                },
                {
                    data: "booking_amount",
                    render: function(data, type, full, meta) {
                        total = parseFloat(full.booking_amount) + parseFloat(full.stripe_charge);
                        if(full.net_total) {
                            total = parseFloat(full.net_total);
                        }

                        return '$' + total.toFixed(2);
                    }
                },
                {
                    data: "created_at", // Date Column
                    render: function(data, type, full, meta) {
                        if (!data) return '';
                        let dateObj = new Date(data);
                        return dateObj.toLocaleDateString('en-AU', {
                            year: 'numeric',
                            month: 'short',
                            day: '2-digit'
                        });
                    }
                },

                {
                    data: "id",
                    render: function(data, type, full, meta) {
                        var a = '';
                        a += '<div class="add_ttrr actions-main">\n\
                                                                <a href="javascript:void(0);" class="action-dots"  id="action' +
                            full
                            .id +
                            '"><img src="{{ public_asset('assets/images/action-dots.png') }}" alt="" onclick="fun(' +
                            full.id + ')"></a>\n\
                                                                <div class="show-actions" id="show-action' + full.id +
                            '" style="display: none;">\n\
                                                                    <span class="angle"><img src="{{ public_asset('assets/images/angle.png') }}" alt=""></span>\n\
                                                                    <ul>\n\
                                                                        <li><a href="{{ url('/student-view-payment-information') }}' +
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

        $('#from').calendar({
            type: 'date'
        });
        $('#to').calendar({
            type: 'date'

        });
        $('body').on('click', '.reset_search', function() {
            $(".reset_val").val("");
            $('#example').DataTable().search('').columns().search('').draw();
        });
        $('body').on('click', '.search_click', function() {
            var col1_filter = $("#col1_filter").val(),
                col2_filter = $("#col2_filter").val();
            if (col1_filter != "" && col2_filter != "") {
                filterColumn(1);
                filterColumn(2);
            } else {
                if (col1_filter == "") {
                    $(".error_col1_filter").html("This field is required");
                }
                if (col1_filter == "") {
                    $(".error_col2_filter").html("This field is required");
                }
            }
        });
        document.addEventListener("DOMContentLoaded", function() {
            // Initialize Flatpickr on the input fields
            flatpickr("#col1_filter", {
                dateFormat: "Y-m-d",
                allowInput: true,
                clickOpens: true,
            });

            flatpickr("#col2_filter", {
                dateFormat: "Y-m-d",
                allowInput: true,
                clickOpens: true,
            });

            // Optional: Open Flatpickr when clicking the input manually
            document.querySelector("#col1_filter").addEventListener("click", function() {
                this._flatpickr.open();
            });

            document.querySelector("#col2_filter").addEventListener("click", function() {
                this._flatpickr.open();
            });

            // If you have a "k-select" button that needs to open flatpickr of its sibling
            $(document).on("click", ".k-select", function() {
                var obj = $(this).parent().find(".start_end_time");
                obj[0]._flatpickr.open();
            });
        });

        // $(document).on("click", ".k-select", function() {
        //     var obj = $(this).parent().find(".start_end_time");

        //     $("#" + obj.attr("id")).data("kendoDatePicker").open();

        // });
        // var d = $("#col1_filter").kendoDatePicker({
        //     // change:changeDatePickerFunction,
        //     disableDates: function(date) {

        //     },
        //     format: "yyyy-MM-dd",
        //     footer: false
        // }).data("kendoDatePicker");
        // var d1 = $("#col2_filter").kendoDatePicker({
        //     // change:changeDatePickerFunction,
        //     disableDates: function(date) {

        //     },
        //     format: "yyyy-MM-dd",
        //     footer: false
        // }).data("kendoDatePicker");
        // $(document).on("click", "#col1_filter", function() {
        //     $("#col1_filter").data("kendoDatePicker").open();
        // });
        // $(document).on("click", "#col2_filter", function() {
        //     $("#col2_filter").data("kendoDatePicker").open();
        // });
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
