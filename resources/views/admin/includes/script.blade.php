<script>
    var resizefunc = [];
</script>
<script src="{{ public_asset('admin/assets/js/jquery.min.js') }}"></script>
<script src="{{ public_asset('admin/assets/js/bootstrap.min.js') }}"></script>
<script src="{{ public_asset('admin/assets/js/detect.js') }}"></script>
<script src="{{ public_asset('admin/assets/js/fastclick.js') }}"></script>
<script src="{{ public_asset('admin/assets/js/jquery.slimscroll.js') }}"></script>
<script src="{{ public_asset('admin/assets/js/jquery.blockUI.js') }}"></script>
<script src="{{ public_asset('admin/assets/js/waves.js') }}"></script>
<script src="{{ public_asset('admin/assets/js/wow.min.js') }}"></script>
<script src="{{ public_asset('admin/assets/js/jquery.nicescroll.js') }}"></script>
<script src="{{ public_asset('admin/assets/js/jquery.scrollTo.min.js') }}"></script>
<script src="{{ public_asset('admin/assets/plugins/waypoints/lib/jquery.waypoints.js') }}"></script>
<script src="{{ public_asset('admin/assets/js/jquery.app.js') }}"></script>

<script src="{{ public_asset('admin/assets/plugins/counterup/jquery.counterup.min.js') }}"></script>
<script src="{{ public_asset('admin/assets/toastr/build/toastr.min.js') }}"></script>
<script src="{{ public_asset('admin/assets/js/semantic.min.js') }}"></script>
<script src="{{ public_asset('admin/assets/js/custom.js') }}"></script>

<script src="{{public_asset('admin/assets/js/jquery.validate.js')}}"></script>

