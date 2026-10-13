@extends('admin.layouts.app')
@section('title')
Academics
@endsection
@section('links')
@include('admin.includes.links')
<link rel="stylesheet" type="text/css" href="{{ public_asset('admin/assets/libs/css/chosen.css') }}">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedcolumns/3.2.1/css/fixedColumns.dataTables.min.css"/>
<style type="text/css">
/*this is excel button needs to hide as we have already download option*/
.buttons-excel{
    display: none;
}
.dt-buttons{
    display: none;
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
                <h1 class="pull-left page-title">Academics<br/><p class="small_tag">You can find information or edit your profile in this section</p></h1>
                <ol class="breadcrumb pull-right">


                    <li> <a href="{{ route('manage.tutors') }}"><i class="fas fa-backward"></i> Back</a></li>
                    <li> <a href="{{ route('view.tutor.academics',$user->id) }}"><i class="fas fa-eye"></i> View</a></li>

                    @if(@$previous_id)
                    <li> <a href="{{ route('edit.tutor.academics',@$previous_id) }}"><i class="fas fa-angle-double-left"></i> Previous</a></li>
                    @endif
                    @if(@$next_id)
                    <li> <a href="{{ route('edit.tutor.academics',@$next_id) }}"><i class="fas fa-angle-double-right"></i> Next</a></li>
                    @endif

                </ol>
            </div>
        </div>
        <div class="step_tab">
            <ul>
                <li class="">
                    <a href="{{ route('edit.tutor.personal.info.step.1',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/peri.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/perih.png') }}" class="accth"></span>
                    Personal Details
                    </a>
                </li>
                <li>
                    <a href="{{ route('edit.tutor.tutorship.plans',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/gar.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/garh.png') }}" class="accth"></span>
                    Tutoring Plan
                    </a>
                </li>
                <li class="active">
                    <a href="{{ route('edit.tutor.academics',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/aca.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/acah.png') }}" class="accth"></span>
                    Academics
                    </a>
                </li>
                <li>
                    <a href="{{ route('edit.tutor.experience',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/ex.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/exh.png') }}" class="accth"></span>
                    Experience </a>
                </li>
                <li>
                    <a href="{{ route('edit.tutor.rec',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/rec.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/rech.png') }}" class="accth"></span>
                    Recognitions
                    </a>
                </li>
                <li>
                    <a href="{{ route('edit.tutor.availablity',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/rec.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/rech.png') }}" class="accth"></span>
                    Availability
                    </a>
                </li>
                <li>
                    <a href="{{ route('edit.tutor.advance.page',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/rec.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/rech.png') }}" class="accth"></span>
                    Advanced
                    </a>
                </li>
                <div class="clearfix"></div>
            </ul>
        </div>

        <!-- Personal-Information -->
        <div class="panel panel-default panel-fill">
            <div class="panel-body rm02 rm04">
                @include('admin.includes.message')
                <form id="editTutorAcademic" method="post" @if(Route::is('update.tutor.academics')) action="{{ route('update.tutor.academics',@$tutorAcademicDtls->id) }}" @else action="{{ route('add.tutor.academics',@$user->id) }}" @endif enctype="multipart/form-data">
                    @csrf
                    <div class="frm_admin">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="qualification">Degree*</label>
                                    <select class="form-control  rm06 required" name="qualification" id="qualification">
                                        <option value="" > Select Degree</option>
                                        <option value="1" @if(@$tutorAcademicDtls->qualification == "1") selected="" @endif>Doctoral Degree</option>
                                        <option value="10" @if(@$tutorAcademicDtls->qualification == "10") selected="" @endif>Certificate</option>
                                        <option value="2" @if(@$tutorAcademicDtls->qualification == "2") selected="" @endif>Postgraduate</option>
                                        <option value="3" @if(@$tutorAcademicDtls->qualification == "3") selected="" @endif>Master's Degree (Research)</option>
                                        <option value="4" @if(@$tutorAcademicDtls->qualification == "4") selected="" @endif>Master's Degree</option>
                                        <option value="5" @if(@$tutorAcademicDtls->qualification == "5") selected="" @endif>Bachelor Honours Degree</option>
                                        <option value="6" @if(@$tutorAcademicDtls->qualification == "6") selected="" @endif>Bachelor’s Degree</option>
                                        <option value="7" @if(@$tutorAcademicDtls->qualification == "7") selected="" @endif>Associate Degree</option>
                                        <option value="8" @if(@$tutorAcademicDtls->qualification == "8") selected="" @endif>Advanced Diploma</option>
                                        <option value="9" @if(@$tutorAcademicDtls->qualification == "9") selected="" @endif>Diploma</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="qualification_status">Qualification Status*</label>
                                    <select class="form-control  rm06 required" name="qualification_status" id="qualification_status">
                                        <option value="">Select Qualification Status</option>
                                        <option value="C" @if(@$tutorAcademicDtls->qualification_status == "C") selected="" @endif>Completed</option>
                                        <option value="G" @if(@$tutorAcademicDtls->qualification_status == "G") selected="" @endif>Graduated</option>
                                        <option value="IP" @if(@$tutorAcademicDtls->qualification_status == "IP") selected="" @endif>In Progress</option>
                                        <option value="D" @if(@$tutorAcademicDtls->qualification_status == "D") selected="" @endif>Discontinued</option>
                                        <option value="GP" @if(@$tutorAcademicDtls->qualification_status == "GP") selected="" @endif>Gap Year</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="field_of_study">Field Study*</label>
                                    <select class="form-control  rm06 required" name="field_of_study" id="field_of_study">
                                        <option value="" > Select Field Of Study</option>
                                        @if(@$field_studies)
                                        @foreach(@$field_studies as $field_study)
                                        <option value="{{ @$field_study->id }}" @if(@$tutorAcademicDtls->field_of_study == @$field_study->id) selected="" @endif>{{ @$field_study->field_of_study }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="university">University*</label>
                                    <select class="form-control rm06 required  " name="university" id="university">
                                        <option value="" > Select University</option>
                                        @if(@$universities)
                                        @foreach(@$universities as $university)
                                        <option value="{{ @$university->id }}" @if(@$tutorAcademicDtls->university == @$university->id) selected="" @endif> {{ @$university->university_name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <div class="dash-d1">
                                        <label for="effective_date">Effective as on* </label>
                                        <div class="ui calendar" id="from_date">
                                            <div class="ui input left icon">
                                              <input type="text" id="effective_date" name="effective_date" placeholder="Select Date" class="form-control required" autocomplete="off" readonly="" value="{{ @$tutorAcademicDtls->effective_date }}">
                                              <span class="over_llp1"><img src="{{ public_asset('admin/assets/images/cal.png') }}" alt=""></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>
                            <div class="col-sm-12">
                                <div class="ad_btn">
                                    <button class="btn btn-primary waves-effect waves-light w-md c_edit_tutor_academic" id="edit_tutor_academic" type="button">@if(Route::is('update.tutor.academics')) Update @else Save @endif</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="centerButtons">

                                <div class="rm05 rightButtons">
                                <button class="btn btn-primary waves-effect waves-light w-md download" id="download" type="button">Download </button>
                            </div>
                            <div class="clearfix"></div>

                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="example">
                                        <thead>
                                            <tr>
                                                <th>Qualification </th>
                                                <th>Field Of Study</th>
                                                <th>University</th>
                                                <th>Qualification Status</th>
                                                <th>Effective Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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
$.validator.setDefaults({ ignore: ":hidden:not(.slct)" });
$(document).ready(function(){
    var isvalidator = $('#editTutorAcademic').validate({
        rules: {
            grade_id: { required: true},
            hourly_rate: { required: true,number:true},
        },
        submitHandler:function(form){
            form.submit();
        },
    });
    $('#editTutorAcademic').on('keyup keypress keydown', function(e) {
      var keyCode = e.keyCode || e.which;
      if (keyCode === 13) {
        e.preventDefault();
        return false;
      }
    });
    $("#edit_tutor_academic").click(function(){
        if(isvalidator.form()){
        if(isvalidator.valid()){
            var obj = $("#edit_tutor_academic"),
            tId = obj.attr("id"),
            tName = "c_edit_tutor_academic",
            tFrmId = "editTutorAcademic";
            $("#type_popup_next").val("R");
            isAuthorizedByAdmin(tName,tId,tFrmId);
            // toastr.error("Popup will open");
        }
        // else{
            // toastr.error("Please fill the form correctly first!");
        // }
        }
    });
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
                return year + '-' + month + '-' + day;
            }
        }
    });
    $('.slct').chosen();
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
            //             columns: [ 0, 1,2,3,4 ]
            //         }
            //     },
            //     'colvis'
            // ],
            columnDefs: [ { targets: 0, type: 'natural' } ],
            stateSave: true,
            // "pageLength":2,
            "order": [
                [3, "desc"]
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
                $(row).children(':nth-child(6)').addClass('rm07');
                $(row).children(':nth-child(6)').attr('data-id',r);
            },
            "ajax": {
                "url": "{{ route('manage.academic.data',@$user->id) }}",
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
                    if(full.qualification != null){
                        if(full.qualification == 1){
                            return "Doctoral Degree";
                        }
                        else if(full.qualification == 2){
                            return "Postgraduate";
                        }
                        else if(full.qualification == 3){
                            return "Master's Degree (Research) ";
                        }
                        else if(full.qualification == 4){
                            return "Master's Degree ";
                        }
                        else if(full.qualification == 5){
                            return "Bachelor Honours Degree ";
                        }
                        else if(full.qualification == 6){
                            return "Bachelor’s Degree";
                        }
                        else if(full.qualification == 7){
                            return "Associate Degree";
                        }
                        else if(full.qualification == 8){
                            return "Advanced Diploma";
                        }
                        else if(full.qualification == 9){
                            return "Diploma";
                        }else{
                            return "";
                        }
                        // return full.qualification;
                    }else{
                        return "";
                    }
                }
            },
            {
                data: "field_of_study",
                render: function(data, type, full, meta){
                    if(full.get_field_study.field_of_study != null){
                        return full.get_field_study.field_of_study;
                    }else{
                        return "";
                    }
                }
            },
            {
                data: "university",
                render: function(data, type, full, meta){
                    if(full.get_university.university_name != null){
                        return full.get_university.university_name;
                    }else{
                        return "";
                    }

                }
            },
            {
                data: "qualification_status",
                render: function(data, type, full, meta){
                    if(full.qualification_status != null){
                        if(full.qualification_status == 'C'){
                            return "Completed";
                        }
                        if(full.qualification_status == 'G'){
                            return "Graduated";
                        }
                        if(full.qualification_status == 'IP'){
                            return "In Progress";
                        }
                        if(full.qualification_status == 'D'){
                            return "Discontinued";
                        }
                        if(full.qualification_status == 'GP'){
                            return "Gap Year";
                        }
                        // return "";
                        // return full.qualification_status;
                    }else{
                        return "";
                    }
                }
            },
            {
                data: "effective_date",
                render: function(data, type, full, meta){
                    return data;
                }
            },
            {
                data: "id",
                render: function(data, type, full, meta){
                // console.log("print : "+JSON.stringify(meta));
                    var a='';
                    a+= '<a href="javascript:void(0);" class="action-dots action" data-key="'+full.id+'" id="action'+full.id+'"><img src="{{ public_asset('admin/assets/images/action-dots.png') }}" alt=""></a>\n\
                        <div class="show-actions" id="show-action'+full.id+'" style="display: none;">\n\
                            <span class="angle"><img src="{{ public_asset('admin/assets/images/angle.png') }}" alt=""></span>\n\
                            <ul>\n\
                                <li><a href="{{ url('admin/update-tutor-academics').'/' }}'+full.id+'">Edit</a></li>\n\
                                <li><a class="delete_tutor_academic" data-id="'+full.id+'" href="javascript:void(0);">Delete</a></li>\n\
                            </ul>\n\
                          </div>';
                    return a;
                }
            },
            ]
        };
        var table = dataTableCall(dataTableObj,"example");
        // var table = $('#example').DataTable(

        // );
    $("#example_filter").hide();
    $(document).on("click",".action",function(){
        var id = $(this).data("key");
        $("#show-action"+id).slideToggle();
    });

    $(document).on("click",".delete_tutor_academic",function(e){
        var targetId = $(this).attr("id");
            $("#tId").val(targetId);
            $("#type_popup_next").val("A");
            $("#ajax_url").val("{{ route('ajax.delete.academic') }}");
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

        // if(confirm("Do you want to delete this academic?")){
        //     $.ajax({
        //         url:"{{ route('ajax.delete.academic') }}",
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
    // $(document).on('click', function () {
    //     var $target = $(event.target);
    //     if(!$target.closest('.show-actions').length
    //         && !$target.closest('.action_menu').length
    //         && $('.show-actions').is(":visible")) {
    //         $('.show-actions').slideUp();
    //     }
    // });
    $("#download").click(function(){
        $(".buttons-excel").trigger("click");
    });
    // $("#example_wrapper div").eq(0).addClass("table-res");
    $("#example_info").remove();
        $("#example_length").remove();
});
</script>
@endsection
