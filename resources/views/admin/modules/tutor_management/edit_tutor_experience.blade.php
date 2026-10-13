@extends('admin.layouts.app')
@section('title')
My Experience

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
                <h1 class="pull-left page-title">My Experience<br/><p class="small_tag">You can find information or edit your work experience in this section</p></h1>
                <ol class="breadcrumb pull-right">
                    <li> <a href="{{ route('manage.tutors') }}"><i class="fas fa-backward"></i> Back</a></li>
                    <li> <a href="{{ route('view.tutor.experience',$user->id) }}"><i class="fas fa-eye"></i> View</a></li>

                    @if(@$previous_id)
                    <li> <a href="{{ route('edit.tutor.experience',@$previous_id) }}"><i class="fas fa-angle-double-left"></i> Previous</a></li>
                    @endif
                    @if(@$next_id)
                    <li> <a href="{{ route('edit.tutor.experience',@$next_id) }}"><i class="fas fa-angle-double-right"></i>Next</a></li>
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
                <li >
                    <a href="{{ route('edit.tutor.tutorship.plans',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/gar.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/garh.png') }}" class="accth"></span>
                    Tutorship Plan
                    </a>
                </li>
                <li >
                    <a href="{{ route('edit.tutor.academics',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/aca.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/acah.png') }}" class="accth"></span>
                    Academics
                    </a>
                </li>
                <li class="active">
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
                <form id="edit_tutor_experience" method="post" @if(Route::is('add.tutor.exp') || Route::is('update.tutor.experience') ) action="{{ route('update.tutor.experience',@$tutorExpDtls->id) }}" @else action="{{ route('add.tutor.exp',@$user->id) }}" @endif enctype="multipart/form-data">
                    @csrf
                    <div class="frm_admin">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="organization">Organization*</label>
                                    <input type="text" id="organization" name="organization" placeholder="Organization" class="form-control required" value="{{ @$tutorExpDtls->organization }}" autocomplete="off" autofocus="" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="job_title">Job Title*</label>
                                    <input type="text" id="job_title" name="job_title" placeholder="Job Title" class="form-control required" value="{{ @$tutorExpDtls->job_title }}" autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');" autofocus="">

                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="year_of_exp">Years Of Experience*</label>
                                    <input type="number" id="year_of_exp" name="year_of_exp" placeholder="Years Of Experience" class="form-control required" @if(@$tutorExpDtls->year_of_exp) value="{{ @$tutorExpDtls->year_of_exp }}" @else value="0" @endif autocomplete="off" readonly=""  autofocus="">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="from_year">From*</label>
                                    <select id="from_year" name="from_year" class="form-control required">
                                        <option value="">Select</option>
                                        @foreach (range(date('Y'),1960) as $number)
                                        <option value="{{ $number }}" @if(@$tutorExpDtls->from_year == $number) selected="" @endif>{{ $number }}</option>
                                        @endforeach

                                    </select>
                                    <span class="error_from_year" style="color:red;"></span>
                                    {{-- <label for="from_year">From Year</label>
                                    <div class="ui calendar year_dropdown" id="from_year">
                                    <div class="ui input left icon">
                                        <i class="time icon"></i>
                                        <input type="text" placeholder="Year" class="form-control required" id="from_year" name="from_year"  readonly="">
                                    </div> --}}
                                </div>

                                {{-- </div> --}}
                            </div>
                            {{-- <div class="clearfix"></div> --}}
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="to_year">To*</label>
                                    {{-- <label for="to_year">To Year</label>
                                    <div class="ui calendar year_dropdown" id="to_year">
                                    <div class="ui input left icon">
                                      <i class="time icon"></i>
                                      <input type="text" placeholder="Year" class="form-control required" id="to_year" name="to_year" readonly="">
                                    </div> --}}
                                    <select id="to_year" name="to_year" class="form-control required">
                                        <option value="">Select</option>
                                        @foreach (range(date('Y'),1960) as $number)
                                        <option value="{{ $number }}" @if(@$tutorExpDtls->to_year == $number) selected="" @endif>{{ $number }}</option>
                                        @endforeach
                                        {{-- <option value="2000" @if(@$tutorExpDtls->to_year == '2000') selected="" @endif>2000</option> --}}
                                        {{-- <option value="2001" @if(@$tutorExpDtls->to_year == '2001') selected="" @endif>2001</option>
                                        <option value="2002" @if(@$tutorExpDtls->to_year == '2002') selected="" @endif>2002</option>
                                        <option value="2003" @if(@$tutorExpDtls->to_year == '2003') selected="" @endif>2003</option>
                                        <option value="2004" @if(@$tutorExpDtls->to_year == '2004') selected="" @endif>2004</option>
                                        <option value="2005" @if(@$tutorExpDtls->to_year == '2005') selected="" @endif>2005</option>
                                        <option value="2006" @if(@$tutorExpDtls->to_year == '2006') selected="" @endif>2006</option>
                                        <option value="2007" @if(@$tutorExpDtls->to_year == '2007') selected="" @endif>2007</option>
                                        <option value="2008" @if(@$tutorExpDtls->to_year == '2008') selected="" @endif>2008</option>
                                        <option value="2009" @if(@$tutorExpDtls->to_year == '2009') selected="" @endif>2009</option>
                                        <option value="2010" @if(@$tutorExpDtls->to_year == '2010') selected="" @endif>2010</option>
                                        <option value="2011" @if(@$tutorExpDtls->to_year == '2011') selected="" @endif>2011</option>
                                        <option value="2012" @if(@$tutorExpDtls->to_year == '2012') selected="" @endif>2012</option>
                                        <option value="2013" @if(@$tutorExpDtls->to_year == '2013') selected="" @endif>2013</option>
                                        <option value="2014" @if(@$tutorExpDtls->to_year == '2014') selected="" @endif>2014</option>
                                        <option value="2015" @if(@$tutorExpDtls->to_year == '2015') selected="" @endif>2015</option>
                                        <option value="2016" @if(@$tutorExpDtls->to_year == '2016') selected="" @endif>2016</option>
                                        <option value="2017" @if(@$tutorExpDtls->to_year == '2017') selected="" @endif>2017</option>
                                        <option value="2018" @if(@$tutorExpDtls->to_year == '2018') selected="" @endif>2018</option>
                                        <option value="2019" @if(@$tutorExpDtls->to_year == '2019') selected="" @endif>2019</option>
                                        <option value="2020" @if(@$tutorExpDtls->to_year == '2020') selected="" @endif>2020</option>
                                        <option value="2021" @if(@$tutorExpDtls->to_year == '2021') selected="" @endif>2021</option> --}}
                                    </select>
                                    <span class="error_to_year" style="color:red;"></span>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="branch_id">Branch</label>
                                    <select class="form-control required" id="branch_id" name="branch_id">
                                        <option value="">Select Branch</option>
                                        @if(@$branches)
                                        @foreach(@$branches as $b)
                                        <option value="{{ @$b->id }}" @if(@$subject->branch_id == $b->id) selected="" @endif>{{ @$b->branch_name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="subject_id">Subject taught*</label>
                                    <select id="subject_id" name="subject_id[]" class="form-control required" >
                                        <option value="">Select</option>
                                        @if(@$subjects)
                                        @foreach(@$subjects as $subject)
                                        <option value="{{ @$subject->id }}" @if(in_array($subject->id,@$get_subject_id)) selected="" @endif>{{ @$subject->subject }}</option>
                                        @endforeach
                                        @endif
                                    </select>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            {{-- <div class="clearfix"></div> --}}
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea maxlength="1000" type="text" id="description" name="description" placeholder="Describe briefly about your job profile, roles and responsibilities in about 100 words" class="form-control  textarea_box" value="" autocomplete="off" autofocus="" rows="6" cols="6" autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');">{!! strip_tags(@$tutorExpDtls->description) !!}</textarea>
                                    <div class="error_description error error_textarea" ></div>

                                </div>
                            </div>
                            {{-- <div class="clearfix"></div> --}}
                            <div class="col-sm-12">
                                <div class="ad_btn">
                                    <button class="btn btn-primary waves-effect waves-light w-md c_edit_tutor_experience_button" type="button" id="edit_tutor_experience_button">@if(Route::is('update.tutor.experience')) Update  @else Save @endif</button>
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
                                                <th>Organization </th>
                                                <th>Job Title</th>
                                                <th>Year Of Experience</th>
                                                <th>From Year</th>
                                                <th>To Year</th>
                                                <th>Description</th>
                                                <th>Subject Taught</th>
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
$("#example_filter").hide();
$(document).ready(function(){
    $.validator.setDefaults({ ignore: ":hidden:not(.slct)" });
    $(document).on("click",".action",function(){
        var id = $(this).data("key");
        $("#show-action"+id).slideToggle();
    });
    var isvalidator = $('#edit_tutor_experience').validate({
        rules: {
            grade_id: { required: true},
            hourly_rate: { required: true,number:true},
        },
        submitHandler:function(form){
           form.submit();
        },
    });
    $('#edit_tutor_experience').on('keyup keypress keydown', function(e) {
      var keyCode = e.keyCode || e.which;
      if (keyCode === 13) {
        e.preventDefault();
        return false;
      }
    });
    $("#edit_tutor_experience_button").click(function(){
        if(isvalidator.form()){
        if(isvalidator.valid()){
            var obj = $("#edit_tutor_experience_button"),
            tId = obj.attr("id"),
            tName = "c_edit_tutor_experience_button",
            tFrmId = "edit_tutor_experience";
            $("#type_popup_next").val("R");
            isAuthorizedByAdmin(tName,tId,tFrmId);
        }else{
            $('#instructionModal').modal('hide');
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
        //     buttons: [
        //         {
        //             extend: 'excelHtml5',
        //             exportOptions: {
        //                 columns: [ 0, 1,2,3,4,5,6 ]
        //             }
        //         },
        //         'colvis'
        //     ],
        columnDefs: [ { targets: 0, type: 'natural' } ],
        stateSave: true,
        // "pageLength":2,
        "order": [
            [0, "desc"]
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
            $(row).children(':nth-child(8)').addClass('rm07');
            $(row).children(':nth-child(8)').attr('data-id',r);
        },
        "ajax": {
            "url": "{{ route('manage.exp.data',@$user->id) }}",
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
            data: "organization",
            render: function(data, type, full, meta){
                if(data != null){
                    return data;
                }else{
                    return "";
                }

            }
        },
        {
            data: "job_title",
            render: function(data, type, full, meta){
                if(data != null){
                    return data;
                }else{
                    return "";
                }
            }
        },
        {
            data: "year_of_exp",
            render: function(data, type, full, meta){
                if(data != null){
                    return data;
                }else{
                    return "";
                }
            }
        },
        {
            data: "from_year",
            render: function(data, type, full, meta){
                if(data != null){
                    return data;
                }else{
                    return "";
                }
            }
        },
        {
            data: "to_year",
            render: function(data, type, full, meta){
                if(data != null){
                    return data;
                }else{
                    return "";
                }
            }
        },
        {
            data: "description",
            render: function(data, type, full, meta){
                if(data != null){
                    return data;
                }else{
                    return "";
                }
            }
        },
        {
            data: "id",
            render: function(data, type, full, meta){
                var length = full.get_exp_to_sub.length;
                if(length>0){
                    var subjects = "";
                    for(var i=0;i<length;i++){
                        subjects = subjects+" "+full.get_exp_to_sub[i].subject_name.subject;
                    }
                    return subjects;
                }else{
                    return "";
                }
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
                            <li><a href="{{ url('admin/update-tutor-experience').'/' }}'+full.id+'">Edit</a></li>\n\
                            <li><a class="delete_tutor_experience" data-id="'+full.id+'" href="javascript:void(0);">Delete</a></li>\n\
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
    $('.year_dropdown').calendar({
      type: 'year'
    });
    $("#example_filter").hide();
    $("#description").on('keyup', function() {
        var words = 0;
        if((this.value.match(/\S+/g)) != null) {
            words = this.value.match(/\S+/g).length;
        }
        if(words > 100){
            var trimmed = $(this).val().split(/\s+/, 100).join(" ");
            $(this).val(trimmed + " ");
        }
    });
    $(document).on("blur","#to_year",function(){
        var to_year = parseInt($.trim($("#to_year").val()));
        var from_year = parseInt($.trim($("#from_year").val()));
        if(to_year < from_year){
            $(this).val("");
            $(".error_from_year").html("From year cannot be greater than to year!");
            $(".error_to_year").html("From year cannot be greater than to year!");
        }else{
            var year_of_exp = to_year - from_year;
            $("#year_of_exp").val(year_of_exp);
        }

    });
    $(document).on("blur","#from_year",function(){
        var to_year = parseInt($.trim($("#to_year").val()));
        var from_year = parseInt($.trim($("#from_year").val()));
        if(to_year < from_year){
            $(this).val("");
            $(".error_to_year").html("From year cannot be greater than to year!");
            $(".error_from_year").html("From year cannot be greater than to year!");
        }else{
            var year_of_exp = to_year - from_year;
            $("#year_of_exp").val(year_of_exp);
        }

    });
    $(document).on("click",".delete_tutor_experience",function(e){
        var targetId = $(this).attr("id");
            $("#tId").val(targetId);
            $("#type_popup_next").val("A");
            $("#ajax_url").val("{{ route('ajax.delete.experience') }}");
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
        // if(confirm("Do you want to delete this experience?")){
        //     $.ajax({
        //         url:"{{ route('ajax.delete.experience') }}",
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
                function check() {
                    var badWords = [];
                    @php
                    $badwords = \DB::table('bad_words')->pluck('words')->toArray();
                    @endphp
                    @foreach(@$badwords as $value)
                        badWords.push('{{$value}}');
                    @endforeach
                    // console.log(badWords);
                    var wordInput = textarea.val();
                    wordInput = wordInput.toLowerCase();
                    var arr = wordInput.split(" ");
                    var foundBadWords = arr.filter(el => badWords.includes(el));

                    if(foundBadWords.length>0){
                        $(".error_textarea").html('Kindly refrain from using email, phone or flagged words on the description!');
                        textarea.val("");

                    }

                    // email & phone word
                    var flaggedWord = ['email','phone'];
                    var wordInput = textarea.val();
                    wordInput = wordInput.toLowerCase();
                    var arr = wordInput.split(" ");
                    var foundFlaggedWords = arr.filter(el => flaggedWord.includes(el));

                    if(foundFlaggedWords.length>0){
                        textarea.val("");
                        $(".error_textarea").html('Kindly refrain from using email, phone or flagged words on the description!');
                    }else{
                        var v = textarea.val();
                        if(v != ""){
                            $(".error_textarea").html('');
                        }

                    }

                }
                var textarea = $('.textarea_box');
                textarea.on({
                    keyup: function(e) {
                        if (e.which == 188) check();
                        if (e.which == 32) check();

                        check();
                        var words = 0;
                            if((this.value.match(/\S+/g)) != null) {
                                words = this.value.match(/\S+/g).length;
                            }
                            if(words > 100){
                                var trimmed = $(this).val().split(/\s+/, 100).join(" ");
                                $(this).val(trimmed + " ");
                            }
                    },
                    blur: check
                });
                $("#download").click(function(){
            $(".buttons-excel").trigger("click");
        });
                // $("#example_wrapper div").eq(0).addClass("table-res");
                $("#example_info").remove();
        $("#example_length").remove();
        $(document).on("change","#branch_id",function(e){
        var grade_id = $.trim($(this).val()),
        branch_id = $.trim($('#branch_id').val()),
        obj = $(this),
        reqData = {
            'jsonrpc' : '2.0',
            '_token'  : '{{csrf_token()}}',
            'data'    : {
                'grade_id'    : grade_id,
                'branch_id'    : branch_id,
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
});
</script>
@endsection
