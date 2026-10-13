@extends('admin.layouts.app')
@section('title')
Session Topics Management
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
                <h1 class="pull-left page-title">Session Topic Management</h1>
                <ol class="breadcrumb pull-right">
                    <li> <a href="{{ route('add.topics') }}"><i class="far fa-plus-square" aria-hidden="true"></i> Add Topics</a></li>
                   
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading rm02 rm04">
                        <form role="form" id="searchSubject" method="get" action="{{ route('topics.management.list.tab') }}">
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
                                            @if(@$subTopics)
                                            @foreach(@$subTopics as $st)
                                            <option value="{{ @$st->id }}">{{ @$st->topics }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>      
                                    
                            
                            <div data-column="3" class="form-group">
                                        <label for="col3_filter">Status</label>
                                        <select class="form-control reset_val" id="col5_filter" name="col5_filter">
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
                                <button type="submit"
        formaction="{{ route('topics.export') }}"
        class="btn btn-primary download">
    Download
</button>
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

    // Load subjects on branch filter
    $('#col2_filter').change(function() {
        var branchId = $(this).val();
        $('#col3_filter').empty().append('<option value="">Select Subject</option>');

        if (branchId) {
            $.ajax({
                url: 'get-subjects/' + branchId,
                type: 'GET',
                success: function(data) {
                    $.each(data, function(key, subject) {
                        $('#col3_filter')
                            .append('<option value="' + subject.id + '">' + subject.subject + '</option>');
                    });
                }
            });
        }
    });

    // ============= DataTable Configuration ============= //
    var dataTableObj = {
        stateSave: false,
        order: [[5, "desc"]],
        processing: true,
        serverSide: false,
        scrollX: true,
        scrollY: "400px",
        scrollCollapse: true,
        autoWidth: false,

        ajax: {
            url: "{{ route('topics.management.list.tab') }}",
            type: "GET",
            data: function(d) {
                d.col1_filter = $('#col1_filter').val();
                d.col2_filter = $('#col2_filter').val();
                d.col3_filter = $('#col3_filter').val();
                d.col4_filter = $('#col4_filter').val();
                d.col5_filter = $('#col5_filter').val();
            },
            dataSrc: "data"
        },

        // IMPORTANT — MATCH THE JSON YOUR CONTROLLER RETURNS
        columns: [
            { data: "grade", name: "grade" },
            { data: "branch", name: "branch" },
            { data: "subject", name: "subject" },
            { data: "topics", name: "topics" },
            { data: "status_label", name: "status_label" },
            { 
                data: "action",
                orderable: false,
                searchable: false,
                render: function(data, type, full, meta){
                    return data;
                }
            }
        ],

        createdRow: function(row, data, dataIndex){
            $(row).addClass("tr_class_" + data.id);
            $(row).addClass("tr_row_class");
            $(row).children(':nth-child(1)').addClass('rm07');
            $(row).children(':nth-child(2)').addClass('rm07');
            $(row).children(':nth-child(3)').addClass('rm07');
            $(row).children(':nth-child(4)').addClass('rm07');
            $(row).children(':nth-child(5)').addClass('rm07 reviews-lists');
        }
    };

    var table = $('#example').DataTable(dataTableObj);

    $("#example_filter").hide();

    // Toggle Actions Menu
    $(document).on("click", ".action", function(){
        var id = $(this).data("key");
        $("#show-action" + id).slideToggle();
    });

    // RESET
    $('body').on('click', '.reset_search', function() {
        $(".reset_val").val("");
        table.search('').columns().search('').draw();
    });

    // SEARCH
    $('body').on('click','.search_click', function() {
        table.ajax.reload();
    });

    // DELETE TOPIC
    $(document).on("click",".delete_topics",function(){
        var id = $(this).attr("data-id");
        var row = table.row('.tr_class_' + id).data();

        $("#ajax_url").val("{{ route('ajax.delete.topics') }}");
        $("#tName").val("Do you want to delete " + row.topics + " topic?");
        $("#ajax_data_id").val(id);

        $('#instructionModal').modal('show');
    });

    // STATUS CHANGE
    $(document).on("click",".status_change_topics",function(){
        var id = $(this).attr("data-id");
        var row = table.row('.tr_class_' + id).data();

        $("#ajax_url").val("{{ route('ajax.change.status.topics') }}");
        $("#tName").val("Do you want to change status of " + row.topics + "?");
        $("#ajax_data_id").val(id);

        $('#instructionModal').modal('show');
    });

    $("#example_info").remove();
    $("#example_length").remove();
});
</script>

@endsection