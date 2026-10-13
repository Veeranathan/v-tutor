@extends('admin.layouts.app')
@section('title')
FAQ Management
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
          <h1 class="pull-left page-title">View FAQ</h1>
          <ol class="breadcrumb pull-right">
          </ol>
          <div class="rm05 backclass">
                    <button class="btn btn-primary waves-effect waves-light w-md reset_search" onclick="rst()" type="button"><a href="{{route('test.list')}}" style="color: white">Back</a>   </button>
                    <button class="btn btn-primary waves-effect waves-light w-md reset_search" onclick="rst()" type="button"><a href="{{route('edit.test',$test->id)}}" style="color: white">Edit</a>   </button>
                  </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="panel panel-default ">

              <div class="panel-heading rm02 rm04">

                 <div class="faqview">
                 <h5><i class="far fa-user"></i></i> Name</h5>
                 <p>{{$test->name}}</p>
                 </div>


              <div class="faqview">
                  <h5><i class="fas fa-location-arrow"></i></i> Email</h5>
                 <p>{{$test->email}}</p>
             </div>
             <div class="faqview">
                  <h5><i class="fas fa-location-arrow"></i></i> Phone</h5>
                 <p>{{@$test->phone}}</p>
             </div>
             {{-- <div class="faqview">
                  <h5><i class="fas fa-location-arrow"></i></i> Location</h5>
                 <p>{{$test->location}}</p>
             </div> --}}
              <div class="faqview">
                  <h5><i class="fas fa-location-arrow"></i></i> Source</h5>
                 <p>
                   @if(@$test->source == 'V')
                                            V-Tutor
                                            @endif
                                            @if(@$test->source == 'W')
                                            Web (Google review)
                                            @endif
                                            @if(@$test->source == 'F')
                                            Facebook
                                            @endif
                                            @if(@$test->source == 'I')
                                            Internet
                                            @endif
                                            @if(@$test->source == 'O')
                                            Offline
                                            @endif
                 </p>
             </div>

              <div class="faqview">

                 <h5><i class="fas fa-star"></i></i> Rating</h5>
                 <p> @for($i=0;$i<=(@$test->rating-1);$i++)

                            <a href="#url"><img src="{{ public_asset('assets/images/star.png')}}" style="width: 10px"></a>

                            @endfor
                            {{-- blank --}}
                            @for($i=0;$i<(5-@$test->rating);$i++)

                            <a href="#url"><img src="{{ public_asset('assets/images/star1.png')}}" style="width: 10px"></a>

                            @endfor
                  </p>
              </div>



             <div class="faqview">

                 <h5><i class="fa fa-check" aria-hidden="true"></i> Status</h5>
                 <p> @if($test->status=="A")
                            Activate
                            @else
                            Inactivate
                            @endif
                  </p>
              </div>




            <div class="faqview">
                  <h5><i class="fa fa-comment" aria-hidden="true"></i> Description</h5>
                 <p>{{$test->text}}</p>
             </div>

              <div class="faqview">
                  <h5> <i class="fas fa-images"></i> Image</h5>
                 <img src="{{url('/')}}/storage/testimonial/{{$test->image}}" style="width: 200px; height: 150px">
             </div>





                <div class="clearfix"></div>
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
  question:{
  required:true,
  },
  answer:{
  required:true,
  },
  user_type:{
  required:true,
  },
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
  	$(".close").click(function(){
  		//alert('j');
  		$(".alert").hide();
  	})
  </script>


  @endsection
