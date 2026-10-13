@extends('layouts.app')
@section('title')
    <title>V-Tutor  Tutor Home</title>
@endsection

@section('left_part')

    {{-- @include('include.tutor_left_part') --}}
    @include('include.tutor_head')
    @include('include.header_menu_part')
    <style>
        body {
            font-family: Faro !important;
        }
        /* Center the modal vertically & horizontally */
.modal-dialog.modal-dialog-centered {
  display: flex;
  align-items: center;
  min-height: calc(100vh - 1rem);
}

/* Optional fallback centering if Bootstrap doesn’t handle it */
.log_modal_bx .modal {
  position: fixed;
  top: 50% !important;
  left: 50% !important;
  transform: translate(-50%, -50%) !important;
}

/* Modal content styling */
.log_modal_bx .modal-content {
  border-radius: 8px;
  overflow: hidden;
  max-width: 500px; /* adjust width as needed */
  width: 90%;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
}

/* Modal header */
.log_modal_bx .modal-header {
  background-color: #fff;
  border-bottom: 1px solid #e5e5e5;
  padding: 1rem 1.5rem;
}
.log_modal_bx .modal-header .modal-title {
  font-size: 1.25rem;
  font-weight: bold;
  margin: 0;
  color: #000;
}
.log_modal_bx .modal-header .btn-close {
  background: none;
  border: none;
  font-size: 1.25rem;
}

/* Modal body */
.log_modal_bx .modal-body {
  padding: 1.5rem;
  text-align: center;
}
.log_modal_bx .modal-body p {
  font-size: 1rem;
  margin: 0 0 1rem 0;
  color: #333;
}

/* Button group: centered and spaced */
.log_modal_bx .button-group {
  display: flex;
  justify-content: center;
  gap: 1rem;
  margin-top: 1.5rem;
}

/* Button styles */
.log_modal_bx .btn-login,
.log_modal_bx .btn-signup {
  min-width: 140px;
  padding: 0.65rem 1.2rem;
  font-size: 1rem;
  font-weight: 600;
  /* Removed uppercase transform */
  text-transform: none;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.2s ease;
}

/* Red buttons */
.log_modal_bx .btn-login {
  background-color: #c00; /* your brand red */
}
.log_modal_bx .btn-login:hover {
  background-color: #a00;
}

/* If both should have same color */
.log_modal_bx .btn-signup {
  background-color: #c00;
}
.log_modal_bx .btn-signup:hover {
  background-color: #a00;
}

/* Responsive: stack buttons on very small screens */
@media (max-width: 400px) {
  .log_modal_bx .button-group {
    flex-direction: column;
    gap: 0.75rem;
  }
  .log_modal_bx .btn-login,
  .log_modal_bx .btn-signup {
    width: 100%;
    min-width: auto;
  }
}

    </style>
@endsection

