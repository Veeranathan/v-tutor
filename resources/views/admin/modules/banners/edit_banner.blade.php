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
      {{--
      <div class="col-sm-12">
        --}}
        <h1 class="pull-left page-title">Edit Banner</h1>
        <ol class="breadcrumb pull-right">
        </ol>
        <div class="rm05 backclass">
          <button class="btn btn-primary waves-effect waves-light w-md reset_search" onclick="rst()" type="button"><a href="{{route('admin.list.banner')}}" style="color: white">Back</a>   </button>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default ">
          @include('admin.includes.message')
          <form action="{{ route('admin.edit.banner',@$banner->id) }}" method="post" id="frm" enctype="multipart/form-data">
            @csrf
            <div class="panel-heading rm02 rm04">
              {{-- <div class="col-md-8 for_txt_area_new01">
                <label for="banner_heading">Banner Heading</label>
                <textarea name="banner_heading" id="banner_heading" class="required form-control reset_val for_txt_area_new"  autocomplete="off">{{ @$banner->banner_heading }}</textarea>
              </div> --}}
              <div class="clearfix"></div>
              {{-- <div class="col-md-8 for_txt_area_new01">
                <label for="banner_subheading">Banner Subheading</label>
                <textarea name="banner_subheading" id="banner_subheading" class="required form-control reset_val for_txt_area_new"  autocomplete="off">{{ @$banner->banner_subheading }}</textarea>
              </div> --}}

              <div class="col-md-8 ">

                <label for="banner_name">Banner Name</label>

                <input type="text" name="banner_name" id="banner_name" class="required form-control reset_val "  autocomplete="off" value="{{ @$banner->banner_name }}">

              </div>
              <div class="col-md-8 for_txt_area_new01">

                <label for="banner_button_caption">Banner Link Name</label>

                <input type="text" name="banner_button_caption" id="banner_button_caption" class="required form-control reset_val "  autocomplete="off" value="{{ @$banner->banner_button_caption }}">

              </div>
              <div class="col-md-8 ">
                <label for="display_order">Display Order</label>
                <input type="number" name="display_order" id="display_order" class="required form-control  "  autocomplete="off" min="1" max="5" value="{{ @$banner->display_order }}">
              </div>
              <div class="clearfix"></div>
              {{-- <div class="col-md-8 for_txt_area_new01">
                <label for="banner_button_caption">Banner Name</label>
                <input type="text" name="banner_button_caption" id="banner_button_caption" class="required form-control reset_val "  autocomplete="off" value="{{ @$banner->banner_button_caption }}">
              </div> --}}
              <div class="clearfix"></div>
                <div class="col-md-8 for_txt_area_new01">
                    <label for="banner_button_url">Banner  URL</label>
                    <input type="url" name="banner_button_url" id="banner_button_url" class="required form-control reset_val "  autocomplete="off" value="{{ @$banner->banner_button_url }}">
                </div>
                <div class="clearfix"></div>
                <div class="col-md-8 for_txt_area_new01">
                    <div class="uplodimg form-group rrtyy">
                        <div class="uplodimgfil">

                            <span>Banner Image(Recommended size(width :1600 pixels & height 414 pixels))</span>

                            <input type="file" name="img" id="file-1" class=" inputfile inputfile-1 ">

                            <label for="file-1">Upload Banner Image

                                <img src="{{ public_asset('admin/assets/images/up.png') }}" alt="">

                            </label>

                            <span class="error_image error"></span>

                        </div>
                        <div class="uplodimgfilimg">
                            <em>
                                <img id="img2" src="{{ env('STORAGE_URL') . '/banners/' .@$banner->banner_image }}" alt="">
                            </em>
                        </div>
                    </div>
                </div>
              <div class="clearfix"></div>
              <div class="">
                <div class="rm05 faqbtn">
                  <button class="btn btn-primary waves-effect waves-light w-md search_click" type="submit">Save</button>
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
<footer class="footer text-right">
  Copyright &copy; {{ date('Y') }} <a href="{{ route('admin.dashboard') }}">V-Tutor</a>  All rights reserved.
</footer>
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
<script type="text/javascript">
    $(document).on("change","#file-1",function(){
        var i=document.getElementById('file-1').files[0];
        var b=URL.createObjectURL(i);
        $("#img2").show();
        $("#img2").attr("src",b);
    });
    $("#frm").validate();
</script>
@endsection
