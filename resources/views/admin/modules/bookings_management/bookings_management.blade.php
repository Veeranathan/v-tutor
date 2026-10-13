@extends('admin.layouts.app')
@section('title')
Bookings Management
@endsection
@section('links')
@include('admin.includes.links')
{{-- <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css"> --}}
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<style type="text/css">
    .dt-buttons{
        display: none;
    }
    /*.show_response{
        width: 20%;
        float: left;
        font-weight: 600;
        margin-right: 10px;
    }*/
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
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12 col-xs-12">
            {{-- <div class="col-sm-12"> --}}
                <h1 class="pull-left page-title">Bookings Management</h1>
                <ol class="breadcrumb pull-right">
                    {{-- <li> <a href="{{ route('add.grade') }}"><i class="far fa-plus-square" aria-hidden="true"></i> Add Grade</a></li> --}}
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading rm02 rm04">
                        <form action="{{ route('booking.management.list.tab') }}" method="get">
                            <div data-column="1" class="form-group">
                                <label for="">Search Booking No</label>
                                <input type="text" placeholder=" " id="col1_filter" name="booking_search" class="form-control reset_val" value="" autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');">
                            </div>
                            <div data-column="2" class="form-group">
                                <label for="">Status</label>
                                <select id="col2_filter" name="col2_filter" class="form-control reset_val">
                                    <option value="">Select Status</option>
                                    <option value="B">Booked</option>
                                    <option value="CM">Completed</option>
                                    <option value="C">Cancelled</option>
                                </select>
                            </div>
                            <div data-column="7" class="form-group">
                                <label for="">Student</label>
                                <select id="col7_filter" name="col7_filter" class="form-control reset_val ">
                                    <option value="">Select Student</option>
                                    @if(@$users)
                                    @foreach(@$users as $s)
                                    <option value="{{ @$s->id }}">{{ @$s->f_name.' '.@$s->l_name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div data-column="8" class="form-group">
                                <label for="">Tutor</label>
                                <select id="col8_filter" name="col8_filter" class="form-control reset_val">
                                    <option value="">Select Tutor</option>
                                    @if(@$tutors)
                                    @foreach(@$tutors as $t)
                                    <option value="{{ @$t->id }}">{{ @$t->f_name.' '.@$t->l_name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div data-column="3" class="form-group">
                                <div class="dash-d1">
                                    <label for="">Date Booked From</label>
                                    <div class="ui calendar calendardatepicker" id="from_date">
                                        <div class="ui input left icon">
                                          <input type="text" id="col3_filter" name="col3_filter" placeholder="" class="form-control reset_val" autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');">
                                          <span class="over_llp1"><img src="{{ public_asset('admin/assets/images/cal.png') }}" alt=""></span>
                                          <span class="error_from_date error"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div data-column="4" class="form-group">
                                <div class="dash-d1">
                                    <label for="">Date Booked To</label>
                                    <div class="ui calendar calendardatepicker" id="to_date">
                                        <div class="ui input left icon">
                                          <input type="text" id="col4_filter" name="col4_filter" placeholder="" class="form-control reset_val" autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');">
                                          <span class="over_llp1"><img src="{{ public_asset('admin/assets/images/cal.png') }}" alt=""></span>
                                          <span class="error_to_date error"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div data-column="5" class="form-group">
                                <div class="dash-d1">
                                    <label for="">Session Date From</label>
                                    <div class="ui calendar calendardatepicker" id="booking_from_date">
                                        <div class="ui input left icon">
                                          <input type="text" id="col5_filter" name="col5_filter" placeholder="" class="form-control reset_val" autocomplete="off"  readonly="" >
                                          <span class="over_llp1"><img src="{{ public_asset('admin/assets/images/cal.png') }}" alt=""></span>
                                          <span class="error_from_date error"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div data-column="6" class="form-group">
                                <div class="dash-d1">
                                    <label for="">Session Date To</label>
                                    <div class="ui calendar calendardatepicker" id="booking_to_date">
                                        <div class="ui input left icon">
                                          <input type="text" id="col6_filter" name="col6_filter" placeholder="" class="form-control reset_val" autocomplete="off"  readonly="">
                                          <span class="over_llp1"><img src="{{ public_asset('admin/assets/images/cal.png') }}" alt=""></span>
                                          <span class="error_to_date error"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- <div data-column="9" class="form-group">
                                <label for="">Grade</label>
                                <select id="col9_filter" name="col9_filter" class="form-control reset_val">
                                    <option value="">Select Grade</option>
                                    @if(@$grades)
                                    @foreach(@$grades as $g)
                                    <option value="{{ @$g->id }}">{{ @$g->grade_name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div data-column="10" class="form-group">
                                <label for="">Subject</label>
                                <select id="col10_filter" name="col10_filter" class="form-control reset_val">
                                    <option value="">Select subject</option>
                                    @if(@$subjects)
                                    @foreach(@$subjects as $sub)
                                    <option value="{{ @$sub->id }}">{{ @$sub->subject }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>  --}}
                            <div class="rm05">
                                <button class="btn btn-primary waves-effect waves-light w-md search_click" type="button">Search</button>
                            </div>
                            <div class="rm05">
                                <button class="btn btn-primary waves-effect waves-light w-md reset_search" type="button">Reset </button>
                            </div>
                            <div class="rm05 rightButtons">
                                <button class="btn btn-primary waves-effect waves-light w-md download" id="download" type="submit">Download </button>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group">
                                {{-- <label for=""></label> --}}


                            </div>
                        </form>
                    </div>
                    <div class="panel-body">
                        @include('admin.includes.message')
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                Total Bookings:<span id="total_booked"></span>
                                Total Completed:<span id="total_completed"></span>
                                Total Cancelled:<span id="total_cancelled"></span>
                                {{-- <p class="show_response">Total Bookings: <span id="total_booked"></span></p> --}}
                                {{-- <p class="show_response">Total Completed : <span id="total_completed"></span></p> --}}
                                {{-- <p class="show_response">Total Cancelled : <span id="total_cancelled"></span></p> --}}

                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="table-responsive">
                                    {{-- <div class="table-res"> --}}
                                    <table class="table table-bordered table-striped" id="example">
                                        <thead>
                                            <tr>
                                                <th class="rm07">Booking No</th>
                                                <th class="rm07">Tutor Name</th>
                                                <th class="rm07">Student Name</th>
                                                <th class="rm07">Subject</th>
                                                <th class="rm07">Student Grade</th>
                                                {{-- <th class="rm07">Tutor Rate per session (30 mins)($)</th> --}}
                                                <th class="rm07">Booking Amount($)</th>
                                                <th class="rm07">Date & Time</th>
                                                {{-- <th class="rm07">From Time</th> --}}
                                                {{-- <th class="rm07">To Time</th> --}}
                                                <th class="rm07">Booking Status</th>

                                                <th class="rm07">Booked on</th>
                                                <th class="rm07">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                  {{-- </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End row -->
    </div>
    <!-- container -->
</div>
@endsection
@section('footer')
@include('admin.includes.footer')
@endsection
@section('script')
@include('admin.includes.script')
<script src="{{ public_asset('assets/js/chosen.jquery.js') }}" type="text/javascript"></script>
<script src="{{ public_asset('assets/js/init.js') }}" type="text/javascript"></script>
{{-- for datatable --}}
{{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
{{-- for validation --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js" integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg==" crossorigin="anonymous"></script>
{{-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script> --}}
<script type="text/javascript">

    $(document).ready(function(){
        $('.slct').chosen();
        $(".buttons-excel").hide();
        function filterColumn ( i ) {
            $('#example').DataTable().column( i ).search(
                $('#col'+i+'_filter').val(),
            ).draw();
        }

        var dataTableObj = {
            // dom: "<div class='table-res'></div>"+'p'+'B',
            // "scrollX": true,
            // dom: 'Bfrtip',
            // buttons: [
            //     {
            //         extend: 'excel',
            //         title:"Booking Management",
            //         exportOptions: {
            //             columns: [ 0, 1,2,3,4,5,6,7,8 ],
            //         }
            //     }
            // ],
            // buttons: [
            //     'copy', 'csv', 'excel', 'pdf', 'print'
            // ],

            stateSave: false,
            // "pageLength":2,
            "order": [
                [9, "desc"]
            ],
            "stateLoadParams": function (settings, data) {
                // $('#col1_filter').val(data.search.grade_name);
            },
            stateSaveParams: function (settings, data) {
                // data.search.grade_name = $('#col1_filter').val();
            },

            "processing": true,
            "serverSide": true,
            'serverMethod': 'post',
            "createdRow": function( row, data, dataIndex ) {
                var id = (JSON.stringify(data.id)),
                r = JSON.stringify(dataIndex);
                // $(row).
                $(row).addClass("tr_class_"+id);
                $(row).addClass("tr_row_class");
                $(row).children(':nth-child(1)').addClass('rm07');
                $(row).children(':nth-child(2)').addClass('rm07');
                $(row).children(':nth-child(3)').addClass('rm07');
                $(row).children(':nth-child(4)').addClass('rm07');
                $(row).children(':nth-child(5)').addClass('rm07');
                $(row).children(':nth-child(6)').addClass('rm07');
                $(row).children(':nth-child(7)').addClass('rm07');
                $(row).children(':nth-child(8)').addClass('rm07');
                $(row).children(':nth-child(9)').addClass('rm07');
                $(row).children(':nth-child(10)').addClass('rm07');
                $(row).children(':nth-child(10)').addClass('reviews-lists');
                // $(row).children(':nth-child(11)').addClass('rm07');
                // $(row).children(':nth-child(12)').addClass('rm07');

                // $(row).children(':nth-child(12)').attr('data-id',r);
                // $(row).children(':nth-child(11)').attr('data-id',r);
                $(row).children(':nth-child(10)').attr('data-id',r);
                $(row).children(':nth-child(3)').attr('data-id',r);
            },
            columnDefs: [ { targets: 0, type: 'natural' } ],
            "ajax": {
                "url": "{{ route('booking.management.datatable.ajax') }}",
                "data": function ( d ) {
                    console.log(d);
                    d.myKey = "myValue";
                    d._token = "{{ @csrf_token() }}";
                },
                "dataSrc": function(response) {
                    // console.log(response.total_booked);
                    // console.log(response.total_completed);
                    // console.log(response.total_cancelled);
                    $('#total_booked').html(response.total_booked);
                    $('#total_completed').html(response.total_completed);
                    $('#total_cancelled').html(response.total_cancelled);

                    return response.aaData
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // Do something here
                    console.log("'error in datatable");
                }
            },
            'columns': [
            {
                data: "booking_no",
                render: function(data, type, full, meta){
                    return data;
                }
            },
            {
                data: "id",
                render: function(data, type, full, meta) {
                    return full.get_tutor.f_name + " " + full.get_tutor.l_name;
                }
            },
            {
                data: "id",
                render: function(data, type, full, meta) {
                    return full.get_student.f_name + " " + full.get_student.l_name;
             }
            },
            // {
            //     data: "id",
            //     render: function(data, type, full, meta){
            //         return full.get_subject.subject;
            //     }
            // },
            {
                data: "id",
                render: function(data, type, full, meta){
                    if(full.is_academic_program == 1){
                        return full.program_name ?? '-';
                    }
                        return full.get_subject ? full.get_subject.subject : '-';
                    }
            },
            {
                data: "id",
                render: function(data, type, full, meta){
                    return full.get_student_grade.grade_name;
                }
            },
            // {
            //     data: "hourly_rate",
            //     render: function(data, type, full, meta){
            //         return "$ "+full.hourly_rate+"";
            //     }
            // },
            {
                data: "booking_amount",
                render: function(data, type, full, meta){
                    return "$ "+full.booking_amount+"";
                }
            },
            {
                data: "booking_date",
                render: function(data, type, full, meta) {

                    if (!full.booking_date) {
                        return '';
                    }

                    var bookingDate = full.booking_date.substring(0, 10);
                    var dateParts = bookingDate.split('-');

                    var year = dateParts[0];
                    var month = dateParts[1];
                    var day = dateParts[2];

                    var formattedDate = day + '-' + month + '-' + year;

                    var startUtc = new Date(
                        bookingDate + 'T' + full.from_time + 'Z'
                    );

                    var endUtc = new Date(
                        bookingDate + 'T' + full.to_time + 'Z'
                    );

                    var startFormatter = new Intl.DateTimeFormat('en-AU', {
                        timeZone: 'Australia/Sydney',
                        hour: 'numeric',
                        minute: '2-digit',
                        hour12: true
                    });

                    var endFormatter = new Intl.DateTimeFormat('en-AU', {
                        timeZone: 'Australia/Sydney',
                        hour: 'numeric',
                        minute: '2-digit',
                        hour12: true
                    });

                    var strFromTime = startFormatter.format(startUtc);
                    var strToTime = endFormatter.format(endUtc);

                        return formattedDate + ' ' + strFromTime + ' - ' + strToTime;
                }
            },
            // {
            //     data: "from_time",
            //     render: function(data, type, full, meta){
            //         var date = new Date(full.booking_date+" "+full.from_time);
            //           var hours = date.getHours();
            //           var minutes = date.getMinutes();
            //           var ampm = hours >= 12 ? 'pm' : 'am';
            //           hours = hours % 12;
            //           hours = hours ? hours : 12; // the hour '0' should be '12'
            //           minutes = minutes < 10 ? '0'+minutes : minutes;
            //           var strTime = hours + ':' + minutes + ' ' + ampm;
            //           return strTime;
            //     }
            // },
            // {
            //     data: "to_time",
            //     render: function(data, type, full, meta){
            //         var date = new Date(full.booking_date+" "+full.to_time);
            //           var hours = date.getHours();
            //           var minutes = date.getMinutes();
            //           var ampm = hours >= 12 ? 'pm' : 'am';
            //           hours = hours % 12;
            //           hours = hours ? hours : 12; // the hour '0' should be '12'
            //           minutes = minutes < 10 ? '0'+minutes : minutes;
            //           var strTime = hours + ':' + minutes + ' ' + ampm;
            //           return strTime;
            //     }
            // },
            {
                data: "booking_status",
                render: function(data, type, full, meta){
                    if(data == 'B'){
                        return "Booked";
                    }
                    if(data == 'C'){
                        return "Cancelled";
                    }
                    if(data == 'CM'){
                        return "COMPLETED";
                    }
                    return data;
                }
            },
            {
                data: "created_at",
                render: function(data, type, full, meta){
                    if(full.created_at) {
                        var date = new Date(full.created_at);
                        var day = date.getDate();
                        var month = date.getMonth();
                        var year = date.getFullYear()
                        return ("0" + day).slice(-2)+'-'+("0" + (month+ 1)).slice(-2)+'-'+year;
                        // return year+'-'+("0" + (month+ 1)).slice(-2)+'-'+("0" + day).slice(-2);
                    }else{
                        return ' ';
                    }
                }
            },
            {
                data: "id",
                render: function(data, type, full, meta){
                // console.log("print : "+JSON.stringify(meta));
                    var a='';
                    // a += '<a href="javascript:void(0);" title="View" class="gtest"><i class="fas fa-ellipsis-v"></i></a>';
                    ;
                    a+= '<a href="javascript:void(0);" class="action-dots action" data-key="'+full.id+'" id="action'+full.id+'"><img src="{{ public_asset('admin/assets/images/action-dots.png') }}" alt=""></a>\n\
                        <div class="show-actions" id="show-action'+full.id+'" style="display: none;">\n\
                            <span class="angle"><img src="{{ public_asset('admin/assets/images/angle.png') }}" alt=""></span>\n\
                            <ul>';
                    a+='<li><a href="{{ url('admin/view-booking-details').'/' }}'+full.booking_no+'">View Details</a></li>';

                    // var bDateTime = new Date(full.booking_date+" "+full.from_time);
                    // var tDateTime = new Date();
                    // if(full.booking_status != 'C'){
                    //     if(bDateTime > tDateTime){
                            // if(full.join_url != null){
                            //     a+='<li><a target="_blank" href="{{ url('class-session-link').'/' }}'+full.id+'">Join Session Link</a></li>';
                            //     // a+='<li><a target="_blank" href="{{ url('class-session-link') }}/'+ full.student_unique_id + '/'+ full.booking_no +'">Join Session Link</a></li>';
                            // }
                            // if(full.start_url != null){
                            //     a+='<li><a target="_blank" href="{{ url('tutor-class-session-link').'/' }}'+full.id+'">Start Session Link</a></li>';
                            // }
                        //     a+='<li><a id="cancel_booking_'+full.id+'" class="cancel_booking" data-id="'+full.id+'" href="javascript:void(0);">Cancel Booking</a></li>';
                        // }

                    // }

                    a+='</ul>\n\
                  </div>';
                    return a;
                }
            },
            ]
            // ,
            // columnDefs: [
            //     {
            //         render: function (data, type, full, meta) {
            //             return "<div class='text-wrap width-200'>" + data + "</div>";
            //         },
            //         targets: 3
            //     }
            //  ]
        };
        var table = dataTableCall(dataTableObj,"example");
        // var info = table.page.info();
        // alert(JSON.stringify(info));
        $("#example_filter").hide();
        // $("#example_wrapper div").eq(0).addClass("table-res");
        $(document).on("click",".action",function(e){
            var id = $(this).data("key");
            $("#show-action"+id).slideToggle();

        });
        // $('#col5_filter').on( ' change', function () {
        //     filterColumn( $(this).parents('div').data('column') );
        // });
        // $('#col6_filter').on( 'change', function () {
        //     filterColumn( $(this).parents('div').data('column') );
        // });
        $('body').on('click','.reset_search', function() {
            $(".reset_val").val("");
            $('#example').DataTable().search('').columns().search('').draw();
        });
        $('body').on('click','.search_click', function() {
            filterColumn( 1 );
            filterColumn( 2 );
            filterColumn( 3 );
            filterColumn( 4 );
            filterColumn( 5 );
            filterColumn( 6 );
            filterColumn( 7 );
            filterColumn( 8 );
            filterColumn( 9 );
            filterColumn( 10 );
        });
        $('#example tbody').on( 'click', 'tr', function () {

        });
        $(document).on("click",".cancel_booking",function(e){
            var id = $(e.currentTarget).data("id"),
            obj = $(this),
            reqData = {
                'jsonrpc' : '2.0',
                '_token'  : '{{csrf_token()}}',
                'data'    : {
                    'id'    : id
                }
            },
            temp = table.row('.tr_class_'+id).data();

            $("#data_table_data_s").val(table);
            $("#ajax_data_id").val(id);
            var tName = "Do you want to cancel "+temp.booking_no+" ? ";
            var ajax_url = "{{ route('ajax.cancel.booking') }}";
            var targetId = $(this).attr("id");
            $("#tId").val(targetId);
            $("#type_popup_next").val("A");
            $("#ajax_url").val(ajax_url);
            $("#tName").val(tName);
            isAuthorizedByAdmin(tName,targetId,id);
        });
        // $("#download").click(function(){
        //     // table = table.page.len( 25 ).draw();
        //     $(".buttons-excel").trigger("click");

        // });
        $(".calendardatepicker").calendar({
            type: 'date',
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
                    var date_value = year + '-' + month + '-' + day;

                    return date_value;
                }
            }
        });

        // $("#example_info").remove();
        $("#example_length").remove();
        // var getHtml = $("#example").html();
        // var appendHtml = '<div class="table-res">'+getHtml+'</div>';

        // $(".example_wrapper").append(appendHtml);
    });
    function proceedConfirm() {

        var id = $("#ajax_data_id").val();
        var ajax_url = $("#ajax_url").val();

        $.ajax({
            url: ajax_url,
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: id
            },
            success: function(response) {
                $("#admConfirmModal").modal('hide');
                location.reload();
            },
            error: function(xhr) {
                console.log(xhr);
            }
        });
    }
</script>
@endsection
