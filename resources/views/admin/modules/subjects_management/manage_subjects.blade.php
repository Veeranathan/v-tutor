@extends('admin.layouts.app')
@section('title')
Subject Management
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
                <h1 class="pull-left page-title">Subject Management</h1>
                <ol class="breadcrumb pull-right">
                    <li> <a href="{{ route('add.subject') }}"><i class="far fa-plus-square" aria-hidden="true"></i> Add Subject</a></li>

                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading rm02 rm04">
                        <form role="form" id="searchSubject" method="get" action="{{ route('subject.management.list.tab') }}">
                             <div data-column="2" class="form-group">
                                        <label for="col2_filter">Grade</label>
                                        <select class="form-control reset_val" id="col2_filter" name="col2_filter">
                                            <option value="">Select Grade</option>
                                            @if(@$grades)
                                            @foreach(@$grades as $g)
                                            <option value="{{ @$g->id }}">{{ @$g->grade_name }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>       
                             <div data-column="3" class="form-group">
                                        <label for="col2_filter">Branch</label>
                                        <select class="form-control reset_val" id="col3_filter" name="col3_filter">
                                            <option value="">Select Branch</option>
                                            @if(@$branches)
                                            @foreach(@$branches as $b)
                                            <option value="{{ @$b->id }}">{{ @$b->branch_name }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                            <div data-column="1" class="form-group">
                                <label for="col1_filter">Search Subject Name/Code</label>
                                <input type="text" placeholder="Subject xx" id="col1_filter" name="subject" class="form-control reset_val" value="" autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');">
                            </div>
                            <div data-column="4" class="form-group">
                                        <label for="col4_filter">Status</label>
                                        <select class="form-control reset_val" id="col4_filter" name="col4_filter">
                                            <option value="">Select Status</option>
                                            <option value="I">Inactive</option>
                                            <option value="A">Active</option>

                                        </select>
                                    </div>
                            {{-- <div class="clearfix"></div> --}}
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
                        </form>
                    </div>
                    <div class="panel-body">
                        @include('admin.includes.message')
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="example">
                                        <thead>
                                            <tr>
                                                <th class="rm07">Grade Name</th>
                                                <th class="rm07">Branch Name</th>
                                                <th class="rm07">Subject</th>
                                                <th class="rm07">Subject Code</th>
                                                <th class="rm07">Display Order</th>
                                                <th class="rm07">Status</th>
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
    $(document).ready(function(){
        function filterColumn ( i ) {
            $('#example').DataTable().column( i ).search(
                $('#col'+i+'_filter').val(),
            ).draw();
        }
        var dataTableObj = {
            // dom: 'Bfrtip',
            // dom: "<div class='table-res'></div>"+'p'+'B',
            // buttons: [
            //     {
            //         extend: 'excelHtml5',
            //         exportOptions: {
            //             columns: [ 0, 1 ]
            //         }
            //     },
            //     'colvis'
            // ],
        stateSave: false,
        "order": [
            [6, "desc"]
        ],
        // "pageLength":2,
        "stateLoadParams": function (settings, data) {
            // $('#col1_filter').val(data.search.subject);
        },
        stateSaveParams: function (settings, data) {
            // data.search.subject = $('#col1_filter').val();
        },
        columnDefs: [ { targets: 0, type: 'natural' } ],
        "processing": true,
        "serverSide": true,
        'serverMethod': 'post',
        "createdRow": function( row, data, dataIndex ) {
            var id = (JSON.stringify(data.id));
            var r = JSON.stringify(dataIndex);
            $(row).addClass("tr_class_"+id);
            $(row).addClass("tr_row_class");
            $(row).children(':nth-child(1)').addClass('rm07');
            $(row).children(':nth-child(2)').addClass('rm07');
            $(row).children(':nth-child(3)').addClass('rm07');
            $(row).children(':nth-child(4)').addClass('rm07');
            $(row).children(':nth-child(5)').addClass('rm07');
            $(row).children(':nth-child(6)').addClass('rm07');
            $(row).children(':nth-child(7)').addClass('rm07');
            $(row).children(':nth-child(7)').addClass('reviews-lists');
            $(row).children(':nth-child(7)').attr('data-id',r);
        },
        "ajax": {
            "url": "{{ route('subject.management') }}",
            "data": function ( d ) {
                console.log(d);
                d.myKey = "myValue";
                d._token = "{{ @csrf_token() }}";
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // Do something here
                console.log("'error in datatable");
            }
        },
        'columns': [
        {
           data: "grade_id",
            render: function(data, type, full, meta){    
                if(data != 0){
                    // return '';    
                    return full.get_grade.grade_name;
                }else{
                    return '';    
                }

            }
        },
        {
            data: "branch_id",
            render: function(data, type, full, meta){
                if(data != 0){
                    // return '';
                    return full.get_branch.branch_name;
                }else{
                    return '';
                }

            }
        },
        {
            data: "subject",
            render: function(data, type, full, meta){
                return data;
            }
        },
        {
            data: "capture_code",
            render: function(data, type, full, meta){
                return data;
            }
        },
        {
            data: "display_order",
            render: function(data, type, full, meta){
                return data;
            }
        },
        {
            data: "display_order",
            render: function(data, type, full, meta){
                if(full.status == 'A'){
                    return 'Active';
                }else{
                    return 'Inactive';
                }
                // return data;
            }
        },
        {
            data: "id",
            render: function(data, type, full, meta){
                var a='';
                var willStatus = '';
                if(full.status == 'A'){
                    willStatus = 'Hide';
                }else{
                    willStatus = 'Show';
                }

                // a += '<a href="javascript:void(0);" title="View" class="gtest"><i class="fas fa-ellipsis-v"></i></a>';
                a+= '<a href="javascript:void(0);" class="action-dots action" data-key="'+full.id+'" id="action'+full.id+'"><img src="{{ public_asset('admin/assets/images/action-dots.png') }}" alt=""></a>\n\
                    <div class="show-actions" id="show-action'+full.id+'" style="display: none;">\n\
                        <span class="angle"><img src="{{ public_asset('admin/assets/images/angle.png') }}" alt=""></span>\n\
                        <ul>\n\
                            <li><a href="{{ url('admin/edit-subject').'/' }}'+full.id+'">Edit</a></li>\n\
                            <li><a class="status_change_subject" data-id="'+full.id+'" href="javascript:void(0);">'+willStatus+'</a></li>\n\
                            <li><a class="delete_subject" data-id="'+full.id+'" href="javascript:void(0);">Delete</a></li>\n\
                        </ul>\n\
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
        // $('#col1_filter').on( 'keyup click', function () {
        //     filterColumn( $(this).parents('div').data('column') );
        // });
        $('body').on('click', '.reset_search', function() {
            $(".reset_val").val("");
            $('#example').DataTable().search('').columns().search('').draw();

        });
        $('body').on('click','.search_click', function() {
            filterColumn( 1 );
            filterColumn( 2 );
            filterColumn( 3 );
            filterColumn( 4 );

            // $('#example').DataTable().draw();
        });
        $(document).on("click",".delete_subject",function(e){
            var id = $(e.currentTarget).attr("data-id"),
            obj = $(this),
            reqData = {
                'jsonrpc' : '2.0',
                '_token'  : '{{csrf_token()}}',
                'data'    : {
                    'id'    : id
                }
            },
            temp = table.row('.tr_class_'+id).data();
            var id = $(e.currentTarget).attr("data-id"),
            obj = $(this),
            reqData = {
                'jsonrpc' : '2.0',
                '_token'  : '{{csrf_token()}}',
                'data'    : {
                'id'      : id
                }
            },
            temp = table.row('.tr_class_'+id).data();
            var targetId = $(this).attr("id");
            $("#tId").val(targetId);
            $("#type_popup_next").val("A");
            // var tName = "Do you want to delete "+temp.f_name+" "+temp.l_name+" student ?";
            $("#ajax_url").val("{{ route('ajax.delete.subject') }}");
            $('#instructionModal').modal('show');
            var tName = "Do you want to delete "+temp.subject+" subject?";
            $("#tName").val(tName);
            $("#data_table_data_s").val(table);
            $("#ajax_data_id").val(id);

        });
        $(document).on("click",".status_change_subject",function(e){
            var id = $(e.currentTarget).attr("data-id"),
            obj = $(this),
            reqData = {
                'jsonrpc' : '2.0',
                '_token'  : '{{csrf_token()}}',
                'data'    : {
                    'id'    : id
                }
            },
            temp = table.row('.tr_class_'+id).data();
            var id = $(e.currentTarget).attr("data-id"),
            obj = $(this),
            reqData = {
                'jsonrpc' : '2.0',
                '_token'  : '{{csrf_token()}}',
                'data'    : {
                'id'      : id
                }
            },
            temp = table.row('.tr_class_'+id).data();
            var targetId = $(this).attr("id");
            $("#tId").val(targetId);
            $("#type_popup_next").val("A");
            // var tName = "Do you want to delete "+temp.f_name+" "+temp.l_name+" student ?";
            $("#ajax_url").val("{{ route('ajax.change.status.subject') }}");
            $('#instructionModal').modal('show');
            var tName = "Do you want to change status of "+temp.subject+" subject?";
            $("#tName").val(tName);
            $("#data_table_data_s").val(table);
            $("#ajax_data_id").val(id);

        });

        // $("#download").click(function(){
        //     $(".buttons-excel").trigger("click");
        // });
        // $("#example_wrapper div").eq(0).addClass("table-res");
        $("#example_info").remove();
        $("#example_length").remove();
    });
    function proceedConfirm() {
        var ajax_data_id= $("#ajax_data_id").val();
        var ajax_url= $("#ajax_url").val();

        var reqData = {
            'jsonrpc' : '2.0',
            '_token'  : '{{csrf_token()}}',
            'data'    : {
                'id'    : ajax_data_id
            }
        };

        var type = $.trim($("#type_popup_next").val());

        if(type == 'H') {
            window.location.href = ajax_url;
        } else {
            $.ajax({
                url:ajax_url,
                dataType: 'json',
                data: reqData,
                type: 'post',
                success:function(resp){
                    $('#admConfirmModal').modal('hide');
                    if(resp.status == 1){
                        table.row('.tr_class_'+ajax_data_id).remove().draw( false );
                        toastr.success(resp.message);
                    }else{
                        toastr.error(resp.message);
                    }
                },
                error:function(){
                    toastr.error("Something went wrong!Ajax error!");
                }
            });
        }
    }

    function admCloseModel() {
        $('#admConfirmModal').modal('hide');
    }
</script>
@endsection
