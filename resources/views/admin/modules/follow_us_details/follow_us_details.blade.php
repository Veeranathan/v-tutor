@extends('admin.layouts.app')
@section('title')
Follow Us
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
            <h1 class="pull-left page-title">Follow Us</h1>
            <ol class="breadcrumb pull-right">
                <li><a href="{{route('admin.dashboard')}}">Vtutor</a></li>              
              <li class="active">Follow Us</li>
            </ol>
          </div>
        </div>
                    
                <div class="row">
                        <div class="col-lg-12"> 
                    <div> 
                                <!-- Personal-Information -->
                                <div class="panel panel-default panel-fill">
                                    <div class="panel-heading"> 
                                        <h3 class="panel-title">Follow Us*</h3> 
                                
                                    </div> 
                                    <div class="panel-body rm02 rm04"> 
                                    @include('admin.includes.message')  
                                    <form class="form-horizontal" id="updateFollowUs" method="post" action="{{ route('admin.update.follow.us') }}" role="form">
                                    
                                        @csrf
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="text" placeholder="Enter email" name="email" id="email" class="form-control required" value="{{ @$contentDetails->email }}">
                                            </div><div class="form-group">
                                                <label for="email">Facebook Link</label>
                                                <input type="url" placeholder="Enter Facebook Link" name="facebook_link" id="facebook_link" class="form-control required" value="{{ @$contentDetails->facebook_link }}">
                                            </div><div class="form-group">
                                                <label for="twitter_link">Twitter Link</label>
                                                <input type="url" placeholder="Enter Twitter Link" name="twitter_link" id="twitter_link" class="form-control required" value="{{ @$contentDetails->twitter_link }}">
                                            </div><div class="form-group">
                                                <label for="instagram_link">Instagram Link</label>
                                                <input type="url" placeholder="Enter Pinterest Link" name="instagram_link" id="instagram_link" class="form-control required" value="{{ @$contentDetails->instagram_link }}">
                                            </div><div class="form-group">
                                                <label for="p_interest_link">Pinterest Link</label>
                                                <input type="url" placeholder="Enter Instagram Link" name="p_interest_link" id="p_interest_link" class="form-control required" value="{{ @$contentDetails->p_interest_link }}">
                                            </div><div class="form-group">  
                                                <label for="youtube_link">Youtube Link</label>
                                                <input type="url" placeholder="Enter Youtube Link" name="youtube_link" id="youtube_link" class="form-control required" value="{{ @$contentDetails->youtube_link }}">
                                            </div>

                                            {{-- <div class="col-lg-12"> 
                                                <label for="description">Description</label>
                                                <textarea id="description" name="description" class="form-control desc required" placeholder="Enter description">{!! (@$contentDetails->description) !!}</textarea>
                                            </div> --}}
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
        var isvalidator = $('#updateFollowUs').validate();
        $('#updateFollowUs').on('keyup keypress keydown', function(e) {
          var keyCode = e.keyCode || e.which;
          if (keyCode === 13) { 
            e.preventDefault();
            return false;
          }
        });
        
    });
</script>
@endsection