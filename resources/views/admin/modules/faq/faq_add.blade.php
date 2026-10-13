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
          <h1 class="pull-left page-title">Add FAQ</h1>
          <ol class="breadcrumb pull-right">
          </ol>
          <div class="rm05 backclass">
                    <button class="btn btn-primary waves-effect waves-light w-md reset_search" onclick="rst()" type="button"><a href="{{route('faq.list')}}" style="color: white">Back</a>   </button>
                  </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="panel panel-default ">
          	 @include('admin.includes.message')

            <form action="{{ route('faq.added') }}" method="post" id="frm">
              @csrf
               <div class="panel-heading rm02 rm04">


                  <div data-column="2" class="form-group mt001">
                  <label for="col2_filter">User Type</label>
                  <select id="user_type" name="user_type" class="form-control reset_val">
                    <option value="">Select type</option>
                    <option value="T" >Tutor</option>
                    <option value="U">Student</option>

                  </select>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-2 ">
                   <label for="display_order">Display Order</label>
                  <input type="number" name="display_order" value="" class="form-control  required" id="display_order">
                </div>
                <div class="clearfix"></div>
                 <div class="col-md-8 for_txt_area_new01">
                 	 <label for="col1_filter">Question</label>
                <textarea name="question" class="form-control reset_val for_txt_area_new"  autocomplete="off"></textarea>
                </div>

                 <div class="col-md-8 for_txt_area_new01">
                 	 <label for="col1_filter">Answer</label>
                <textarea name="answer" id="answer" class="desc form-control reset_val for_txt_area_new"  autocomplete="off"></textarea>
                </div>

                <div class="clearfix"></div>


             <div class="clearfix"></div>

                <div class="">
                  <div class="rm05 faqbtn">
                    <button class="btn btn-primary waves-effect waves-light w-md search_click" type="submit">Add</button>
                  </div>


                </div>
                <div class="clearfix"></div>
              </div>
            </form>

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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.10.2/tinymce.min.js"></script>
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
  display_order:{
  required:true,
  number:true,
  digits:true,
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
    $.validator.setDefaults({ ignore: ":hidden:not(.desc)" });
    tinyMCE.init({
        mode : "specific_textareas",
        editor_selector : "desc",
        height: '320px',
        plugins: [
          'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
          'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
          'save table contextmenu directionality emoticons template paste textcolor'
        ],
        relative_urls : false,
        remove_script_host : false,
        convert_urls : true,
        toolbar: 'insertfile undo redo | styleselect | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | preview | forecolor backcolor emoticons',

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
