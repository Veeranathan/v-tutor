
@if(@Auth::user()->grade==0)

<script>window.location = "{{url('/')}}/my-profile";</script>


@else

@extends('layouts.app')
@section('title')
<title>V-Tutor  | User | Home </title>
@endsection
@section('left_part')
{{-- @include('include.student_top_common') --}}
@include('include.header_menu_part')
@endsection
@section('content')

 <!-- bannersec -->
    <div class="top_mar"></div>
    <!--- profile --->
    <section class="user-account">
        <div class="container">
            <div class="row">
                <div class="zin">
               @include('include.student_left_common'){{-- student left part --}}

                    <div class="user-right-panel">
                        <div class="user-right-top ">
                            <h2 class="profile-heading">My Dashboard</h2>
                            <p class="mb-3">You can find information about your sessions and tutors in this section</p>
                            <hr class="das-hr">


                            <div class="user-account-info">
                                <h3>Classes</h3>
                                <div class="row">
                                        <div class="col-sm-6 col-12">
                                            <div class="dashboxitm">
                                                <div class="media">
                                                    <div class="meadia-img">
                                                        <img src="{{ public_asset('assets/images/dash-ic1.png')}}">
                                                    </div>
                                                    <div class="meadia-body">
                                                        <h6>Today's sessions</h6>
                                                        <p>{{ @$count_todays_session }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-12">
                                            <div class="dashboxitm">
                                                <div class="media">
                                                    <div class="meadia-img">
                                                        <img src="{{ public_asset('assets/images/dash-ic1.png')}}">
                                                    </div>
                                                    <div class="meadia-body">
                                                        <h6>Past Sessions</h6>
                                                        <p>{{ @$count_past_session }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-12">
                                            <div class="dashboxitm">
                                                <div class="media">
                                                    <div class="meadia-img">
                                                        <img src="{{ public_asset('assets/images/dash-ic1.png')}}">
                                                    </div>
                                                    <div class="meadia-body">
                                                        <h6>Upcoming Sessions</h6>
                                                        <p>{{ @$count_upcoming_session }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-12">
                                            <div class="dashboxitm">
                                                <div class="media">
                                                    <div class="meadia-img">
                                                        <img src="{{ public_asset('assets/images/dash-ic1.png')}}">
                                                    </div>
                                                    <div class="meadia-body">
                                                        <h6>Total Sessions</h6>
                                                        <p>{{ @$count_total_session }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>

                             <div class="user-account-info">
                                <h3>Tutors</h3>
                                <div class="row">
                                        <div class="col-sm-6 col-12">
                                            <div class="dashboxitm">
                                                <div class="media">
                                                    <div class="meadia-img">
                                                        <img src="{{ public_asset('assets/images/dash-ic14.png')}}">
                                                    </div>
                                                    <div class="meadia-body">
                                                        <h6>Review History</h6>
                                                        <p>{{ @$count_reviewed_tutors }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-12">
                                            <div class="dashboxitm">
                                                <div class="media">
                                                    <div class="meadia-img">
                                                        <img src="{{ public_asset('assets/images/dash-ic3.png')}}">
                                                    </div>
                                                    <div class="meadia-body">
                                                        <h6>Favorite Tutors</h6>
                                                        <p>{{ @$count_fav_tutors }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-12">
                                            <div class="dashboxitm">
                                                <div class="media">
                                                    <div class="meadia-img">
                                                        <img src="{{ public_asset('assets/images/dash-ic3.png')}}">
                                                    </div>
                                                    <div class="meadia-body">
                                                        <h6> Frequent Tutors</h6>
                                                        <p>{{ @$count_frequent_tutors }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-12">
                                            <div class="dashboxitm">
                                                <div class="media">
                                                    <div class="meadia-img">
                                                        <img src="{{ public_asset('assets/images/dash-ic3.png')}}">
                                                    </div>
                                                    <div class="meadia-body">
                                                        <h6>Total Tutors</h6>
                                                        <p>{{ @$total_tutors }}</p>
                                                    </div>
                                                </div>
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


<!--- profile --->

@endsection
@section('footer')
@include('include.footer')
@endsection
@section('script')
@include('include.script')
@endsection

@endif
