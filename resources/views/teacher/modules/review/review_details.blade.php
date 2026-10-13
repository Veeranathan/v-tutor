@extends('layouts.app')
@section('title')
<title>V-Tutor  | Tutor | My Review Details</title>
@endsection
@section('left_part')
@include('include.header_menu_part')
{{-- for datatable --}}
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<style>
  .sub-hd{
    font-weight: 400;
    font-size:16px;
    margin-bottom: 0px;
  }
</style>
@endsection

    @section('content')
    <!-- bannersec -->
    <div class="top_mar"></div>
    <!--- profile --->
    <section class="user-account">
        <div class="container">
            <div class="row">
                <div class="zin">
                    @include('include.teacher_left_common'){{-- left common part --}}
                      <div class="user-right-panel tutor-right ">



                        <div class="turo-edit">

                        <div class="user-right-top">
                            <h2 class="profile-heading">Reviews</h2>
                            <p>You can find information about your ratings and reviews in this section</p>



                        </div>
                        <div class="user-right-top">
                            <div class="main-tabels">
                                <!-- Nav tabs -->

                                <!-- Tab panes -->

                                   <div class="custom-table">
                                    	<div class="profile_body">
                    		<div class="skill d-flex align-items-center gap-2">
                    			<h2 class="profile-heading sub-hd ">Student name :</h2>
                    			<p>{{@$reviews->student->f_name}} {{@$reviews->student->l_name}}</p>
                    		</div>

                    		<div class="skill d-flex  align-items-center gap-2">
                    			<h2 class="profile-heading sub-hd">Date :</h2>
                    			<p>{{date('d.m.Y', strtotime(@$reviews->created_at))}}  </p>
                    		</div>

                    		<div class="skill d-flex  align-items-center gap-2">
                    			<h2 class="profile-heading sub-hd">Time :</h2>
                    			<p>{{date('h:i A', strtotime(@$reviews->created_at))}}  </p>
                    		</div>


                    		<div class="skill d-flex  align-items-center gap-2">
                    			<h2 class="profile-heading sub-hd">Rating :</h2>
                    			 @for($i=0;$i<=(@$reviews->ratting-1);$i++)

                                        <a href="#url"><img src="{{ public_asset('assets/images/star.png')}}"></a>

                                    @endfor
                                    {{-- blank --}}
                                    	 @for($i=0;$i<(5-@$reviews->ratting);$i++)

                                        <a href="#url"><img src="{{ public_asset('assets/images/star1.png')}}"></a>

                                    @endfor
                    		</div>

                    		<div class="about-pro d-flex  align-items-center gap-2">
                    			<h2 class="profile-heading sub-hd">Comment :</h2>
                    			<p>{{@$reviews->message}}</p>



                    		</div>
                    	</div>

                                    </div>





                            </div>
                            <div class="clearfix"></div>
                        </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('footer')
@include('include.footer')
@endsection
@section('script')
@include('include.script')
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
"pageLength":10,
"language": {
			"emptyTable": "No data available",
			"info": "",
			"infoEmpty": "",
			"infoFiltered": "" 
		},
		dom: '<"top"f>t<"bottom row"<"col-12 d-flex justify-content-end"p>>',
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
qualification:{
required:true,
},
field_of_study:{
required:true,
},
university:{
required:true,
},
qualification_status:{
required:true,
},
effective_date:{
required:true,
}
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
function fun(id){
$('.show-actions').slideUp();
$("#show-action"+id).show();
}
function Cancel(id){
$("#show-action"+id).hide();
}
$(document).mouseup(function(e)
{
var container = $(".show-actions");
// if the target of the click isn't the container nor a descendant of the container
if (!container.is(e.target) && container.has(e.target).length === 0)
{
container.hide();
}
});
</script>


{{--  <script>
//var d = new Date();
$('#frm').validate({
    submitHandler: function (form) {
      var val1 = new Date($('#from_date').val());
      var val2 = new Date($('#to_date').val());


console.log($('#from').val());
console.log(val2);
//return false;

         if(val1 == "Invalid Date" && val2 == "Invalid Date") {
          alert("select both dates");
        return false;

      }
       else if(val1 == "Invalid Date" && val2 != "Invalid Date" ) {
         alert("select from date");
           return false;
      }
       else if(val1 != "Invalid Date" && val2 == "Invalid Date" ) {
          alert("select to date");
           return false;
      }
       else if(val1 > val2) {
        console.log('max');
        console.log(val1);
        console.log(val2);

        alert('From date cannot be greater than to date');
      }
       else{
         form.submit();
      }

    }
  });
 </script> --}}

{{--  <script >
    $('#from').calendar({
  type: 'date',
   maxDate:new Date({{strtotime(date('Y-m-d H:i:s') . "-1 days")}}*1000),
});
</script>
<script >
    $('#to').calendar({
  type: 'date',
   maxDate:new Date({{strtotime(date('Y-m-d H:i:s') . "-1 days" )}}*1000),
});
</script> --}}
<script>
	function readmore(id){
    //alert('j');
    $("#desc"+id).slideToggle("slow");
    $("#rr"+id).hide();
    $("#rrr"+id).show();

    }
    function readless(id){
    //alert('j');
    $("#desc"+id).slideToggle("slow");
    $("#rr"+id).show();
    $("#rrr"+id).hide();

    }
</script>

@endsection
