@extends('admin.layouts.app')
@section('title')
{{ @$contentDetails->title }}
@endsection
@section('links')
    @include('admin.includes.links')
@endsection
@section('header')
    @include('admin.includes.header')
@endsection
@section('sidebar')
    @include('admin.includes.sidebar')
@endsection
@section('content')
            <!-- Start content -->
        <div class="content">

        <div class="wraper container-fluid">
                    
        <div class="row">
          <div class="col-sm-12">
            <h1 class="pull-left page-title">{{ @$contentDetails->title }}</h1>
            <ol class="breadcrumb pull-right">
                <li><a href="{{route('admin.dashboard')}}">Vtutor</a></li>              
              <li class="active">{{ @$contentDetails->title }}</li>
            </ol>
          </div>
        </div>
                    
                <div class="row">
                        <div class="col-lg-12"> 
                    <div> 
                                <!-- Personal-Information -->
                                <div class="panel panel-default panel-fill">
                                    <div class="panel-heading"> 
                                        <h3 class="panel-title">{{ @$contentDetails->title }}*</h3> 
                                
                                    </div> 
                                    <div class="panel-body rm02 rm04"> 
                                    @include('admin.includes.message')  
                                    <form class="form-horizontal" id="terms" method="post" action="{{ route('update.terms.conditions') }}" role="form">
                                    
                                        @csrf
                                            <div class="form-group">
                                                <label for="title">Title</label>
                                                <input type="text" placeholder="Enter title" name="title" id="title" class="form-control required" value="{{ @$contentDetails->title }}">
                                            </div>
                                            <div class="col-lg-12"> 
                                                <label for="description">Description</label>
                                                <textarea id="description" name="description" class="form-control desc required" placeholder="Enter description">{!! (@$contentDetails->description) !!}</textarea>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="col-lg-12"> <button class="btn btn-primary waves-effect waves-light w-md" type="submit">Save</button></div>
                                    </form>

                                    </div> 
                                </div>
                                <!-- Personal-Information -->
                           
                        </div> 
                    </div>
                    </div>
                </div> <!-- container -->

@endsection
@section('footer')
    @include('admin.includes.footer')
@endsection
@section('script')
@include('admin.includes.script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.10.2/tinymce.min.js"></script>
<script>
    $(document).ready(function(){
        var isvalidator = $('#terms').validate();
        $('#terms').on('keyup keypress keydown', function(e) {
          var keyCode = e.keyCode || e.which;
          if (keyCode === 13) { 
            e.preventDefault();
            return false;
          }
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
@endsection