@extends('admin.layouts.app')
@section('title')
Campaigns Management
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
                <h4 class="pull-left page-title">Campaigns Management</h4>
            </div>
        </div>

        @include('admin.includes.message')

        <!-- ===================== FILTER SECTION ===================== -->
        <div class="panel panel-default panel-fill">
            <div class="panel-heading"><strong>Filter Campaigns</strong></div>
            <div class="panel-body">

                <form method="GET" action="{{ route('promotion.index') }}">
                    <div class="row">

                        <div class="col-md-3">
                            <label>Search Campaign Code</label>
                            <input type="text" name="search" class="form-control"
                                   value="{{ request('search') }}" placeholder="e.g. SAVE10">
                        </div>

                        <div class="col-md-2">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="">All</option>
                                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>From Date</label>
                            <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                        </div>

                        <div class="col-md-3">
                            <label>To Date</label>
                            <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                        </div>

                        <div class="col-md-1">
                            <label>&nbsp;</label>
                            <button class="btn btn-primary btn-block">Filter</button>
                        </div>

                    </div>
                </form>

            </div>
        </div>
        <!-- ================= END FILTER ================= -->

        <!-- ===================== PROMOTION LIST TABLE ===================== -->
        <div class="panel panel-default panel-fill">
            <div class="panel-heading"><strong>All Campaigns</strong></div>
            <div class="panel-body">

                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Promo Code</th>
                        <th>Discount</th>
                        <th>Valid From</th>
                        <th>Valid To</th>
                        <th>Status</th>
                        <th width="150">Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse($promotions as $promo)
                        <tr>
                            <td>{{ $promo->id }}</td>
                            <td>{{ $promo->discount_code }}</td>
                            <td>{{ $promo->discount }}%</td>
                            <td>{{ $promo->start_date->format('d-m-Y') }}</td>
                            <td>{{ $promo->end_date->format('d-m-Y') }}</td>

                            <td>
                                @if($promo->status)
                                    <span class="label label-success">Active</span>
                                @else
                                    <span class="label label-danger">Inactive</span>
                                @endif
                            </td>

                            <td>
                                <a href="{{ route('promotion.index', ['edit' => $promo->id]) }}"
                                   class="btn btn-primary btn-sm">Edit</a>

                                <a href="{{ route('promotion.status', $promo->id) }}"
                                   class="btn btn-warning btn-sm">
                                   {{ $promo->status ? 'Deactivate' : 'Activate' }}
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-danger">No promotions found</td></tr>
                    @endforelse
                    </tbody>

                </table>

                <div class="text-center">
                    {{ $promotions->appends(request()->query())->links() }}
                </div>

            </div>
        </div>
        <!-- ===================== END TABLE ===================== -->

        <!-- ===================== ADD / EDIT FORM ===================== -->
        <div class="panel panel-default panel-fill">
            <div class="panel-heading">
                <strong>{{ $promotion ? 'Edit  Campaign' : 'Add New Campaign' }}</strong>
            </div>
            <div class="panel-body">

                <form action="{{ $promotion ? route('promotion.update', $promotion->id) : route('promotion.store') }}"
                      method="POST">
                    @csrf

                    <div class="row">

                        <div class="col-md-3">
                            <label>Start Date</label>
                            <input type="date" name="start_date" class="form-control"
        value="{{ old('start_date', optional($promotion)->start_date ? $promotion->start_date->format('Y-m-d') : '') }}">
                        </div>

                        <div class="col-md-3">
                            <label>End Date</label>
                             <input type="date" name="end_date" class="form-control"
        value="{{ old('end_date', optional($promotion)->end_date ? $promotion->end_date->format('Y-m-d') : '') }}">
                        </div>

                        <div class="col-md-3">
                            <label>Promo Code</label>
                            <input type="text" name="discount_code" class="form-control"
                                   placeholder="e.g. SAVE10"
                                   value="{{ old('discount_code', $promotion->discount_code ?? '') }}">
                        </div>

                        <div class="col-md-3">
                            <label>Discount (%)</label>
                            <input type="number" name="discount" class="form-control"
                                   value="{{ old('discount', $promotion->discount ?? '') }}" min="0" max="100">
                        </div>

                    </div>

                    <br>

                    <div class="row">

                        <div class="col-md-6">
                            <label>Heading</label>
                            <input type="text" name="promotion_hd" class="form-control"
                                   value="{{ old('promotion_hd', $promotion->promotion_hd ?? '') }}">
                        </div>

                        <div class="col-md-6">
                            <label>Sub Heading</label>
                            <input type="text" name="promotion_sub_hd" class="form-control"
                                   value="{{ old('promotion_sub_hd', $promotion->promotion_sub_hd ?? '') }}">
                        </div>

                    </div>

                    <br>

                    <button class="btn btn-success">
                        {{ $promotion ? 'Update  Campaign' : 'Create Campaign' }}
                    </button>

                </form>

            </div>
        </div>
        <!-- ===================== END FORM ===================== -->

    </div>
</div>
@endsection
