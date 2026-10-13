@extends('admin.layouts.app')
@section('title')
Add Testimony
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
					<h1 class="pull-left page-title">Add Testimony</h1>
					<ol class="breadcrumb pull-right">
					</ol>
					<div class="rm05 backclass">
						<button class="btn btn-primary waves-effect waves-light w-md reset_search" onclick="rst()" type="button"><a href="{{route('test.list')}}" style="color: white">Back</a>   </button>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default ">
						@include('admin.includes.message')

						<form action="{{ route('test.added') }}" method="post" id="frm" enctype="multipart/form-data">
							@csrf
							<div class="panel-heading rm02 rm04">


								<div data-column="1" class="form-group">
									<label for="col1_filter">Name</label>
									<input type="text" placeholder="Name" id="name" name="name" class="form-control required"  autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');" value="{{request('keyword')}}">
								</div>
								<div class="clearfix"></div>
								<div class="form-group">
									<label for="email">Email</label>
									<input type="text" placeholder="Email" id="email" name="email" class="form-control  required"  autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');" value="{{request('keyword')}}">
								</div>
								<div class="form-group">
									<label for="phone">Phone</label>
									<input type="text" placeholder="Phone" id="phone" name="phone" class="form-control required"  autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');" value="{{request('keyword')}}" onkeypress='validate(event)' pattern="\d{10}">
								</div>
								<div class="form-group">
									<label for="source">Source</label>
									<select id="source" name="source" class="form-control">
										<option value="">Select source</option>
										<option value="V">V-Tutor</option>
										<option value="W">Web (Google review)</option>
										<option value="F">Facebook</option>
										<option value="I">Internet</option>
										<option value="O">Offline</option>
									</select>
								</div>


								<div class="clearfix"></div>

								<div class="clearfix"></div>
								{{-- ratting --}}
								<div class="col-md-12 ">
								<div class="form_box_area newmar ">
									<label>Rating</label>
									<div>

										<div id="half-stars-example">


											<li><a href="javascript:void(0)"  onclick="fair(1)"><img id="f1" src="{{ public_asset('assets/images/rating/rating2.png') }}"></a>
											<a href="javascript:void(0)"  onclick="fair(2)"><img id="f2" src="{{ public_asset('assets/images/rating/rating2.png') }}"></a>
											<a href="javascript:void(0)"  onclick="fair(3)"><img id="f3" src="{{ public_asset('assets/images/rating/rating2.png') }}"></a>
											<a href="javascript:void(0)"  onclick="fair(4)"><img id="f4" src="{{ public_asset('assets/images/rating/rating2.png') }}"></a>
											<a href="javascript:void(0)"  onclick="fair(5)"><img id="f5" src="{{ public_asset('assets/images/rating/rating2.png') }}"></a>
										</li>

										<input type="hidden" id="ratting" name="rating" required>
										<br>
									</div>
								</div>
							</div>
						</div>
							<div class="clearfix"></div>
							{{-- text --}}
							<div class="col-md-8 for_txt_area_new01">
								<label for="col1_filter">Testimony</label>
								<textarea name="description" class="form-control reset_val for_txt_area_new textarea_box"  autocomplete="off"></textarea>
								<span class="error_textarea"></span>
							</div>

							<div class="clearfix"></div>
							{{-- img --}}
							<label id="img-error" class="error" for="img"></label>



								<div class="col-md-4">
			                    	<div class="label-wrapper">
			                        <label class="control-label">Upload Image</label>
			   						</div>

									<div class="fileUpload btn btn-primary cust_file clearfix">
										<span class="upld_txt"><i class="fa fa-upload upld-icon" aria-hidden="true"></i>Click here to Upload Image </span>
										<input type="file"   class="upload" name="img" id="img"  onChange="fun();" >
									</div>

			                    </div>
			                    <div class="review_img rmm_001" style="display: none">
									<em class="testimg"><img src="" alt=""id="img2"></em>
								</div>
							<div class="clearfix"></div>

							<div class="ratingtest">
								<div class="rm05 faqbtn ">
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
	jQuery.validator.addMethod("emailonly", function(value, element) {
    return this.optional(element) || /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/.test(value.toLowerCase());
    }, "Enter a valid email address");

    jQuery.validator.addMethod("mobileonly", function(value, element) {
    	return this.optional(element) ||  /^[+]?\d+$/.test(value.toLowerCase());
    }, "Enter a valid 10 digit mobile number");
