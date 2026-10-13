@extends('admin.layouts.app')
@section('title')
Right to Work
| You can find information
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



    .textLimit {
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .gj_wwcc_tbl_desc {
        margin-top: 15px !important;
        margin-bottom: 10px;
        /* font-style: italic;
        font-weight: 600;
        font-size: 12px !important; */
    }

    .gj_wwcc_tbl_hd {
        color: #d73c5d;
        text-align: center;
        font-size: 16px;
        margin: 15px auto;
    }
    td.gj_wwcc_hd {
        text-align: center;
        font-weight: 700;
    }
    .gj_wwcc_nnote {
        font-style: italic;
        font-size: 14px !important;
        margin-bottom: 20px !important;
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
                <h1 class="pull-left page-title">Right to Work<br/><p class="small_tag">This section allows you to view your WWCC work authorisation.</p></h1>
                <ol class="breadcrumb pull-right">
                    <li> <a href="{{ route('manage.tutors') }}"><i class="fas fa-backward"></i> Back</a></li>
                    {{-- <li> <a href="{{ route('edit.tutor.rec',$user->id) }}"><i class="fas fa-pen"></i> Edit</a></li> --}}

                    @if($previous_id)
                    <li> <a href="{{ route('view.tutor.right.to.work',@$previous_id) }}"><i class="fas fa-angle-double-left"></i> Previous</a></li>
                    @endif
                    @if(@$next_id)
                    <li> <a href="{{ route('view.tutor.right.to.work',@$next_id) }}"><i class="fas fa-angle-double-right"></i> Next</a></li>
                    @endif
                </ol>
            </div>
        </div>
        <div class="step_tab">
            <ul>
                <li>
                    <a href="{{ route('view.tutor.personal.info.step.1',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/peri.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/perih.png') }}" class="accth"></span>
                    Personal Details
                    </a>
                </li>
                <li>
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
                <li class="active">
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
                {{--<li>
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
                            </div>
                            <div class="clearfix"></div>

                        </div> --}}
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="wwcc_rtw_div">
                                    <p class="gj_wwcc_nnote">To work with V-Tutor, your Working with Children Check (WWCC) must remain valid in the states and territories where you tutor. Please keep your details up to date and let us know at wwcc@v-tutor.com.au if anything changes. If a WWCC expires, you won’t be able to work in that region until it’s renewed. </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td colspan="4" class="gj_wwcc_hd">Working with Children Check (WWCC)</td>
                                            </tr>
                                            <tr>
                                                <th class="text-center">State</th>
                                                <th class="text-center">WWCC #</th>
                                                <th class="text-center">Date of Expiry</th>
                                                <th class="text-center">WWCC Doc</th>
                                                <th class="text-center">Authorised</th>
                                            </tr>
                                            
                                            @if (is_array(config('tutor_form.australian_states')))
                                                @php
                                                    $wwccData = collect(@$tutor_wwcc ?? [])->keyBy('states');
                                                @endphp
                                                @foreach (config('tutor_form.australian_states') as $wwcc_chk_k => $wwcc_chk_v)
                                                    @php
                                                        $ext_wwcc_chk_k = @$wwccData[$wwcc_chk_k] ?? null;
                                                    @endphp
                                                    
                                                    <tr>
                                                        <td class="text-left">{{ $wwcc_chk_v }}</td>
                                                        <td class="text-left">{{ $ext_wwcc_chk_k['wwcc_no'] ?? '-' }}</td>
                                                        <td class="text-center">{{ (isset($ext_wwcc_chk_k['expiry_date']) && $ext_wwcc_chk_k['expiry_date']) ? date('d M Y', strtotime($ext_wwcc_chk_k['expiry_date'])) : '-' }}</td>
                                                        <td>
                                                            @if (isset($ext_wwcc_chk_k['wwcc_doc']) && $ext_wwcc_chk_k['wwcc_doc'])
                                                                <a href="{{ $ext_wwcc_chk_k['wwcc_doc'] ? public_asset($ext_wwcc_chk_k['wwcc_doc']) : '' }}" target="_blank" class="wwcc_doc_file">View Doc</a>     
                                                            @else
                                                                {{ '-' }}
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @if (isset($ext_wwcc_chk_k['is_valid']) && $ext_wwcc_chk_k['is_valid'] == 3)
                                                                {{ 'Not Validated' }}
                                                            @elseif (isset($ext_wwcc_chk_k['is_valid']) && $ext_wwcc_chk_k['is_valid'] == 2)
                                                                {{ 'No' }}
                                                            @elseif (isset($ext_wwcc_chk_k['is_valid']) && $ext_wwcc_chk_k['is_valid'] == 1)
                                                                {{ 'Yes' }}
                                                            @else
                                                                {{ '-' }}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 col-12 mb-3">
                                <div class="gj_wwcc_tbl_div">
                                    <p class="gj_wwcc_tbl_desc">Below is a list of official government websites
                                        where users can find information, apply, or check the status of a
                                        Working with Children Check (WWCC) (or its equivalent) in each
                                        Australian state and territory:</p>

                                    <h4 class="gj_wwcc_tbl_hd">WWCC Information by State and Territory –
                                        Official Websites </h4>

                                    <div class="table-responsive gj_tbl_resp">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>State / Territory</th>
                                                    <th> WWCC Name </th>
                                                    <th style="width: 450px;"> Official Website </th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @if (is_array(config('tutor_form.wwcc_australian_states')))
                                                    @foreach (config('tutor_form.wwcc_australian_states') as $aus_sts_k => $aus_sts_v)
                                                        <tr>
                                                            <td>{{ $aus_sts_v['states'] }}</td>

                                                            <td>{{ $aus_sts_v['wwcc'] }}</td>

                                                            <td>
                                                                <a href="{{ $aus_sts_v['link'] }}"
                                                                    target="_blank">{{ $aus_sts_v['link_text'] }}</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
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
        $("#edit_tutor_recognization_button").click(function(){
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
            //             columns: [ 0, 1,2,3]
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
                data: "location",
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
        $("#download").click(function(){
            $(".buttons-excel").trigger("click");
        });
        // $("#example_wrapper div").eq(0).addClass("table-res");
        $("#example_info").remove();
        $("#example_length").remove();
    });
</script>
@endsection
