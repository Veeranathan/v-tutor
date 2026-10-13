@extends('admin.layouts.app')

@section('content')

<div class="card p-3">
    <h4>Session Details</h4><hr>

    <p><b>Tutor:</b> {{ $r->tutor_name }}</p>
    <p><b>Date:</b> {{ $r->booking_date }}</p>
    <p><b>Time:</b> {{ $r->from_time }} - {{ $r->to_time }}</p>
    <p><b>Amount:</b> ${{ number_format($r->booking_amount,2) }}</p>
    <p><b>Status:</b> {{ $r->booking_status }}</p>

    <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
</div>

@endsection
