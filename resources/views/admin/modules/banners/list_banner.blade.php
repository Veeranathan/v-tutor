@extends('admin.layouts.app')
@section('title')
Banner Management
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
        {{-- <div class="col-sm-12"> --}}
          <h1 class="pull-left page-title">Banner Management</h1>
          <ol class="breadcrumb pull-right">
          </ol>
          <div class="rm05 backclass">
            @if(@$bannerCount < 5)

            <a href="{{ route('admin.add.banner') }}" class="btn btn-primary waves-effect waves-light w-md " > Add Banner</a>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="panel panel-default ">


            <div class="panel-body">
              @include('admin.includes.message')
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="table-responsive" id="t1">
                    {{-- start --}}
                    <table id="example" class="cell-border table table-responsive">
                      <thead>
                        <tr>

                          {{-- <th >Heading</th> --}}
                          {{-- <th >Sub heading</th> --}}
                          <th >Banner Name</th>
                          <th >Banner Link Name</th>
                          <th >Display Order</th>
                          <th >Banner URL</th>
                          <th> Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach(@$banners as $key=> $val)
                        <tr id="data{{$val->id}}">

                          {{-- <td data-label="Name">
                            {{@$val->banner_heading}}
                          </td>
                          <td data-label="Name">
                            {{@$val->banner_subheading}}
                          </td> --}}
                          <td data-label="Name">
                            {{@$val->banner_name}}
                          </td>
                          <td data-label="Name">
                            {{@$val->banner_button_caption}}
                          </td>
                          <td data-label="Name">
                            {{@$val->display_order}}
                          </td>
                          <td data-label="Name" class="textLimit">{{@$val->banner_button_url}} </td>
                          <td class="reviews-lists rm07">
                            <div class="add_ttrr actions-main ">
                              <a href="javascript:void(0);" class="action-dots"  id="action{{$val->id}}"><img src="{{ public_asset('assets/images/action-dots.png')}}" alt="" onclick="fun({{$val->id}})"></a>
                              <div class="show-actions" id="show-action{{$val->id}}" style="display: none;"> <span class="angle"><img src="{{ public_asset('assets/images/angle.png')}}" alt=""></span>
                              <ul>
                                <li><a onclick="return confirm('Are you sure want to delete this Banner?');" href="{{route('admin.delete.banner',$val->id)}}">Delete</a></li>


                                <li><a href="{{route('admin.edit.banner',$val->id)}}" >Edit</a></li>

                              </ul>
                            </div>

                            </div></td>
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
  {{-- <footer class="footer text-right">
    Copyright &copy; {{ date('Y') }} <a href="{{ route('admin.dashboard') }}">V-Tutor</a>  All rights reserved.
  </footer> --}}
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
  $('#frm').validate({
  rules:{
  // keyword:{
  // required:true,
  // },
  // rating:{
  // required:true,
  // },
  // status:{
  // required:true,
  // },

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
  $('#keyword').val('');
   $('#rating').val('');

  //ajax call
  $.ajaxSetup({
  headers: {
  'X-CSRF-TOKEN': "{{csrf_token()}}"
  }
  });
  //var fd= new FormData;
  //fd.append('grade_id',grade_id);

  $.ajax({
  url:'{{route('get.all.test')}}',
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
