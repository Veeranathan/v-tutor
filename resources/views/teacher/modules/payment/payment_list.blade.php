@extends('layouts.app')
@section('title')
<title>V-Tutor  | Tutor | Payment history</title>
@endsection
@section('left_part')
@include('include.header_menu_part')
@endsection
<body class="after-user">
	@section('content')
   <!-- bannersec -->
    <div class="top_mar"></div>
    <!--- profile --->
    <section class="user-account">
        <div class="container">
            <div class="row">
                <div class="zin">
                 @include('include.teacher_left_common'){{-- left common part --}}

                    <div class="user-right-panel">
                        <div class="user-right-top-new ">
                        	@include('include.errors')
                            <h2 class="profile-heading">Payment History</h2>
                            <p>You can find information about your payments in this section</p>
                        </div>

                        <div class="class-feild">
                            <form>
                                <div class="row new_rows no-gutters">



                                            <div class="col-sm-6">
                                                <div class="form_box_area">

                                                    <div class="dash-d1">
                                                      <label>From Date</label>
                                                       <div class="ui calendar" id="example2">
                                                            <div class="ui input left icon">

                                                              <input type="text" placeholder="Select date" required="">
                                                              <span class="over_llp1"><img src="{{ public_asset('assets/images/cal.png')}}" alt=""></span>
                                                            </div>
                                                         </div>
                                                    </div>

                                                    <div class="dash-d1">
                                                      <label>To Date</label>
                                                       <div class="ui calendar" id="example1">
                                                            <div class="ui input left icon">

                                                              <input type="text" placeholder="Select date" required="">
                                                              <span class="over_llp1"><img src="{{ public_asset('assets/images/cal.png')}}" alt=""></span>
                                                            </div>
                                                         </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                 </div>
                                            </div>




                                    <div class="col-sm-2">
                                         <button class="dash-btn @if(count(@$tot_payments) <= 0) addDisablePhone pointerEventsNone @endif"> <img src="{{ public_asset('assets/images/ser.png')}}"> Search </button></div>

                                </div>
                            </form>
                        </div>

                        <div class="user-right-top-new">
                            <div class="main-tabels">
                                <!-- Nav tabs -->

                                <!-- Tab panes -->

                                    <div class="float-right">
                                        <a href="#" class="deen">Download</a>
                                    </div>

                                    <div class="custom-table">
                                        <div class="new-table-mr">
                                           <div class="table">
                                              <div class="one_row1 hidden-sm-down only_shawo">
                                                <div class="cell1 tab_head_sheet">Booking ID</div>
                                                 <div class="cell1 tab_head_sheet">Date <img src="{{ public_asset('assets/images/sort.png')}}"></div>
                                                 <div class="cell1 tab_head_sheet">Grade  <img src="{{ public_asset('assets/images/sort.png')}}"></div>
                                                 <div class="cell1 tab_head_sheet" >Subject <img src="{{ public_asset('assets/images/sort.png')}}"></div>
                                                 <div class="cell1 tab_head_sheet" >Student <img src="{{ public_asset('assets/images/sort.png')}}"></div>
                                                 <div class="cell1 tab_head_sheet">Amount <img src="{{ public_asset('assets/images/sort.png')}}"></div>

                                                 <div class="cell1 tab_head_sheet">&nbsp;</div>
                                              </div>

                                           {{--    <!--row 1-->
                                              <div class="one_row1 small_screen31">
                                                <div class="cell1 tab_head_sheet_1">
                                                    <span class="W55_1">Booking ID</span>
                                                    <p class="add_ttrr" > #87C5VCKL5</p>
                                                 </div>
                                                 <div class="cell1 tab_head_sheet_1">
                                                    <span class="W55_1">Date</span>
                                                    <p class="add_ttrr"> 10.06.2021</p>
                                                 </div>
                                                 <div class="cell1 tab_head_sheet_1 half-boxes">
                                                    <span class="W55_1">Grade </span>
                                                    <p class="add_ttrr">Grade 1</p>
                                                 </div>
                                                 <div class="cell1 tab_head_sheet_1 half-boxes">
                                                    <span class="W55_1">Subject</span>
                                                    <p class="add_ttrr" >Mathematics</p>
                                                 </div>
                                                 <div class="cell1 tab_head_sheet_1">
                                                    <span class="W55_1">Student</span>
                                                    <p class="add_ttrr" >Anisha R. </p>
                                                 </div>
                                                 <div class="cell1 tab_head_sheet_1 half-boxes">
                                                    <span class="W55_1">Amount</span>
                                                    <p class="add_ttrr">A$08.00</p>
                                                 </div>
                                                 <div class="cell1 tab_head_sheet_1 ">
                                                    <span class="W55_1">Action</span>
                                                    <div class="add_ttrr actions-main">
                                                      <a href="javascript:void(0);" class="action-dots" id="action1"><img src="./images/action-dots.png" alt=""></a>
                                                      <div class="show-actions" id="show-action1" style="display: none;">
                                                        <span class="angle"><img src="./images/angle.png" alt=""></span>
                                                        <ul>

                                                             <li><a href="#">Download invoice</a></li>
                                                        </ul>
                                                      </div>
                                                    </div>
                                                 </div>
                                              </div>
                                              <!--row 1-->

                                              <!--row 1-->
                                              <div class="one_row1 small_screen31">
                                                 <div class="cell1 tab_head_sheet_1">
                                                    <span class="W55_1">Booking ID</span>
                                                    <p class="add_ttrr" >#Abc000410</p>
                                                 </div>
                                                 <div class="cell1 tab_head_sheet_1">
                                                    <span class="W55_1">Date</span>
                                                    <p class="add_ttrr"> 05.06.2021</p>
                                                 </div>
                                                 <div class="cell1 tab_head_sheet_1 half-boxes">
                                                    <span class="W55_1">Grade </span>
                                                    <p class="add_ttrr">Grade 3</p>
                                                 </div>
                                                 <div class="cell1 tab_head_sheet_1 half-boxes">
                                                    <span class="W55_1">Subject</span>
                                                    <p class="add_ttrr" >English</p>
                                                 </div>
                                                 <div class="cell1 tab_head_sheet_1">
                                                    <span class="W55_1">Student</span>
                                                    <p class="add_ttrr" >Rabin T. </p>
                                                 </div>
                                                 <div class="cell1 tab_head_sheet_1 half-boxes">
                                                    <span class="W55_1">Amount</span>
                                                    <p class="add_ttrr">A$10.00</p>
                                                 </div>
                                                 <div class="cell1 tab_head_sheet_1">
                                                    <span class="W55_1">Action</span>
                                                    <div class="add_ttrr actions-main">
                                                      <a href="javascript:void(0);" class="action-dots" id="action2"><img src="./images/action-dots.png" alt=""></a>
                                                      <div class="show-actions" id="show-action2" style="display: none;">
                                                        <span class="angle"><img src="./images/angle.png" alt=""></span>
                                                        <ul>
                                                            <li><a href="#">Download invoice</a></li>
                                                        </ul>
                                                      </div>
                                                    </div>
                                                 </div>
                                              </div>
                                              <!--row 1-->

                                              <!--row 1-->
                                              <div class="one_row1 small_screen31">
                                                 <div class="cell1 tab_head_sheet_1">
                                                    <span class="W55_1">Booking ID</span>
                                                    <p class="add_ttrr" > #87C5VCKL5</p>
                                                 </div>
                                                 <div class="cell1 tab_head_sheet_1">
                                                    <span class="W55_1">Date</span>
                                                    <p class="add_ttrr"> 01.06.2021</p>
                                                 </div>
                                                 <div class="cell1 tab_head_sheet_1 half-boxes">
                                                    <span class="W55_1">Grade </span>
                                                    <p class="add_ttrr">Grade 1</p>
                                                 </div>
                                                 <div class="cell1 tab_head_sheet_1 half-boxes">
                                                    <span class="W55_1">Subject</span>
                                                    <p class="add_ttrr" >History</p>
                                                 </div>
                                                 <div class="cell1 tab_head_sheet_1">
                                                    <span class="W55_1">Student</span>
                                                    <p class="add_ttrr" >Anisha R. </p>
                                                 </div>
                                                 <div class="cell1 tab_head_sheet_1 half-boxes">
                                                    <span class="W55_1">Amount</span>
                                                    <p class="add_ttrr">A$14.00</p>
                                                 </div>
                                                 <div class="cell1 tab_head_sheet_1">
                                                    <span class="W55_1">Action</span>
                                                    <div class="add_ttrr actions-main">
                                                      <a href="javascript:void(0);" class="action-dots" id="action3"><img src="./images/action-dots.png" alt=""></a>
                                                      <div class="show-actions" id="show-action3"  style="display: none;">
                                                        <span class="angle"><img src="./images/angle.png" alt=""></span>
                                                        <ul>
                                                           <li><a href="#">Download invoice</a></li>
                                                        </ul>
                                                      </div>
                                                    </div>
                                                 </div>
                                              </div>
                                              <!--row 1--> --}}


                                           </div>
                                        </div>
                                        {{-- <nav aria-label="...">
                                          <ul class="pagination new-pagination">
                                            <li class="page-item">
                                              <span class="page-link"><i class="fas fa-chevron-left"></i></span>
                                            </li>
                                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                            <li class="page-item" aria-current="page">
                                              <span class="page-link">
                                                2
                                                <span class="sr-only">(current)</span>
                                              </span>
                                            </li>
                                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                                            <li class="page-item"><a class="page-link" href="#">4</a></li>
                                            <li class="page-item">
                                              <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                                            </li>
                                          </ul>
                                        </nav> --}}
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js" integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg==" crossorigin="anonymous"></script>
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



	@endsection
