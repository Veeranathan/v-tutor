<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>V-Tutor – Tutor – Forgot Password</title>
        {{-- <link rel="icon" href="{{ public_asset('assets/images/favicon.ico')}}" type="image/x-icon" />
        <link rel="shortcut icon" href="{{ public_asset('assets/images/favicon.ico')}}" type="image/x-icon" /> --}}
        <link rel="icon" href="{{ public_asset('assets/images/favicon.ico')}}" type="image/x-icon" />
        <link rel="shortcut icon" href="{{ public_asset('assets/images/favicon.ico')}}" type="image/x-icon" />
        <link rel="icon" href="{{ public_asset('assets/images/favicon.png') }}" sizes="32x32">
        <link rel="icon" href="{{ public_asset('assets/images/favicon.png') }}" sizes="96x96">
        <link rel="icon" href="{{ public_asset('assets/images/favicon.png') }}" sizes="192x192">
        <link rel="apple-touch-icon" href="{{ public_asset('assets/images/favicon.png') }}">
        <meta name="msapplication-TileImage" content="{{ public_asset('assets/images/favicon.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ public_asset('assets/images/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ public_asset('assets/images/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ public_asset('assets/images/favicon-16x16.png') }}">
        
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="{{ public_asset('assets/css/new_login_bootstrap.min.css') }}" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Alex+Brush&display=swap" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Satisfy&display=swap" rel="stylesheet">
        
        <link href="{{ public_asset('assets/css/new_login.css') }}" rel="stylesheet">

        <style>
            .card2 {
                margin-top: 100px;
            }
        </style>
    </head>

    <body class="fp_body">
        <div class="container-fluid px-1 px-md-5 px-lg-1 px-xl-5 py-5 mx-auto">
            <div class="card card0 border-0">
                <div class="row d-flex">
                    <div class="col-lg-6">
                        <div class="card1 pb-5">
                            <div class="row">
                                <a class="navbar-brand" href="{{ url('/') }}">
                                    <img src="{{ public_asset('assets/images/logo.png') }}" alt="logo"  class="logo"/></a>
                            </div>

                            <div class="row px-3 justify-content-center mt-4 mb-5 border-line">
                                <img src="https://imgs.search.brave.com/PEUEYCC0QOZ7D-KiSD9IbhUnn1hiBqJbn8SFjKP4NtI/rs:fit:500:0:1:0/g:ce/aHR0cHM6Ly90aHVt/YnMuZHJlYW1zdGlt/ZS5jb20vYi90dXRv/cmluZy1oaXMtb25s/aW5lLWVkdWNhdGlv/bi1sZWFybmluZy1l/ZHVjYXRpb24tdGVh/Y2hlci10dXRvci1j/b2FjaC1tYW5hZ2Vt/ZW50LTg5MzYyMTM5/LmpwZw" class="image">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card2 card border-0 px-4 py-5">
                            {{-- Success flash --}}
                            <div class="row mb-4 px-3">
                                @foreach (['success','error'] as $type)
                                    @if (session($type))
                                        <div class="mb-4 px-4 py-3 rounded-lg text-sm {{ $type === 'success' ? 'flash_success' : 'flash_error' }}">
                                            {{ session($type) }}
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                            <div class="row mb-4 px-3">
                                <h6 class="mb-0 mr-4 mt-2">Forgot Password</h6>
                                <p class="info_sec mb-0 mr-4 mt-2">Please enter your email address for a link to reset password</p>
                            </div>

                            <form method="post" action="{{route('tutor_application_form_chk_fp')}}" id="frm">
                                @csrf
                                <div class="row px-3">
                                    <label class="mb-1">
                                        <h6 class="mb-0 text-sm">
                                            Email Address 
                                            @error('email')
                                                <span class="text-error">{{ $message }}</span>
                                            @enderror
                                        </h6>
                                    </label>
                                    <input class="mb-4" type="text" name="email" placeholder="Enter a valid email address">
                                </div>
                                
                                <div class="row mb-3 px-3">
                                    <button type="submit" class="btn login_btn text-center">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="login_footer py-4">
                    <div class="row px-3">
                        <small class="ml-4 ml-sm-5 mb-2">Copyright © {{ date('Y') }} <a href="{{ url('/') }}">V-Tutor.com.au</a>   <span>|</span> All Rights Reserved.</small>

                        @php
							$followUsDetails = \App\Models\FollowUsDetails::first();
                        @endphp

                        <div class="social-contact ml-4 ml-sm-auto">
                            <a href="{{ @$followUsDetails->facebook_link }}" target="_blank"><span class="fa fa-facebook mr-4 text-sm"></span></a>

                            <a href="{{ @$followUsDetails->twitter_link }}" target="_blank"><span class="fa fa-twitter mr-4 text-sm"></span></a>
                            
                            <a href="{{ @$followUsDetails->instagram_link }}" target="_blank"><span class="fa fa-instagram mr-4 text-sm"></span></a>

                            <a href="{{ @$followUsDetails->youtube_link }}" target="_blank"><span class="fa fa-youtube mr-4 text-sm"></span></a>

                            <a href="{{ @$followUsDetails->p_interest_link }}" target="_blank"><span class="fa fa-pinterest mr-4 mr-sm-5 text-sm"></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{ public_asset('assets/js/new_login_jquery.min.js') }}"></script>
        <script src="{{ public_asset('assets/js/new_login_bootstrap.bundle.min.js') }}"></script>

        <script>
            $(document).ready(function() {
                $(document).on("click", ".toggle-password", function(e) {
                    $(this).toggleClass("fa-eye fa-eye-slash");
                    var input = $($(this).attr("toggle"));
                    if (input.attr("type") == "password") {
                        input.attr("type", "text");
                    } else {
                        input.attr("type", "password");
                    }
                });
            });
        </script>
    </body>
</html>