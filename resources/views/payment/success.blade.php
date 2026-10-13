@extends('layouts.app')

@section('title')
    <title>V-Tutor  | Student | Payment | {{ @$bookingDataInformation->booking_no }}</title>
@endsection

@section('left_part')
    {{-- @include('include.student_top_common') --}}
@include('include.header_menu_part')

    <style type="text/css">
        .selectBox {

            height: 44px;

        }
    </style>
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

                            <h2 class="profile-heading">Booking Order Success</h2>

                            {{-- <p> {{ @$bookingDataInformation->booking_no }} </p> --}}

                            @include('include.errors')

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

@endsection
