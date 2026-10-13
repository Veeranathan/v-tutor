@extends('admin.layouts.app')
@section('title')
Student Management
@endsection
@section('links')
@include('admin.includes.links')

<script src="{{ public_asset('admin/assets/js/modernizr.min.js') }}"></script>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<style type="text/css">
    .ratings_message{

        word-break: break-all;
    }
    .textLimit {
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
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
                            <label for="col1_filter">Keyword</label>
                            <input type="text" placeholder="Keyword" id="col1_filter" name="col1_filter" class="form-control reset_val" value="" autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');">
                        </div>
                        <div data-column="2" class="form-group">
                            <label for="col2_filter">Rattings</label>
                            <select id="col2_filter" name="col2_filter" class="form-control reset_val">
                                <option value="">Select Rattings</option>
                                <option value="1">1 star</option>
                                <option value="2">2 star</option>
                                <option value="3">3 star</option>
                                <option value="4">4 star</option>
                                <option value="5">5 star</option>
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
                                                <th class="rm07">Review by (Student)</th>
                                                <th class="rm07">Review for (Tutor)</th>
                                                <th class="rm07">Review Date</th>
                                                <th class="rm07">Rating</th>
                                                <th class="rm07">Comments</th>
                                                {{-- <th class="rm07">Action</th> --}}
                                                {{-- <th class="rm07">Status</th> --}}
                                                {{-- <th class="rm07">Closed on</th> --}}
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

            columnDefs: [ { targets: 0, type: 'natural' } ],
            stateSave: false,
            "order": [
                [0, "desc"]
            ],
            "stateLoadParams": function (settings, data) {

            },
            stateSaveParams: function (settings, data) {

            },
            "processing": true,
            "serverSide": true,
            'serverMethod': 'post',
            "createdRow": function( row, data, dataIndex ) {
                var id = (JSON.stringify(data.id));
                var r = JSON.stringify(dataIndex);
                $(row).addClass("tr_class_"+id);
                $(row).addClass("data"+id);
                $(row).addClass("tr_row_class");
                $(row).children(':nth-child(5)').addClass('ratings_message');
                $(row).children(':nth-child(5)').addClass('');

                $(row).children(':nth-child(6)').addClass('rm07');
                $(row).children(':nth-child(6)').addClass('reviews-lists');
                $(row).children(':nth-child(6)').attr('data-id',r);
            },
            "ajax": {
                "url": "{{ route('review.list.datatable') }}",
                "data": function ( d ) {

                    d.myKey = "myValue";
                    d._token = "{{ @csrf_token() }}";
                },
                error: function (jqXHR, textStatus, errorThrown) {

                }
            },
            'columns': [

                {
                    data: "id",
                    render: function(data, type, full, meta){
                        var name = "";
                        if(full.tutor.f_name != null ){
                            name += full.tutor.f_name+" ";
                        }
                        if(full.tutor.l_name != null ){
                            name += full.tutor.l_name;
                        }
                        return name;
                    }
                },
                {
                    data: "id",
                    render: function(data, type, full, meta){
                        var name = "";
                        if(full.student.f_name != null ){
                            name += full.student.f_name+" ";
                        }
                        if(full.student.l_name != null ){
                            name += full.student.l_name;
                        }
                        return name;
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

                        }else{
                            return ' ';
                        }
                    }
                },
                {
                    data: "ratting",
                    render: function(data, type, full, meta){
                        var rHtml ='';
                        for(var i=0;i<=full.ratting - 1;i++){
                            rHtml = rHtml+'<a href="#url"><img src="{{ public_asset('assets/images/star.png')}}" style="width: 10px"></a>';
                        }
                        var bHtml ='';
                        for(var i=0;i<5- full.ratting;i++){
                            bHtml = bHtml+'<a href="#url"><img src="{{ public_asset('assets/images/star1.png')}}" style="width: 10px"></a>';
                        }
                        return rHtml+bHtml;
                    }
                },
                {
                    data: "message",
                    render: function(data, type, full, meta){
                        var m = '<p class="add_ttrr desi ">'+data+'</p>';
                        var t = '<p class="add_ttrr desi textLimit">'+data+'</p>\n\
                            <a class="{{-- moreless-button2 --}}  allread" onclick="readmore('+full.id+')" id="rr'+full.id+'">Read More +</a>\n\
                            <p class="moretext2 desi" style="display: none;" id="desc'+full.id+'">\n\
                              <a class="allread" style="display: none;" onclick="readless('+full.id+')" id="rrr'+full.id+'">Read less -</a>\n\
                            </p>';
                        return t;
                    }
                },
                {
                    data: "id",
                    render: function(data, type, full, meta){
                        var changeStatus = "";

                        var a='';
                        a+= '<a href="javascript:void(0);" class="action-dots action" data-key="'+full.id+'" id="action'+full.id+'"><img src="{{ public_asset('admin/assets/images/action-dots.png') }}" alt=""></a>\n\
                            <div class="show-actions" id="show-action'+full.id+'" style="display: none;">\n\
                                <span class="angle"><img src="{{ public_asset('admin/assets/images/angle.png') }}" alt=""></span>\n\
                                <ul>\n\
                                    <li><a class="delete_review" href="javascript:void(0);" data-id="'+full.id+'" onclick="dlt('+full.id+')">Delete</a></li>\n\
                                </ul>\n\
                              </div>';
                        return a;
                    }
                },
            ]
        };
        var table = dataTableCall(dataTableObj,"example");
        $(document).on("click",".delete_review",function(e){
            if(confirm('Are you sure want to delete this review ?')){
                dlt($(this).attr("data-id"));
            }
        });
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

            var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);

            if(from_date < to_date){
                $("#to_date").val("");
                $("#from_date").val("");
            }
        });
        $(document).on("blur","#to_date",function(){
            var from_date = Date.parse($("#col3_filter").val()),
            to_date = Date.parse($("#col4_filter").val());
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
        $('#instructionModal').modal('hide');
        $("#example_info").remove();
        $("#example_length").remove();
    });
</script>
<script>
  function dlt(id){

  $.ajaxSetup({
  headers: {
  'X-CSRF-TOKEN': "{{csrf_token()}}"
  }
  });
  var fd= new FormData;
  fd.append('id',id);

  $.ajax({
  url:'{{route('review.dlt')}}',
  type:'POST',
  data: fd,
  contentType: false,
  processData: false,

  success:function(res){
  //console.log(res.msg,res.dates);
  //alert(res.id);
  $(".data"+id).remove();

  }
  });
  }
  </script>
<script>
  function readmore(id){
  //alert('j');
  $("#desc"+id).slideToggle("slow");
  $("#rr"+id).hide();
  $("#rrr"+id).show();

  }
  function readless(id){
  //alert('j');
  $("#desc"+id).slideToggle("slow");
  $("#rr"+id).show();
  $("#rrr"+id).hide();

  }
  </script>
@endsection