<script type="text/javascript">
    var table;
    function dataTableCall(objDatatable,dataTableId){
        table = $("#"+dataTableId).DataTable(objDatatable);
        return table;
    }
    var isT = 1;
    function isAuthorizedByAdmin(tName,tId = null,tFrmId = null){
        //popup for admin
        // var myWindow = window.open();
        //     myWindow.onkeydown = function(e){
        //     if(e.keyCode === 27){
        //         e.preventDefault();
        //     }
        // };
        // var length = $(".required").length();
        // for(var i=0;i<=length;i++){
        //     var v = $(".required").eq(i).val();
        //     if(v == ""){
        //         $(".error").eq(i).text("This field is required!");
        //     }
        // }
        $("#tName").val(tName);
        $("#tId").val(tId);
        $("#tFrmId").val(tFrmId);
        // $("#isAuthorizedByAdmin").val(isAuthorizedByAdmin);
        $('#instructionModal').modal('show');
        // var id = $(e.currentTarget).data("id"),
        // obj = $(this),
        // onClickPopupSubmit();
    }
    function onClickPopupSubmit(){
        var reqData = {
            'jsonrpc' : '2.0',
            '_token'  : '{{csrf_token()}}',
            'data'    : {
                'verify_password'    : $.trim($("#verify_password").val())
            }
        };
        $.ajax({
            url:"{{ route('ajax.confirm.admin.password') }}",
            dataType: 'json',
            data: reqData,
            type: 'post',
            success:function(resp){
                if(resp.result.output == 1){
                  $('#instructionModal').modal('hide');
                  var tName = $.trim($("#tName").val()),
                  tId = $.trim($("#tId").val()),
                  tFrmId = $.trim($("#tFrmId").val());
                  $("#"+tFrmId).submit();
                  // toastr.error("/");
                   // return 1;
                }else{
                    // $('#instructionModal').modal('hide');
                    toastr.error("Password is not correct!Please try again!");
                    // return 0;
                }

            },
            error:function(){
                // return 0;
                toastr.error("Something went wrong!Ajax error!");
            }
        });
    }
    function onDeleteAjaxFunctionCall(){
        var outout = 0;
        $('#instructionModal').modal('show');
        // var output = 1;
        var verify_password = $.trim($("#verify_password").val());
        if(verify_password == ""){
            $(".error_verify_password").html("This field is required!");
        }
        if(verify_password != ""){
            var reqData = {
                'jsonrpc' : '2.0',
                '_token'  : '{{csrf_token()}}',
                'data'    : {
                    'verify_password'    : $.trim($("#verify_password").val())
                }
            };
            var o = $.ajax({
                url:"{{ route('ajax.confirm.admin.password') }}",
                dataType: 'json',
                data: reqData,
                type: 'post',
                success:function(resp){
                    if(resp.result.output == 1){

                      $('#instructionModal').modal('hide');
                      // toastr.success("Please wait....");
                      ajaxCallDeletePopupCall();
                      // outout = 1;
                      // return resp.result.output;
                    }else{
                        // outout = 0;
                        toastr.error("Password is not correct!Please try again!");
                        // return resp.result.output;
                    }
                },
                error:function(){
                    // outout = 0;
                    // toastr.error("Please wait....");


                    // return 0;
                }
            });

        }

    }
    $("#verify_password").keydown(function(e){
        var key = e.keyCode || e.which;
        // alert(key);
        if(key == 13){
            $("#next").trigger("click");
        }

    });
    $(".modal form #verify_password" ).click(function( event ) {
      event.stopPropagation();
    });
    $(".modal form .noinsBodyDev" ).click(function( event ) {
      event.stopPropagation();
    });
    $(".modal .noinsBodyDev" ).click(function( event ) {
      event.stopPropagation();
    });
    $(".modal .instructionModal" ).click(function( event ) {
      event.stopPropagation();
    });
    $(".modal form #edit_conf_password" ).click(function( event ) {
      event.stopPropagation();
    });
    $(".modal form #next" ).click(function( event ) {
      event.stopPropagation();
    });
    $("#next").click(function(){
        var verify_password = $.trim($("#verify_password").val());
        var type = $.trim($("#type_popup_next").val());
        if(verify_password == ""){
            $(".error_verify_password").html("This field is required!");
        }
        if(verify_password != ""){
            // R means for add edit update pages
            if(type == 'R'){
                onClickPopupSubmit();
            }
            else if(type == 'H'){
                var tId = $.trim($("#tId").val()),
                ajax_url = $.trim($("#ajax_url").val()),
                tName = $.trim($("#tName").val());

                $('.gj_adm_popup_text').text(tName);
                setTimeout(function () {
                    $('#admConfirmModal').modal('show');
                }, 100);
                /* if(confirm(tName)){
                    window.location.href = ajax_url;
                } */
            }else{
                // ajax
                // others like datatable row delete
                onDeleteAjaxFunctionCall();
                // alert("output :"+output);
                // if(output == 1){
                //     ajaxCallDeletePopupCall();
                // }
            }

            // $('#instructionModal').modal('show');

        }
    });
    function popupValidate(){
        var verify_password = $.trim($("#verify_password").val());
        if(verify_password == ""){
            $(".error_verify_password").html("This field is required!");
        }
        if(verify_password != ""){
            onClickPopupSubmit();
            // $('#instructionModal').modal('show');
        }
    }
    function ajaxCallDeletePopupCall(){
        var ajax_data_id= $("#ajax_data_id").val(),
            tId= $("#tId").val(),
            ajax_data_id= $("#ajax_data_id").val(),
            ajax_url= $("#ajax_url").val(),
            data_table_data_s= $("#data_table_data_s").val();
        // var id = $(e.currentTarget).data("id"),
            // obj = $(this),
            var reqData = {
                'jsonrpc' : '2.0',
                '_token'  : '{{csrf_token()}}',
                'data'    : {
                    'id'    : ajax_data_id
                }
            },
            temp = table.row('.tr_class_'+ajax_data_id).data();
            var tName = $.trim($("#tName").val());
            if(tName == ""){
                tName = "Do you want to delete this ?";
            }

            $('.gj_adm_popup_text').text(tName);
            setTimeout(function () {
                $('#admConfirmModal').modal('show');
            }, 100);
            /* if(confirm(tName)){
                $.ajax({
                    url:ajax_url,
                    dataType: 'json',
                    data: reqData,
                    type: 'post',
                    success:function(resp){
                        if(resp.status == 1){
                            table.row('.tr_class_'+ajax_data_id).remove().draw( false );
                            toastr.success(resp.message);
                        }else{
                            toastr.error(resp.message);
                        }
                    },
                    error:function(){
                        toastr.error("Something went wrong!Ajax error!");
                    }
                });
            } */
    }
</script>
