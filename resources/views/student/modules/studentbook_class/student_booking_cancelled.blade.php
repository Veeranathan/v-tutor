@extends('layouts.app')



@section('title')



<title>V-Tutor  | Student | Booking Cancelled | {{ @$bookingDataInformation->booking_no }}</title>



@endsection



@section('left_part')



{{-- @include('include.student_top_common') --}}
@include('include.header_menu_part')



@endsection



@section('content')



<!-- bannersec -->



<!-- bannersec -->



   <div class="top_mar"></div>



    <!--- profile --->



    <section class="user-account">



        <div class="container">



            <div class="row">



                <div class="zin">



                    @include('include.student_left_common')



                    <div class="user-right-panel">



                        <div class="user-right-top-new ">



                            <h2 class="profile-heading">Booking Cancelled</h2>



                            <p>Your booking {{ @$bookingDataInformation->booking_no }} sucessfully cancelled</p>

                            @include('include.errors')

                        </div>
                        <div class="class-feild mt-4">
                            <div class="row">
                                <div class="col-12">
                                    <div class="tuto-rating">
                                        <em>
                                            @if(@$bookingDataInformation->getTutor->profile_pic)
                                            @php
                                            $image_path = 'assets/images/all_avatars/'.@$bookingDataInformation->getTutor->profile_pic;
                                            @endphp
                                            @if(file_exists(@$image_path))
                                                <img src="{{ public_asset('assets/images/all_avatars/' . @$bookingDataInformation->getTutor->profile_pic) }}" alt="profile_img">
                                            @else
                                                <img src="{{env('STORAGE_URL') . '/teacher_profile_pic/'.@$bookingDataInformation->getTutor->profile_pic}}" alt="">
                                            @endif
                                                {{-- <img src="{{env('STORAGE_URL') . '/teacher_profile_pic/'.@$bookingDataInformation->getTutor->profile_pic}}" alt="" id="img2"> --}}
                                            @else
                                                @if(@$bookingDataInformation->getTutor->avatar)
                                                    <img src="{{@$bookingDataInformation->getTutor->avatar}}" alt="" id="img2">
                                                @else
                                                    <img src="{{ public_asset('assets/images/user-pro.png') }}" alt="" id="img2">
                                                @endif
                                            @endif
                                        </em>
                                        <div class="tu-info">
                                            <h2>{{ @$bookingDataInformation->getTutor->f_name }} {{ @$bookingDataInformation->getTutor->l_name }}</h2>
                                            <div class="sed">
                                                 <span><img src="{{ public_asset('assets/images/map.png') }}">  {{ @$bookingDataInformation->getTutor->getState->state_name }}</span>
                                                 <ul class="profile-rating m-0">
                                                    @if(@$bookingDataInformation->avg_review>=0 && @$bookingDataInformation->avg_review<=0.24)
                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i></li>
                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i></li>
                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i></li>
                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i></li>
                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i></li>
                                                    @endif
                                                    @if(@$bookingDataInformation->avg_review>=0.25 && @$bookingDataInformation->avg_review<=0.74)
                                                        <li><i class="fas fa-star-half-alt" style="color:#ef9a0c!important;"></i></li>
                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i></li>
                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i></li>
                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i></li>
                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i></li>
                                                    @endif
                                                    @if(@$bookingDataInformation->avg_review>=0.75 && @$bookingDataInformation->avg_review<=1.24)
                                                        <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>
                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i></li>
                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i></li>
                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i></li>
                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i></li>
                                                    @endif
                                                    @if(@$bookingDataInformation->avg_review>=1.25 && @$bookingDataInformation->avg_review<=1.74)







                                                    <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>







                                                    <li><i class="fas fa-star-half-alt" style="color:#ef9a0c!important;"></i></li>







                                                    <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i></li>







                                                    <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i></li>







                                                    <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i></li>







                                                    @endif







                                                    @if(@$bookingDataInformation->avg_review>=1.75 && @$bookingDataInformation->avg_review<=2.24)







                                                    <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>







                                                    <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>







                                                    <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i></li>







                                                    <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i></li>







                                                    <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i></li>







                                                    @endif







                                                    @if(@$bookingDataInformation->avg_review>=2.25 && @$bookingDataInformation->avg_review<=2.74)







                                                    <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>







                                                    <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>







                                                    <li><i class="fas fa-star-half-alt" style="color:#ef9a0c!important;"></i></li>







                                                    <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i></li>







                                                    <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i></li>







                                                    @endif







                                                    @if(@$bookingDataInformation->avg_review>=2.75 && @$bookingDataInformation->avg_review<=3.24)







                                                    <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>







                                                    <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>







                                                    <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>







                                                    <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i></li>







                                                    <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i></li>







                                                    @endif







                                                    @if(@$bookingDataInformation->avg_review>=3.25 && @$bookingDataInformation->avg_review<=3.74)







                                                    <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>







                                                    <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>







                                                    <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>







                                                    <li><i class="fas fa-star-half-alt" style="color:#ef9a0c!important;"></i></li>







                                                    <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i></li>







                                                    @endif







                                                    @if(@$bookingDataInformation->avg_review>=3.75 && @$bookingDataInformation->avg_review<=4.24)







                                                    <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>







                                                    <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>







                                                    <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>







                                                    <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>







                                                    <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i></li>







                                                    @endif







                                                    @if(@$bookingDataInformation->avg_review>=4.25 && @$bookingDataInformation->avg_review<=4.74)







                                                    <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>







                                                    <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>







                                                    <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>







                                                    <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>







                                                    <li><i class="fas fa-star-half-alt" style="color:#ef9a0c!important;"></i></li>







                                                    @endif







                                                    @if(@$bookingDataInformation->avg_review>=4.75 && @$bookingDataInformation->avg_review<=5)







                                                    <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>







                                                    <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>







                                                    <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>







                                                    <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>







                                                    <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>







                                                    @endif







                                                    <li><p>{{ @$bookingDataInformation->getTutor->avg_review }} ({{ @$bookingDataInformation->getTutor->total_no_of_reviews }})</p></li>



                                                </ul>



                                            </div>



                                            <div class="sed ">







                                            </div>



                                            <div class="sed grade_sed">



                                                <span><img src="{{ public_asset('assets/images/gra.png') }}"> {{ @$bookingDataInformation->getStudentGrade->grade_name }}</span>



                                                <span>



                                                        <img src="{{ public_asset('assets/images/world.png') }}">







                                                        @if(@$t_my_av_show)



                                                            @foreach(@$t_my_av_show as $key=>$t)

                                                            @if(@$key != 0), @endif

                                                                @if(@$t->day == 1)



                                                                Monday



                                                                @elseif(@$t->day == 2)



                                                                Tuesday



                                                                @elseif(@$t->day == 3)



                                                                Wednesday



                                                                @elseif(@$t->day == 4)



                                                                Thursday



                                                                @elseif(@$t->day == 5)



                                                                Friday



                                                                @elseif(@$t->day == 6)



                                                                Saturday



                                                                @elseif(@$t->day == 7)



                                                                Sunday



                                                                @endif



                                                                 {{ date("h:i a", strtotime(@$t->from_time)) }}-{{ date("h:i a", strtotime(@$t->to_time)) }},



                                                            @endforeach



                                                        @endif



                                                    </span>



                                            </div>







                                        </div>



                                    </div>



                                </div>



                            </div>



                        </div>







                        <div class="user-right-top-new marb90 text-center">



                            <img src="{{ public_asset('assets/images/confr.png') }}">



                            <h2 class="profile-headingnew">Your booking is cancelled.</h2>



                            <p>Your all booking information here...</p>







                            <!-- <div class="booking-stat">



                                <span>Booking Number: <p> {{ @$bookingDataInformation->booking_no }} </p></span>



                                <span>Subject: <p> {{ @$bookingDataInformation->getSubject->subject }} </p></span>



                                <span>Date: <p> {{ @$bookingDataInformation->booking_date }} </p></span>



                                <span>Time: <p> {{ date("h:i a", strtotime(@$bookingDataInformation->from_time)) }} to {{ date("h:i a", strtotime(@$bookingDataInformation->to_time)) }} </p></span>



                            </div> -->

                            <div class="booking-stat table_book">

                                <div class="table-responsive">

                                    <table class="table table-bordered">

                                        <thead>

                                            <tr>

                                                <th>Booking Number </th>

                                                <th>Subject</th>

                                                <th>Date</th>

                                                <th>Time</th>

                                               <th>Rate per session (30 mins)</th>
                                               <th>Amount</th>

                                            </tr>

                                          </thead>

                                      <tr>

                                        <td>{{ @$bookingDataInformation->booking_no }}</td>

                                        <td>{{ @$bookingDataInformation->getSubject->subject }} </td>

                                        <td>{{ @$bookingDataInformation->booking_date }}</td>

                                        <td>{{ date("h:i a", strtotime(@$bookingDataInformation->from_time)) }} to {{ date("h:i a", strtotime(@$bookingDataInformation->to_time)) }}</td>

                                        <td>${{ @$bookingDataInformation->hourly_rate }}</td>
                                        <td>${{ number_format(@$bookingDataInformation->booking_amount + @$bookingDataInformation->stripe_charge,2) }}</td>



                                      </tr>

                                    </table>
                                </div>
                                <div class="btn_3_cc">
                                        <a href="{{ url('studentbook-class?search_tutor_nm_studentclass='.$bookingDataInformation->getTutor->f_name." ".$bookingDataInformation->getTutor->l_name.'&search_tutor_id_studentclass='.$bookingDataInformation->getTutor->id.'&search_tutor_selected_name_studentclass='.$bookingDataInformation->getTutor->f_name." ".$bookingDataInformation->getTutor->l_name.'&search_tutor_slug_studentclass='.$bookingDataInformation->getTutor->slug.'&book_subject='.$bookingDataInformation->getSubject->slug) }}" class="sub_btn new-subbtn">Book Again</a>


                                    </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>



        </div>



    </section>
<!--
<div class="modal log_modal_bx" id="proceed_id">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"> Please signup or login to continue</h4>
          <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        <div class="modal-body">
            <div class="modal_button">
                <ul>
                    <li><a href="#" class=" pg_btn">Leave</a></li>
                    <li><a href="#" class="pg_btn">Stay</a></li>
                </ul>
            </div>
        </div>

      </div>
    </div>
  </div> -->

<div class="modal fade log_modal_bx" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">You are about to leave the site to complete booking process</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="modal_button">
                <ul>
                    <li><a href="#" class=" pg_btn">Leave</a></li>
                    <li><a href="#" class="pg_btn">Stay</a></li>
                </ul>
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







@endsection
