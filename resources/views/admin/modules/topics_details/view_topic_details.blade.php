@extends('admin.layouts.app')
@section('title')
View Topics
@endsection
@section('links')
@include('admin.includes.links')
<script src="{{ asset('public/admin/assets/js/modernizr.min.js') }}"></script>
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','../../www.google-analytics.com/analytics.js','ga');
    
    ga('create', 'UA-65046120-1', 'auto');
    ga('send', 'pageview');
</script>
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
        <h4 class="pull-left page-title">View Topic Details</h4>
        <ol class="breadcrumb pull-right">
            <li> <a href="{{ route('manage.topics.details') }}"><i class="fas fa-angle-double-left"></i> Back</a></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div>
            <div class="row">
                <div class="col-md-6">
                    <!-- Personal-Information -->
                    <div class="panel panel-default panel-fill">
                        <div class="panel-heading">
                            <h3 class="panel-title">View Topic Details</h3>
                        </div>
                        <div class="panel-body">
                            <div class="about-info-p">
                                <strong>Topic Details </strong>
                                <br>
                                <p class="text-muted">{{ @$topics->topics }}</p>
                            </div>
                        </div>
                    </div>
                    <!-- Personal-Information -->
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