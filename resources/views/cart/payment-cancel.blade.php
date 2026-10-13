@extends('layouts.app')

@section('page_title', 'Payment Cancelled')

@section('content')
<section class="py-5 text-center">
    <div class="container">
        <h1 class="text-danger mb-3">Payment Cancelled</h1>
        <p>Your payment was cancelled. You can try again anytime.</p>

        <a href="{{ route('cart.index') }}" class="btn btn-warning mt-4">
            Back to Cart
        </a>
    </div>
</section>
@endsection
