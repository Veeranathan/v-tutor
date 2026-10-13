@extends('admin.layouts.app')
@section('title')
Edit Profile
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
<div class="content">
    <div class="wraper container-fluid">
       <div class="row">
          <div class="col-sm-12">
             <h1 class="pull-left page-title">Edit Profile</h1>
             <ol class="breadcrumb pull-right">
                <li><a href="{{route('admin.dashboard')}}">Vtutor</a></li>
                {{--
                <li><a href="#">Data Tables</a></li>
                --}}
                <li class="active">Edit Profile</li>
             </ol>
          </div>
       </div>
       <div class="row">
          <div class="col-lg-12">
             <div>
                <!-- Personal-Information -->
                <div class="panel panel-default panel-fill">
                   <div class="panel-heading">
                      <h3 class="panel-title">Edit Profile</h3>

                   </div>
                   <div class="panel-body rm02 rm04">
                      @include('admin.includes.message')
                      <form class="form-horizontal" method="POST" action="{{route('update.admin.profile')}}" enctype="multipart/form-data" role="form" id="EditProfileForm">
                         @csrf
                         <input type="hidden" name="id" value="{{@$profile->id}}" id="ID">
                         <div class="col-sm-12 col-xs-12">
                         <div class="form-group">
                            <label >Name*</label>
                            <input type="text" class="form-control" placeholder="Enter Name" name="name" value="{{@$profile->name}}" maxlength="255">
                         </div>
                         </div>
                         <div class="col-sm-12 col-xs-12">
                         <div class="form-group">
                            <label >Email*</label>
                            <input type="email" id="email" placeholder="Enter Email" class="form-control" name="email" value="{{@$profile->email}}" maxlength="255" readonly>
                         </div>
                         </div>
                         <div class="col-sm-12 col-xs-12">
                         <div class="form-group">
                            <label >Mobile*</label>
                            <input type="number" id="mobile" placeholder="Enter mobile" class="form-control" name="mobile" value="{{@$profile->mobile}}" minlength="10">
                         </div>
                         </div>
                         <div class="col-sm-12 col-xs-12">
                            <div class="uplodimg form-group">
                                <div class="uplodimgfil">
                                    <span>Profile Picture</span>
                                    <input type="file" name="image" id="file-1" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" onchange="fun();">
                                    <label for="file-1">Upload Profile Pic<img src="{{ public_asset('admin/assets/images/up.png') }}" alt=""></label>
                                </div>
                                <div class="uplodimgfilimg">
                                    <em>
                                        @if(@$profile->image)
                                        <img id="profilePictures" src="{{public_asset('admin/profileImage/'.@$profile->image)}}" alt="">
                                        @else
                                        <img id="profilePictures" src="" alt="" style="display:none;">
                                        @endif
                                    </em>
                                </div>
                            </div>
                        </div>
                         
                         <div class="clearfix"></div>
                         <div class="col-sm-12 col-xs-12"><div class="form-group">{{-- <div class="col-lg-12"> --}} <button class="btn btn-primary waves-effect waves-light w-md c_save_and_update" type="button" id="save_and_update">Save</button></div></div>
                      </form>
                   </div>
                </div>
                <!-- Personal-Information -->
             </div>
          </div>
       </div>
    </div>
@endsection
@section('footer')
    @include('admin.includes.footer')
@endsection
@section('script')
@include('admin.includes.script')
<script src="{{public_asset('admin/assets/js/jquery.validate.js')}}"></script>

<script type="text/javascript">
    function fun(){
        var i=document.getElementById('file-1').files[0];
        var b=URL.createObjectURL(i);
        $(".uploadImg").show();
        $("#profilePictures").show();
        $("#profilePictures").attr("src",b);
    }
$(document).ready(function(){
    var isvalidator = $('#EditProfileForm').validate({
        rules:{
        email:{required: true,email:true},
        name: { required: true},
        mobile :{ required: true,number:true}
        },
        submitHandler:function(form){
            form.submit();
        },
    });
    $('#EditProfileForm').on('keyup keypress', function(e) {
      var keyCode = e.keyCode || e.which;
      if (keyCode === 13) {
        e.preventDefault();
        return false;
      }
    });
    $("#save_and_update").click(function(){
        if(isvalidator.form()){
        if(isvalidator.valid()){
            var obj = $("#save_and_update"),
            tId = obj.attr("id"),
            tName = "c_save_and_update",
            tFrmId = "EditProfileForm";
            $("#type_popup_next").val("R");
            isAuthorizedByAdmin(tName,tId,tFrmId);
        }else{
            $('#instructionModal').modal('hide');
        }
        }
    });
});
</script>

@endsection
