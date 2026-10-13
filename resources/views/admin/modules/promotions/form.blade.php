@extends('admin.layouts.app')
@section('title')
Promotion
@endsection
@section('links')
@include('admin.includes.links')
<link href="{{ public_asset('admin/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ public_asset('admin/assets/css/core.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ public_asset('admin/assets/css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ public_asset('admin/assets/css/responsive.css') }}" rel="stylesheet" type="text/css">
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
                <h4 class="pull-left page-title">Promotions</h4>
                <ol class="breadcrumb pull-right">
                    <li> <a href="{{ route('manage.subjects') }}"><i class="fas fa-angle-double-left"></i> Back</a></li>
                </ol>
            </div>
        </div>
        <!-- Personal-Information -->
        <div class="panel panel-default panel-fill">
            <div class="panel-body rm02 rm04">
                @include('admin.includes.message')
                <div class="frm_admin">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
<form action="{{ $promotion ? route('promotion.update') : route('promotion.store') }}" method="POST" id="promotion_form">
    @csrf
    @if($promotion)
        <input type="hidden" name="promotion_id" value="{{ $promotion->id }}">
    @endif

    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="form-group">
                <label for="start_date">Start Date</label>
                <input type="date" name="start_date" id="start_date" class="form-control required"
                    value="{{ old('start_date', isset($promotion->start_date) ? $promotion->start_date->format('Y-m-d') : '') }}">
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="form-group">
                <label for="end_date">End Date</label>
                <input type="date" name="end_date" id="end_date" class="form-control required"
                    value="{{ old('end_date', isset($promotion->end_date) ? $promotion->end_date->format('Y-m-d') : '') }}">
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="form-group">
                <label for="discount_code">Discount Code</label>
                <input type="text" name="discount_code" id="discount_code" class="form-control required"
                    placeholder="e.g. SAVE10"
                    value="{{ old('discount_code', $promotion->discount_code ?? '') }}">
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="form-group">
                <label for="discount">Discount (%)</label>
                <input type="number" name="discount" id="discount" class="form-control required"
                    placeholder="e.g. 15"
                    value="{{ old('discount', $promotion->discount ?? '') }}" min="0" max="100" step="0.01">
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="form-group">
                <label for="promotion_hd">Promotion Heading</label>
                <input type="text" name="promotion_hd" id="promotion_hd" class="form-control required"
                    placeholder="e.g. Winter Sale"
                    value="{{ old('promotion_hd', $promotion->promotion_hd ?? '') }}">
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="form-group">
                <label for="promotion_sub_hd">Promotion Sub Heading</label>
                <input type="text" name="promotion_sub_hd" id="promotion_sub_hd" class="form-control required"
                    placeholder="e.g. Limited time offer!"
                    value="{{ old('promotion_sub_hd', $promotion->promotion_sub_hd ?? '') }}">
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-sm-12">
            <div class="ad_btn text-center">
                <button class="btn btn-primary waves-effect waves-light w-md" type="submit">
                    {{ $promotion ? 'Update Promotion' : 'Create Promotion' }}
                </button>
            </div>
        </div>
    </div>
</form>



</div>
@endsection
