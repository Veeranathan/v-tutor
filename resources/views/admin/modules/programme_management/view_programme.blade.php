@extends('admin.layouts.app') 

@section('title')
View Programme
@endsection

@section('links')
@include('admin.includes.links')
<script src="{{ public_asset('admin/assets/js/modernizr.min.js') }}"></script>
@endsection

@section('header')
@include('admin.includes.header')
@endsection

@section('sidebar')
@include('admin.includes.sidebar')
@endsection

@section('content')
<div class="content">
    <div class="wraper container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <h1 class="pull-left page-title">View Programme</h1>
                <ol class="breadcrumb pull-right">
                    <li> 
                        <a href="{{ route('manage.programmes') }}">
                            <i class="fas fa-angle-double-left"></i> Back
                        </a>
                    </li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div>
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Programme Details -->
                            <div class="panel panel-default panel-fill">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Programme Details</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="about-info-p">
                                        <strong>Parent Name</strong>
                                        <br>
                                        <p class="text-muted">{{ $programme->parent_name }}</p>
                                    </div>

                                    <div class="about-info-p">
                                        <strong>Email</strong>
                                        <br>
                                        <p class="text-muted">{{ $programme->email }}</p>
                                    </div>

                                    <div class="about-info-p">
                                        <strong>Student Name</strong>
                                        <br>
                                        <p class="text-muted">{{ $programme->student_name }}</p>
                                    </div>

                                    <div class="about-info-p">
                                        <strong>Grade</strong>
                                        <br>
                                        <p class="text-muted">{{ $programme->student_grade }}</p>
                                    </div>

                                    <div class="about-info-p">
                                        <strong>Programs</strong>
                                        <br>
                                        <p class="text-muted">
                                            @if($programme->programs)
                                                @php
                                                    // If programs is a JSON string, decode it. If already array, use as-is
                                                    $programs = is_string($programme->programs) 
                                                        ? json_decode($programme->programs, true) 
                                                        : $programme->programs;
                                                @endphp
                                                {{ is_array($programs) ? implode(', ', $programs) : $programs }}
                                            @endif
                                        </p>
                                    </div>

                                    <div class="about-info-p">
                                        <strong>Subscribed</strong>
                                        <br>
                                        <p class="text-muted">
                                            {!! $programme->subscribe ? '<b class="text-success">Yes</b>' : '<b class="text-danger">No</b>' !!}
                                        </p>
                                    </div>

                                    <div class="about-info-p">
                                        <strong>Terms Agreed</strong>
                                        <br>
                                        <p class="text-muted">
                                            {!! $programme->terms_agreed ? '<b class="text-success">Yes</b>' : '<b class="text-danger">No</b>' !!}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!-- End Programme Details -->
                        </div>
                    </div>
                </div>
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
@endsection
