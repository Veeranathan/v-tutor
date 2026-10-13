@extends('admin.layouts.app')
@section('title')
Student Management
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
                <h1 class="pull-left page-title">Student Management</h1>
                <ol class="breadcrumb pull-right">
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default ">
                    <form action="{{ route('student.management.list.tab') }}" method="get">
                    <div class="panel-heading rm02 rm04">
                        <div data-column="1" class="form-group">
                            <label for="col1_filter">(Name/Email/Phone)</label>
                            <input type="text" placeholder="(Name/Email/Phone)" id="col1_filter" name="col1_filter" class="form-control reset_val" value="" autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');">
                        </div>
                        <div data-column="2" class="form-group">
                            <label for="col2_filter">Status</label>
                            <select id="col2_filter" name="col2_filter" class="form-control reset_val">
                                <option value="">Select Status</option>
                                <option value="A">Active</option>
                                <option value="I">Suspended</option>
                                <option value="U">Unverified</option>
                                <option value="AA">Awaiting Approval</option>
                                <option value="C">Closed</option>
                            </select>
                        </div>

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
                        {{-- <div class="clearfix"></div> --}}
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
                        {{-- <div class="clearfix"></div> --}}
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
                    </div>
                    </form>

                    <div class="panel-body">
                        @include('admin.includes.message')
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
                                                <th class="rm07 mt_sts_col">Status</th>
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

<div class="modal res-modal newqusmo instructionModal adminpasswordPopup" id="approveStntModal">
    <div class="modal-dialog modal-dialog-centered instructionModal">
        <div class="modal-content instructionModal">
            <!-- Modal Header -->
            <div class="modal-header instructionModal">
            <h4 class="modal-title passText">Confirmation</h4>
            <button type="button" class="close" onclick="ClosePopupModel(this)" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body instructionModal noinsBodyDev">
            
                <div class="divs">
                    <div class="appome_input form_box_area cls1 ">
                        <div>
                            <p class="gj_popup_text">Are you sure you want to approve this tutor?</p>
                        </div>
                    </div>
                </div>
                
                <input type="hidden" value="" name="tut_id" id="tut_id">
            </div>

            <div class="modal-footer adm_modal_Footer">
                <button type="button" class="btn btn-new btn-danger" id="yes_tut_approve" onclick="yesApproveSubmitModal(this)" style="color: #b80f0a;">Yes</button>
                <button type="button" data-bs-dismiss="modal" class="btn btn-new btn-danger popup_no" onclick="ClosePopupModel(this)" style="color: #b80f0a;">No</button>
            </div>
        </div>
    </div>
</div>

<div class="modal res-modal newqusmo instructionModal adminpasswordPopup" id="suspendStntModal">
    <div class="modal-dialog modal-dialog-centered instructionModal">
        <div class="modal-content instructionModal">
            <!-- Modal Header -->
            <div class="modal-header instructionModal">
            <h4 class="modal-title passText gj_modal_title">Confirmation</h4>
            <button type="button" class="close" onclick="ClosePopupModel(this)" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body instructionModal noinsBodyDev">
            
                <div class="divs">
                    <div class="appome_input form_box_area cls1 ">
                        <div class="gj_confirm_div">
                            <p class="gj_popup_text">Are you sure you want to suspend this tutor?</p>
                        </div>

                        <div class="gj_submit_div">
                            <textarea class="form-control" name="suspend_reason" id="suspend_reason" placeholder="Enter your reason"></textarea>
                            <p class="suspend_reason_error" style="color: #ef5350;"></p>
                            <button type="button" class="btn btn-new btn-danger" id="submit_suspend" style="color: #b80f0a;" onclick="submitSuspendFn(this)">Submit</button>
                        </div>
                    </div>
                </div>
                
                <input type="hidden" value="" name="stut_id" id="stut_id">
            </div>

            <div class="modal-footer adm_modal_Footer">
                <button type="button" class="btn btn-new btn-danger" id="yes_tut_suspend" style="color: #b80f0a;" onclick="yesSuspendFn(this)">Yes</button>
                {{--  onclick="popupSuspendSubmitModal(this)" --}}
                <button type="button" data-bs-dismiss="modal" class="btn btn-new btn-danger popup_no" onclick="ClosePopupModel(this)" style="color: #b80f0a;">No</button>
            </div>
        </div>
    </div>
