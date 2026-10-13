@extends('admin.layouts.app')

@section('title')
View Learning Assessment
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
                <h1 class="pull-left page-title">View Learning Program</h1>
                <div class="rm05 backclass">
                    <a href="{{ route('manage.learning.assessments') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default panel-fill">
                    <div class="panel-heading">
                        <h3 class="panel-title">Program Details</h3>
                    </div>

                    <div class="panel-body">
                        <div class="about-info-p">
                            <strong>Parent Name</strong><br>
                            <p class="text-muted">
                                {{ $assessment->first_name }}
                            </p>
                        </div>

                        <div class="about-info-p">
                            <strong>Child Name</strong><br>
                            <p class="text-muted">
                               {{ $assessment->last_name }}
                            </p>
                        </div>

                        <div class="about-info-p">
                            <strong>Assessment For</strong><br>
                            <p class="text-muted">{{ ucfirst($assessment->assessment_for) }}</p>
                        </div>

                        <div class="about-info-p">
                            <strong>Program Mode</strong><br>
                            <p class="text-muted">{{ $assessment->program_mode_label}}</p>
                        </div>

                        <div class="about-info-p">
                            <strong>School Year / Grade</strong><br>
                            <p class="text-muted">{{ $assessment->school_year }}</p>
                        </div>

                        <div class="about-info-p">
                            <strong>State</strong><br>
                            <p class="text-muted">{{ $assessment->state ?? '-' }}</p>
                        </div>

                        <div class="about-info-p">
                            <strong>Subject</strong><br>
                            <p class="text-muted">{{ $assessment->subject }}</p>
                        </div>

                        <div class="about-info-p">
                            <strong>Learning Need</strong><br>
                            <p class="text-muted">{{  $assessment->learning_need_title }}</p>
                        </div>

                        <div class="about-info-p">
                            <strong>Free Time</strong><br>
                            <p class="text-muted">{{ $assessment->free_time_label ?? '-'  }}</p>
                        </div>

                        <hr>

                        <div class="about-info-p">
                            <strong>Email</strong><br>
                            <p class="text-muted">{{ $assessment->email }}</p>
                        </div>

                        <div class="about-info-p">
                            <strong>Phone</strong><br>
                            <p class="text-muted">{{ $assessment->phone }}</p>
                        </div>

                        <div class="about-info-p">
                            <strong>Terms Agreed</strong><br>
                            {{ $assessment->terms_agreed_label }}
                        </div>

                        <div class="about-info-p">
                            <strong>Submitted On</strong><br>
                            <p class="text-muted">
                                {{ $assessment->created_at->format('d-m-Y h:i A') }}
                            </p>
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
