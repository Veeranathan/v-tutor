
@extends('layouts.app')
@section('title')
<title>V-Tutor  | Tutor | Tutoring Plan | Edit</title>
@endsection
@section('left_part')
@include('include.header_menu_part')
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
 <style>
        .table-head {
            display: flex;
            align-items: center;
            gap:4px;
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
					<div class="user-right-panel tutor-right">
						<div class="step_tab">
							<ul>
								<li>
									<a href="{{route('teacher.profile')}}">
										<span><img src="{{ public_asset('assets/images/peri.png')}}" class="actt"><img src="{{ public_asset('assets/images/perih.png')}}" class="accth"></span>
										Personal Details
									</a>
								</li>
								<li class="active">
									<a href="{{route('tutorship.plan')}}">
										<span><img src="{{ public_asset('assets/images/gar.png')}}" class="actt"><img src="{{ public_asset('assets/images/garh.png')}}" class="accth"></span>
										Tutoring Plan
									</a>
								</li>
								<li>
									<a href="{{route('tutor.acadamic')}}">
										<span><img src="{{ public_asset('assets/images/aca.png')}}" class="actt"><img src="{{ public_asset('assets/images/acah.png')}}" class="accth"></span>
										Academics
									</a>
								</li>
								<li>
									<a href="{{route('tutor.exp')}}">
										<span><img src="{{ public_asset('assets/images/ex.png')}}" class="actt"><img src="{{ public_asset('assets/images/exh.png')}}" class="accth"></span>
									Experience </a>
								</li>
								<li>
									<a href="{{route('tutor.recognization')}}">
										<span><img src="{{ public_asset('assets/images/rec.png')}}" class="actt"><img src="{{ public_asset('assets/images/rech.png')}}" class="accth"></span>
										Recognitions
									</a>
								</li>
								<li>
                                    <a class="disable_class" href="{{ route('tutor.right_to_work') }}">
                                        <span><img src="{{ public_asset('assets/images/rec.png') }}" class="actt"><img
                                                src="{{ public_asset('assets/images/rech.png') }}" class="accth"></span>
                                        Right to Work
                                    </a>
                                </li>
								{{-- <li > --}}
									{{-- <a @if(@Auth::user()->platform_type != NULL) href="{{ route('teacher.close.account') }}" onclick="return confirm('We find that you have decided to close the account and we are sorry to see you go! We may need your account password to validate closure! If you have any issues / concerns that you would like to share, kindly use the Complaints link . Please be aware that this process is irreversible. Any data on this account will be retained as per our privacy policy and purged after a certain time')" @else href="#" data-toggle="modal" data-target="#myModalnes" @endif    class="" >Close my account</a> --}}
									{{-- <a href="#" data-toggle="modal" data-target="#myModalnes"   > --}}
                                {{-- Close my account</a> --}}
                                 {{-- <a class="" href="{{route('teacher.close.account')}}"> --}}
                                    {{-- <span><i class="fa fa-user acttrr" aria-hidden="true"></i></span>
                                  Close Account
                                </a> --}}
		                                 {{-- <a class="" href="{{route('teacher.close.account')}}">
		                                    <span><i class="fa fa-user acttrr" aria-hidden="true"></i></span>
		                                  Close Account
		                                </a> --}}
		                            {{-- </li> --}}
							</ul>
							<div class="clearfix"></div>
						</div>
						<div class="turo-edit">
							<div class="user-right-top">

								{{-- <h2 class="profile-heading"><span class="per-info"><img src="{{ public_asset('assets/images/garde.png')}}"></span>Tutoring Plan</h2> --}}
								<p>This section allows you to access details and update your tutoring plan as needed</p>

								@include('include.errors')
								<form method="post" action="{{route('tutorship.plan.update')}}" class="gj_tut_plan_frm" id="frm">
									@csrf
									{{-- <input type="hidden" name="prv_grade" value="{{@$grade_id}}">
									<input type="hidden" name="prv_rt" value="{{@$hourly_rate}}"> --}}
									<input type="hidden" name="t_id" value="{{@$t_id}}">
									<div class="user-account-info">

										<div class="row new_rows no-gutters">
											<div class="col-md-11 col-sm-12 p-0">
												<div class="row new_rows no-gutters">
													<div class="col-md-2 col-sm-6">
														<div class="form_box_area">
															<label>Grade* </label>
															<select name="grade" required  id="hhh">
																<option value=""> Select </option>
																@foreach($grade as $key=> $val)
																<option value="{{@$val->id}}" @if(@$grade_id== @$val->id) selected @endif > {{@$val->grade_name}}</option>

																@endforeach
															</select>
														</div>
													</div>


													<div class="col-md-3 col-sm-6" id="old_branch">
														<div class="form_box_area">
															<label>Branch*</label>
															<select name="branch" id="branch" onchange ="getSub()" class="required">
																<option value="">Select branch</option>
																@if(@$branches)
																@foreach(@$branches as $key=> $val)
																<option value="{{@$val->id}}" @if(@$branch_id==$val->id) selected=""  @endif>{{@$val->branch_name}}</option>
																@endforeach
																@endif
															</select>
															{{-- <label id="subject-error" class="error" for="subject" style="display: block;"></label> --}}
														</div>
													</div>
													<div class="col-md-2 col-sm-6" id="old">
														<div class="form_box_area">
															<label>Subject*</label>
															<select  {{-- multiple --}} name="subject">
																@if(@$subject)
																@foreach($subject as $key=> $val)
																<option value="{{@$val->id}}" @if(@$subject_idd==$val->id) selected=""  @endif >{{@$val->subject}}</option>
																@endforeach
																@endif
															</select>
															<label id="subject-error" class="error" for="subject" style="display: block;"></label>
														</div>
													</div>
													<div class="col-md-2 col-sm-6" id="new_branch" style="display: none">
													</div>
													<div class="col-md-2 col-sm-6" id="new" style="display: none">
													</div>


													<div class="col-md-4 col-sm-6 new_est_width">
														{{-- <div class="form_box_area">
															<label>Rate per session (60 mins)*</label>
															<div>min="10" max="100"
																<input type="text" name="hourly_rate" placeholder="Enter numbers only" class="pricein rate_per_class" required value="{{@$hourly_rate}}" autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');">
																<div class="llt_icon"><i class="fas fa-dollar-sign" style="margin-top: 7px"></i></div>
															</div>
														</div> --}}

														<div class="form_box_area">
															<label>Rate per session (60 mins)*</label>
															<select name="hourly_rate">
																<option value="">Select Rate </option>
																@for ($i = 50; $i <= 150; $i += 5)
																    <option {{ (@$hourly_rate == $i) ? 'selected' : '' }} value="{{$i}}">$ {{$i}}</option>
																@endfor
															</select>
															<label id="subject-error" class="error" for="subject" style="display: block;"></label>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-1 col-sm-4 p-0">
												<div class="form_box_area btn_closer">
													<label></label>
													<button type="submit" class="add_btn">Save</button>

												</div>
											</div>
											<div class="col-12">
												<div class="custom-table">
													<table id="example" class="cell-border table table-responsive">
														<thead>
															<tr>

																<th ><div class="table-head">Grade <img src="{{ public_asset('assets/images/sort.png')}}"></div></th>
																<th ><div class="table-head">Branch <img src="{{ public_asset('assets/images/sort.png')}}"></div></th>
																<th ><div class="table-head">Subject <img src="{{ public_asset('assets/images/sort.png')}}"></div></th>
																<th ><div class="table-head">Rate per Session <img src="{{ public_asset('assets/images/sort.png')}}"></div></th>
																<th> </th>

															</tr>
														</thead>
														<tbody>
															@foreach(@$tutorship_plan as $key=> $val)
															<tr>

																<td data-label="Name">{{@$val->getGrade->grade_name}}</td>
																<td data-label="Name">{{@$val->getBranch->branch_name}}</td>
																<td data-label="Name">{{@$val->getSubject->subject}}</td>
																<td data-label="Name">$ {{@$val->hourly_rate}}</td>
																<td ><div class="add_ttrr actions-main">
																	<a href="javascript:void(0);" class="action-dots"  id="action{{$val->id}}"><img src="{{ public_asset('assets/images/action-dots.png')}}" alt="" onclick="fun({{$val->id}})"></a>
																	<div class="show-actions" id="show-action{{$val->id}}" style="display: none;"> <span class="angle"><img src="{{ public_asset('assets/images/angle.png')}}" alt=""></span>
																	<ul>
																		<li><a href="{{route('tutorship.plan.edit.page',$val->id)}}">Edit </a></li>
																		<li><a href="{{route('tutorship.plan.dlt',$val->id)}}">Delete</a></li>
																	</ul>
																</div>
															</div>
														</td>
													</tr>


													@endforeach

												</tbody>
											</table>
										</div>
										<nav aria-label="...">
											{{-- <ul class="pagination new-pagination">
												{{$tutorship_plan->links()}}
											</ul> --}}
										</nav>
									</div>




								</div>
							</div>




						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<div class="modal res-modal newqusmo" id="myModalnes">
     <div class="modal-dialog modal-dialog-centered divPoMW tapDiv proClose">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Warning</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body ">
            <div class="testPro">
                <div class="proDiv " id="warningTextDi">
                    {{-- <h6>We are sorry to se</h6> --}}
                    <span class="proclosespan">We are sorry to see you go</span>😔
                    <h6></h6>
                    <p>We notice that you have decided to close your account. If there are any issues / concerns that you would like to share or discuss, kindly message us. Our backend team will review and respond over email or give you a call, if needed.</p>
                    <p>We require your account password to validate closure! Please be aware that this process is not reversible. Any data on this user account will be retained as per our policies and purged after a certain date. For more details, review our Privacy Policy.</p>
                    <p class="tutoracademiccor academic_team_bold">Academics Team</p>
                    {{-- <p>We are sorry to see you go (sad)
                    </p> --}}
                    <div class="next-btn1 newst_btn-pop">

                        <button type="button" class="btn btn-new btn-danger float-left change-new-link"  id="nextValueShow">Yes, please close</button>
                        <button type="button" class="btn btn-new btn-danger " data-dismiss="modal">No, don’t close </button>
                        <div class="clearfix"></div>
                    </div>
                </div>
               <div class="appome_input form_box_area cls2 " id="passwordForm" style="display:none;">
                @if(@Auth::user()->user_type == 'T')
                    <form action="{{route('teacher.close.account')}}" id="checkPassword" method="post">
                        @csrf
                @else
                <form action="{{route('teacher.close.account')}}" id="checkPassword" method="post">
                        @csrf
                @endif
                       <span class="form_box_area mt-2" id="abcd">
                            <label>Password </label>
                            <span class="autocomplete">
                                <input id="mypassword" type="password" name="mypassword" placeholder="Password" autocomplete="off" required="" class="required">
                            </span>
                        </span>
                        <div class="next-btn1 newst_btn-pop">
                            <button type="submit" class="btn btn-new btn-danger change-new-link">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
      </div>
    </div>
</div>
@endsection
@section('footer')
@include('include.footer')
@endsection
@section('script')
@include('include.script')
<script src="{{ public_asset('assets/js/chosen.jquery.js') }}" type="text/javascript"></script>
<script src="{{ public_asset('assets/js/init.js') }}" type="text/javascript"></script>
{{-- data table --}}
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js" integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg==" crossorigin="anonymous"></script>
<script>
(function() {

/*
 * Natural Sort algorithm for Javascript - Version 0.7 - Released under MIT license
 * Author: Jim Palmer (based on chunking idea from Dave Koelle)
 * Contributors: Mike Grier (mgrier.com), Clint Priest, Kyle Adams, guillermo
 * See: http://js-naturalsort.googlecode.com/svn/trunk/naturalSort.js
 */
function naturalSort (a, b, html) {
    var re = /(^-?[0-9]+(\.?[0-9]*)[df]?e?[0-9]?%?$|^0x[0-9a-f]+$|[0-9]+)/gi,
        sre = /(^[ ]*|[ ]*$)/g,
        dre = /(^([\w ]+,?[\w ]+)?[\w ]+,?[\w ]+\d+:\d+(:\d+)?[\w ]?|^\d{1,4}[\/\-]\d{1,4}[\/\-]\d{1,4}|^\w+, \w+ \d+, \d{4})/,
        hre = /^0x[0-9a-f]+$/i,
        ore = /^0/,
        htmre = /(<([^>]+)>)/ig,
        // convert all to strings and trim()
        x = a.toString().replace(sre, '') || '',
        y = b.toString().replace(sre, '') || '';
        // remove html from strings if desired
        if (!html) {
            x = x.replace(htmre, '');
            y = y.replace(htmre, '');
        }
        // chunk/tokenize
    var xN = x.replace(re, '\0$1\0').replace(/\0$/,'').replace(/^\0/,'').split('\0'),
        yN = y.replace(re, '\0$1\0').replace(/\0$/,'').replace(/^\0/,'').split('\0'),
        // numeric, hex or date detection
        xD = parseInt(x.match(hre), 10) || (xN.length !== 1 && x.match(dre) && Date.parse(x)),
        yD = parseInt(y.match(hre), 10) || xD && y.match(dre) && Date.parse(y) || null;

    // first try and sort Hex codes or Dates
    if (yD) {
        if ( xD < yD ) {
            return -1;
        }
        else if ( xD > yD ) {
            return 1;
        }
    }

    // natural sorting through split numeric strings and default strings
    for(var cLoc=0, numS=Math.max(xN.length, yN.length); cLoc < numS; cLoc++) {
        // find floats not starting with '0', string or 0 if not defined (Clint Priest)
        var oFxNcL = !(xN[cLoc] || '').match(ore) && parseFloat(xN[cLoc], 10) || xN[cLoc] || 0;
        var oFyNcL = !(yN[cLoc] || '').match(ore) && parseFloat(yN[cLoc], 10) || yN[cLoc] || 0;
        // handle numeric vs string comparison - number < string - (Kyle Adams)
        if (isNaN(oFxNcL) !== isNaN(oFyNcL)) {
            return (isNaN(oFxNcL)) ? 1 : -1;
        }
        // rely on string comparison if different types - i.e. '02' < 2 != '02' < '2'
        else if (typeof oFxNcL !== typeof oFyNcL) {
            oFxNcL += '';
            oFyNcL += '';
        }
        if (oFxNcL < oFyNcL) {
            return -1;
        }
        if (oFxNcL > oFyNcL) {
            return 1;
        }
    }
    return 0;
}

jQuery.extend( jQuery.fn.dataTableExt.oSort, {
    "natural-asc": function ( a, b ) {
        return naturalSort(a,b,true);
    },

    "natural-desc": function ( a, b ) {
        return naturalSort(a,b,true) * -1;
    },

    "natural-nohtml-asc": function( a, b ) {
        return naturalSort(a,b,false);
    },

    "natural-nohtml-desc": function( a, b ) {
        return naturalSort(a,b,false) * -1;
    },

    "natural-ci-asc": function( a, b ) {
        a = a.toString().toLowerCase();
        b = b.toString().toLowerCase();

        return naturalSort(a,b,true);
    },

    "natural-ci-desc": function( a, b ) {
        a = a.toString().toLowerCase();
        b = b.toString().toLowerCase();

        return naturalSort(a,b,true) * -1;
    }
} );

}());
	oTable = $('#example').DataTable({
		"searching": false,
		"order": [
			[0, "desc"]
		],
		"pageLength":10,

		"language": {
			"emptyTable": "No data available",
			"info": "",
			"infoEmpty": "",
			"infoFiltered": "" 
		},
		dom: '<"top"f>t<"bottom row"<"col-12 d-flex justify-content-end"p>>',
		columnDefs: [ { targets: '_all', type: 'natural' } ]
		//"bSort": true,
		// aoColumnDefs: [
		//   {
		//      bSortable: false,
		//      aTargets: [ -3 ]
		//   }
		// ]
	});

	if (oTable.rows().data().length === 0) {
		$(oTable.table().container())
			.find('.dataTables_paginate')
			.hide();
	}
</script>
<script>
$(document).ready(function(){
	$("#checkPassword").validate();
$('#frm').validate({
ignore: [],
rules:{
grade:{
required:true,
},
// 'subject[]':{
// required:true,
// },
 subject:{
    required:true,
},
hourly_rate:{
required:true,
number:true,
min:1,
// min:10,
// max:100,

},


},
messages:{
     hourly_rate:{
                    min:"Enter value greater than 0 ",
                  }
}
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
<script>
		function getSub(){
			//console.log("k");
			var grade_id=$("#hhh").val();
			var branch_id=$("#branch").val();
			console.log(grade_id);
			   $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': "{{csrf_token()}}"
            }
            });
            var fd= new FormData;
            fd.append('grade_id',grade_id);
            fd.append('branch_id',branch_id);

            $.ajax({
	            url:'{{route('get.sub')}}',
	            type:'POST',
	            data: fd,
	            contentType: false,
	            processData: false,

	            success:function(res){
		            $("#old").remove();
		            $("#new").show();
		            $("#new").html(res);
		            $("#new .form_box_area").append('<label id="subject-error" class="error" for="subject" style="display: block;"></label>');

	            }
            });


		}

		$(document).on('change', '#hhh', function(e) {
            getSub();
        });
	</script>
@endsection
