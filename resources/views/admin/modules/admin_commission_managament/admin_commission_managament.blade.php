@extends('admin.layouts.app')
@section('title')
Update Commission
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
            <h1 class="pull-left page-title">Update Commission</h1>
            <ol class="breadcrumb pull-right">
                <li><a href="{{route('admin.dashboard')}}">Vtutor</a></li>
                <li class="active">Update Commission</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div>
                <!-- Personal-Information -->
                <div class="panel panel-default panel-fill">
                    <div class="panel-heading">
                        <h3 class="panel-title">Change Commission*</h3>
                    </div>
                    <div class="panel-body rm02 rm04">
                        @include('admin.includes.message')  
                        <form class="form-horizontal" id="commissionForm" method="post" action="{{ route('admin.set.commission') }}" role="form">
                            @csrf
                            <div class="form-group">
                                <label for="grade_name">Commission Percentage*</label>
                                <input type="number" placeholder="Commission" id="commission" name="commission" class="form-control required" autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');" min="0" max="100" value="{{ @$admin_commission_management->commission }}">
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-12"> <button class="btn btn-primary waves-effect waves-light w-md c_save_g" id="save_g" type="button">Save</button> </div>
                        </form>
                    </div>
                </div>
                <!-- Personal-Information -->
            </div>
        </div>
    </div>
</div>
<!-- container -->
@endsection
@section('footer')
@include('admin.includes.footer')
@endsection
@section('script')
@include('admin.includes.script')
<script>
    $(document).ready(function(){
        var isvalidator = $('#commissionForm').validate();
        $('#commissionForm').on('keyup keypress keydown', function(e) {
          var keyCode = e.keyCode || e.which;
          if (keyCode === 13) { 
            e.preventDefault();
            return false;
          }
        });
        $("#save_g").click(function(){
            if(isvalidator.form()){
            if(isvalidator.valid()){
                var obj = $("#save_g"),
                tId = obj.attr("id"),
                tName = "c_save_g",
                tFrmId = "commissionForm";
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