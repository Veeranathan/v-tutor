@extends('admin.layouts.app')
@section('title')
View Assesments
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
                <h1 class="pull-left page-title">View Assesments</h1>
                <ol class="breadcrumb pull-right">
                    {{-- <li> <a href="{{ route('add.grade') }}"><i class="far fa-plus-square" aria-hidden="true"></i> Add Grade</a></li> --}}
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading rm02 rm04">
                        <form action="{{ route('admin.class.end.assesment.management.a') }}" method="get">
                            <div data-column="1" class="form-group">
                                <label for="col1_filter">Search Booking No</label>
                                <input type="text" placeholder=" " id="col1_filter" name="booking_search" class="form-control reset_val" value="" autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');">
                            </div>
                            <div data-column="2" class="form-group">
                                <label for="col2_filter">Rating</label>
                                <select id="col2_filter" name="col2_filter" class="form-control reset_val">
                                    <option value="">Select rating</option>
                                    <option value="5">5</option>
                                    <option value="4">4</option>
                                    <option value="3">3</option>
                                    <option value="2">2</option>
                                    <option value="1">1</option>
                                </select>
                            </div>
                            <div data-column="3" class="form-group">
                                <div class="dash-d1">
                                    <label for="col3_filter">Search From Date(Created At)</label>
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
                                    <label for="col4_filter">Search To Date (Created At)</label>
                                    <div class="ui calendar calendardatepicker" id="to_date">
                                        <div class="ui input left icon">
                                          <input type="text" id="col4_filter" name="col4_filter" placeholder="" class="form-control reset_val" autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');">
                                          <span class="over_llp1"><img src="{{ public_asset('admin/assets/images/cal.png') }}" alt=""></span>
                                          <span class="error_to_date error"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            {{-- <div data-column="5" class="form-group">
                                <div class="dash-d1">
                                    <label for="col5_filter">Search From Date(Booking Date)</label>
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
                                    <label for="col6_filter">Search To Date (Booking Date)</label>
                                    <div class="ui calendar calendardatepicker" id="booking_to_date">
                                        <div class="ui input left icon">
                                          <input type="text" id="col6_filter" name="col6_filter" placeholder="" class="form-control reset_val" autocomplete="off"  readonly="">
                                          <span class="over_llp1"><img src="{{ public_asset('admin/assets/images/cal.png') }}" alt=""></span>
                                          <span class="error_to_date error"></span>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div data-column="5" class="form-group">
                                <label for="col5_filter">Assessment from</label>
                                <select id="col5_filter" name="col5_filter" class="form-control reset_val">
                                    <option value="">Select </option>
                                    @if(@$posted_by)
                                    @foreach(@$posted_by as $s)
                                    <option value="{{$s->id}}">{{ @$s->f_name.' '.@$s->l_name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div data-column="6" class="form-group">
                                <label for="col6_filter"> Assessment by Student</label>
                                <select id="col6_filter" name="col6_filter" class="form-control reset_val">
                                    <option value="">Select Student</option>
                                    @if(@$students)
                                    @foreach(@$students as $s)
                                    <option value="{{ @$s->id }}">{{ @$s->f_name.' '.@$s->l_name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div data-column="7" class="form-group">
                                <label for="col7_filter"> Assessment by Tutor</label>
                                <select id="col7_filter" name="col7_filter" class="form-control reset_val">
                                    <option value="">Select Tutor</option>
                                    @if(@$tutors)
                                    @foreach(@$tutors as $s)
                                    <option value="{{ @$s->id }}">{{ @$s->f_name.' '.@$s->l_name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
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
                                    {{-- <div class="table-res"> --}}
                                    <table class="table table-bordered table-striped" id="example">
                                        <thead>
                                            <tr>
                                                <th class="rm07">Booking No</th>
                                                <th class="rm07">Assessment by</th>
                                                <th class="rm07">Assessed by</th>
                                                <th class="rm07">Overall rating</th>
                                                <th class="rm07">Date</th>
                                                <th class="rm07">Student Name</th>
                                                <th class="rm07">Tutor Name</th>
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

<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js" integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg==" crossorigin="anonymous"></script>

<script type="text/javascript">
    $(document).ready(function(){

        function filterColumn ( i ) {
            $('#example').DataTable().column( i ).search(
                $('#col'+i+'_filter').val(),
            ).draw();
        }

        var dataTableObj = {

            stateSave: false,
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
                $(row).children(':nth-child(10)').attr('data-id',r);
                $(row).children(':nth-child(3)').attr('data-id',r);
            },
            "ajax": {
                "url": "{{ route('admin.class.end.assesment.management') }}",
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
            columnDefs: [ { targets: 0, type: 'natural' } ],
            'columns': [
            {
                data: "booking_id",
                render: function(data, type, full, meta){
                    return full.booking_info.booking_no;
                }
            },

            {
                data: "user_id",
                render: function(data, type, full, meta){
                    // return full.get_tutor.f_name+" "+full.get_tutor.l_name;
                    if(full.get_user.user_type == 'T'){
                        return 'Tutor';
                    }else{
                        return 'Student';
                    }
                }
            },
            {
                data: "user_id",
                render: function(data, type, full, meta){
                    // return full.get_student.f_name+" "+full.get_student.l_name;
                    return full.get_user.f_name+" "+full.get_user.l_name;
                }
            },
            {
                data: "rating",
                render: function(data, type, full, meta){
                    return full.rating;


                }
            },
            {
                data: "id",
                render: function(data, type, full, meta){
                    var date = new Date(full.created_at);
                        var day = date.getDate();
                        var month = date.getMonth();
                        var year = date.getFullYear();
                        var created_at = year+'-'+("0" + (month+ 1)).slice(-2)+'-'+("0" + day).slice(-2);
                        return created_at;
                }
            },
            {
                data: "id",
                render: function(data, type, full, meta){
                    return full.booking_info.get_student.f_name+" "+full.booking_info.get_student.l_name;
                }
            },
            {
                data: "id",
                render: function(data, type, full, meta){

                    return full.booking_info.get_tutor.f_name+" "+full.booking_info.get_tutor.l_name;
                }
            },
            {
                data: "id",
                render: function(data, type, full, meta){
                    var a='';
                    a+= '<a href="javascript:void(0);" class="action-dots action" data-key="'+full.id+'" id="action'+full.id+'"><img src="{{ public_asset('admin/assets/images/action-dots.png') }}" alt=""></a>\n\
                        <div class="show-actions" id="show-action'+full.id+'" style="display: none;">\n\
                            <span class="angle"><img src="{{ public_asset('admin/assets/images/angle.png') }}" alt=""></span>\n\
                            <ul>';
                    a+='<li><a href="{{ url('admin/view-class-end-assesment').'/' }}'+full.id+'">View Details</a></li>';
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
        $('body').on('click','.reset_search', function() {
            $(".reset_val").val("");
            $('#example').DataTable().search('').columns().search('').draw();
        });
        $('body').on('click','.search_click', function() {
            $('#example').DataTable().column( 1 ).search(
                $('#col1_filter').val(),
            ).draw();
            $('#example').DataTable().column( 2 ).search(
                $('#col2_filter option:selected').val(),
            ).draw();
            $('#example').DataTable().column( 3 ).search(
                $('#col3_filter').val(),
            ).draw();
            $('#example').DataTable().column( 4 ).search(
                $('#col4_filter').val(),
            ).draw();
            $('#example').DataTable().column( 5 ).search(
                $('#col5_filter option:selected').val(),
            ).draw();
            $('#example').DataTable().column( 6 ).search(
                $('#col6_filter option:selected').val(),
            ).draw();

            $('#example').DataTable().column( 7 ).search(
                $('#col7_filter option:selected').val(),
            ).draw();
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
        $("#example_info").remove();
        $("#example_length").remove();
    });
</script>
@endsection
