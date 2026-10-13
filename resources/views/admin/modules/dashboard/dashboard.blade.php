@extends('admin.layouts.app')
@section('title')
    Dashboard
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
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h1 class="pull-left page-title">Welcome !</h1>
                    <ol class="breadcrumb pull-right">
                        <li><a href="{{ route('admin_dashboard') }}">V-Tutor</a></li>
                        <li class="active">Dashboard</li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <a href="{{ route('admin_tutor_application_form_list') }}">
                        <div class="mini-stat clearfix bx-shadow bg-white">
                            <span class="mini-stat-icon bg-info"><i class="fas fa-user"></i></span>
                            <div class="mini-stat-info text-right text-dark">
                                <span class="counter text-dark">{{ @$tutor_application_count }}</span>
                                <b> Tutor Applications</b>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <a href="{{ route('manage.tutors') }}">
                        <div class="mini-stat clearfix bx-shadow bg-white">
                            <span class="mini-stat-icon bg-pink"><i class="fas fa-user-tie"></i></span>
                            <div class="mini-stat-info text-right text-dark">
                                <span class="counter text-dark">{{ @$tutor_count }}</span>
                                <b>Tutors </b>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <a href="{{ route('manage.students') }}">
                        <div class="mini-stat clearfix bx-shadow bg-white">
                            <span class="mini-stat-icon bg-success"><i class="far fa-user"></i></span>
                            <div class="mini-stat-info text-right text-dark">
                                <span class="counter text-dark">{{ @$student_count }}</span>
                               <b>Students </b>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <a href="{{ route('booking.management') }}">
                        <div class="mini-stat clearfix bx-shadow bg-white">
                            <span class="mini-stat-icon bg-pink"><i class="fa fa-check-square-o" aria-hidden="true"></i></span>
                            <div class="mini-stat-info text-right text-dark">
                                <span class="counter text-dark">{{ @$student_bookings_count }}</span>
                                <b>Bookings</b>
                            </div>
                        </div>
                    </a>
                </div>
                
                {{-- <div class="col-md-6 col-sm-6 col-lg-3">
                    <a href="{{ route('manage.admin.class.end.assesment') }}">
                        <div class="mini-stat clearfix bx-shadow bg-white">
                            <span class="mini-stat-icon bg-info"><i class="fas fa-user"></i></span>
                            <div class="mini-stat-info text-right text-dark">
                                <span class="counter text-dark">{{ @$assessments_count }}</span>
                                <b> Assessments</b>
                            </div>
                        </div>
                    </a>
                </div> --}}
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <a href="{{ route('manage.tutors') }}">
                        <div class="mini-stat clearfix bx-shadow bg-white">
                            <span class="mini-stat-icon bg-warning"><i class="fas fa-clock"></i></span>
                            <div class="mini-stat-info text-right text-dark">
                                <span class="counter text-dark">{{ @$todays_s_count }}</span>
                                <b>Today's Sign Up</b>
                            </div>
                        </div>
                    </a>
                </div>
                
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <a href="{{ route('booking.management') }}">
                        <div class="mini-stat clearfix bx-shadow bg-white">
                            <span class="mini-stat-icon bg-success"><i class="far fa-credit-card" aria-hidden="true"></i></span>
                            <div class="mini-stat-info text-right text-dark">
                                <span class="counter text-dark">{{ @$todays_booking_count }}</span>
                                <b>Today's Booking</b>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-6 col-sm-6 col-lg-3">
                    <a href="{{ route('manage.grades') }}">
                        <div class="mini-stat clearfix bx-shadow bg-white">
                            <span class="mini-stat-icon bg-info"><i class="fa fa-book" aria-hidden="true"></i></span>
                            <div class="mini-stat-info text-right text-dark">
                                <span class="counter text-dark">{{ @$grade_count }}</span>
                                <b>Grade</b>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <a href="{{ route('manage.subjects') }}">
                        <div class="mini-stat clearfix bx-shadow bg-white">
                            <span class="mini-stat-icon bg-warning"><i class="fas fa-hand-holding-usd" aria-hidden="true"></i></span>
                            <div class="mini-stat-info text-right text-dark">
                                <span class="counter text-dark">{{ @$subject_count }}</span>
                                <b>Subjects</b>
                            </div>
                        </div>
                    </a>
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
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('.counter').counterUp({
            delay: 100,
            time: 1200
        });
    });
</script>
@endsection