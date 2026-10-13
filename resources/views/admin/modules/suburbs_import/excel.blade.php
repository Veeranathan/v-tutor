@extends('admin.layouts.app')

@section('title')
    Suburbs Import
@endsection

@section('links')
    @include('admin.includes.links')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('header')
    @include('admin.includes.header')
@endsection

@section('sidebar')
    @include('admin.includes.sidebar')
@endsection

@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <h1 class="pull-left page-title">Suburbs Import Excel</h1>
                    <ol class="breadcrumb pull-right">
                        {{-- Breadcrumbs here if needed --}}
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading rm02 rm04">
                            <h4>Upload Excel File</h4>
                        </div>
                        <div class="panel-body">
                            <form action="{{ route('import.suburbs') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="file" required>
                                <button type="submit" class="btn btn-primary mt-2">Import</button>
                            </form>
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
