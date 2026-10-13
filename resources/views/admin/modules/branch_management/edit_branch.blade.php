@extends('admin.layouts.app')
@section('title')
Edit Branch
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
                <h4 class="pull-left page-title">Edit Branch</h4>
                <ol class="breadcrumb pull-right">
                    <li> <a href="{{ route('manage.branches') }}"><i class="fas fa-angle-double-left"></i> Back</a></li>
                </ol>
            </div>
        </div>
        <!-- Personal-Information -->
        <div class="panel panel-default panel-fill">
            <div class="panel-body rm02 rm04">
                @include('admin.includes.message')
                <div class="frm_admin">
                        <form id="subjectform" method="post" action="{{ route('edit.branch',$branch->id) }}">
                            @csrf
                            <div class="row">
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="branch_name">Branch*</label>
                                        <input type="text" placeholder="Branch" id="branch_name" name="branch_name" class="form-control required" autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');" value="{{ @$branch->branch_name }}">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="capture_code">Branch Code*</label>
                                        <input type="text" placeholder="Branch Code" id="capture_code" name="capture_code" class="form-control required" autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');" value="{{ @$branch->capture_code }}">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="display_order">Display order*</label>
                                        <input type="number" placeholder="Display Order" id="display_order" name="display_order" class="form-control required" autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');" value="{{ @$branch->display_order }}">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="ad_btn">
                                        <button class="btn btn-primary waves-effect waves-light w-md c_save_subject" type="button" id="save_subject">Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                </div>
            </div>
        </div>
        <!-- Personal-Information -->
    </div>
</div>
@endsection
@section('footer')
@include('admin.includes.footer')
@endsection
@section('script')
@include('admin.includes.script')
<script src="{{ public_asset('admin/assets/js/jquery.min.js') }}"></script>
<script src="{{ public_asset('admin/assets/js/bootstrap.min.js') }}"></script>
<script src="{{public_asset('admin/assets/js/jquery.validate.js')}}"></script>
<script>
$(document).ready(function(){
    var isvalidator = $('#subjectform').validate({
        rules: {
            branch_name: {
                required: true,
                remote:{
                    url:"{{route('ajax.branch.duplicate.check')}}",
                    type:"POST",
                    data: {
                        branch_name: function() {
                            return $("#branch_name").val();
                        },
                        branch_id: function() {
                            return {{ @$branch->id }};
                        },
                        _token: '{{ csrf_token() }}'
                    }
                }
            },
            capture_code: {
                required: true,
                remote:{
                    url:"{{route('ajax.branch.capture.duplicate.check')}}",
                    type:"POST",
                    data: {
                        capture_code: function() {
                            return $("#capture_code").val();
                        },
                        branch_id: function() {
                            return {{ @$branch->id }};
                        },
                        _token: '{{ csrf_token() }}'
                    }
                }
            },
        },
        messages: {
            branch_name:{
               remote: 'This branch has already been taken'
            } ,
            capture_code:{
               remote: 'This code has already been taken'
            },
        },
        submitHandler:function(form){

           form.submit();

        },
    });
    $('#subjectform').on('keyup keypress keydown', function(e) {
      var keyCode = e.keyCode || e.which;
      if (keyCode === 13) {
        e.preventDefault();
        return false;
      }
    });
    $("#save_subject").click(function(){
        if(isvalidator.form()){
        if(isvalidator.valid()){
            var obj = $("#save_subject"),
            tId = obj.attr("id"),
            tName = "c_save_subject",
            tFrmId = "subjectform";
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
