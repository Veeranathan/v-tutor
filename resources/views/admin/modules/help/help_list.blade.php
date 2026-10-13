@extends('admin.layouts.app')
@section('title')
Help Guide Management
@endsection
@section('links')
@include('admin.includes.links')
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
      {{--
      <div class="col-sm-12">
        --}}
        <h1 class="pull-left page-title">Help Guide Management</h1>
        <ol class="breadcrumb pull-right">
        </ol>
        <div class="rm05 backclass">
          <button class="btn btn-primary waves-effect waves-light w-md reset_search" onclick="rst()" type="button"><a href="{{route('add.help.page')}} " style="color: white"> Add Help Guide</a>   </button>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default ">
          <form action="{{ route('help.list') }}" method="post" id="frm">
            @csrf
            <div class="panel-heading rm02 rm04">
              <div data-column="2" class="form-group">
                <label for="col2_filter">Help Category</label>
                <select id="cat" name="cat" class="form-control reset_val">
                  <option value="">Select help category</option>
                  @php
                  $cats= DB::table('help_category')->get();
                  @endphp
                  @foreach($cats as $val)
                  <option value="{{$val->id}}" @if(request('cat')==@$val->id) selected @endif>{{@$val->name}}</option>
                  @endforeach
                </select>
              </div>
              <div data-column="2" class="form-group">
                <label for="col2_filter">Status</label>
                <select id="status" name="status" class="form-control reset_val">
                  <option value="">Select status</option>
                  <option value="A" @if(request('status')=="A") selected @endif>Active</option>
                  <option value="I" @if(request('status')=="I") selected @endif>Inactive</option>
                </select>
              </div>
              <div class="centerButtons">
                <div class="rm05">
                  <button class="btn btn-primary waves-effect waves-light w-md search_click" type="submit">Search</button>
                </div>
                <div class="rm05">
                  <button class="btn btn-primary waves-effect waves-light w-md reset_search" onclick="rst()" type="button">Reset </button>
                </div>
              </div>
              <div class="clearfix"></div>
            </div>
          </form>
          <div class="panel-body">
            @include('admin.includes.message')
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="table-responsive" id="t1">
                  {{-- start --}}
                  <table id="example" class="cell-border table table-responsive">
                    <thead>
                      <tr>
                        <th >Questions </th>
                        <th >Help Category </th>
                        <th >Status </th>
                        <th >Display Order </th>
                        <th >Date </th>
                        <th> </th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($helps as $key=> $val)
                      <tr id="data{{$val->id}}">
                        <td data-label="Name">
                          {{@$val->question}}
                        </td>
                        <td data-label="Name">
                          @php
                          $cat=DB::table('help_category')->where('id',$val->help_category)->first();
                          @endphp
                          {{@$cat->name}}
                        </td>
                        <td data-label="Name">
                          @if($val->status=="A")
                          Active
                          @else
                          Inactive
                          @endif
                        </td>
                        <td data-label="Name">
                          {{@$val->display_order}}
                        </td>
                        <td data-label="Name">{{date('d.m.Y', strtotime(@$val->updated_at))}} </td>
                        {{--
                        <td data-label="Name">{{@$val->message}}</td>
                        --}}
                        <td class="reviews-lists">
                          <div class="add_ttrr actions-main ">
                            <a href="javascript:void(0);" class="action-dots"  id="action{{$val->id}}"><img src="{{ public_asset('assets/images/action-dots.png')}}" alt="" onclick="fun({{$val->id}})"></a>
                            <div class="show-actions" id="show-action{{$val->id}}" style="display: none;">
                              <span class="angle"><img src="{{ public_asset('assets/images/angle.png')}}" alt=""></span>
                              <ul>
                                <li>
                                    {{-- onclick="return confirm('Are you sure you want to delete?');" href="{{route('del.help',$val->id)}}"--}}
                                  <a href="javascript:void(0);" data-onclick="return confirm('Are you sure you want to delete?');" data-href="{{route('del.help',$val->id)}}" class="onclickPopupModal">Delete</a>

                                </li>
                                @if($val->status=="A")
                                <li><a onclick=" return confirm('Are you sure want to deactivate this  ?');"href="{{route('inactive.help',$val->id)}}" >Deactivate</a></li>
                                @else
                                <li><a onclick=" return confirm('Are you sure want to activate this  ?');"href="{{route('active.help',$val->id)}}" >Activate</a></li>
                                @endif
                                {{--
                                <li><a href="{{route('edit.help',$val->id)}}" >Edit</a></li>
                                --}}
                                <li><a href="{{route('view.help',$val->id)}}" >View/Edit</a></li>
                              </ul>
                            </div>
                          </div>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="clearfix"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</section>