</div>

<div class="modal res-modal newqusmo instructionModal adminpasswordPopup" id="adminReasonStntModal">
    <div class="modal-dialog modal-dialog-centered instructionModal">
        <div class="modal-content instructionModal">
            <!-- Modal Header -->
            <div class="modal-header instructionModal">
            <h4 class="modal-title passText gj_modal_title">Admin Reason</h4>
            <button type="button" class="close" onclick="ClosePopupModel(this)" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body instructionModal noinsBodyDev">
            
                <div class="divs">
                    <div class="appome_input form_box_area cls1 ">
                        <div class="gj_reason_div">
                            <p class="gj_popuprsn_text text-left"></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer adm_modal_Footer">
                
                <button type="button" data-bs-dismiss="modal" class="btn btn-new btn-danger popup_no" onclick="ClosePopupModel(this)" style="color: #b80f0a;">Ok</button>
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
<script>
    function ClosePopupModel(its) {
        $(its).closest('.modal').modal('hide');
    }

    function yesApproveSubmitModal(its) {
        var ajax_url = "{{ route('ajax.status.change.user.new') }}";
        var id = $('#tut_id').val();
        $(its).closest('.modal').modal('hide');

        if(id) {
            $("#v_tutor_Loader").css("display", "flex");
            
            var reqData = {
                'jsonrpc' : '2.0',
                '_token'  : '{{csrf_token()}}',
                'data'    : {
                    'id'    : id,
                }
            };

            $.ajax({
                url:ajax_url,
                dataType: 'json',
                data: reqData,
                type: 'post',
                success:function(resp){
                    if(resp.status == 1) {
                        table.row('.tr_class_'+id).remove().draw( false );
                        toastr.success(resp.message);
                    } else {
                        toastr.error(resp.message);
                    }
                },
                error:function(){
                    toastr.error("Something went wrong!Ajax error!");
                },
                complete: function() {
                    $("#v_tutor_Loader").hide();
                }
            });
        } else {
            toastr.error("Something went wrong, please try again later"); 
        }
    }

    function yesSuspendFn(its) {
        $('#suspendStntModal .gj_modal_title').text('Suspend this Student?');
        $('#suspendStntModal .adm_modal_Footer').hide();            
        $('#suspendStntModal .gj_confirm_div').hide();   
        $('#suspendStntModal #suspend_reason').val('');
        $('#suspendStntModal .gj_submit_div').show();     
        $('#suspendStntModal .suspend_reason_error').hide();
    }
    
    function submitSuspendFn(its) {
        var ajax_url = "{{ route('ajax.status.change.user.new') }}";
        var id = $('#stut_id').val();
        var reason = $('#suspend_reason').val();
        if(id && reason) {
            $(its).closest('.modal').modal('hide');
            $('#suspendStntModal .suspend_reason_error').text(''); 
            $('#suspendStntModal .suspend_reason_error').hide(); 

            $("#v_tutor_Loader").css("display", "flex");
            
            var reqData = {
                'jsonrpc' : '2.0',
                '_token'  : '{{csrf_token()}}',
                'data'    : {
                    'id'    : id,
                    'reason': reason,
                }
            };

            $.ajax({
                url:ajax_url,
                dataType: 'json',
                data: reqData,
                type: 'post',
                success:function(resp){
                    if(resp.status == 1) {
                        table.row('.tr_class_'+id).remove().draw( false );
                        toastr.success(resp.message);
                    } else {
                        toastr.error(resp.message);
                    }
                },
                error:function(){
                    toastr.error("Something went wrong!Ajax error!");
                },
                complete: function() {
                    $("#v_tutor_Loader").hide();
                }
            });
        } else {
            $('#suspendStntModal .suspend_reason_error').text('This field is required'); 
            $('#suspendStntModal .suspend_reason_error').show(); 
        }
    }
