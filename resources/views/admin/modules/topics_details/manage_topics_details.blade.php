@extends('admin.layouts.app')
@section('title')
View Session Topics
@endsection
@section('links')
@include('admin.includes.links')

<script src="{{ asset('public/admin/assets/js/modernizr.min.js') }}"></script>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<style>
    /* Ensure the dropdown and its parent are styled correctly */
td {
  position: relative;
  overflow: visible !important;
}

.show-actions {
  position: absolute;
  top: 25px;
  right: 0;
  background: #fff;
  border: 1px solid #ccc;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
  border-radius: 4px;
  z-index: 9999;
  display: none;
  min-width: 130px;
}

.show-actions ul {
  list-style: none;
  margin: 0;
  padding: 5px 0;
}

.show-actions ul li {
  padding: 8px 12px;
}

.show-actions ul li a {
  color: #333;
  text-decoration: none;
  display: block;
}

.show-actions ul li a:hover {
  background-color: #f0f0f0;
}

.angle {
  position: absolute;
  top: -8px;
  right: 10px;
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
                <h1 class="pull-left page-title">View Session Topic Management</h1>
                <ol class="breadcrumb pull-right">
                    <!--li> <a href="{{ route('add.topics.details') }}"><i class="far fa-plus-square" aria-hidden="true"></i> Add Topics Details</a></li-->
                   
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading rm02 rm04">
                        <form role="form" id="searchSubject" method="get" action="{{ route('topics.management.list.tab.details') }}">
                                     <div data-column="2" class="form-group">
                                        <label for="col1_filter">Grade</label>
                                        <select class="form-control reset_val" id="col1_filter" name="col1_filter">
                                            <option value="">Select Grade</option>
                                            @if(@$grades)
                                            @foreach(@$grades as $g)
                                            <option value="{{ @$g->id }}">{{ @$g->grade_name }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                 <div data-column="2" class="form-group">
                                        <label for="col2_filter">Branch</label>
                                        <select class="form-control reset_val" id="col2_filter" name="col2_filter">
                                            <option value="">Select Branch</option>
                                            @if(@$branches)
                                            @foreach(@$branches as $b)
                                            <option value="{{ @$b->id }}">{{ @$b->branch_name }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>      
                                     <div data-column="2" class="form-group">
                                        <label for="col2_filter">Subject</label>
                                        <select class="form-control reset_val" id="col3_filter" name="col3_filter">
                                            <option value="">Select Subject</option>
                                           
                                        </select>
                                    </div>      
                                     <div data-column="2" class="form-group">
                                        <label for="col2_filter">Subject Topic</label>
                                        <select class="form-control reset_val" id="col4_filter" name="col4_filter">
                                            <option value="">Select Topic</option>
                                           
                                        </select>
                                    </div>      
                        <div data-column="1" class="form-group">
                                <label for="col1_filter">Subject Details Code</label>
                                <input type="text" placeholder="Subject Details Code" id="col5_filter" name="col5_filter" class="form-control reset_val" value="" autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');">
                            </div>   
                            
                            <div data-column="1" class="form-group">
                                <label for="col1_filter">Session Focus</label>
                                <input type="text" placeholder="Session Focus" id="col6_filter" name="col6_filter" class="form-control reset_val" value="" autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');">
                            </div>
                            <div data-column="1" class="form-group">
                                <label for="col1_filter">Learning Outcome</label>
                                <input type="text" placeholder="Learning Outcome" id="col7_filter" name="col7_filter" class="form-control reset_val" value="" autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');">
                            </div>
                            <div data-column="3" class="form-group">
                                        <label for="col3_filter">Status</label>
                                        <select class="form-control reset_val" id="col8_filter" name="col8_filter">
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
                                  <table class="table table-bordered"  id="example">
    <thead>
        <tr>
            <th class="rm07">Grade</th> 
            <th class="rm07">Branch</th>
            <th class="rm07">Subject</th>
            <th class="rm07">Topic</th>
            <th class="rm07">Details Code</th>
            <th class="rm07">Session Focus</th> 
            <th class="rm07">Learning Outcome</th>
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
<script src="{{url('/')}}/public/assets/js/chosen.jquery.js" type="text/javascript"></script>
<script src="{{url('/')}}/public/assets/js/init.js" type="text/javascript"></script>
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
   
        $('col1_filter,#col2_filter').change(function() {
             var branchId = $('#col2_filter').val();
            var gradeId = $('#col1_filter').val();
             $('#col3_filter').empty().append('<option value="">Select Subject</option>');

            if (branchId && gradeId) {
                $.ajax({
                    url: 'get-subjects/' + branchId + '/' + gradeId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if (data.length > 0) {
                            $.each(data, function(index, subject) {
                                $('#col3_filter').append(
                                    '<option value="' + subject.id + '">' + subject.subject + '</option>'
                                );
                            });
                        } else {
                            $('#col3_filter').append('<option value="">No subjects found</option>');
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Failed to fetch subjects. Error: ' + error);
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    $('col1_filter,#col3_filter').change(function() {
            var gradeId = $('#col1_filter').val();
            var subjectId = $('#col3_filter').val();
            $('#col4_filter').empty().append('<option value="">Select Topic</option>');
                                       

            if (gradeId && subjectId) {
                $.ajax({
                    url: 'get-topics/' + gradeId + '/' + subjectId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                          if (data.length > 0) {
                        $.each(data, function(index, topic) {
                            $('#col4_filter').append('<option value="' + topic.id + '">' + topic.topics + '</option>');
                        });
                   } else {
                            $('#col3_filter').append('<option value="">No subjects found</option>');
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Failed to fetch subjects. Error: ' + error);
                        console.error(xhr.responseText);
                    }
                });
            }
        });


    function filterColumn ( i ) {
        $('#example').DataTable().column( i ).search(
            $('#col'+i+'_filter').val(),
        ).draw();
    }

    var dataTableObj = {
        stateSave: false,
        "order": [
            [8, "desc"]
        ],
        "stateLoadParams": function (settings, data) {
            // $('#col5_filter').val(data.search.session_focus);  
        },
        stateSaveParams: function (settings, data) { 
            // data.search.topics = $('#col5_filter').val();
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
            $(row).children(':nth-child(8)').addClass('rm07');
            $(row).children(':nth-child(8)').addClass('reviews-lists');
            $(row).children(':nth-child(8)').attr('data-id',r);
        },
        "ajax": {
            "url": "{{ route('topics.management.details') }}",
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
            data: "subject_id",
            render: function(data, type, full, meta){    
                if(data != 0){
                    // return '';    
                    return full.get_subject.subject;
                }else{
                    return '';    
                }
                
            }
        },
{ 
            data: "topic_id",
render: function(data, type, full, meta){    
    if (data != 0 && full.get_topic && full.get_topic.topics) {
        return full.get_topic.topics;
    } else {
        return '';    
    }
}},
        { 
            data: "topic_det_code",
            render: function(data, type, full, meta){    
                return data;
            }
        },
       { 
            data: "session_focus",
            render: function(data, type, full, meta){    
                return data;
            }
        },
        { 
            data: "learning_outcome",
            render: function(data, type, full, meta){    
                return data;
            }
        },
       
        { 
            data: "status",
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
  render: function (data, type, full, meta) {
    var willStatus = full.status === 'A' ? 'Hide' : 'Show';
    var a = '';

    a += '<div class="action-wrapper">' +
      '<a href="javascript:void(0);" class="action-dots action" data-key="' + full.id + '" id="action' + full.id + '">' +
        '<img src="{{ public_asset("admin/assets/images/action-dots.png") }}" alt="Actions">' +
      '</a>' +
      '<div class="show-actions" id="show-action' + full.id + '">' +
        '<span class="angle"><img src="{{ public_asset("admin/assets/images/angle.png") }}" alt=""></span>' +
        '<ul>' +
          
          '<li><a href="{{ url("admin/change-status-topic-details") }}/' + full.id + '">' + willStatus + '</a></li>' +
          
        '</ul>' +
      '</div>' +
    '</div>';

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
            filterColumn( 5 );
            filterColumn( 6 );
            filterColumn( 7 );
            filterColumn( 8 );
            
            // $('#example').DataTable().draw();
        });
        $(document).on("click",".delete_topics_details",function(e){
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
            $("#ajax_url").val("{{ route('ajax.delete.topics.details') }}");
            $('#instructionModal').modal('show');
            var tName = "Do you want to delete ?";
            $("#tName").val(tName);
            $("#data_table_data_s").val(table);
            $("#ajax_data_id").val(id);
            
        });
        $(document).on("click",".status_change_topics_details",function(e){
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
            $("#ajax_url").val("{{ route('ajax.change.status.topics.details') }}");
            $('#instructionModal').modal('show');
            var tName = "Do you want to change status ?";
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
</script>
@endsection