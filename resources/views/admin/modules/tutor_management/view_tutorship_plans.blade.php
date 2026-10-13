@extends('admin.layouts.app')
@section('title')
Tutoring Plan
@endsection
@section('links')
@include('admin.includes.links')
<link rel="stylesheet" type="text/css" href="{{ public_asset('admin/assets/libs/css/chosen.css') }}">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedcolumns/3.2.1/css/fixedColumns.dataTables.min.css"/>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<style type="text/css">
/*this is excel button needs to hide as we have already download option*/
    .buttons-excel{
    display: none;
}
.step_tab ul {
    display: flex;
    flex-wrap: nowrap !important;
    padding-left: 0;
    margin-bottom: 10px;
}

.step_tab ul li {
    margin-right: 6px;
}

.step_tab ul li a {
    font-size: 11px !important;       /* Smaller font */
    padding: 5px 10px !important;      /* Reduce tab width */
    border-radius: 6px !important;     /* Slightly smaller curve */
    white-space: nowrap;
    display: flex;
    align-items: center;
    gap: 4px;                          /* Reduce icon + text gap */
}

.step_tab ul li a span img {
    width: 15px !important;           /* Reduce icon size */
    height: auto;
}


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
    <div class="wraper container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="pull-left page-title">Tutoring Plan<br/><p class="small_tag">You can find information or view tutor profile in this section </p></h1>
                <ol class="breadcrumb pull-right">
                    <li> <a href="{{ route('manage.tutors') }}"><i class="fas fa-backward"></i> Back</a></li>
                    {{-- <li> <a href="{{ route('edit.tutor.tutorship.plans',$user->id) }}"><i class="fas fa-pen"></i> Edit</a></li> --}}

                    @if(@$previous_id)
                    <li> <a href="{{ route('view.tutor.tutorship.plans',@$previous_id) }}"><i class="fas fa-angle-double-left"></i> Previous</a></li>
                    @endif

                    @if(@$next_id)
                    <li> <a href="{{ route('view.tutor.tutorship.plans',@$next_id) }}"><i class="fas fa-angle-double-right"></i> Next</a></li>
                    @endif
                </ol>
            </div>
        </div>
        <div class="step_tab">
            <ul>
                <li class="">
                    <a href="{{ route('view.tutor.personal.info.step.1',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/peri.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/perih.png') }}" class="accth"></span>
                    Personal Details
                    </a>
                </li>
                <li class="active">
                    <a href="{{ route('view.tutor.tutorship.plans',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/gar.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/garh.png') }}" class="accth"></span>
                    Tutorship Plan
                    </a>
                </li>
                <li>
                    <a href="{{ route('view.tutor.academics',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/aca.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/acah.png') }}" class="accth"></span>
                    Academics
                    </a>
                </li>
                <li>
                    <a href="{{ route('view.tutor.experience',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/ex.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/exh.png') }}" class="accth"></span>
                    Experience </a>
                </li>
                <li>
                    <a href="{{ route('view.tutor.recognitions',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/rec.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/rech.png') }}" class="accth"></span>
                    Recognitions
                    </a>
                </li>
                <li>
                    <a href="{{ route('view.tutor.right.to.work',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/rec.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/rech.png') }}" class="accth"></span>
                    Right to Work
                    </a>
                </li>
                 <li>
                    <a href="{{ route('view.tutor',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/rec.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/rech.png') }}" class="accth"></span>
                    Availability
                    </a>
                </li>
               {{-- <li>
                    <a href="{{ route('view.tutor.advance.page',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/rec.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/rech.png') }}" class="accth"></span>
                    Advanced
                    </a>
                </li> --}}

                <div class="clearfix"></div>
            </ul>
        </div>

        <!-- Personal-Information -->
        <div class="panel panel-default panel-fill">
            <div class="panel-body rm02 rm04">
                @include('admin.includes.message')

                    <div class="frm_admin">
                        <div class="row">
                            {{-- <div class="centerButtons">

                                <div class="rm05 rightButtons">
                                <button class="btn btn-primary waves-effect waves-light w-md download" id="download" type="button">Download </button>
                            </div> --}}
                            <div class="clearfix"></div>

                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="example">
                                        <thead>
                                            <tr>
                                                <th>Grade </th>
                                                <th>Branch </th>
                                                <th>Subject</th>
                                                <th>Rate per Session</th>
                                                {{-- <th>Action</th>     --}}
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
</div>
@endsection
@section('footer')
@include('admin.includes.footer')
@endsection
@section('script')
@include('admin.includes.script')
<script src="{{public_asset('admin/assets/js/jquery.validate.js')}}"></script>
<script src="{{ public_asset('admin/assets/libs/js/chosen.jquery.min.js') }}"></script>

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
    $.validator.setDefaults({ ignore: ":hidden:not(.slct)" });
    var isvalidator = $('#addTutorshipPlans').validate({
        rules: {
            grade_id: { required: true},
            hourly_rate:
            {
                required: true,
                number:true,
                min:10,
                max:100
            },
        },
        messages: {
            grade_id: {
                required: 'Grade required'
            },
            hourly_rate: {
                required: 'Rate per session (30 mins) is required'
            },
        },
        errorPlacement: function (error, element)
        {
            // console.log(element.attr("name"));
            // console.log(error);
            if (element.attr("name") == "subject_id[]") {
                var error = '<label for="fn" generated="true" class="error" style="color:#f85d2c;border:none!important;background:none!important;">'+'Please select atleast one subject!'+'</label>';
                $('.error_subject').html(error);
            }
            if (element.attr("name") == "grade_id") {
                var error = '<label for="fn" generated="true" class="error" style="color:#f85d2c;border:none!important;background:none!important;">'+'This field is required!'+'</label>';
                $('.error_grade').html(error);
            }
            if (element.attr("name") == "hourly_rate") {
                var error = '<label for="fn" generated="true" class="error" style="color:#f85d2c;border:none!important;background:none!important;">'+'Please enter the value between 10 to 100!'+'</label>';
                $('.error_hourly_rate').html(error);
            }

        },
        submitHandler:function(form){
           form.submit();
        },
    });
    $("#edit_tutor_tutorship_plans").click(function(){
        if(isvalidator.form()){
        if(isvalidator.valid()){
            var obj = $("#edit_tutor_tutorship_plans"),
            tId = obj.attr("id"),
            tName = "c_edit_tutor_tutorship_plans",
            tFrmId = "addTutorshipPlans";
            $("#type_popup_next").val("R");
            isAuthorizedByAdmin(tName,tId,tFrmId);
        }else{
            $('#instructionModal').modal('hide');
        }
        }

    });
    $("#example_filter").hide();


    // alert(url);
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
            //             columns: [ 0, 1,2 ]
            //         }
            //     },
            //     'colvis'
            // ],
            columnDefs: [ { targets: 0, type: 'natural' } ],
            stateSave: true,
            // "pageLength":2,
            "order": [
                [2, "desc"]
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
                $(row).addClass("tr_class_"+id);
                $(row).addClass("tr_row_class");
                $(row).children(':nth-child(5)').addClass('rm07');
                $(row).children(':nth-child(5)').attr('data-id',r);
            },
            "ajax": {
                "url": "{{ route('manage.tutorship.plans.data',@$user->id) }}",
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
                data: "id",
                render: function(data, type, full, meta){
                    if(full.get_grade.grade_name != null){
                        return full.get_grade.grade_name;
                    }else{
                        return "";
                    }
                }
            },
            {
                data: "id",
                render: function(data, type, full, meta){
                    if(full.get_branch.branch_name != null){
                        return full.get_branch.branch_name;
                    }else{
                        return "";
                    }
                }
            },
            {
                data: "id",
                render: function(data, type, full, meta){
                    if(full.get_subject.subject != null){
                        return full.get_subject.subject;
                    }else{
                        return "";
                    }
                }
            },
            {
                data: "hourly_rate",
                render: function(data, type, full, meta){
                    return '$ '+data;
                }
            },
            // {
            //     data: "id",
            //     render: function(data, type, full, meta){
            //     // console.log("print : "+JSON.stringify(meta));
            //         var a='';
            //         // a+= '<a href="javascript:void(0);" class="action-dots action" data-key="'+full.id+'" id="action'+full.id+'"><img src="{{ public_asset('admin/assets/images/action-dots.png') }}" alt=""></a>\n\
            //         //     <div class="show-actions" id="show-action'+full.id+'" style="display: none;">\n\
            //         //         <span class="angle"><img src="{{ public_asset('admin/assets/images/angle.png') }}" alt=""></span>\n\
            //         //         <ul>\n\
            //         //             <li><a href="{{ url('admin/update-tutorship-plan').'/' }}'+full.id+'">Edit</a></li>\n\
            //         //             <li><a id="delete_tutor_ship_plan_'+full.id+'" class="delete_tutor_ship_plan" href="javascript:void(0);" data-id="'+full.id+'">Delete</a></li>\n\
            //         //         </ul>\n\
            //         //       </div>';
            //         return a;
            //     }
            // },
            ]
        };
        var table = dataTableCall(dataTableObj,"example");
        // var table = $('#example').DataTable(

        // );
        $("#example_filter").hide();
        $(document).on("click",".action",function(e){
            var id = $(this).data("key");
            $("#show-action"+id).slideToggle();
        });
    // $("#example").DataTable();

        // messages: {
        //         grade_id: {
        //             required: 'Grade required'
        //         },
        //         hourly_rate: {
        //             required: '@lang('validation.required')'
        //         },
        //         internal_order_rate: {
        //             required: '@lang('validation.required')'
        //         },
        //         external_order_rate: {
        //             required: '@lang('validation.required')'
        //         }
        //     },

    $(document).on("change",".required",function(){
        var id = $(this).attr("id");
        if(id == "subject_id"){
            $('.error_subject').html("");
        }
        if(id == "hourly_rate"){
            $('.error_hourly_rate').html("");
        }
        if(id == "grade_id"){
            $('.error_grade').html("");
        }
    });
    $(document).on("keyup",".required",function(){
        var id = $(this).attr("id");
        var value = parseInt($.trim($(this).val()));
        if(id == "hourly_rate"){
            if(value <=10 || value >=100){
                $('.error_hourly_rate').html("Please enter the value between 10 to 100");
            }else{
                $('.error_hourly_rate').html("");
            }

        }

    });
    $('.slct').chosen();
    $(document).on("click",".delete_tutor_ship_plan",function(e){
        var targetId = $(this).attr("id");
            $("#tId").val(targetId);
            $("#type_popup_next").val("A");
            $("#ajax_url").val("{{ route('ajax.delete.tutorship.plan') }}");
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
            $("#data_table_data_s").val(table);
            $("#ajax_data_id").val(id);
        // var currentObj = $(this),
        // tName = 'delete_tutor_ship_plan',
        // tId = $(this).attr("id");
        // isAuthorizedByAdmin(currentObj,tName,tId);
        // var isAuthorized = isAuthorizedByAdmin();
        // if(isAuthorized == 1){
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

            // if(confirm("Do you want to delete this tutorship plan?")){
            //     $.ajax({
            //         url:"{{ route('ajax.delete.tutorship.plan') }}",
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
        // }else{
            // toastr.error("Password wrong!");
            // $('#instructionModal').modal('hide');
        // }

    });
    $(document).on("change","#grade_id",function(e){
        var grade_id = $.trim($(this).val()),
        obj = $(this),
        reqData = {
            'jsonrpc' : '2.0',
            '_token'  : '{{csrf_token()}}',
            'data'    : {
                'grade_id'    : grade_id,
                'teacher_id'    : {{@$user->id  }}
            }
        };
        $.ajax({
            url:"{{ route('ajax.grade.subject') }}",
            dataType: 'json',
            data: reqData,
            type: 'post',
            success:function(resp){
                if(resp.count <=0){
                    $("#subject_id").html("");
                }else{
                    $("#subject_id").html(resp.html_response);
                }
                $(".slct").val('').trigger("chosen:updated");
            },
            error:function(){

            }
        });

    });
    $("#download").click(function(){
        $(".buttons-excel").trigger("click");
    });
    // $("#example_wrapper div").eq(0).addClass("table-res");
    $("#example_info").remove();
    $("#example_length").remove();
});
</script>
@endsection
