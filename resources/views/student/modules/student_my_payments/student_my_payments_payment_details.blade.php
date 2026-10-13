@extends('layouts.app')



@section('title')



<title>V-Tutor  | Student | View Payment Details | {{ @$bookingDataInformation->booking_no }}</title>



@endsection



@section('left_part')



{{-- @include('include.student_top_common') --}}
@include('include.header_menu_part')

<style type="text/css">
    .overflowtext{
        overflow-wrap: break-word;
    }
    .breaktext{
        word-break: break-all;
    }
</style>
<style type="text/css">
.textLimit {
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
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

                            @include('include.errors')

                            <h2 class="profile-heading">Payment Details <a href="{{ route('student.my.payments') }}" class="pg_btn gj_back_div">Back</a></h2>



                            <p class="gj_sub_hd"> You can find details of the payment here</p>
                        </div>



                        {{-- <div class="class-feild mt-4">



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
                                                //<img src="{{env('STORAGE_URL') . '/teacher_profile_pic/'.@$bookingDataInformation->getTutor->profile_pic}}" alt="" id="img2">



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



                                                 // <span><img src="{{ public_asset('assets/images/map.png') }}">  {{ @$bookingDataInformation->getTutor->getState->state_name }}</span>
                                                 <span><img src="{{ public_asset('assets/images/map.png') }}">{{@$bookingDataInformation->getTutor->city}},{{@$bookingDataInformation->getTutor->getState->state_name}} </span>


                                                 <ul class="profile-rating m-0">



                                                    @if(@$bookingDataInformation->getTutor->avg_review>=0 && @$bookingDataInformation->getTutor->avg_review<=0.24)
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                                @endif

                                                @if(@$bookingDataInformation->getTutor->avg_review>=0.25 && @$bookingDataInformation->getTutor->avg_review<=0.74)
                                                <li><a href="#"><img src="{{ public_asset('assets/images/halfstar.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                                @endif


                                                @if(@$bookingDataInformation->getTutor->avg_review>=0.75 && @$bookingDataInformation->getTutor->avg_review<=1.24)
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                                @endif



                                                @if(@$bookingDataInformation->getTutor->avg_review>=1.25 && @$bookingDataInformation->getTutor->avg_review<=1.74)
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/halfstar.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                                @endif



                                                 @if(@$bookingDataInformation->getTutor->avg_review>=1.75 && @$bookingDataInformation->getTutor->avg_review<=2.24)
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                                @endif




                                                 @if(@$bookingDataInformation->getTutor->avg_review>=2.25 && @$bookingDataInformation->getTutor->avg_review<=2.74)
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/halfstar.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                                @endif




                                                @if(@$bookingDataInformation->getTutor->avg_review>=2.75 && @$bookingDataInformation->getTutor->avg_review<=3.24)
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                                @endif




                                                @if(@$bookingDataInformation->getTutor->avg_review>=3.25 && @$bookingDataInformation->getTutor->avg_review<=3.74)
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/halfstar.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                                @endif




                                                @if(@$bookingDataInformation->getTutor->avg_review>=3.75 && @$bookingDataInformation->getTutor->avg_review<=4.24)
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                                @endif





                                                  @if(@$bookingDataInformation->getTutor->avg_review>=4.25 && @$bookingDataInformation->getTutor->avg_review<=4.74)
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/halfstar.png')}}" alt=""></a></li>
                                                @endif



                                                  @if(@$bookingDataInformation->getTutor->avg_review>=4.75 && @$bookingDataInformation->getTutor->avg_review<=5)
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
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



                                                            @foreach(@$t_my_av_show as $t)



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



                        </div> --}}


                        <div class="class-feild">
                            <div class="row">
                                <div class="col-lg-9 col-md-8">
                                    <div class="tuto-rating">
                                        <em>
                                            @if (@$bookingDataInformation->getTutor->profile_pic)
                                            @php
                                            $image_path =
                                            'assets/images/all_avatars/' . @$bookingDataInformation->getTutor->profile_pic;
                                            @endphp
                                            @if (file_exists(@$image_path))
                                            <img src="{{ public_asset('assets/images/all_avatars/' . @$bookingDataInformation->getTutor->profile_pic) }}"
                                                alt="profile_img">
                                            @else
                                            <img src="{{ env('STORAGE_URL') . '/teacher_profile_pic/' . @$bookingDataInformation->getTutor->profile_pic }}"
                                                alt="">
                                            @endif
                                            @else
                                            @if (@$bookingDataInformation->getTutor->avatar)
                                            <img src="{{ @$bookingDataInformation->getTutor->avatar }}" alt="" id="img2">
                                            @else
                                            <img src="{{ public_asset('assets/images/user-pro.png') }}" alt="" id="img2">
                                            @endif
                                            @endif
                                        </em>
                                        <div class="tu-info">
                                            <h2>{{ @$bookingDataInformation->getTutor->f_name }} {{ @$bookingDataInformation->getTutor->l_name }}</h2>
                                            <div class="sed">
                                                <input type="hidden" id="tutor_id" value="{{ @$bookingDataInformation->getTutor->id }}">
                                                <span><img src="{{ public_asset('assets/images/map.png') }}">
                                                    @if (@$bookingDataInformation->getTutor->getState->state_name)
                                                    @if (@$bookingDataInformation->getTutor->getState->state_name == 'New South Wales')
                                                    NSW
                                                    @elseif(@$bookingDataInformation->getTutor->getState->state_name == 'Victoria')
                                                    VIC
                                                    @elseif(@$bookingDataInformation->getTutor->getState->state_name == 'Queensland')
                                                    QLD
                                                    @elseif(@$bookingDataInformation->getTutor->getState->state_name == 'South Australia')
                                                    SA
                                                    @elseif(@$bookingDataInformation->getTutor->getState->state_name == 'Western Australia')
                                                    WA
                                                    @elseif(@$bookingDataInformation->getTutor->getState->state_name == 'Tasmania')
                                                    TAS
                                                    @elseif(@$bookingDataInformation->getTutor->getState->state_name == 'Northern Territory')
                                                    NT
                                                    @elseif(
                                                    @$bookingDataInformation->getTutor->getState->state_name ==
                                                    'Australian Capital
                                                    Territory')
                                                    ACT
                                                    @endif
                                                    @endif
                                                </span>

                                                <ul class="profile-rating m-0">
                                                    @if (@$bookingDataInformation->getTutor->avg_review >= 0 && @$bookingDataInformation->getTutor->avg_review <= 0.24) <li><a
                                                            href="#"><img
                                                                src="{{ public_asset('assets/images/star1.png') }}"
                                                                alt=""></a></li>
                                                        <li><a href="#"><img
                                                                    src="{{ public_asset('assets/images/star1.png') }}"
                                                                    alt=""></a></li>
                                                        <li><a href="#"><img
                                                                    src="{{ public_asset('assets/images/star1.png') }}"
                                                                    alt=""></a></li>
                                                        <li><a href="#"><img
                                                                    src="{{ public_asset('assets/images/star1.png') }}"
                                                                    alt=""></a></li>
                                                        <li><a href="#"><img
                                                                    src="{{ public_asset('assets/images/star1.png') }}"
                                                                    alt=""></a></li>
                                                        @endif
                                                        @if (@$bookingDataInformation->getTutor->avg_review >= 0.25 && @$bookingDataInformation->getTutor->avg_review <= 0.74)
                                                            <li><a href="#"><img
                                                                    src="{{ public_asset('assets/images/halfstar.png') }}"
                                                                    alt=""></a></li>
                                                            <li><a href="#"><img
                                                                        src="{{ public_asset('assets/images/star1.png') }}"
                                                                        alt=""></a></li>
                                                            <li><a href="#"><img
                                                                        src="{{ public_asset('assets/images/star1.png') }}"
                                                                        alt=""></a></li>
                                                            <li><a href="#"><img
                                                                        src="{{ public_asset('assets/images/star1.png') }}"
                                                                        alt=""></a></li>
                                                            <li><a href="#"><img
                                                                        src="{{ public_asset('assets/images/star1.png') }}"
                                                                        alt=""></a></li>
                                                            @endif
                                                            @if (@$bookingDataInformation->getTutor->avg_review >= 0.75 && @$bookingDataInformation->getTutor->avg_review <= 1.24)
                                                                <li><a href="#"><img
                                                                        src="{{ public_asset('assets/images/star.png') }}"
                                                                        alt=""></a></li>
                                                                <li><a href="#"><img
                                                                            src="{{ public_asset('assets/images/star1.png') }}"
                                                                            alt=""></a></li>
                                                                <li><a href="#"><img
                                                                            src="{{ public_asset('assets/images/star1.png') }}"
                                                                            alt=""></a></li>
                                                                <li><a href="#"><img
                                                                            src="{{ public_asset('assets/images/star1.png') }}"
                                                                            alt=""></a></li>
                                                                <li><a href="#"><img
                                                                            src="{{ public_asset('assets/images/star1.png') }}"
                                                                            alt=""></a></li>
                                                                @endif
                                                                @if (@$bookingDataInformation->getTutor->avg_review >= 1.25 && @$bookingDataInformation->getTutor->avg_review <=
                                                                    1.74) <li><a href="#"><img
                                                                            src="{{ public_asset('assets/images/star.png') }}"
                                                                            alt=""></a></li>
                                                                    <li><a href="#"><img
                                                                                src="{{ public_asset('assets/images/halfstar.png') }}"
                                                                                alt=""></a></li>
                                                                    <li><a href="#"><img
                                                                                src="{{ public_asset('assets/images/star1.png') }}"
                                                                                alt=""></a></li>
                                                                    <li><a href="#"><img
                                                                                src="{{ public_asset('assets/images/star1.png') }}"
                                                                                alt=""></a></li>
                                                                    <li><a href="#"><img
                                                                                src="{{ public_asset('assets/images/star1.png') }}"
                                                                                alt=""></a></li>
                                                                    @endif
                                                                    @if (@$bookingDataInformation->getTutor->avg_review >= 1.75 && @$bookingDataInformation->getTutor->avg_review
                                                                    <= 2.24) <li><a href="#"><img
                                                                                src="{{ public_asset('assets/images/star.png') }}"
                                                                                alt=""></a></li>
                                                                        <li><a href="#"><img
                                                                                    src="{{ public_asset('assets/images/star.png') }}"
                                                                                    alt=""></a></li>
                                                                        <li><a href="#"><img
                                                                                    src="{{ public_asset('assets/images/star1.png') }}"
                                                                                    alt=""></a></li>
                                                                        <li><a href="#"><img
                                                                                    src="{{ public_asset('assets/images/star1.png') }}"
                                                                                    alt=""></a></li>
                                                                        <li><a href="#"><img
                                                                                    src="{{ public_asset('assets/images/star1.png') }}"
                                                                                    alt=""></a></li>
                                                                        @endif
                                                                        @if (@$bookingDataInformation->getTutor->avg_review >= 2.25 &&
                                                                        @$bookingDataInformation->getTutor->avg_review <= 2.74) <li><a href="#"><img
                                                                                    src="{{ public_asset('assets/images/star.png') }}"
                                                                                    alt=""></a></li>
                                                                            <li><a href="#"><img
                                                                                        src="{{ public_asset('assets/images/star.png') }}"
                                                                                        alt=""></a></li>
                                                                            <li><a href="#"><img
                                                                                        src="{{ public_asset('assets/images/halfstar.png') }}"
                                                                                        alt=""></a></li>
                                                                            <li><a href="#"><img
                                                                                        src="{{ public_asset('assets/images/star1.png') }}"
                                                                                        alt=""></a></li>
                                                                            <li><a href="#"><img
                                                                                        src="{{ public_asset('assets/images/star1.png') }}"
                                                                                        alt=""></a></li>
                                                                            @endif
                                                                            @if (@$bookingDataInformation->getTutor->avg_review >= 2.75 &&
                                                                            @$bookingDataInformation->getTutor->avg_review <= 3.24) <li><a
                                                                                    href="#"><img
                                                                                        src="{{ public_asset('assets/images/star.png') }}"
                                                                                        alt=""></a></li>
                                                                                <li><a href="#"><img
                                                                                            src="{{ public_asset('assets/images/star.png') }}"
                                                                                            alt=""></a></li>
                                                                                <li><a href="#"><img
                                                                                            src="{{ public_asset('assets/images/star.png') }}"
                                                                                            alt=""></a></li>
                                                                                <li><a href="#"><img
                                                                                            src="{{ public_asset('assets/images/star1.png') }}"
                                                                                            alt=""></a></li>
                                                                                <li><a href="#"><img
                                                                                            src="{{ public_asset('assets/images/star1.png') }}"
                                                                                            alt=""></a></li>
                                                                                @endif
                                                                                @if (@$bookingDataInformation->getTutor->avg_review >= 3.25 &&
                                                                                @$bookingDataInformation->getTutor->avg_review <= 3.74) <li><a
                                                                                        href="#"><img
                                                                                            src="{{ public_asset('assets/images/star.png') }}"
                                                                                            alt=""></a></li>
                                                                                    <li><a href="#"><img
                                                                                                src="{{ public_asset('assets/images/star.png') }}"
                                                                                                alt=""></a></li>
                                                                                    <li><a href="#"><img
                                                                                                src="{{ public_asset('assets/images/star.png') }}"
                                                                                                alt=""></a></li>
                                                                                    <li><a href="#"><img
                                                                                                src="{{ public_asset('assets/images/halfstar.png') }}"
                                                                                                alt=""></a></li>
                                                                                    <li><a href="#"><img
                                                                                                src="{{ public_asset('assets/images/star1.png') }}"
                                                                                                alt=""></a></li>
                                                                                    @endif
                                                                                    @if (@$bookingDataInformation->getTutor->avg_review >= 3.75 &&
                                                                                    @$bookingDataInformation->getTutor->avg_review <= 4.24) <li><a
                                                                                            href="#"><img
                                                                                                src="{{ public_asset('assets/images/star.png') }}"
                                                                                                alt=""></a></li>
                                                                                        <li><a href="#"><img
                                                                                                    src="{{ public_asset('assets/images/star.png') }}"
                                                                                                    alt=""></a></li>
                                                                                        <li><a href="#"><img
                                                                                                    src="{{ public_asset('assets/images/star.png') }}"
                                                                                                    alt=""></a></li>
                                                                                        <li><a href="#"><img
                                                                                                    src="{{ public_asset('assets/images/star.png') }}"
                                                                                                    alt=""></a></li>
                                                                                        <li><a href="#"><img
                                                                                                    src="{{ public_asset('assets/images/star1.png') }}"
                                                                                                    alt=""></a></li>
                                                                                        @endif
                                                                                        @if (@$bookingDataInformation->getTutor->avg_review >= 4.25 &&
                                                                                        @$bookingDataInformation->getTutor->avg_review <= 4.74) <li><a
                                                                                                href="#"><img
                                                                                                    src="{{ public_asset('assets/images/star.png') }}"
                                                                                                    alt=""></a></li>
                                                                                            <li><a href="#"><img
                                                                                                        src="{{ public_asset('assets/images/star.png') }}"
                                                                                                        alt=""></a></li>
                                                                                            <li><a href="#"><img
                                                                                                        src="{{ public_asset('assets/images/star.png') }}"
                                                                                                        alt=""></a></li>
                                                                                            <li><a href="#"><img
                                                                                                        src="{{ public_asset('assets/images/star.png') }}"
                                                                                                        alt=""></a></li>
                                                                                            <li><a href="#"><img
                                                                                                        src="{{ public_asset('assets/images/halfstar.png') }}"
                                                                                                        alt=""></a></li>
                                                                                            @endif
                                                                                            @if (@$bookingDataInformation->getTutor->avg_review >= 4.75
                                                                                            && @$bookingDataInformation->getTutor->avg_review <= 5)
                                                                                                <li><a href="#"><img
                                                                                                        src="{{ public_asset('assets/images/star.png') }}"
                                                                                                        alt=""></a></li>
                                                                                                <li><a href="#"><img
                                                                                                            src="{{ public_asset('assets/images/star.png') }}"
                                                                                                            alt=""></a></li>
                                                                                                <li><a href="#"><img
                                                                                                            src="{{ public_asset('assets/images/star.png') }}"
                                                                                                            alt=""></a></li>
                                                                                                <li><a href="#"><img
                                                                                                            src="{{ public_asset('assets/images/star.png') }}"
                                                                                                            alt=""></a></li>
                                                                                                <li><a href="#"><img
                                                                                                            src="{{ public_asset('assets/images/star.png') }}"
                                                                                                            alt=""></a></li>
                                                                                                @endif
                                                                                                <li>
                                                                                                    <p>{{
                                                                                                        @$bookingDataInformation->getTutor->avg_review
                                                                                                        }}
                                                                                                        ({{
                                                                                                        @$bookingDataInformation->getTutor->total_no_of_reviews
                                                                                                        }})</p>
                                                                                                </li>
                                                </ul>
                                            </div>
                                            <div class="sed ">
                                            </div>
                                            <div class="sed grade_sed">
                                                <span><img src="{{ public_asset('assets/images/gra.png') }}">
                                                    {{ @$bookingDataInformation->getStudentGrade->grade_name }}</span>

                                            </div>
                                            <div class="sed">
                                                @php
                                                $todayDayIndex = @$todayDayIndex; // 1 (Mon) to 7 (Sun)
                                                @endphp

                                                <img src="{{ public_asset('assets/images/world.png') }}">
                                                @if (@$t_my_av_show && count($t_my_av_show) > 0)
                                                {{-- Nav Tabs --}}
                                                <ul class="nav nav-tabs me-3 flex-wrap" id="availabilityTab" role="tablist">
                                                    @foreach ($t_my_av_show as $day => $slots)
                                                    <li class="nav-item" role="presentation">
                                                        <a class="nav-link {{ $day == $todayDayIndex ? 'active' : '' }}"
                                                            id="tab-{{ $day }}-tab" data-toggle="tab" href="#tab-{{ $day }}"
                                                            role="tab" aria-controls="tab-{{ $day }}"
                                                            aria-selected="{{ $day == $todayDayIndex ? 'true' : 'false' }}">
                                                            {{ $shortDayNames[$day] }}
                                                        </a>
                                                    </li>
                                                    @endforeach
                                                </ul>

                                                {{-- Tab Content --}}
                                                @else
                                                <h4>No Availability</h4>
                                                @endif


                                            </div>

                                        </div>

                                    </div>

                                </div>
                                <div class="col-lg-3 col-md-4">
                                    <div class="availability">
                                        @if (@$t_my_av_show)
                                        <div class="tab-content" id="availabilityTabContent">
                                            @foreach ($t_my_av_show as $day => $slots)
                                            <div class="tab-pane fade {{ $day == $todayDayIndex ? 'show active' : '' }}"
                                                id="tab-{{ $day }}" role="tabpanel" aria-labelledby="tab-{{ $day }}-tab">

                                                <h5>{{ $dayNames[$day] }} Availability</h5>
                                                <ul class="list-group mt-2">
                                                    @if (count($slots) > 0)
                                                    @foreach ($slots as $slot)
                                                    <li class="list-group-item">
                                                        {{ \Carbon\Carbon::parse($slot->from_time_student)->format('g:i A')
                                                        }}
                                                        -
                                                        {{-- {{ \Carbon\Carbon::parse($slot->to_time_student)->format('g:i A') }} --}}
                                                        {{ \Carbon\Carbon::parse($slot->to_time_student)->greaterThan(\Carbon\Carbon::createFromFormat('H:i', config('sessionsettings.max_end_time')))
                                                            ? \Carbon\Carbon::createFromFormat('H:i', config('sessionsettings.max_end_time'))->format('g:i A')
                                                            : \Carbon\Carbon::parse($slot->to_time_student)->format('g:i A')
                                                            }}
                                                    </li>
                                                    @endforeach
                                                    @else
                                                    <li class="list-group-item">No Slots Available</li>
                                                    @endif
                                                </ul>
                                            </div>
                                            @endforeach
                                        </div>
                                        @else
                                        <h4>No Availability</h4>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>




                        <div class="user-right-top-new marb90 text-center">



                            {{-- <img src="{{ public_asset('assets/images/confr.png') }}"> --}}



                            {{-- <h2 class="profile-headingnew">Payment Details </h2> --}}



                            {{-- <p>Please find details of the payment below</p> --}}

                            {{-- <div class="backBtnCls"><a href="{{ route('student.my.payments') }}" class="pg_btn">Back</a></div> --}}





                            <!-- <div class="booking-stat">



                                <span>Booking Number: <p> {{ @$bookingDataInformation->booking_no }} </p></span>



                                <span>Subject: <p> {{ @$bookingDataInformation->getSubject->subject }} </p></span>



                                <span>Date: <p> {{date('d-m-Y', strtotime(@$bookingDataInformation->booking_date))}} </p></span>



                                <span>Time: <p> {{ date("h:i a", strtotime(@$bookingDataInformation->from_time)) }} to {{ date("h:i a", strtotime(@$bookingDataInformation->to_time)) }} </p></span>



                            </div> -->

                            <div class="booking-stat table_book">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Booking ID </th>
                                                <th>Grade</th>
                                                <th>Subject</th>
                                                <th>Amount</th>
                                                {{-- view_details_date --}}
                                                {{-- view_details_time --}}
                                                <th class="">Transaction Id</th>
                                                <th class="">Paid Via</th>
                                                <th>Status</th>
                                                {{-- <th class="view_details_ses">Session</th> --}}
                                                {{-- @if(@$bookingDataInformation->status != 'C') --}}
                                                {{-- <th>Join Url</th> --}}
                                                {{-- @endif --}}
                                            </tr>
                                          </thead>
                                            <tr>
                                                <td>{{ @$bookingDataInformation->booking_no }}</td>
                                                {{-- <td>{{ @$bookingDataInformation->getTutor->f_name }} {{ @$bookingDataInformation->getTutor->l_name }}</td> --}}
                                                <td>{{ @$bookingDataInformation->getStudentGrade->grade_name }}</td>
                                                <td>{{ @$bookingDataInformation->getSubject->subject }} </td>

                                                <td>
                                                    @if (isset($bookingDataInformation->net_total) && $bookingDataInformation->net_total)
                                                        ${{ number_format(@$bookingDataInformation->net_total,2)}}
                                                    @else
                                                        ${{ number_format(@$bookingDataInformation->booking_amount + @$bookingDataInformation->stripe_charge,2)}}
                                                    @endif
                                                </td>

                                                <td>{{ @$bookingDataInformation->getPaymentsInfo->txn_id }}</td>
                                                <td>
                                                    @php
                                                      $paidVia = json_decode(@$bookingDataInformation->getPaymentsInfo->response);
                                                      @endphp
                                                      {{strtoupper(@$paidVia->payment_method_details->card->brand)}} {{strtoupper(@$paidVia->payment_method_details->card->funding)}} {{strtoupper(@$paidVia->payment_method_details->type)}}
                                                </td>

                                                <td class="@if(@$bookingDataInformation->booking_status=="B")
                                                        Booked
                                                        @elseif(@$bookingDataInformation->booking_status=="C")
                                                        cancelled_red_color
                                                        @elseif(@$bookingDataInformation->booking_status=="CM")
                                                        completed_green_color
                                                        @else
                                                        In progress
                                                        @endif">
                                                    @if(@$bookingDataInformation->booking_status == 'IC')
                                                    Incomplete
                                                    @elseif(@$bookingDataInformation->booking_status == 'B')
                                                    Booked
                                                    @elseif(@$bookingDataInformation->booking_status == 'CM')
                                                        @if(@$bookingDataInformation->booking_status=="CM" && @$bookingDataInformation->class_assessment_student == 'N')
                                                            <a href="{{route('student.class.end.assesment',$bookingDataInformation->booking_no)}}" class="red_link">Review</a>
                                                        @else
                                                            Completed
                                                        @endif
                                                    @elseif(@$bookingDataInformation->booking_status == 'C')
                                                    Cancelled
                                                    @elseif(@$bookingDataInformation->booking_status == 'F')
                                                    Failed
                                                    @endif
                                                </td>

                                            </tr>
                                    </table>

                                </div>
                            </div>
                            <div class="booking-stat table_book">
                                <div class="table-responsive">
                                    @if(@$bookingDataInformation->booking_status == 'C')
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Refund Id</th>
                                                <th>Refund Amount</th>
                                                <th>Cancelled By</th>
                                                <th>Cancelled On</th>
                                                <th>Refund Status</th>

                                                {{-- <th class="">Transaction Id</th> --}}
                                                {{-- <th class="">Paid Via</th> --}}
                                                {{-- <th>Status</th> --}}
                                            </tr>
                                          </thead>
                                            <tr>
                                                <td>
                                                    @if(@$bookingDataInformation->getPaymentsInfo->refund_id)
                                                    {{ @$bookingDataInformation->getPaymentsInfo->refund_id }}
                                                    @else
                                                    No Refund
                                                    @endif
                                                </td>
                                                <td>${{ number_format(@$bookingDataInformation->getPaymentsInfo->refund_amount,2) }}</td>
                                                <td>
                                                    @if(@$bookingDataInformation->cancelled_by == 'S')
                                                        {{ @$bookingDataInformation->getStudent->parent_f_name }} {{ @$bookingDataInformation->getStudent->parent_l_name }}
                                                    @elseif(@$bookingDataInformation->cancelled_by == 'T')
                                                        {{ @$bookingDataInformation->getTutor->f_name }} {{ @$bookingDataInformation->getTutor->l_name }}
                                                    @elseif(@$bookingDataInformation->cancelled_by == 'A')
                                                        Admin
                                                    @endif
                                                </td>
                                                <td>{{ @$bookingDataInformation->cancelled_on }}</td>
                                                <td>
                                                    @if(@$bookingDataInformation->getPaymentsInfo->refund_type == '100')
                                                      Full Refund
                                                      @elseif(@$bookingDataInformation->getPaymentsInfo->refund_type == '75')
                                                      75% amount refunded
                                                      @elseif(@$bookingDataInformation->getPaymentsInfo->refund_type == '50')
                                                      50% amount refunded
                                                      @elseif(@$bookingDataInformation->getPaymentsInfo->refund_type == '25')
                                                      25% amount refunded
                                                      @elseif(@$bookingDataInformation->getPaymentsInfo->refund_type == 'N')
                                                      No refund
                                                      @endif

                                                </td>


                                            </tr>
                                    </table>
                                    @endif
                                </div>

                                <div class="btn_3_cc">
                                        {{-- @if(@$bookingDataInformation->booking_status == 'B')
                                            @if(@$bookingDataInformation->booking_date ==date('Y-m-d') && @$bookingDataInformation->to_time > date('H:i:s'))
                                                <a data-toggle="modal" data-target="#cancelPopup" href="#" class="sub_btn new-subbtn">Cancel Booking</a>
                                            @else
                                                <a data-toggle="modal" data-target="#cancelPopup" href="#" class="sub_btn new-subbtn">Cancel Booking</a>
                                            @endif
                                        @endif --}}
                                        @php
                                        $getTutorGrades = @$bookingDataInformation->getTutor->getTutorShipPlan->pluck('grade_id')->toArray();
                                        $mGrade = @Auth::user()->grade;


                                        @endphp

                                        @if(@$admin_disable_bookings_values->disable_booking == 'Y')
                                            <li><a class="open_popup_g sub_btn new-subbtn" data-toggle="modal" data-target="#admin_disabled_bookings_popup" href="javascript:void(0);">Book again</a></li>
                                        @elseif(in_array(date('Y-m-d'),$all_disabled_booking_dates))
                                            <li><a class="open_popup_g sub_btn new-subbtn" data-toggle="modal" data-target="#admin_disabled_bookings_popup" href="javascript:void(0);">Book again</a></li>

                                        @elseif(!in_array($mGrade,$getTutorGrades))
                                            <li><a class="open_popup_g sub_btn new-subbtn" data-toggle="modal" data-target="#not_b_popup" href="javascript:void(0);">Book Again </a></li>
                                        @elseif(@Auth::user()->timezone_id == @$bookingDataInformation->getTutor->timezone_id && @Auth::user()->state == @$bookingDataInformation->getTutor->state && in_array($mGrade,$getTutorGrades))
                                            <a href="{{ url('studentbook-class?search_tutor_nm_studentclass='.$bookingDataInformation->getTutor->f_name." ".$bookingDataInformation->getTutor->l_name.'&search_tutor_id_studentclass='.$bookingDataInformation->getTutor->id.'&search_tutor_selected_name_studentclass='.$bookingDataInformation->getTutor->f_name." ".$bookingDataInformation->getTutor->l_name.'&search_tutor_slug_studentclass='.$bookingDataInformation->getTutor->slug.'&book_subject='.$bookingDataInformation->getSubject->slug) }}" class="sub_btn new-subbtn">Book Again </a>
                                        @endif
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
    <div class="modal " id="not_b_popup">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title ">Message</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="">
                        <div class=" ">
                            <div class="meass-popup">
                                <ul class="">
                                    <li class="">
                                        You cannot book a session outside your grade
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal " id="not_b_popupState">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title ">Message</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="">
                        <div class=" ">
                            <div class="meass-popup">
                                <ul class="">
                                    <li class="">
                                        You cannot book a session outside your state
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal " id="not_b_popupTimeZone">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title ">Message</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="">
                        <div class=" ">
                            <div class="meass-popup">
                                <ul class="">
                                    <li class="">
                                        You cannot book this tutor since they are outside your State / Timezone. Try to book tutors within your State / Timezone.
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal " id="admin_disabled_bookings_popup">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title bb_disabled_booking_u">Message</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="">
                        <div class=" ">
                            <div class="meass-popup">
                                <ul class="">
                                    <li class="">
                                        You cannot make bookings at this time. Please contact support
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal res-modal newqusmo" id="cancelPopup">
        <div class="modal-dialog modal-dialog-centered divPoMW tapDiv proClose">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Booking Cancellation</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body ">
                    <div class="testPro">
                        <div class=" proDiv" id="warningTextDiCancel">
                            <span class="proclosespan">Cancel Booking</span>
                            <h6></h6>
                            <p>You have chosen to cancel the booking. If this is by mistake, kindly ignore</p>
                            <p><em>Cancellation of sessions will be treated in accordance with the V-Tutor cancellation policy. Refunds are subject to conditions. Refer to the policy from the Help section for more details.</em></p>

                            <div class="next-btn1 newst_btn-pop">
                                {{-- {{ route('student.cancel.class.booking',@$val->booking_no) }} --}}
                                <a href="{{ route('student.cancel.class.booking',@$bookingDataInformation->booking_no) }}" class="btn btn-new btn-danger float-left change-new-link">Yes, please cancel</a>

                                <button type="button" class="btn btn-new btn-danger " data-dismiss="modal">No, don’t cancel </button>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal res-modal newqusmo" id="sessionLink">
        <div class="modal-dialog modal-dialog-centered divPoMW tapDiv proClose">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">You are early!</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body ">
                    <div class="testPro">
                        <div class=" proDiv" id="warningTextDiCancel">
                            {{-- <span class="proclosespan">Cancel Booking</span> --}}
                            <h6></h6>
                            <p>Meeting link will be active only 5 minutes before the session</p>
                            <p>Session booked for {{ date("d-m-Y", strtotime(@$bookingDataInformation->booking_date)) }}  between {{ date("h:i a", strtotime(@$bookingDataInformation->from_time_user)) }}-{{ date("h:i a", strtotime(@$bookingDataInformation->to_time_user)) }} <timezone>. </p>


                            <div class="next-btn1 newst_btn-pop">
                                {{-- {{ route('student.cancel.class.booking',@$val->booking_no) }} --}}
                                <a href="{{route('student.my.classes')}}" id="cancel_session_link" class="btn btn-new btn-danger float-left change-new-link"></a>


                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



@section('script')



@include('include.script')







@endsection
