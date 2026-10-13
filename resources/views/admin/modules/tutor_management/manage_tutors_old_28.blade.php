@extends('admin.layouts.app')
@section('title')
Tutor Management
@endsection
@section('links')
@include('admin.includes.links')
<script src="{{ public_asset('admin/assets/js/modernizr.min.js') }}"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
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
                <h1 class="pull-left page-title">Tutor Management</h1>
                <ol class="breadcrumb pull-right">
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading rm02 rm04">
                        <form method="get" action="{{ route('tutor.management.list.tab') }}">
                            <div data-column="1" class="form-group">
                                <label for="col1_filter">Name/Email/Phone/Tutor ID</label>
                                <input type="text" placeholder="Name/Email/Phone" id="col1_filter" name="col1_filter" class="form-control reset_val" value="" autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');">
                            </div>
                            <div data-column="2" class="form-group">
                                <label for="col2_filter">Status</label>
                                <select id="col2_filter" name="col2_filter" class="form-control reset_val">
                                    <option value="">Select Status</option>
                                    <option value="A">Active</option>
                                    <option value="I">Suspended</option>
                                    <option value="U">Unverified</option>
                                    <option value="AA">In Progress</option>
                                    <option value="draft">Submitted</option>
                                    <option value="C">Closed</option>
                                </select>
                            </div>
                            {{-- <div data-column="6" class="form-group">
                                <label for="col6_filter">Submitted</label>
                                <select id="col6_filter" name="col6_filter" class="form-control reset_val">
                                    <option value="">Select Status</option>
                                    <option value="N">Submitted</option>
                                    <option value="Y">Not Submitted</option>

                                </select>
                            </div> --}}
                            <div data-column="3" class="form-group">
                                <div class="dash-d1">
                                    <label for="col3_filter">Search From Date</label>
                                    <div class="ui calendar" id="from_date">
                                        <div class="ui input left icon">
                                          <input type="text" id="col3_filter" name="col3_filter" placeholder="date joined from" class="form-control " autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');">
                                          <span class="over_llp1"><img src="{{ public_asset('admin/assets/images/cal.png') }}" alt=""></span>
                                          <span class="error_from_date error"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div data-column="4" class="form-group">
                                <div class="dash-d1">
                                    <label for="col4_filter">Search To Date </label>
                                    <div class="ui calendar" id="to_date">
                                        <div class="ui input left icon">
                                          <input type="text" id="col4_filter" name="col4_filter" placeholder="date joined to" class="form-control " autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');">
                                          <span class="over_llp1"><img src="{{ public_asset('admin/assets/images/cal.png') }}" alt=""></span>
                                          <span class="error_to_date error"></span>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="centerButtons">
                                <div class="rm05">
                                    <button class="btn btn-primary waves-effect waves-light w-md search_click" type="button">Search</button>
                                </div>
                                <div class="rm05">
                                    <button class="btn btn-primary waves-effect waves-light w-md reset_search" type="button">Reset </button>
                                </div>
                                <div class="rm05 rightButtons">
                                <button class="btn btn-primary waves-effect waves-light w-md download" id="download" type="submit">Download </button>
                            </div>
                            </div>
                            <div class="clearfix"></div>
                        </form>
                    </div>

                    <div class="panel-body">
                        @include('admin.includes.message')
                        <div class="row">
                           <div class="col-md-12 col-sm-12 col-xs-12 d-lestis">
                              <div class="col-md-3 col-sm-3 col-lg-2">
                                 <div class="mini-stat clearfix bx-shadow bg-white">
                                    <span class="mini-stat-icon bg-info"><i class="fa fa-book" aria-hidden="true"></i></span>
                                    <div class="mini-stat-info text-right text-dark">
                                       <span class="counter text-dark" id="total_submitted">{{ @$tot_submitted }}</span>
                                       <b> Submitted</b>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-3 col-sm-3 col-lg-2">
                                 <div class="mini-stat clearfix bx-shadow bg-white">
                                    <span class="mini-stat-icon bg-warning"><i class="fas fa-hand-holding-usd" aria-hidden="true"></i></span>
                                    <div class="mini-stat-info text-right text-dark">
                                       <span class="counter text-dark" id="total_in_progress">{{ @$tot_in_progress }}</span>
                                       <b>In Progress</b>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-3 col-sm-3 col-lg-2">
                                 <div class="mini-stat clearfix bx-shadow bg-white">
                                    <span class="mini-stat-icon bg-pink"><i class="fas fa-user-tie"></i></span>
                                    <div class="mini-stat-info text-right text-dark">
                                       <span class="counter text-dark" id="total_unverified">{{ @$tot_unverified }}</span>
                                       <b>Unverified </b>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-3 col-sm-3 col-lg-2">
                                 <div class="mini-stat clearfix bx-shadow bg-white">
                                    <span class="mini-stat-icon bg-success"><i class="far fa-user"></i></span>
                                    <div class="mini-stat-info text-right text-dark">
                                       <span class="counter text-dark" id="total_closed">{{ @$tot_closed }}</span>
                                       <b>Closed </b>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-3 col-sm-3 col-lg-2">
                                 <div class="mini-stat clearfix bx-shadow bg-white">
                                    <span class="mini-stat-icon bg-pink"><i class="fa fa-check-square-o" aria-hidden="true"></i></span>
                                    <div class="mini-stat-info text-right text-dark">
                                       <span class="counter text-dark" id="total_active">{{ @$tot_active }}</span>
                                       <b>Active</b>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-3 col-sm-3 col-lg-2">
                                 <div class="mini-stat clearfix bx-shadow bg-white">
                                    <span class="mini-stat-icon bg-pink"><i class="fa fa-check-square-o" aria-hidden="true"></i></span>
                                    <div class="mini-stat-info text-right text-dark">
                                       <span class="counter text-dark" id="total_inactive">{{ @$tot_inactive }}</span>
                                       <b>Suspended</b>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        {{-- <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 d-lestis">
                                <p>Total Submitted     :<span>{{ @$tot_submitted }}</span></p>
                                <p> In Progress   :<span >{{ @$tot_in_progress }}</span></p>
                                <p> Unverified    :<span >{{ @$tot_unverified }}</span></p>
                                <p> Closed        :<span >{{ @$tot_closed }}</span></p>
                                <p> Active        :<span >{{ @$tot_active }}</span></p>
                            </div>
                        </div> --}}
                        {{-- <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 d-lestis">
                                <p> Submitted     :<span id="total_submitted"></span></p>
                                <p> In Progress   :<span id="total_in_progress"></span></p>
                                <p> Unverified    :<span id="total_unverified"></span></p>
                                <p> Closed        :<span id="total_closed"></span></p>
                                <p>Active        :<span id="total_active"></span></p>
                            </div>
                        </div> --}}
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="example">
                                        <thead>
                                            <tr>
                                                <th class="rm07">Id</th>
                                                <th class="rm07">Name</th>
                                                <th class="rm07">Email</th>
                                                <th class="rm07">Phone</th>
                                                <th class="rm07">Date Joined</th>
                                                <th class="rm07">Sign Up</th>
                                                <th class="rm07">Status</th>
                                                <th class="rm07">Closed on</th>
                                                <th class="rm07">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
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

    function differenceInDates(from_date,to_date){
        // var from_date = from_date,
        // to_date = to_date;
        // var date_from_value = ($.trim($("#from_date").val()).toString()),
        // date_to_value = ($.trim($("#from_date").val()).toString());
        // alert(date_from_value);
        // var convertedTime_from_time_val = moment(date_from_value,'Y-m-d').format('HH:mm');
        // alert("date_from_value : "+date_from_value+" date_to_value : "+date_to_value);
        // alert(from_date+" "+to_date);
        // const date1 = new Date(),
        // date2 = new Date();
        // diffTime = Math.abs(date2 - date1),
        // diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    }
    $(document).ready(function(){
        $("#from_date").calendar({
            type: 'date',
            formatter: {
                date: function (date, settings) {
                    if (!date) return '';
                    var day = date.getDate() + '';
                    if(day.length < 2) {
                        day = '0' + day;
                    }
                    var month = (date.getMonth() + 1) + '';
                    if (month.length < 2) {
                        month = '0' + month;
                    }
                    var year = date.getFullYear();
                    var date_value = year + '-' + month + '-' + day;
                    // if(date_value > $.trim($("#to_time").val())){
                    //     $("#to_time").val("");
                    // }
                    return date_value;
                }
            }
        });
        $("#to_date").calendar({
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
                    // if(date_value > $.trim($("#from_time").val())){
                    //     $("#to_time").val("");
                    // }
                    return date_value;
                }
            }
        });
        function filterColumn ( i ) {
            $('#example').DataTable().column( i ).search(
                $('#col'+i+'_filter').val(),
            ).draw();
        }
        var dataTableObj = {
            // dom: "<div class='table-res'></div>"+'p'+'B',
            // buttons: [
            //     {
            //         extend: 'excelHtml5',
            //         exportOptions: {
            //             columns: [ 0, 1,2,3,4,5 ]
            //         }
            //     },
            //     'colvis'
            // ],
            "bStateSave": true,
        // "fnStateSave": function (oSettings, oData) {
        //     localStorage.setItem('offersDataTables', JSON.stringify(oData));
        // },
        // "fnStateLoad": function (oSettings) {
        //     return JSON.parse(localStorage.getItem('offersDataTables'));
        // },
            columnDefs: [ { targets: 0, type: 'natural' } ],
            stateSave: false,
            "order": [
                [8, "desc"]
            ],
            "stateLoadParams": function (settings, data) {

                // $('#col1_filter').val(data.search.col1_filter);
                // $('#col2_filter').val(data.search.col2_filter);
                // $('#col3_filter').val(data.search.col3_filter);
                // $('#col4_filter').val(data.search.col4_filter);
                if(localStorage.getItem("pageNo") != NaN && localStorage.getItem("pageNo") != null){

                    table.page(parseInt(localStorage.getItem("pageNo"))).draw('page');
                }
                else{
                    table.page(0).draw('page');

                }


            },
            stateSaveParams: function (settings, data) {
                // var p = (this.api().page.info());
                // localStorage.setItem("page",this.api().page.info());
                // localStorage.setItem("pageNo",p.page);
                // data.search.col1_filter = $('#col1_filter').val();
                // data.search.col2_filter = $('#col2_filter').val();
                // data.search.col3_filter = $('#col3_filter').val();
                // data.search.col4_filter = $('#col4_filter').val();

            },
            "processing": true,
            "serverSide": true,
            'serverMethod': 'post',
            "createdRow": function( row, data, dataIndex ) {
                var id = (JSON.stringify(data.id));
                var r = JSON.stringify(dataIndex);
                $(row).addClass("tr_class_"+id);
                $(row).addClass("tr_row_class");
                $(row).children(':nth-child(9)').addClass('rm07');
                $(row).children(':nth-child(9)').addClass('reviews-lists');
                $(row).children(':nth-child(9)').attr('data-id',r);
                // console.log(dataIndex)
            },
            "ajax": {
                "url": "{{ route('list.tutors') }}",
                "data": function ( d ) {
                    // console.log(d);
                    d.myKey = "myValue";
                    d._token = "{{ @csrf_token() }}";
                },
                "dataSrc": function(response) {
                    $('#total_submitted').html(response.total_submitted);
                    $('#total_inactive').html(response.total_inactive);
                    $('#total_unverified').html(response.total_unverified);
                    $('#total_in_progress').html(response.total_in_progress);
                    $('#total_active').html(response.total_active);
                    $('#total_closed').html(response.total_closed);

                    return response.aaData
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // Do something here
                    // console.log("'error in datatable");
                    location.reload();
                }
            },
            drawCallback : function() {
               // processInfo(this.api().page.info());
                // var p = (this.api().page.info());
                // localStorage.setItem("page",this.api().page.info());
                // localStorage.setItem("pageNo",p.page);
            },
            initComplete: function () {

              if(localStorage.getItem("pageNo") != NaN && localStorage.getItem("pageNo") != null){

                    table.page(parseInt(localStorage.getItem("pageNo"))).draw('page');
                }
                else{
                    table.page(0).draw('page');

                }
            },
            'columns': [
             {
                    data: "id",
                    render: function(data, type, full, meta){

                        return full.unique_id;
                    }
                },
                {
                    data: "id",
                    render: function(data, type, full, meta){
                        var name = "";
                        if(full.f_name != null ){
                            name += full.f_name+" ";
                        }
                        if(full.l_name != null ){
                            name += full.l_name;
                        }
                        return name;
                    }
                },
                {
                    data: "email",
                    render: function(data, type, full, meta){
                        return data;
                    }
                },
                {
                    data: "phone",
                    render: function(data, type, full, meta){
                        return data;
                    }
                },
                {
                    data: "created_at",
                    render: function(data, type, full, meta){
                        if(full.created_at) {
                            var date = new Date(full.created_at),
                            day = date.getDate(),
                            month = date.getMonth(),
                            year = date.getFullYear();
                            return ("0" + day).slice(-2)+'-'+("0" + (month+ 1)).slice(-2)+'-'+year;
                            // return year+'-'+("0" + (month+ 1)).slice(-2)+'-'+("0" + day).slice(-2);
                        }else{
                            return ' ';
                        }
                    }
                },
                {
                    data: "platform_type",
                    render: function(data, type, full, meta){
                        if(data == 'google'){
                            return 'google';
                        }
                        else if(data == 'facebook'){
                            return 'facebook';
                        }else{
                            return "Web";
                        }
                        // return data;
                    }
                },
                {
                    data: "status",
                    render: function(data, type, full, meta){
                        if(data == 'A'){
                            return '<span class="green_color status_update_'+full.id+'">Active</span>';
                        }
                        if(data == 'I'){
                            return '<span class=" status_update_'+full.id+'">Suspended<span>';
                        }
                        if(data == 'U'){
                            return '<span class=" status_update_'+full.id+'">Unverified</span>';
                        }
                        if(data == 'AA'){
                            if(full.draft == 'N'){
                                return '<span class=" status_update_'+full.id+'">Submitted</span>';
                            }else{
                                return '<span class="status_update_'+full.id+'">In Progress</span>';
                            }

                        }
                        if(data == 'C'){
                            return '<span class="status_update_'+full.id+'">Closed</span>';
                        }
                        return data;
                    }
                },
                {
                    data: "updated_at",
                    render: function(data, type, full, meta){
                        if(full.status != 'C'){
                            return '';
                        }
                        if(full.updated_at) {
                            var date = new Date(full.updated_at),
                            day = date.getDate(),
                            month = date.getMonth(),
                            year = date.getFullYear();
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
                        var a='',changeStatus = "";
                            if(full.status == 'A'){
                                changeStatus = '<span class="text_change_'+full.id+'">Suspend</span>';
                            }
                            if(full.status == 'I'){
                                changeStatus = '<span class="text_change_'+full.id+'">Activate</span>';
                            }

                            if(full.status == 'AA'){
                                changeStatus = '<span class="text_change_'+full.id+'">Approve</span>';
                            }
                            if(full.status == 'C'){
                                changeStatus = '<span class="text_change_'+full.id+'">Activate</span>';
                            }
                            a+= '<a href="javascript:void(0);" class="action-dots action" data-key="'+full.id+'" id="action'+full.id+'"><img src="{{ public_asset('admin/assets/images/action-dots.png') }}" alt=""></a>\n\
                                <div class="show-actions" id="show-action'+full.id+'" style="display: none;">\n\
                                    <span class="angle"><img src="{{ public_asset('admin/assets/images/angle.png') }}" alt=""></span>\n\
                                    <ul>';
                            a+='<li><a target="_blank" href="{{ url('admin/view-tutor-personal-info').'/' }}'+full.id+'">View </a></li>';
                            // a+='<li><a class="suspended_change_user" data-id="'+full.id+'" href="javascript:void(0);">Suspend</a></li>';
                            if(full.status == 'AA'){
                                a+='<li><a class="suspended_change_user" data-id="'+full.id+'" href="javascript:void(0);">Suspend</a></li>';
                            }
                            if(full.draft == 'N'){
                                a+='<li><a class="status_change_user" data-id="'+full.id+'" href="javascript:void(0);">'+changeStatus+'</a></li>';
                            }
                            // else{
                                // if(full.status != 'A' && full.status != 'I'){
                                //     a+='<li><a class="suspended_change_user" data-id="'+full.id+'" href="javascript:void(0);">Suspend</a></li>';
                                // }
                            // }
                            // if(full.status == 'I' && full.status == 'A'){
                                a+='<li><a class="status_change_user" data-id="'+full.id+'" href="javascript:void(0);">'+changeStatus+'</a></li>';
                            // }
                            // if(full.status == 'U'){
                                // a+='<li><a class="status_change_user" data-id="'+full.id+'" href="javascript:void(0);">Activate</a></li>';
                            // }
                            // if(full.status == 'AA' && full.status == 'A'){
                            //     a+='<li><a class="suspended_change_user" data-id="'+full.id+'" href="javascript:void(0);">Suspend</a></li>';
                            // }
                            if(full.status == 'U'){
                                a+='<li><a class="resend_verify" data-id="'+full.id+'" href="javascript:void(0);">Verification Mail</a></li>';
                            }

                            a+='</ul>\n\
                            </div>';
                        return a;
                    }
                },
            ]
        };
        var table = dataTableCall(dataTableObj,"example");
        // table.page(JSON.stringify(localStorage.getItem('page'))).draw('page');
        $("#example_filter").hide();
        $(document).on("click",".action",function(e){
            var id = $(this).data("key");
            $("#show-action"+id).slideToggle();
        });
        $('body').on('click', '.reset_search', function() {
            $(".reset_val").val("");
            $("#col4_filter").val("");
            $("#col3_filter").val("");
            $("#col5_filter").val("N");
            $('#example').DataTable().search('').columns().search('').draw();
        });
        $(document).on('click','.search_click', function() {
            filterColumn( 1 );
            filterColumn( 2 );
            filterColumn( 3 );
            filterColumn( 4 );
            filterColumn( 5 );
        });
        $('body').on('click','.search_click', function() {
            filterColumn( 3 );
        });
        $(document).on("click",".delete_user",function(e){
            var targetId = $(this).attr("id");
            $("#tId").val(targetId);
            $("#type_popup_next").val("A");
            // var tName = "Do you want to delete "+temp.f_name+" "+temp.l_name+" student ?";
            $("#ajax_url").val("{{ route('ajax.delete.user') }}");
            $('#instructionModal').modal('show');
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
            var tName = "Do you want to delete this tutor ?";
            $("#tName").val(tName);
            $("#data_table_data_s").val(table);
            $("#ajax_data_id").val(id);
            // var id = $(e.currentTarget).attr("data-id"),
            // obj = $(this),
            // temp = table.row('.tr_class_'+id).data(),
            // reqData = {
            //     'jsonrpc' : '2.0',
            //     '_token'  : '{{csrf_token()}}',
            //     'data'    : {
            //         'id'    : id
            //     }
            // };

            // if(confirm("Do you want to delete "+temp.f_name+" "+temp.l_name+" tutor ?")){
            //     $.ajax({
            //         url:"{{ route('ajax.delete.user') }}",
            //         dataType: 'json',
            //         data: reqData,
            //         type: 'post',
            //         success:function(resp){
            //             if(resp.status == 1){
            //                 table.row('.tr_class_'+id).remove().draw( false );
            //                 toastr.success(resp.message);
            //             }else{
            //                 toastr.error(resp.message);
            //             }
            //         },
            //         error:function(){
            //             toastr.error("Something went wrong!Ajax error!");
            //         }
            //     });
            // }
        });
        $(document).on("click",".status_change_user",function(e){
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
            var tName = "Do you want to change the status of this tutor?";
            var ajax_url = "{{ route('ajax.status.change.user') }}";
            var targetId = $(this).attr("id");
            $("#tId").val(targetId);
            $("#type_popup_next").val("A");
            $("#ajax_url").val(ajax_url);
            $("#tName").val(tName);
            isAuthorizedByAdmin(tName,targetId,id);
            // var id = $(e.currentTarget).data("id"),
            // obj = $(this),
            // reqData = {
            //     'jsonrpc' : '2.0',
            //     '_token'  : '{{csrf_token()}}',
            //     'data'    : {
            //         'id'    : id
            //     }
            // },
            // temp = table.row('.tr_class_'+id).data();

            // if(confirm("Do you want to change the status of "+temp.f_name+" "+temp.l_name+" tutor?")){
            //     $.ajax({
            //         url:"{{ route('ajax.status.change.user') }}",
            //         dataType: 'json',
            //         data: reqData,
            //         type: 'post',
            //         success:function(resp){

            //             if(resp.status == 1){
            //                 table.row('.tr_class_'+id).draw( false );
            //                 toastr.success(resp.message);
            //             }else{
            //                 toastr.error(resp.message);

            //             }
            //         }
            //     });
            // }
        });
        $(document).on("click",".suspended_change_user",function(e){
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
            var tName = "Do you want to change the status of this tutor?";
            var ajax_url = "{{ route('ajax.status.change.user.inactive') }}";
            var targetId = $(this).attr("id");
            $("#tId").val(targetId);
            $("#type_popup_next").val("A");
            $("#ajax_url").val(ajax_url);
            $("#tName").val(tName);
            isAuthorizedByAdmin(tName,targetId,id);
            // var id = $(e.currentTarget).data("id"),
            // obj = $(this),
            // reqData = {
            //     'jsonrpc' : '2.0',
            //     '_token'  : '{{csrf_token()}}',
            //     'data'    : {
            //         'id'    : id
            //     }
            // },
            // temp = table.row('.tr_class_'+id).data();

            // if(confirm("Do you want to change the status of "+temp.f_name+" "+temp.l_name+" tutor?")){
            //     $.ajax({
            //         url:"{{ route('ajax.status.change.user') }}",
            //         dataType: 'json',
            //         data: reqData,
            //         type: 'post',
            //         success:function(resp){

            //             if(resp.status == 1){
            //                 table.row('.tr_class_'+id).draw( false );
            //                 toastr.success(resp.message);
            //             }else{
            //                 toastr.error(resp.message);

            //             }
            //         }
            //     });
            // }
        });
        $(document).on("click",".resend_verify",function(e){
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
            var tName = "Do you want to resend verification link to "+temp.email+" ?";
            var ajax_url = "{{ route('ajax.resend.verification.link') }}";
            var targetId = $(this).attr("id");
            $("#tId").val(targetId);
            $("#type_popup_next").val("A");
            $("#ajax_url").val(ajax_url);
            $("#tName").val(tName);
            isAuthorizedByAdmin(tName,targetId,id);

        });
        $(document).on("blur","#col3_filter",function(){
            var from_date = $("#col3_filter").val(),
            to_date = $("#col4_filter").val();
            var from_split = from_date.split("-");
            var to_split = to_date.split("-");
            var new_from_date = from_split[0]+"-"+from_split[1]+"-"+from_split[2];
            var new_to_date = to_split[0]+"-"+to_split[1]+"-"+to_split[2];
            var d2 = Date.parse(new_from_date);
            var d1 = Date.parse(new_to_date);
            if (d1 < d2) {
                $("#col3_filter").val("");
                $("#col4_filter").val("");
                $(".error_from_date").html("to date cannot be grater from from date");
            }
        });



        // $(document).on("click",".onModalShow",function(e){
        //     var id= $.trim($(e.currentTarget).attr("data-id"));
        //     var href= $.trim($(e.currentTarget).attr("data-href"));
        //     // $('#editTutorInfoPasswordForm').attr("action",href);
        //     $('#instructionModal').modal('show');
        //     // $('#instructionModal').modal('hide');
        //     // $("#order_id_reassign").val(id);
        // });
        // function setEditConfPasswordId(id){
        //     $("#instructionModal").show();
        //     // $("#editTutorInfoPasswordForm").attr("action",{{ url('confirm-admin-change-password') }});
        // }
        $(document).on("blur","#col4_filter",function(){
            var from_date = $("#col3_filter").val(),
            to_date = $("#col4_filter").val();
            var from_split = from_date.split("-");
            var to_split = to_date.split("-");
            var new_from_date = from_split[0]+"-"+from_split[1]+"-"+from_split[2];
            var new_to_date = to_split[0]+"-"+to_split[1]+"-"+to_split[2];
            var d2 = Date.parse(new_from_date);
            var d1 = Date.parse(new_to_date);
            if (d1 < d2) {
                $("#col3_filter").val("");
                $("#col4_filter").val("");
                $(".error_from_date").html("to date cannot be grater from from date");
            }
        });

        $('#instructionModal').modal('hide');
        // $("#download").click(function(){
        //     $(".buttons-excel").trigger("click");
        // });
        // $("#example_wrapper div").eq(0).addClass("table-res");
        // $("#example_info").remove();
        // $("#example_length").remove();
        $.fn.dataTableExt.oApi.fnPagingInfo = function ( oSettings )
      {
        return {
          "iStart":         oSettings._iDisplayStart,
          "iEnd":           oSettings.fnDisplayEnd(),
          "iLength":        oSettings._iDisplayLength,
          "iTotal":         oSettings.fnRecordsTotal(),
          "iFilteredTotal": oSettings.fnRecordsDisplay(),
          "iPage":          Math.ceil( oSettings._iDisplayStart / oSettings._iDisplayLength ),
          "iTotalPages":    Math.ceil( oSettings.fnRecordsDisplay() / oSettings._iDisplayLength )
        };
      };
        $('#example').on('page.dt',function(){
            // alert("sakjkfhas");
            var info = table.page.info();
            // alert(info.page);
            // var p = (this.api().page.info());
            if(isNaN(info.page) == false){
                // alert(isNaN(info.page));
                localStorage.setItem("page",info);
                localStorage.setItem("pageNo",info.page);
            }else{

                localStorage.setItem("pageNo",0);

            // $('#pageInfo').html( 'Showing page: '+info.page+' of '+info.pages );
            }
        });
    });
</script>
@endsection