@section('content')
    <div class="gj_land_alert_sec">
        @include('include.errors')
    </div>
    
    {{-- Banner Section Start --}}
        <section class="gj_tut_lan_banner_sec">
            <div class="container-fluid">
                <div class="row m-0">
                    <div class="col-lg-6 col-md-12 col-sm-12 col-12 banner_left_col1 p-0">
                        <div class="banner_left_div">
                            <div class="container">
                                <div class="row m-0">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12 banner_left_col2 p-0">
                                        <h1 class="banner_hd text-white mb-3"><span class="banner_hd_split">Join a Movement </span> of Educators Making a Difference</h1>

                                        @if(!@Auth::check())
                                            <a href="{{route('reg.home')}}" class="start_now_button">Start Now</a>
                                        @else
                                            <a href="{{route('tutor_application_form')}}" class="start_now_button">Start Now</a>
                                        @endif

                                        <div class="freedom_div">
                                            <p class="freedom_hd mb-2">Freedom to Choose. <span class="freedom_hd_split">Flexibility to Grow</span></p>

                                            <ul class="freedom_ul">
                                                <li class="d-flex"><img src="{{ public_asset('assets/tutor_landing/star_tick.svg') }}" alt="tick"> Share your passion for teaching</li>
                                                <li class="d-flex"><img src="{{ public_asset('assets/tutor_landing/star_tick.svg') }}" alt="tick"> Earn by doing what you love</li>
                                                <li class="d-flex"><img src="{{ public_asset('assets/tutor_landing/star_tick.svg') }}" alt="tick"> Join a thriving tutor community</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6 col-md-12 col-sm-12 col-12 banner_right_col1 p-0">
                        <div class="banner_right_div">
                            <img src="{{ public_asset('assets/tutor_landing/banner_image.svg') }}" alt="banner_image">
                        </div>
                    </div>
                </div>
            </div>
        </section>
    {{-- Banner Section End --}}
    
    {{-- Features Section Start --}}
    <section class="gj_tut_lan_feature_sec">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="feature_div">
                        <div class="feature_div_sec d-flex justify-content-center align-items-center flex-col">
                            <img src="{{ public_asset('assets/tutor_landing/v_tutor_feature_image/feature_img_1.svg') }}" alt="all_australia_coverage">
                            <p class="feature_content">All-Australia Coverage</p>
                        </div>
                        
                        <div class="feature_div_sec d-flex justify-content-center align-items-center flex-col">
                            <img src="{{ public_asset('assets/tutor_landing/v_tutor_feature_image/feature_img_2.svg') }}" alt="100%_online_delivery">
                            <p class="feature_content">100% Online Delivery</p>
                        </div>

                        <div class="feature_div_sec d-flex justify-content-center align-items-center flex-col">
                            <img src="{{ public_asset('assets/tutor_landing/v_tutor_feature_image/feature_img_3.svg') }}" alt="fully_flexible_scheduling">
                            <p class="feature_content">Fully Flexible Scheduling</p>
                        </div>

                        <div class="feature_div_sec d-flex justify-content-center align-items-center flex-col">
                            <img src="{{ public_asset('assets/tutor_landing/v_tutor_feature_image/feature_img_4.svg') }}" alt="integrated_session_management">
                            <p class="feature_content">Integrated Session Management</p>
                        </div>

                        <div class="feature_div_sec d-flex justify-content-center align-items-center flex-col">
                            <img src="{{ public_asset('assets/tutor_landing/v_tutor_feature_image/feature_img_5.svg') }}" alt="responsive_support">
                            
                            <p class="feature_content">Responsive Support</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Features Section End --}}
    
    {{-- Passion to Teach Section Start --}}
    <section class="gj_tut_lan_passion_sec">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="passion_teach_hd_div">
                        <h2 class="passion_teach_hd">Redefining connection between the desire to learn and <span class="passion_teach_hd_split"> passion to teach</span></h2>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="passion_teach_div">
                        <img src="{{ public_asset('assets/tutor_landing/v_tutor_passion_to_teach_image/passion_to_teach_1.svg') }}" alt="finding_the_right_tutor">

                        <p class="passion_teach_content">For many parents and students, finding the right tutor is a time-consuming and uncertain journey.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="passion_teach_div">
                        <img src="{{ public_asset('assets/tutor_landing/v_tutor_passion_to_teach_image/passion_to_teach_2.svg') }}" alt="rising_academic_standards">

                        <p class="passion_teach_content">With rising academic standards, after school support has become essential for students to stay ahead.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="passion_teach_div">
                        <img src="{{ public_asset('assets/tutor_landing/v_tutor_passion_to_teach_image/passion_to_teach_3.svg') }}" alt="focused_attention">

                        <p class="passion_teach_content">Focused attention and tailored strategies can bridge gaps and accelerate academic growth.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Passion to Teach Section End --}}
    
    {{-- Own Tutoring Section Start --}}
    <section class="gj_tut_lan_own_tutoring_sec">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="own_tutoring_hd_div">
                        <h2 class="own_tutoring_hd text-white">Own Your <span class="own_tutoring_hd_split"> Tutoring Journey</span></h2>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                    <div class="own_tutoring_div d-flex justify-content-center align-items-center flex-col">
                        <img src="{{ public_asset('assets/tutor_landing/v_tutor_own_tutoring_image/own_tutoring_image_1.svg') }}" alt="stay_in_control">

                        <p class="own_tutoring_title">Stay in Control</p>

                        <p class="own_tutoring_content">Be your own boss with complete freedom-no long-term contracts, no binding clauses</p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                    <div class="own_tutoring_div d-flex justify-content-center align-items-center flex-col">
                        <img src="{{ public_asset('assets/tutor_landing/v_tutor_own_tutoring_image/own_tutoring_image_2.svg') }}" alt="profit_from_passion">

                        <p class="own_tutoring_title">Profit from Passion</p>

                        <p class="own_tutoring_content">Use your passion for teaching to unlock extra earning potential in your spare time.</p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                    <div class="own_tutoring_div d-flex justify-content-center align-items-center flex-col">
                        <img src="{{ public_asset('assets/tutor_landing/v_tutor_own_tutoring_image/own_tutoring_image_3.svg') }}" alt="your_time_your_terms">

                        <p class="own_tutoring_title">Your time, Your terms</p>

                        <p class="own_tutoring_content">Set your own schedule with full control over your time and choice of subjects</p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                    <div class="own_tutoring_div d-flex justify-content-center align-items-center flex-col">
                        <img src="{{ public_asset('assets/tutor_landing/v_tutor_own_tutoring_image/own_tutoring_image_4.svg') }}" alt="teach_without_boundaries">

                        <p class="own_tutoring_title">Teach without boundaries</p>

                        <p class="own_tutoring_content">Break state barriers and tutor students from every corner of the country, unlocking your true potential.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Own Tutoring Section End --}}
    
    {{-- Discover Freelance Section Start --}}
    <section class="gj_tut_lan_freelance_sec">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-7 col-sm-12 col-12">
                    <div class="slider_div">
                        <div class="swiper freelance_swiper">
                            <div class="swiper-wrapper">
                            <div class="swiper-slide"><img src="{{ public_asset('assets/tutor_landing/v_tutor_slider_image/freelance_slider_1.jpg') }}" alt="slider_image_1" /></div>
                            <div class="swiper-slide"><img src="{{ public_asset('assets/tutor_landing/v_tutor_slider_image/freelance_slider_2.jpg') }}" alt="slider_image_2" /></div>
                            <div class="swiper-slide"><img src="{{ public_asset('assets/tutor_landing/v_tutor_slider_image/freelance_slider_3.jpg') }}"  alt="slider_image_3" /></div>
                            <div class="swiper-slide"><img src="{{ public_asset('assets/tutor_landing/v_tutor_slider_image/freelance_slider_4.jpg') }}" alt="slider_image_4"/></div>
                            <div class="swiper-slide"><img src="{{ public_asset('assets/tutor_landing/v_tutor_slider_image/freelance_slider_5.jpg') }}"  alt="slider_image_5"/></div>
                            <div class="swiper-slide"><img src="{{ public_asset('assets/tutor_landing/v_tutor_slider_image/freelance_slider_6.jpg') }}" alt="slider_image_6"/></div>
                            <div class="swiper-slide"><img src="{{ public_asset('assets/tutor_landing/v_tutor_slider_image/freelance_slider_1.jpg') }}" alt="slider_image_1"/></div>
                            <div class="swiper-slide"><img src="{{ public_asset('assets/tutor_landing/v_tutor_slider_image/freelance_slider_2.jpg') }}" alt="slider_image_2"/></div>
                            <div class="swiper-slide"><img src="{{ public_asset('assets/tutor_landing/v_tutor_slider_image/freelance_slider_3.jpg') }}" alt="slider_image_3" /></div>
                            <div class="swiper-slide"><img src="{{ public_asset('assets/tutor_landing/v_tutor_slider_image/freelance_slider_4.jpg') }}" alt="slider_image_4"/></div>
                            <div class="swiper-slide"><img src="{{ public_asset('assets/tutor_landing/v_tutor_slider_image/freelance_slider_5.jpg') }}" alt="slider_image_5"/></div>
                            <div class="swiper-slide"><img src="{{ public_asset('assets/tutor_landing/v_tutor_slider_image/freelance_slider_6.jpg') }}" alt="slider_image_6"/></div>
                            </div>
                            <!-- Pagination -->
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-5 col-sm-12 col-12">
                    <div class="freelance_div">
                        <h2 class="freelance_hd">Discover Freelance Tutoring with the <span class="freelance_hd_split"> Freedom to Inspire</span></h2>

                        <ul class="freedom_ul freelance_ul">
                            <li class="d-flex "><img src="{{ public_asset('assets/tutor_landing/freelance_tick.svg') }}" alt="tick"> Nationwide student reach</li>
                            <li class="d-flex "><img src="{{ public_asset('assets/tutor_landing/freelance_tick.svg') }}" alt="tick"> Unified Sessions Management</li>
                            <li class="d-flex "><img src="{{ public_asset('assets/tutor_landing/freelance_tick.svg') }}" alt="tick"> Flexibility to choose own schedule</li>
                            <li class="d-flex "><img src="{{ public_asset('assets/tutor_landing/freelance_tick.svg') }}" alt="tick"> Maximum session coverage window</li>
                            <li class="d-flex "><img src="{{ public_asset('assets/tutor_landing/freelance_tick.svg') }}" alt="tick"> Transparent payment terms</li>
                            <li class="d-flex "><img src="{{ public_asset('assets/tutor_landing/freelance_tick.svg') }}" alt="tick"> Tutor Management and Support</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Discover Freelance Section End --}}
    
    {{-- Launch Section Start --}}
    <section class="gj_tut_lan_launch_sec">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="launch_div">
                        <p class="launch_content">Launch Your Tutoring Career with <span class="launch_content_split">Flexibility that fits you!</span></p>

                        @if(!@Auth::check())
                            <a href="{{route('reg.home')}}" class="start_now_button">Start Now</a>
                        @else
                            <a href="{{route('tutor_application_form')}}" class="start_now_button">Start Now</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Launch Section End --}}
