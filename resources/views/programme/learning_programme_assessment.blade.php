@extends('layouts.app')

@section('page_title', 'V-Tutor | Learning Program Assessment')

@section('left_part')
    @include('include.header_menu_part')
@endsection
@section('content')
@php
$title = 'Learning Program';
@endphp
<!-- ================= HERO (Modern Card Header) ================= -->
@include('include.page_hero', [
    'title' => $title,
    'showBreadcrumb' => true
])


@include('include.learning_program_section')
@include('include.learning_program_modal_only')

@endsection

@section('footer')
    @include('include.footer')
@endsection

@section('script')
    @include('include.script')


@endsection
