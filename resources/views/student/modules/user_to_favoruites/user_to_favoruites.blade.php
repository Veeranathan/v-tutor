@extends('layouts.app')
@section('title')
    <title>V-Tutor | Tutors</title>
@endsection
@section('left_part')
    {{-- @include('include.student_top_common') --}}
    @include('include.header_menu_part')
    <link href="{{ public_asset('assets/toastr/build/toastr.min.css') }}" rel="stylesheet">
    <style type="text/css">
        .autocomplete-items {
            height: auto !important;
        }
    </style>
@endsection
@section('content')
<section class="makes_special_sec faq-sec">
    <div class="makes_special_inr">
        <div class="top_mar"></div>
        <section class="user-account">
            <div class="container">
                <div class="row">
                    <div class="zin">
                        @include('include.student_left_common')
                        <div class="user-right-panel">
                            <div class="user-right-top-new ">
                                @include('include.errors')
                                <h2 class="profile-heading">Tutors</h2>
                                <p class="gj_sub_hd">You can find information about your tutors in this section</p>
                            </div>
                            <div class="class-feild">
                                <form>
                                    <div class="row new_rows no-gutters">
                                        <div class="col-md-5 col-sm-6">
                                            <div class="form_box_area">
                                                <label>Search V-Tutor</label>
                                                <div class="autocomplete">

                                                    <input id="search_tutor_nm_studentclass" class="required"
                                                        name="search_tutor_nm_studentclass" type="text"
                                                        placeholder="Type tutor name" autocomplete="off"
                                                        onfocus="this.removeAttribute('readonly');" readonly=""
                                                        onclick="this.removeAttribute('readonly');"
                                                        onblur="this.removeAttribute('readonly');" autocomplete="off"
                                                        value="{{ @$key['search_tutor_nm_studentclass'] }}">
                                                    <input type="hidden" name="search_tutor_id_studentclass"
                                                        id="search_tutor_id_studentclass"
                                                        value="{{ @$key['search_tutor_id_studentclass'] }}">

                                                    <input type="hidden" name="search_tutor_selected_name_studentclass"
                                                        id="search_tutor_selected_name_studentclass"
                                                        value="{{ @$key['search_tutor_selected_name_studentclass'] }} ">

                                                    <input type="hidden" name="search_tutor_slug_studentclass"
                                                        id="search_tutor_slug_studentclass"
                                                        value="{{ @$key['search_tutor_slug_studentclass'] }}">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">

                                            <button class="dash-btn">
                                                <img src="{{ public_asset('assets/images/ser.png') }}"> Search </button>

                                        </div>
                                        <div class="col-sm-2">

                                            <a href="{{ route('list.of.favourite') }}" class="dash-btn">Reset</a>
                                        </div>
                                    </div>
                                </form>

                            </div>
                            <div class="user-right-top-new">
                                <div class="main-tabels w-100">

                                    @if (count(@$tutors) > 0)
                                        <div class="search_right_body pl-0">
                                            @if (@$tutors)
                                                @foreach (@$tutors as $tutor)
                                                    <div class="search_lop d-flex flex-column flex-md-row">
                                                        <a @if (@Auth::check()) href="javascript:void(0)" @else href="{{ route('login') }}" @endif
                                                            class=" heart_cc @if (@$tutor->getuserToFavourite) heart_cc_act @endif  saveUsertoFavourite"
                                                            data-saveUsertoFavourite="{{ @$tutor->id }}">
                                                            <i class="fas fa-heart"></i>
                                                        </a>
                                                        <div class="search_lop_left d-flex d-md-block justify-content-start pl-3 pl-md-0 align-items-center">
                                                            <em>
                                                                @if (@$tutor->profile_pic)
                                                                    @php
                                                                        $image_path =
                                                                            'assets/images/all_avatars/' .
                                                                            @$tutor->profile_pic;
                                                                    @endphp
                                                                    @if (file_exists(@$image_path))
                                                                        <img src="{{ public_asset('assets/images/all_avatars/' . @$tutor->profile_pic) }}"
                                                                            alt="profile_img">
                                                                    @else
                                                                        <img src="{{ asset('storage/teacher_profile_pic/' . @$tutor->profile_pic) }}" alt="">
                                                                    @endif

                                                                @else
                                                                    @if (@$tutor->avatar)
                                                                        <img src="{{ @$tutor->avatar }}" alt="">
                                                                    @else
                                                                        <img src="{{ public_asset('assets/images/searchimg1.jpg') }}"
                                                                            alt="" />
                                                                    @endif
                                                                @endif

                                                            </em>


                                                            <div>
                                                                <h4 class="mb-0">From ${{ @$tutor->min_hourly_rate }}/hr
                                                                </h4>
                                                                <ul class="sh_lis_star">
                                                                    @if ($tutor->avg_review >= 0 && $tutor->avg_review <= 0.24)
                                                                        <li><i class="fa fa-star rre_star"
                                                                                style="color:#b6b6b6 !important;"></i></li>
                                                                        <li><i class="fa fa-star rre_star"
                                                                                style="color:#b6b6b6 !important;"></i></li>
                                                                        <li><i class="fa fa-star rre_star"
                                                                                style="color:#b6b6b6 !important;"></i></li>
                                                                        <li><i class="fa fa-star rre_star"
                                                                                style="color:#b6b6b6 !important;"></i></li>
                                                                        <li><i class="fa fa-star rre_star"
                                                                                style="color:#b6b6b6 !important;"></i></li>
                                                                    @endif
                                                                    @if ($tutor->avg_review >= 0.25 && $tutor->avg_review <= 0.74)
                                                                        <li><i class="fas fa-star-half-alt" style="color:#ef9a0c!important;"></i>
                                                                        </li>
                                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i>
                                                                        </li>
                                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i>
                                                                        </li>
                                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i>
                                                                        </li>
                                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i>
                                                                        </li>
                                                                    @endif
                                                                    @if ($tutor->avg_review >= 0.75 && $tutor->avg_review <= 1.24)
                                                                        <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i>
                                                                        </li>
                                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i>
                                                                        </li>
                                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i>
                                                                        </li>
                                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i>
                                                                        </li>
                                                                    @endif
                                                                    @if ($tutor->avg_review >= 1.25 && $tutor->avg_review <= 1.74)
                                                                        <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fas fa-star-half-alt" style="color:#ef9a0c!important;"></i>
                                                                        </li>
                                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i>
                                                                        </li>
                                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i>
                                                                        </li>
                                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i>
                                                                        </li>
                                                                    @endif
                                                                    @if ($tutor->avg_review >= 1.75 && $tutor->avg_review <= 2.24)
                                                                        <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i>
                                                                        </li>
                                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i>
                                                                        </li>
                                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i>
                                                                        </li>
                                                                    @endif
                                                                    @if ($tutor->avg_review >= 2.25 && $tutor->avg_review <= 2.74)
                                                                        <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fas fa-star-half-alt" style="color:#ef9a0c!important;"></i>
                                                                        </li>
                                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i>
                                                                        </li>
                                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i>
                                                                        </li>
                                                                    @endif
                                                                    @if ($tutor->avg_review >= 2.75 && $tutor->avg_review <= 3.24)
                                                                        <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i>
                                                                        </li>
                                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i>
                                                                        </li>
                                                                    @endif
                                                                    @if ($tutor->avg_review >= 3.25 && $tutor->avg_review <= 3.74)
                                                                        <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fas fa-star-half-alt" style="color:#ef9a0c!important;"></i>
                                                                        </li>
                                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i>
                                                                        </li>
                                                                    @endif
                                                                    @if ($tutor->avg_review >= 3.75 && $tutor->avg_review <= 4.24)
                                                                        <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i>
                                                                        </li>
                                                                    @endif
                                                                    @if ($tutor->avg_review >= 4.25 && $tutor->avg_review <= 4.74)
                                                                        <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fas fa-star-half-alt" style="color:#ef9a0c!important;"></i>
                                                                        </li>
                                                                    @endif
                                                                    @if ($tutor->avg_review >= 4.75 && $tutor->avg_review <= 5)
                                                                        <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>

                                                                    @endif
                                                                    <li>{{ @$tutor->avg_review }} <b>({{ @$tutor->total_no_of_reviews }})</b></li>
                                                                </ul>
                                                                <h5>{{ @$tutor->total_experience }} yrs. exp. </h5>
                                                            </div>
                                                        </div>
                                                        <div class="search_lop_right float-none my-auto">
                                                            <div class="lop_name_box d-flex flex-column flex-md-row">
                                                                <div class="search_lop_name">
                                                                    <h4><a target="_blank"
                                                                            href="{{ url('tutor-public-profile') }}/{{ @$tutor->slug }}">{{ @$tutor->f_name . ' ' . @$tutor->l_name }}</a>
                                                                    </h4>
                                                                    <ul class="search_sibj">
                                                                        <li><img src="{{ public_asset('assets/images/edu1.png') }}" alt="">
                                                                            @php
                                                                                $academics = @$tutor->getTutorAcademic[0];
                                                                            @endphp

                                                                            @if (@$academics->qualification == 1)
                                                                                Doctoral Degree
                                                                            @elseif(@$academics->qualification == 2)
                                                                                Postgraduate
                                                                            @elseif(@$academics->qualification == 3)
                                                                                Master's Degree (Research)
                                                                            @elseif(@$academics->qualification == 4)
                                                                                Master's Degree
                                                                            @elseif(@$academics->qualification == 5)
                                                                                Bachelor Honours Degree
                                                                            @elseif(@$academics->qualification == 6)
                                                                                Bachelor’s Degree
                                                                            @elseif(@$academics->qualification == 7)
                                                                                Associate Degree
                                                                            @elseif(@$academics->qualification == 8)
                                                                                Advanced Diploma
                                                                            @elseif(@$academics->qualification == 9)
                                                                                Diploma
                                                                            @endif

                                                                        </li>


                                                                    </ul>
                                                                    <ul class="sub_list">
                                                                        @php
                                                                            $plans = @$tutor->getTutorShipPlan->unique('subject_id')->take(3);
                                                                        @endphp
                                                                        @if (@$plans)
                                                                            @foreach (@$plans as $tutorshipplan)
                                                                                <li>
                                                                                    {{ @$tutorshipplan->getSubject->subject }}
                                                                                </li>
                                                                            @endforeach
                                                                        @endif
                                                                        @if (@$tutor->getTutorShipPlan->unique('subject_id')->count() > 3)
                                                                            <li>+{{ @$tutor->getTutorShipPlan->unique('subject_id')->count() - 3 }}
                                                                            </li>
                                                                        @endif

                                                                    </ul>
                                                                </div>
                                                                <div class="search_lop_name_list">
                                                                    <ul class="d-flex flex-wrap  d-md-block smgap-2">
                                                                        @php
                                                                            $myGrade = \App\Models\Grade::where([
                                                                                'id' => @Auth::user()->grade,
                                                                                'status' => 'A',
                                                                            ])
                                                                                ->select('id', 'slug', 'status')
                                                                                ->first();
                                                                        @endphp

                                                                        @php
                                                                            $getTutorGrades = @$tutor->getTutorShipPlan
                                                                                ->pluck('grade_id')
                                                                                ->toArray();
                                                                            $mGrade = @Auth::user()->grade;
                                                                        @endphp
                                                                        @if (@$admin_disable_bookings_values->disable_booking == 'Y')
                                                                            <li><img src="{{ public_asset('assets/images/list_ico1.png') }}"
                                                                                    alt=""><a class="open_popup_g" data-toggle="modal"
                                                                                    data-target="#admin_disabled_bookings_popup"
                                                                                    href="javascript:void(0);">Book a Session</a></li>
                                                                        @else
                                                                            @if (@Auth::check())
                                                                                @php
                                                                                    $getTutorGrades = @$tutor->getTutorShipPlan
                                                                                        ->pluck('grade_id')
                                                                                        ->toArray();
                                                                                    $mGrade = @Auth::user()->grade;

                                                                                @endphp

                                                                                @if (in_array($mGrade, $getTutorGrades))
                                                                                    <li class="d-flex"><img
                                                                                            src="{{ public_asset('assets/images/list_ico1.png') }}"
                                                                                            alt=""><a
                                                                                            href="{{ url('studentbook-class?search_tutor_slug_studentclass=' . @$tutor->slug . '&search_tutor_id_studentclass=' . @$tutor->id) }}">Book
                                                                                            a session</a></li>
                                                                                @else
                                                                                    <li class="d-flex"><img
                                                                                            src="{{ public_asset('assets/images/list_ico1.png') }}"
                                                                                            alt=""><a class="open_popup_g"
                                                                                            data-toggle="modal" data-target="#not_b_popup"
                                                                                            href="javascript:void(0);">Book my session</a></li>

                                                                                @endif


                                                                                {{--  --}}
                                                                                {{-- <li><img src="{{ public_asset('assets/images/list_ico1.png') }}" alt=""><a class="open_popup_g" data-toggle="modal" data-target="#not_b_popup" href="javascript:void(0);">Book a session</a></li> --}}
                                                                            @else
                                                                                <li class="d-flex"><img
                                                                                        src="{{ public_asset('assets/images/list_ico1.png') }}"
                                                                                        alt=""><a
                                                                                        @if (!@Auth::check()) href="javascript:void(0);" data-id="{{ @$tutor->id }}" data-toggle="modal" data-target="#log_modal{{ @$tutor->id }}" class="save_input_data_on_click" data-type="B"   @else href="{{ url('studentbook-class?search_tutor_slug_studentclass=' . @$tutor->slug . '&search_tutor_id_studentclass=' . @$tutor->id) }}" @endif>Book
                                                                                        a session</a></li>
                                                                            @endif
                                                                            {{-- @if (in_array($mGrade, $getTutorGrades))

                                                                            <li><img src="{{ public_asset('assets/images/list_ico1.png') }}" alt=""><a href="{{ url('studentbook-class?search_tutor_slug_studentclass='.@$tutor->slug.'&search_tutor_id_studentclass='.@$tutor->id) }}">Book a session</a></li>
                                                                            @else
                                                                            <li><img src="{{ public_asset('assets/images/list_ico1.png') }}" alt=""><a data-toggle="modal" data-target="#not_b_popup" href="javascript:void(0);" style="font-size: 14px;">Book a session</a></li>
                                                                            @endif --}}
                                                                        @endif
                                                                        @if (@$tutor->profile_video)
                                                                            <li class="d-flex"><img
                                                                                    src="{{ public_asset('assets/images/list_ico2.png') }}"
                                                                                    alt=""><a data-toggle="modal"
                                                                                    data-target="#videoaModal">My V-profile</a></li>
                                                                        @endif
                                                                        <div class="modal fade" id="videoaModal">
                                                                            <div class="modal-dialog modal-lg">
                                                                                <div class="modal-content">
                                                                                    <!-- Modal Header -->
                                                                                    <div class="modal-header">
                                                                                        <h2 class="videopmodal">My V-profile</h2>
                                                                                        <button type="button" class="close"
                                                                                            data-dismiss="modal">&times;</button>
                                                                                    </div>
                                                                                    <!-- Modal body -->
                                                                                    <div class="modal-body">
                                                                                        <div class="profile_body">
                                                                                            <iframe
                                                                                                src="https://www.youtube.com/embed/{{ @$tutor->video_short_url }}"
                                                                                                title="YouTube video player" frameborder="0"
                                                                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                                                                allowfullscreen=""></iframe>
                                                                                        </div>
                                                                                        {{-- <video width="100%" controls> --}}
                                                                                        {{-- <source src="{{ public_asset('assets/images/profile1.mp4') }}" type="video/mp4"> --}}
                                                                                        {{--
                                                                                            <source id="profile_video_link" src="{{ @$tutor->profile_video }}" type="video/mp4">
                                                                                            --}}
                                                                                        {{-- </video> --}}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <li class="d-flex"><img
                                                                                src="{{ public_asset('assets/images/list_ico3.png') }}"
                                                                                alt=""><a target="_blank"
                                                                                href="{{ url('tutor-public-profile') }}/{{ @$tutor->slug }}">Visit my
                                                                                page</a></li>
                                                                        @php
                                                                            @$countRev = DB::table('reviews')
                                                                                ->where('student_id', @Auth::user()->id)
                                                                                ->where('tutor_id', @$tutor->id)
                                                                                ->count();

                                                                        @endphp

                                                                        <li class="d-flex"><img
                                                                                src="{{ public_asset('assets/images/list_ico4.png') }}"
                                                                                alt="">
                                                                            {{-- <a href="{{route('student.my.review',@$tutor->slug)}}">Post a review</a> --}}
                                                                            @if (!@Auth::check())
                                                                                <a data-toggle="modal" data-target="#log_modal{{ @$tutor->id }}"
                                                                                    class="save_input_data_on_click" data-id="{{ @$tutor->id }}"
                                                                                    data-type="PR" href="javascript::void(0);">Post a review </a>
                                                                            @elseif(in_array(@$tutor->id, $getBookedTutors))
                                                                                <a @if (!@Auth::check()) data-toggle="modal" data-target="#log_modal{{ @$tutor->id }}" class="save_input_data_on_click" data-id="{{ @$tutor->id }}" data-type="PR"  href="javascript::void(0);"
                                                                                        @else
                                                                                        @if (@$countRev > 0) data-toggle="modal" data-target="#alreadyRev" class="save_input_data_on_click" href="javascript::void(0);"
                                                                                        @else
                                                                                        href="{{ route('student.my.review', @$tutor->slug) }}" @endif
                                                                                    @endif>Post a review </a>
                                                                            @else
                                                                                @if (@Auth::user()->timezone_id == @$tutor->timezone_id && @Auth::user()->state == @$tutor->state)
                                                                                    @if (in_array($mGrade, $getTutorGrades))
                                                                                        <a @if (!@Auth::check()) data-toggle="modal" data-target="#log_modal{{ @$tutor->id }}" class="save_input_data_on_click" data-id="{{ @$tutor->id }}" data-type="PR"  href="javascript::void(0);" @else @if (@$countRev > 0) data-toggle="modal" data-target="#alreadyRev" class="save_input_data_on_click" href="javascript::void(0);"  @else
                                                                                    href="{{ route('student.my.review', @$tutor->slug) }}" @endif
                                                                                            @endif>Post a review </a>
                                                                                        {{-- <li><img src="{{ public_asset('assets/images/list_ico4.png') }}" alt=""><a  href="{{ url('studentbook-class?search_tutor_slug_studentclass='.@$tutor->slug.'&search_tutor_id_studentclass='.@$tutor->id) }}" >Post a review</a></li> --}}
                                                                                    @elseif(in_array(@$tutor->id, $getBookedTutors))
                                                                                        <a @if (!@Auth::check()) data-toggle="modal" data-target="#log_modal{{ @$tutor->id }}" class="save_input_data_on_click" data-id="{{ @$tutor->id }}" data-type="PR"  href="javascript::void(0);"
                                                                                        @else
                                                                                        @if (@$countRev > 0) data-toggle="modal" data-target="#alreadyRev" class="save_input_data_on_click" href="javascript::void(0);"
                                                                                        @else
                                                                                        href="{{ route('student.my.review', @$tutor->slug) }}" @endif
                                                                                            @endif>Post a review </a>
                                                                                    @else
                                                                                        @if (@Auth::user()->timezone_id != @$tutor->timezone_id)
                                                                                            <a class="open_popup_g" data-toggle="modal"
                                                                                                data-target="#not_p_popupTimeZone"
                                                                                                href="javascript:void(0);">Post a review </a>
                                                                        </li>
                                                                    @elseif(@Auth::user()->state != @$tutor->state)
                                                                        <a class="open_popup_g" data-toggle="modal" data-target="#not_p_popupState"
                                                                            href="javascript:void(0);">Post a review</a></li>
                                                                    @else
                                                                        <a class="open_popup_g" data-toggle="modal" data-target="#not_p_popup"
                                                                            href="javascript:void(0);">Post a review</a></li>
                                                                        @endif
                                                                        @endif
                                                                    @else
                                                                        @if (@Auth::user()->timezone_id != @$tutor->timezone_id)
                                                                            <a class="open_popup_g" data-toggle="modal"
                                                                                data-target="#not_p_popupTimeZone" href="javascript:void(0);">Post a
                                                                                review</a></li>
                                                                        @elseif(@Auth::user()->state != @$tutor->state)
                                                                            <a class="open_popup_g" data-toggle="modal"
                                                                                data-target="#not_p_popupState" href="javascript:void(0);">Post a
                                                                                review</a></li>
                                                                        @else
                                                                            <a class="open_popup_g" data-toggle="modal" data-target="#not_p_popup"
                                                                                href="javascript:void(0);">Post a review</a></li>
                                                                        @endif

                                                                        @endif
                                                                        @endif
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            @if (strlen(@$tutor->about_me))
                                                                <div class="lop_name_para">
                                                                    <p>
                                                                        @if (strlen(@$tutor->about_me) > 120)
                                                                            @php
                                                                                $len = strpos(wordwrap(@$tutor->about_me, 120), "\n");
                                                                            @endphp
                                                                            {!! nl2br(substr(@$tutor->about_me, 0, $len)) !!}
                                                                            {{-- <span class="textLimit"> --}}
                                                                            {{-- {!! strip_tags(@$tutor->about_me) !!} --}}
                                                                            {{-- </span> --}}
                                                                            <span class=" text_c_more_less text_c_more_less{{ @$tutor->id }}"
                                                                                style="display: none;">
                                                                                {!! strip_tags(@$tutor->about_me) !!}
                                                                            </span>

                                                                            <a class=" button_red_cc c_c_moreless c_c_moreless{{ @$tutor->id }}"
                                                                                data-id="{{ @$tutor->id }}">Read more</a>
                                                                        @else
                                                                            {!! strip_tags(@$tutor->about_me) !!}
                                                                        @endif
                                                                        {{-- <span class="moretext5" style="display: none;">
                                                                    I completed my Bachelor of Degree in Banking and Finance. I am currently a postgrad student, doing my Masters in Philosophy. I aspire to a professional academic.
                                                                    </span>
                                                                    <a class="moreless-button5 button_red_cc">Read more</a> --}}
                                                                    </p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                            <div class="pagi_cc">
                                                <nav aria-label="...">
                                                    <ul class="pagination">
                                                        {{ @$tutors->links() }}
                                                    </ul>
                                                </nav>
                                            </div>
                                        </div>
                                    @else
                                        <div class="search_right_body">
                                            <div class="empty_box search_emt_bx">
                                                <img src="{{ public_asset('assets/images/empty_img.png') }}">
                                                <h2>No V-Tutor is available matching your criteria</h2>
                                                <p>Try changing filters to search again</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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

                    <h4 class="modal-title">Message</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>

                <!-- Modal body -->

                <div class="modal-body">

                    <div class="">

                        <div class=" ">

                            <div class="meass-popup">

                                <ul class="">

                                    <li class="">

                                        You cannot book a class outside your grade

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
                    <h4 class="modal-title">Message</h4>
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
                                        Please choose carefully as this would impact booking of sessions!You cannot book a
                                        session outside your timezone!
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
    <div class="modal fade" id="alreadyRev" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content revmodal">
                <!-- Modal Header -->


                <!-- Modal body -->
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <div class="modal_button">
                        <img src="{{ public_asset('assets/images/review_given.png') }}" width="100px">
                        <center>
                            <h2>You have already reviewed this tutor.</h2>
                        </center>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="modal " id="not_p_popupState">
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
                                        You cannot post a review outside your state
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
                                        You cannot book this tutor since they are outside your State / Timezone. Try to book
                                        tutors within your State / Timezone.
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
    <div class="modal " id="not_p_popupTimeZone">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title ">Message</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->

                </form>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('script')
    @include('include.script')
    <script>
        $('#exampledate').calendar({
            type: 'date',
            maxDate: new Date({{ strtotime(date('Y-m-d H:i:s')) }} * 1000),
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"
        integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg=="
        crossorigin="anonymous"></script>
    <script src="{{ public_asset('assets/toastr/build/toastr.min.js') }}"></script>
    <script src="https://kit.fontawesome.com/446e463225.js" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on("click", ".c_c_moreless", function() {
                var id = $(this).data("id");
                // text_c_more_less
                $('.text_c_more_less' + id).slideToggle();
                if ($(this).text() == "Read more") {
                    $(this).text("Read Less")
                } else {
                    $(this).text("Read more")
                }
            });
            $(document).on("click", ".saveUsertoFavourite", function(e) {
                // alert("sfjhahs");
                var favourite_user_id = $(this).attr("data-saveUsertoFavourite"),
                    obj = $(this),
                    reqData = {
                        'jsonrpc': '2.0',
                        '_token': '{{ csrf_token() }}',
                        'data': {
                            'favourite_user_id': favourite_user_id
                        }
                    };
                // alert(favourite_user_id);


                $.ajax({
                    url: "{{ route('save.user.to.favourite') }}",
                    dataType: 'json',
                    data: reqData,
                    type: 'post',
                    success: function(resp) {
                        if (resp.result.status == 'Added') {
                            obj.addClass("heart_cc_act");
                        } else {
                            obj.removeClass("heart_cc_act");
                            obj.parent().hide();
                        }
                        toastr.success(resp.result.message);
                    },
                    error: function() {
                        toastr.error("Please refresh the page!");
                    }
                });

            });
        });
    </script>

    <script type="text/javascript">
        function datastudentautocomplete(inp, arr) {

            /*the autocomplete function takes two arguments,

            the text field element and an array of possible autocompleted values:*/

            var currentFocus;

            /*execute a function when someone writes in the text field:*/

            inp.addEventListener("input", function(e) {

                var a, b, i, val = this.value;

                /*close any already open lists of autocompleted values*/

                closeaAllLists();

                if (!val) {
                    return false;
                }

                currentFocus = -1;

                /*create a DIV element that will contain the items (values):*/

                a = document.createElement("DIV");

                a.setAttribute("id", this.id + "autocomplete-list");

                a.setAttribute("class", "autocomplete-items");

                /*append the DIV element as a child of the autocomplete container:*/

                this.parentNode.appendChild(a);

                $.ajax({

                    url: "{{ route('get.all.v.tutors') }}",

                    dataType: 'json',

                    data: {

                        "book_grade": {{ @Auth::user()->grade }},
                        "search_u_name": val,
                        "get_fav": "Y",

                    },

                    type: 'GET',

                    success: function(resp) {

                        /*for each item in the array...*/

                        if (resp.grade_id != 0) {

                            for (i = 0; i < resp.tutors.length; i++) {

                                /*check if the item starts with the same letters as the text field value:*/

                                if ((resp.tutors[i].f_name + " " + resp.tutors[i].l_name).substr(0, val
                                        .length).toUpperCase() == val.toUpperCase()) {

                                    /*create a DIV element for each matching element:*/

                                    b = document.createElement("DIV");

                                    /*make the matching letters bold:*/

                                    b.innerHTML = "<strong>" + (resp.tutors[i].f_name + " " + resp
                                        .tutors[i].l_name).substr(0, val.length) + "</strong>";

                                    b.innerHTML += (resp.tutors[i].f_name + " " + resp.tutors[i].l_name)
                                        .substr(val.length);

                                    /*insert a input field that will hold the current array item's value:*/

                                    b.innerHTML += "<input type='hidden' data-slug='" + resp.tutors[i]
                                        .slug + "' id='" + resp.tutors[i].id + "' value='" + resp
                                        .tutors[i].f_name + ' ' + resp.tutors[i].l_name + "'>";

                                    // b.innerHTML += "<input type='hidden' name='ttuor_hidden' value='" + resp.tutors[i].f_name + "'>";

                                    /*execute a function when someone clicks on the item value (DIV element):*/

                                    b.addEventListener("click", function(e) {

                                        /*insert the value for the autocomplete text field:*/

                                        inp.value = this.getElementsByTagName("input")[0].value;

                                        $("#search_tutor_id_studentclass").val(this
                                            .getElementsByTagName("input")[0].id);

                                        $("#search_tutor_selected_name_studentclass").val(this
                                            .getElementsByTagName("input")[0].value);

                                        // console.log(this.getElementsByTagName("input")[0].data-slug);

                                        var slug = $("#" + this.getElementsByTagName("input")[0]
                                            .id).attr("data-slug");

                                        $("#search_tutor_slug_studentclass").val(slug);

                                        // inp.id = this.getElementsByTagName("input")[0].id;



                                        /*close the list of autocompleted values,

                                        (or any other open lists of autocompleted values:*/

                                        closeaAllLists();

                                    });

                                    a.appendChild(b);

                                }

                            }

                        }

                        // console.log(resp);

                    },

                    error: function() {

                    }

                });



            });

            /*execute a function presses a key on the keyboard:*/

            inp.addEventListener("keydown", function(e) {

                var x = document.getElementById(this.id + "autocomplete-list");

                if (x) x = x.getElementsByTagName("div");

                if (e.keyCode == 40) {

                    /*If the arrow DOWN key is pressed,

                    increase the currentFocus variable:*/

                    currentFocus++;

                    /*and and make the current item more visible:*/

                    addaActive(x);

                } else if (e.keyCode == 38) { //up

                    /*If the arrow UP key is pressed,

                    decrease the currentFocus variable:*/

                    currentFocus--;

                    /*and and make the current item more visible:*/

                    addaActive(x);

                } else if (e.keyCode == 13) {

                    /*If the ENTER key is pressed, prevent the form from being submitted,*/

                    e.preventDefault();

                    if (currentFocus > -1) {

                        /*and simulate a click on the "active" item:*/

                        if (x) x[currentFocus].click();

                    }

                }

            });

            function addaActive(x) {

                /*a function to classify an item as "active":*/

                if (!x) return false;

                /*start by removing the "active" class on all items:*/

                removeaActive(x);

                if (currentFocus >= x.length) currentFocus = 0;

                if (currentFocus < 0) currentFocus = (x.length - 1);

                /*add class "autocomplete-active":*/

                x[currentFocus].classList.add("autocomplete-active");

            }

            function removeaActive(x) {

                /*a function to remove the "active" class from all autocomplete items:*/

                for (var i = 0; i < x.length; i++) {

                    x[i].classList.remove("autocomplete-active");

                }

            }

            function closeaAllLists(elmnt) {

                /*close all autocomplete lists in the document,

                except the one passed as an argument:*/

                var x = document.getElementsByClassName("autocomplete-items");

                for (var i = 0; i < x.length; i++) {

                    if (elmnt != x[i] && elmnt != inp) {

                        x[i].parentNode.removeChild(x[i]);

                    }

                }

            }

            /*execute a function when someone clicks in the document:*/

            document.addEventListener("click", function(e) {

                closeaAllLists(e.target);

            });
        }
        datastudentautocomplete(document.getElementById("search_tutor_nm_studentclass"), []);
    </script>
@endsection