@endsection
@section('footer')
@include('admin.includes.footer')
<div class="modal res-modal newqusmo instructionModal deleteModalPopup" id="deleteModalPopup">
    <div class="modal-dialog modal-dialog-centered instructionModal">
        <div class="modal-content instructionModal">
        <!-- Modal Header -->
        <div class="modal-header instructionModal">
            <h1 class="modal-title">Confirm Deletion</h1>
        </div>
        <!-- Modal body -->
        <div class="modal-body instructionModal noinsBodyDev">

            <div class="divs">
                <div class="appome_input form_box_area cls1 deleteHelpPopupM">

                    <label>Are you sure you want to delete?</label>
                    <div class="next-btn1">

                        <a href="javascript::void(0);" class="btn btn-new btn-danger" id="deleteMId" style="color: #b80f0a;">Yes,please delete</a>
                        <a data-dismiss="modal" class="btn btn-new btn-danger float-right" id="deleteMIdNext" style="color: #b80f0a;">No,dont delete</a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
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
<script>
  oTable = $('#example').DataTable({
      "order": [
          [0, "desc"]
      ],
      "pageLength": 10,
      "language": {
          "emptyTable": "No data available",
          "info": "",
          "infoEmpty": "",
          "infoFiltered": "" 
      },
      dom: '<"top"f>t<"bottom row"<"col-12 d-flex justify-content-end"p>>',
      columnDefs: [{
          targets: '_all',
          type: 'natural'
      }]
  });

  if (oTable.rows().data().length === 0) {
      $(oTable.table().container())
          .find('.dataTables_paginate')
          .hide();
  }
</script>
<script>
  $(document).ready(function(){
  $('.onclickPopupModal').on("click",function(){
    $("#deleteMId").attr("href",$(this).attr("data-href"));
        $("#deleteModalPopup").modal('show');
  });
  $('#frm').validate({
  rules:{
  qualification:{
  required:true,
  },
  field_of_study:{
  required:true,
  },
  university:{
  required:true,
  },
  qualification_status:{
  required:true,
  },
  effective_date:{
  required:true,
  }
  },
  // messages:{
  //      qualification:{
  //         required:" Category name is mandatory",
  //     }
  // }
  });
  });
</script>
<script>
  function fun(id){
  $('.show-actions').slideUp();
  $("#show-action"+id).show();
  }
  function Cancel(id){
  $("#show-action"+id).hide();
  }
  $(document).mouseup(function(e)
  {
  var container = $(".show-actions");
  // if the target of the click isn't the container nor a descendant of the container
  if (!container.is(e.target) && container.has(e.target).length === 0)
  {
  container.hide();
  }
  });
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
<script>
  function rst(p){
  $('#status').val('');
   $('#user_type').val('');

   //ajax call
   $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': "{{csrf_token()}}"
            }
            });
            //var fd= new FormData;
            //fd.append('grade_id',grade_id);

            $.ajax({
            url:'{{route('get.all.help')}}',
            type:'GET',
            //data: fd,
            contentType: false,
            processData: false,

            success:function(res){
           // console.log(res);
             $("#example").remove();
              $("#t1").html(res);
            // $("#new").html(res);


            }
            });
  }
</script>
@endsection