$('#frm').validate({
rules:{
	name:{
		required:true,
	},
	email:{
		required:true,
		email:true,
		emailonly:true
	},
	phone:{
		required:true,
		number:true,
		minlength:10,
		maxlength:10,
		mobileonly:true
	},
	source:{
		required:true,
	},
	img:{
		required:true,
	},
	rating:{
		required:true,
	},
	description:{
		required:true,
	},
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
	$(".close").click(function(){
		//alert('j');
		$(".alert").hide();
	})
</script>
<script type="text/javascript">
		function fair(id){
	console.log(id);
	if(id==1){
	document.getElementById('f1').src='{{ public_asset('assets/images/rating/rating1.png') }}';
	document.getElementById('f2').src='{{ public_asset('assets/images/rating/rating2.png') }}';
	document.getElementById('f3').src='{{ public_asset('assets/images/rating/rating2.png') }}';
	document.getElementById('f4').src='{{ public_asset('assets/images/rating/rating2.png') }}';
	document.getElementById('f5').src='{{ public_asset('assets/images/rating/rating2.png') }}';
	$('#ratting').val(id);
	}
	if(id==2){
	document.getElementById('f1').src='{{ public_asset('assets/images/rating/rating1.png') }}';
	document.getElementById('f2').src='{{ public_asset('assets/images/rating/rating1.png') }}';
	document.getElementById('f3').src='{{ public_asset('assets/images/rating/rating2.png') }}';
	document.getElementById('f4').src='{{ public_asset('assets/images/rating/rating2.png') }}';
	document.getElementById('f5').src='{{ public_asset('assets/images/rating/rating2.png') }}';
	$('#ratting').val(id);
	}
	if(id==3){
	document.getElementById('f1').src='{{ public_asset('assets/images/rating/rating1.png') }}';
	document.getElementById('f2').src='{{ public_asset('assets/images/rating/rating1.png') }}';
	document.getElementById('f3').src='{{ public_asset('assets/images/rating/rating1.png') }}';
	document.getElementById('f4').src='{{ public_asset('assets/images/rating/rating2.png') }}';
	document.getElementById('f5').src='{{ public_asset('assets/images/rating/rating2.png') }}';
	$('#ratting').val(id);
	}
	if(id==4){
	document.getElementById('f1').src='{{ public_asset('assets/images/rating/rating1.png') }}';
	document.getElementById('f2').src='{{ public_asset('assets/images/rating/rating1.png') }}';
	document.getElementById('f3').src='{{ public_asset('assets/images/rating/rating1.png') }}';
	document.getElementById('f4').src='{{ public_asset('assets/images/rating/rating1.png') }}';
	document.getElementById('f5').src='{{ public_asset('assets/images/rating/rating2.png') }}';
	$('#ratting').val(id);
	}
	if(id==5){
	document.getElementById('f1').src='{{ public_asset('assets/images/rating/rating1.png') }}';
	document.getElementById('f2').src='{{ public_asset('assets/images/rating/rating1.png') }}';
	document.getElementById('f3').src='{{ public_asset('assets/images/rating/rating1.png') }}';
	document.getElementById('f4').src='{{ public_asset('assets/images/rating/rating1.png') }}';
	document.getElementById('f5').src='{{ public_asset('assets/images/rating/rating1.png') }}';
	$('#ratting').val(id);
	}
	}
</script>
<script>
function fun(){
var i=document.getElementById('img').files[0];
//console.log(i);
var b=URL.createObjectURL(i);
$(".review_img").show();
$("#img2").attr("src",b);
}
</script>
<script type="text/javascript">
	function check() {
            var badWords = [];
            @php
            $badwords = \DB::table('bad_words')->pluck('words')->toArray();
            @endphp
            @foreach(@$badwords as $value)
                badWords.push('{{$value}}');
            @endforeach
            // console.log(badWords);
            var wordInput = textarea.val();
            wordInput = wordInput.toLowerCase();
            var arr = wordInput.split(" ");
            var foundBadWords = arr.filter(el => badWords.includes(el));

            if(foundBadWords.length>0){
                $(".error_textarea").html('Kindly refrain from using email, phone or flagged words on the description!');
                textarea.val("");

            }

            // email & phone word
            var flaggedWord = ['email','phone'];
            var wordInput = textarea.val();
            wordInput = wordInput.toLowerCase();
            var arr = wordInput.split(" ");
            var foundFlaggedWords = arr.filter(el => flaggedWord.includes(el));

            if(foundFlaggedWords.length>0){
                textarea.val("");
                $(".error_textarea").html('Kindly refrain from using email, phone or flagged words on the description!');
            }else{
                var v = textarea.val();
                if(v != ""){
                    $(".error_textarea").html('');
                }

            }

        }
        var textarea = $('.textarea_box');
        textarea.on({
            keyup: function(e) {
                if (e.which == 188) check();
                if (e.which == 32) check();
                check();
                var words = 0;
                    if((this.value.match(/\S+/g)) != null) {
                        words = this.value.match(/\S+/g).length;
                    }
                    if(words > 200){
                        var trimmed = $(this).val().split(/\s+/, 200).join(" ");
                        $(this).val(trimmed + " ");
                    }
            },
            blur: check
        });
</script>
<script type="text/javascript">
   	function validate(evt)

        {

            var theEvent = evt || window.event;

            // Handle key press

            var key = theEvent.keyCode || theEvent.which;

            key = String.fromCharCode(key);

            var regex = /[0-9]/;

            if(!regex.test(key) ) {

                theEvent.returnValue = false;

                if(theEvent.preventDefault) theEvent.preventDefault();

            }

        }


   </script>
@endsection
