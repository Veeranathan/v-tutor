@extends('admin.layouts.app')
@section('title')
Change Password
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
            <h1 class="pull-left page-title">Change Password</h1>
            <ol class="breadcrumb pull-right">
                <li><a href="{{route('admin.dashboard')}}">Vtutor</a></li>
              <li class="active">Change Password</li>
            </ol>
          </div>
        </div>

                <div class="row">
                        <div class="col-lg-12">
                    <div>
                                <!-- Personal-Information -->
                                <div class="panel panel-default panel-fill">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Change Password*</h3>

                                    </div>
                                    <div class="panel-body rm02 rm04">
                                    @include('admin.includes.message')
                                    <form class="form-horizontal" method="POST" action="{{route('change.password')}}" role="form" id="change_password">
                                        @csrf
                                            <div class="form-group">
                                                <label for="Category">Current Password*</label>
                                                <input type="password" placeholder="Current Password" name="opassword" value="" id="opassword" class="form-control">
                                            </div>

                                            <div class="form-group">
                                                <label for="Category">New Password*</label>
                                                <input type="password" placeholder="New Password" name="npassword" value="" id="npassword" class="form-control">
                                            </div>

                                            <div class="form-group">
                                                <label for="Category">Confirm Password*</label>
                                                <input type="password" placeholder="Confirm Password" name="cpassword" value="" id="cpassword" class="form-control">
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
<script src="{{public_asset('admin/assets/js/jquery.validate.js')}}"></script>

<script>
$(document).ready(function(){
    $('#change_password').validate({
        rules:{
            cpassword:{equalTo:"#npassword",required:true,minlength:5},
            opassword:{required:true},
            npassword:{required:true,minlength:5},
        }
    });
});
</script>
@endsection
