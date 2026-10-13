@extends('admin.layouts.app')
@section('title')
Achievements
| You can find information or edit your awards and recognitions in this section
@endsection
@section('links')
@include('admin.includes.links')
<link rel="stylesheet" type="text/css" href="{{ public_asset('admin/assets/libs/css/chosen.css') }}">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedcolumns/3.2.1/css/fixedColumns.dataTables.min.css"/>
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
                <h1 class="pull-left page-title">Achievements<br/><p class="small_tag">You can find information or edit your awards and recognitions in this section</p></h1>
                <ol class="breadcrumb pull-right">
                    <li> <a href="{{ route('manage.tutors') }}"><i class="fas fa-backward"></i> Back</a></li>
                    <li> <a href="{{ route('view.tutor.recognitions',$user->id) }}"><i class="fas fa-eye"></i> View</a></li>

                    @if($previous_id)
                    <li> <a href="{{ route('edit.tutor.rec',@$previous_id) }}"><i class="fas fa-angle-double-left"></i> Previous</a></li>
                    @endif
                    @if(@$next_id)
                    <li> <a href="{{ route('edit.tutor.rec',@$next_id) }}"><i class="fas fa-angle-double-right"></i> Next</a></li>
                    @endif
                </ol>
            </div>
        </div>
        <div class="step_tab">
            <ul>
                <li>
                    <a href="{{ route('edit.tutor.personal.info.step.1',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/peri.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/perih.png') }}" class="accth"></span>
                    Personal Details
                    </a>
                </li>
                <li>
                    <a href="{{ route('edit.tutor.tutorship.plans',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/gar.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/garh.png') }}" class="accth"></span>
                    Tutorship Plan
                    </a>
                </li>
                <li>
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
                <li class="active">
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
                <form id="edit_tutor_recognization" method="post" @if(Route::is('update.tutor.rec')) action="{{ route('update.tutor.rec',@$tutorRecDtls->id) }}"  @else action="{{ route('add.tutor.rec',@$user->id) }}" @endif enctype="multipart/form-data">
                    @csrf
                    <div class="frm_admin">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="organization">Organization*</label>
                                    <input type="text" id="organization" name="organization" placeholder="ABC School" class="form-control required" value="{{ @$tutorRecDtls->organization }}" autocomplete="off" autofocus="">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="recg_title">Award / Recognition*</label>
                                    <input type="text" id="recg_title" name="recg_title" placeholder="Best Music Teacher" class="form-control required" value="{{ @$tutorRecDtls->recg_title }}" autocomplete="off" autofocus="">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="year_of_recg">Year Of Recognition*</label>
                                    <select id="year_of_recg" name="year_of_recg" class="form-control required">
                                        <option value="">Select Year</option>
                                        @foreach (range(date('Y'),1960) as $number) {
                                        <option value="{{ $number }}" @if(@$tutorRecDtls->year_of_recg == $number) selected="" @endif>{{ $number }}</option>
                                        @endforeach
                                    </select>
                                    {{-- <input type="number" id="year_of_recg" name="year_of_recg" placeholder="2015" class="form-control required" value="{{ @$tutorRecDtls->year_of_recg }}" autocomplete="off" autofocus="" min="1800" max="{{ date('Y') }}" maxlength="4"> --}}
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="description">Description*</label>
                                    <textarea maxlength="1000" type="text" id="description" name="description" placeholder="Describe briefly about your awards and recognitions in about 100 words" class="form-control  textarear_box" autocomplete="off" autofocus="">{!! strip_tags(@$tutorRecDtls->description) !!}</textarea>
                                    <div class="error_description error error_textarea"></div>
                                </div>
                            </div>

                            <div class="clearfix"></div>
                            <div class="col-sm-12">
                                <div class="ad_btn">
                                    <button class="btn btn-primary waves-effect waves-light w-md c_edit_tutor_recognization_button" type="button" id="edit_tutor_recognization_button">@if(Route::is('update.tutor.rec')) Update @else Save @endif</button>
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
                                                <th>Award / Recognition</th>
                                                <th>Year of Recognition</th>
                                                <th>Description</th>
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
        var isvalidator =  $('#edit_tutor_recognization').validate({
            rules: {
                grade_id: { required: true},
                hourly_rate: { required: true,number:true},
            },
            submitHandler:function(form){
               form.submit();
            },
        });
        $('#edit_tutor_recognization').on('keyup keypress keydown', function(e) {
          var keyCode = e.keyCode || e.which;
          if (keyCode === 13) {
            e.preventDefault();
            return false;
          }
        });
        $("#edit_tutor_recognization_button").click(function(){
            if(isvalidator.form()){
            if(isvalidator.valid()){
                var obj = $("#edit_tutor_recognization_button"),
                tId = obj.attr("id"),
                tName = "c_edit_tutor_recognization_button",
                tFrmId = "edit_tutor_recognization";
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
            // buttons: [
            //     {
            //         extend: 'excelHtml5',
            //         exportOptions: {
            //             columns: [ 0, 1,2,3 ]
            //         }
            //     },
            //     'colvis'
            // ],
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
                $(row).children(':nth-child(5)').addClass('rm07');
                $(row).children(':nth-child(5)').attr('data-id',r);
            },
            "ajax": {
                "url": "{{ route('manage.rec.data',@$user->id) }}",
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
                data: "recg_title",
                render: function(data, type, full, meta){
                    if(data != null){
                        return data;
                    }else{
                        return "";
                    }
                }
            },
            {
                data: "year_of_recg",
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
                // console.log("print : "+JSON.stringify(meta));
                    var a='';
                    a+= '<a href="javascript:void(0);" class="action-dots action" data-key="'+full.id+'" id="action'+full.id+'"><img src="{{ public_asset('admin/assets/images/action-dots.png') }}" alt=""></a>\n\
                        <div class="show-actions" id="show-action'+full.id+'" style="display: none;">\n\
                            <span class="angle"><img src="{{ public_asset('admin/assets/images/angle.png') }}" alt=""></span>\n\
                            <ul>\n\
                                <li><a href="{{ url('admin/update-My-Recognitions') }}/'+full.id+'">Edit</a></li>\n\
                                <li><a id="delete_tutor_recognision-'+full.id+'" class="openpopupajaxcall  delete_tutor_recognision" data-id="'+full.id+'" href="javascript:void(0);">Delete</a></li>\n\
                            </ul>\n\
                          </div>';
                    return a;
                }
            },
            ]
            };
        var table = dataTableCall(dataTableObj,"example");

        // var table = $('#example').DataTable(
            // {
            // stateSave: true,
            // // "pageLength":2,
            // "order": [
            //     [0, "desc"]
            // ],
            // "stateLoadParams": function (settings, data) {
            //     // $('#col1_filter').val(data.search.grade_name);
            // },
            // stateSaveParams: function (settings, data) {
            //     // data.search.grade_name = $('#col1_filter').val();
            // },
            // "processing": true,
            // "serverSide": true,
            // 'serverMethod': 'post',
            // "createdRow": function( row, data, dataIndex ) {
            //     var id = (JSON.stringify(data.id)),
            //     r = JSON.stringify(dataIndex);
            //     $(row).addClass("tr_class_"+id);
            //     $(row).addClass("tr_row_class");
            //     $(row).children(':nth-child(5)').addClass('rm07');
            //     $(row).children(':nth-child(5)').attr('data-id',r);
            // },
            // "ajax": {
            //     "url": "{{ route('manage.rec.data',@$user->id) }}",
            //     "data": function ( d ) {
            //         console.log(d);
            //         d.myKey = "myValue";
            //         d._token = "{{ @csrf_token() }}";
            //     },
            //     error: function (jqXHR, textStatus, errorThrown) {
            //         // Do something here
            //         console.log("'error in datatable");
            //     }
            // },
            // 'columns': [
            // {
            //     data: "organization",
            //     render: function(data, type, full, meta){
            //         if(data != null){
            //             return data;
            //         }else{
            //             return "";
            //         }

            //     }
            // },
            // {
            //     data: "recg_title",
            //     render: function(data, type, full, meta){
            //         if(data != null){
            //             return data;
            //         }else{
            //             return "";
            //         }
            //     }
            // },
            // {
            //     data: "year_of_recg",
            //     render: function(data, type, full, meta){
            //         if(data != null){
            //             return data;
            //         }else{
            //             return "";
            //         }
            //     }
            // },
            // {
            //     data: "description",
            //     render: function(data, type, full, meta){
            //         if(data != null){
            //             return data;
            //         }else{
            //             return "";
            //         }
            //     }
            // },
            // {
            //     data: "id",
            //     render: function(data, type, full, meta){
            //     // console.log("print : "+JSON.stringify(meta));
            //         var a='';
            //         a+= '<a href="javascript:void(0);" class="action-dots action" data-key="'+full.id+'" id="action'+full.id+'"><img src="{{ public_asset('admin/assets/images/action-dots.png') }}" alt=""></a>\n\
            //             <div class="show-actions" id="show-action'+full.id+'" style="display: none;">\n\
            //                 <span class="angle"><img src="{{ public_asset('admin/assets/images/angle.png') }}" alt=""></span>\n\
            //                 <ul>\n\
            //                     <li><a href="{{ url('admin/update-My-Recognitions') }}/'+full.id+'">Edit</a></li>\n\
            //                     <li><a id="delete_tutor_recognision-'+full.id+'" class="openpopupajaxcall  delete_tutor_recognision" data-id="'+full.id+'" href="javascript:void(0);">Delete</a></li>\n\
            //                 </ul>\n\
            //               </div>';
            //         return a;
            //     }
            // },
            // ]
            // }
        // );
        $("#example_filter").hide();
        $(document).on("click",".action",function(){
            var id = $(this).data("key");
            $("#show-action"+id).slideToggle();
        });
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

        // $(document).on("click",".openpopupajaxcall:not(.delete_tutor_recognision)",function(e){
        //     var id = $(this).attr("id");
        //     $("#tId").val(tId);
        //     $('#instructionModal').modal('show');
        //     // isAuthorizedByAdmin(null,id,null);
        // });
        $(document).on("click",".delete_tutor_recognision",function(e){
            var targetId = $(this).attr("id");
            $("#tId").val(targetId);
            $("#type_popup_next").val("A");
            $("#ajax_url").val("{{ route('ajax.delete.recognision') }}");
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
            // if(confirm("Do you want to delete this recognision?")){
            //     $.ajax({
            //         url:"{{ route('ajax.delete.recognision') }}",
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
    });
</script>
@endsection