@endsection

@section('footer')
    @include('include.tutor_footer')
   <div class="modal fade log_modal_bx" id="log_modal{{ @$tutor->id }}">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Login / Sign up</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <p>Click on Login or Sign up to continue</p>
        <div class="button-group">
          <a href="{{ route('login') }}" class="btn btn-login">Login</a>
          <a href="{{ route('register') }}" class="btn btn-signup">Sign up</a>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')
    {{-- <script src="{{ public_asset('assets/js/jquerymin.js') }}"></script>
    <script src="{{ public_asset('assets/js/bootstrap.js') }}"></script>
    <script src="{{ public_asset('assets/js/carouselscript.js')}}"></script>
    <script src="{{ public_asset('assets/js/owl.carousel.js')}}"></script>
    <script src="{{ public_asset('assets/js/moment.js')}}"></script>
    <script src="{{ public_asset('assets/js/jquery-ui.js')}}"></script>
    <script src="{{ public_asset('assets/js/semantic.min.js')}}"></script>
    <script src="{{ public_asset('assets/js/custom.js')}}"></script>     --}}
    @include('include.script')
    {{-- <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script> --}}
    <script src="{{ public_asset('assets/js/swiper-bundle.min.js')}}"></script>
    <script>
        var swiper = new Swiper(".freelance_swiper", {
            effect: "cards",
            grabCursor: true,
            speed: 700,
            centeredSlides: true,
            slidesPerView: 5,
            initialSlide: 2,
            loop: true,                   // ← enable wrap-around
            loopAdditionalSlides: 12,      // or: loopedSlides: 5 (older Swiper)
            watchOverflow: true,         // still slide even if few items
            autoplay: {
                delay: 2000,              // time between slides (ms)
                disableOnInteraction: false // keep autoplay after user swipes
            },
            cardsEffect: {
                perSlideOffset: 15,
                perSlideRotate: 2,
                slideShadows: false
            },
            // pagination: { el: ".swiper-pagination", clickable: true }
        });

    </script>

@endsection

