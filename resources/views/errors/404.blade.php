@extends('layouts.app')
@section('title')
    <title>V-Tutor  404</title>
@endsection

@section('left_part')
    {{-- @include('include.left_part') --}}
    @include('include.header_menu_part')
    <style>
        .gj_404_div {
            margin: 65px auto;
            text-align: center;
            width: 100%;
            display: flex;
            justify-content: center;
        }
        .error-container {
            max-width: 600px;
            padding: 30px;
        }
        h1 {
            font-size: 80px;
            margin: 0;
            color: #dc3545;
        }
        h2 {
            margin: 10px 0 20px;
            font-size: 24px;
        }
    </style>
@endsection

@section('content')
    <section class="gj_tut_app_frm_sec">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="gj_404_div">
                        {{-- <h1>404 NOT  FOUND</h1> --}}
                        <div class="error-container">
                            <h1>404</h1>
                            <h2>Oops! Page Not Found</h2>
                            <p>The page you're looking for doesn't exist or has been moved.</p>
                            <a href="{{ url('/') }}">Go to Homepage</a>
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
@endsection