</script>
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
        const date1 = new Date(),
        date2 = new Date();
        // const date1 = new Date(from_date),
        // date2 = new Date(to_date),
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
                    if (day.length < 2) {
                        day = '0' + day;
                    }
                    var month = (date.getMonth() + 1) + '';
                    if (month.length < 2) {
                        month = '0' + month;
                    }
                    var year = date.getFullYear();
                    var date_value = year + '-' + month + '-' + day;
                    if(date_value > $.trim($("#to_time").val())){
                        $("#to_time").val("");
                    }
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
                    if(date_value > $.trim($("#from_time").val())){
                        $("#to_time").val("");
                    }
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
            // dom: 'Bfrtip',
            // dom: "<div class='tablef-res'></div>"+'p'+'B',
            // buttons: [
            //     {
            //         extend: 'excelHtml5',
            //         exportOptions: {
            //             columns: [ 0, 1,2,3,4,5 ]
            //         }
            //     },
            //     'colvis'
            // ],
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
            },
            stateSaveParams: function (settings, data) {
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
            },
            "ajax": {
                "url": "{{ route('list.manage.students') }}",
                "data": function ( d ) {
                    // console.log(d);
                    d.myKey = "myValue";
                    d._token = "{{ @csrf_token() }}";
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // Do something here
                    // console.log("'error in datatable");
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
                        // if(full.student_type == 'P'){
                        //     if(full.parent_f_name != null ){
                        //         name += full.parent_f_name+" ";
                        //     }
                        //     if(full.parent_l_name != null ){
                        //         name += full.parent_l_name+" ";
                        //     }
                        //     return name;
                        // }
                        // if(full.student_type == 'G'){
                        //     if(full.parent_f_name != null ){
                        //         name += full.parent_f_name+" ";
                        //     }
                        //     if(full.parent_l_name != null ){
                        //         name += full.parent_l_name+" ";
                        //     }
                        //     return name;

                        // }
                        // if(full.student_type == 'S'){
                            if(full.f_name != null ){
                                name += full.f_name+" ";
                            }
                            if(full.l_name != null ){
                                name += full.l_name;
                            }
                            return name;
                        // }
                        // return name;
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
                    }
                },
                {
                    data: "status",
                    render: function(data, type, full, meta){
                        var reason = '';
                        if(full.admin_rej_sus_reason) {
                            reason = full.admin_rej_sus_reason;
                        }

                        if(data == 'A'){
                            return '<span class="status_update_'+full.id+'">Active</span>';
                        }
                        if(data == 'I'){
                            if(reason) {
                                return '<span class="suspend_color status_update_'+full.id+'">Suspended<span><span class="fa fa-question-circle gj_reason_qc" data-id="'+full.id+'" data-reason="'+reason+'"></span>';
                            } else {
                                return '<span class="suspend_color status_update_'+full.id+'">Suspended<span>';
                            }
                            // return '<span class="status_update_'+full.id+'">Suspended<span>';
                        }
                        if(data == 'U'){
                            return '<span class="status_update_'+full.id+'">Unverified</span>';
                        }
                        if(data == 'AA'){
                            return '<span class="status_update_'+full.id+'">Awaiting Apporval</span>';
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
                        var changeStatus = "";
                        if(full.status == 'A'){
                            changeStatus = '<span class="text_change_'+full.id+'">Suspended</span>';
                        }
                        if(full.status == 'I'){
                            changeStatus = '<span class="text_change_'+full.id+'">Activate</span>';
                        }

                        if(full.status == 'C'){
                            changeStatus = '<span class="text_change_'+full.id+'">Activate</span>';
                        }
                        var a='';
                        a+= '<a href="javascript:void(0);" class="action-dots action" data-key="'+full.id+'" id="action'+full.id+'"><img src="{{ public_asset('admin/assets/images/action-dots.png') }}" alt=""></a>\n\
                            <div class="show-actions" id="show-action'+full.id+'" style="display: none;">\n\
                                <span class="angle"><img src="{{ public_asset('admin/assets/images/angle.png') }}" alt=""></span>\n\
                                <ul>';
                                a+='\n\
                                    <li><a href="{{ url('admin/view-student').'/' }}'+full.id+'">View </a></li>';

                                    /* a+='<li><a class="status_change_user" data-id="'+full.id+'" href="javascript:void(0);">'+changeStatus+'</a></li>';
                                    if(full.status == 'U'){
                                        a+='<li><a class="resend_verify" data-id="'+full.id+'" href="javascript:void(0);">Resend Verification Mail</a></li>';
                                    } */

                                    if(full.status == 'I'){
                                        a+='<li><a class="status_change_user_activate" data-id="'+full.id+'" href="javascript:void(0);">Activate</a></li>';
                                    } else {
                                        a+='<li><a class="status_change_user_suspend" data-id="'+full.id+'" href="javascript:void(0);">Suspended</a></li>';
                                    }

                                a+='</ul>\n\
                              </div>';
                        return a;
                    }
                },
            ]
        };
        var table = dataTableCall(dataTableObj,"example");

        $("#example_filter").hide();
        $(document).on("click",".action",function(e){
            var id = $(this).data("key");
            $("#show-action"+id).slideToggle();
        });
        $(document).on("blur","#from_date",function(){
            var from_date = $("#col3_filter").val(),
            to_date = $("#col4_filter").val(),
            splitData = from_date.split("-"),
            splitToData = to_date.split("-"),
            new_from_date = new Date(splitData[0],splitData[1]-1,splitData[2],0,0,0),
            new_to_date = new Date(splitToData[0],splitToData[1]-1,splitToData[2],23,59,59);
            var Difference_In_Time = new_to_date.getTime() - new_from_date.getTime();
            // To calculate the no. of days between two dates
            var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);
            // console.log(Difference_In_Time);
            // Difference_In_Time = to_date.getTime() - from_date.getTime();
            // console.log(Difference_In_Time);
            // alert(from_date);
            // alert(to_date);
            // differenceInDates();
            if(from_date < to_date){
                $("#to_date").val("");
                $("#from_date").val("");
            }
        });
        $(document).on("blur","#to_date",function(){
            var from_date = Date.parse($("#col3_filter").val()),
            to_date = Date.parse($("#col4_filter").val());
            // var Difference_In_Time = to_date.getTime() - from_date.getTime();
            // console.log(Difference_In_Time);
            // if(from_date < to_date){
            //     $("#to_date").val("");
            //     $("#from_date").val("");
            // }
        });
        $('body').on('click', '.reset_search', function() {
            $(".reset_val").val("");
            $("#col4_filter").val("");
            $("#col3_filter").val("");
            $("#col5_filter").val("N");
            $('#example').DataTable().search('').columns().search('').draw();
        });
        $('body').on('click','.search_click', function() {
            filterColumn(1);
            filterColumn(2);
            filterColumn(3);
            filterColumn(4);
            filterColumn(5);
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

            var tName = "Do you want to delete student ?";
            $("#tName").val(tName);
            $("#data_table_data_s").val(table);
            $("#ajax_data_id").val(id);
            // var targetId = $(this).attr("id");
            // $("#tId").val(targetId);
            // $("#type_popup_next").val("A");
            // $("#ajax_url").val("{{ route('ajax.delete.user') }}");
            // var tName = "Do you want to delete "+temp.f_name+" "+temp.l_name+" student ?";
            // var ajax_url = "{{ route('ajax.delete.user') }}";
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
            // $("#data_table_data_s").val(table);
            // $("#ajax_data_id").val(id);
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

            // if(confirm("Do you want to delete "+temp.f_name+" "+temp.l_name+" student ?")){
            //     $.ajax({
            //         url:"",
            //         dataType: 'json',
            //         data: reqData,
            //         type: 'post',
            //         success:function(resp){
            //             if(resp.status == 1){
            //                 table.row('.tr_class_'+id).remove().draw( false );
            //                 toastr.success(resp.message);
            //                 // obj.parent().parent().parent().parent().parent().remove();
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
        $(document).on("click",".close_user",function(e){
            var targetId = $(this).attr("id");
            $("#tId").val(targetId);
            $("#type_popup_next").val("A");
            // var tName = "Do you want to delete "+temp.f_name+" "+temp.l_name+" student ?";
            $("#ajax_url").val("{{ route('ajax.close.user') }}");
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

            var tName = "Do you want to close student ?";
            $("#tName").val(tName);
            $("#data_table_data_s").val(table);
            $("#ajax_data_id").val(id);
            // var targetId = $(this).attr("id");
            // $("#tId").val(targetId);
            // $("#type_popup_next").val("A");
            // $("#ajax_url").val("{{ route('ajax.close.user') }}");
            // var tName = "Do you want to delete "+temp.f_name+" "+temp.l_name+" student ?";
            // var ajax_url = "{{ route('ajax.close.user') }}";
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
            // $("#data_table_data_s").val(table);
            // $("#ajax_data_id").val(id);
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

            // if(confirm("Do you want to delete "+temp.f_name+" "+temp.l_name+" student ?")){
            //     $.ajax({
            //         url:"",
            //         dataType: 'json',
            //         data: reqData,
            //         type: 'post',
            //         success:function(resp){
            //             if(resp.status == 1){
            //                 table.row('.tr_class_'+id).remove().draw( false );
            //                 toastr.success(resp.message);
            //                 // obj.parent().parent().parent().parent().parent().remove();
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
            var tName = "Do you want to change the status of this student?";
            var ajax_url = "{{ route('ajax.status.change.user') }}";
            var targetId = $(this).attr("id");
            $("#tId").val(targetId);
            $("#type_popup_next").val("A");
            $("#ajax_url").val(ajax_url);
            $("#tName").val(tName);
            isAuthorizedByAdmin(tName,targetId,id);
            // var id = $(e.currentTarget).attr("data-id"),
            // obj = $(this),
            // reqData = {
            //     'jsonrpc' : '2.0',
            //     '_token'  : '{{csrf_token()}}',
            //     'data'    : {
            //         'id'    : id
            //     }
            // },
            // temp = table.row('.tr_class_'+id).data();
            // if(confirm("Do you want to change the status of "+temp.f_name+" "+temp.l_name+" student?")){
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

        $(document).on("click",".status_change_user_activate",function(e){
            var id = $(e.currentTarget).data("id");
            $('#tut_id').val(id);
            $('#approveStntModal').modal('show');
        });

        $(document).on("click",".status_change_user_suspend",function(e){
            var id = $(e.currentTarget).data("id");
            $('#stut_id').val(id);
            $('#suspendStntModal .gj_modal_title').text('Confirmation');
            $('#suspendStntModal .adm_modal_Footer').show();
            $('#suspendStntModal .gj_confirm_div').show(); 
            $('#suspendStntModal .gj_submit_div').hide(); 
            $('#suspendStntModal .suspend_reason_error').hide(); 
            $('#suspendStntModal').modal('show');            
        });

        $(document).on("click",".gj_reason_qc",function(e){
            var id = $(e.currentTarget).data("id");
            var reason = $(e.currentTarget).data("reason");
            $('#adminReasonStntModal .gj_popuprsn_text').text(reason);            
            $('#adminReasonStntModal').modal('show');            
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
        $('#instructionModal').modal('hide');
        // $(document).on("click",".onModalShow",function(e){
        //     var id= $.trim($(e.currentTarget).attr("data-id")),
        //     href= $.trim($(e.currentTarget).attr("data-href"));
        //     nexthref= $.trim($(e.currentTarget).attr("data-nexthref"));
        //     $('#editTutorInfoPasswordForm').attr("action",href);
        //     $('#instructionModal').modal('show');
        //     $("#user_id").val(id);
        //     $("#nextHref").val(nexthref);
        //     // $('#instructionModal').modal('hide');
        //     // $("#order_id_reassign").val(id);
        // });
        // $("#download").click(function(){
        //     $(".buttons-excel").trigger("click");
        // });
        // $("#example_wrapper div").eq(0).addClass("table-res");
        $("#example_info").remove();
        $("#example_length").remove();
    });
</script>
@endsection
