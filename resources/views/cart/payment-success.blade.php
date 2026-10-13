@extends('layouts.app')

@section('page_title', 'Payment Successful')

@section('left_part')
    @include('include.header_menu_part')
@endsection

@section('content')

@php
$title = 'Order Success';
@endphp
<!-- ================= HERO (Modern Card Header) ================= -->
@include('include.page_hero', [
    'title' => $title,
    'showBreadcrumb' => true
])

<!-- ======= SUCCESS CONTENT ======= -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="card shadow-sm p-4 text-center">

                    <h3 class="text-success mb-2">
                        Thank you for purchasing the learning program.
                    </h3>

                    <p class="mb-4">
                        Your order has been successfully placed. Refer to email for more details.
                    </p>
                    
                    @if($orderId)
                        <p class="mb-4">
                            <strong>Order ID:</strong>
                            <span class="text-muted">{{ $orderId }}</span>
                        </p>
                    @endif

                    <!-- ORDER DETAILS -->
                    <div class="text-start mb-4">
                        <h5 class="mb-3">Purchased Items</h5>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Program</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-end">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                    <tr>
                                        <td>{{ $item['name'] }}</td>
                                        <td class="text-center">{{ $item['qty'] }}</td>
                                        <td class="text-end">
                                            ${{ number_format($item['price'] * $item['qty'], 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <hr>

                        <div class="mb-2 d-flex justify-content-between">
                            <span>Subtotal</span>
                            <span> ${{ number_format($subTotal, 2) }}</span>
                        </div>

                        <div class="mb-2 d-flex justify-content-between">
                            <span>GST (10%)</span>
                            <span> ${{ number_format($gst, 2) }}</span>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between fw-bold fs-5">
                            <span>Total Paid</span>
                            <span> ${{ number_format($total, 2) }}</span>
                        </div>

                    </div>

                    <a href="{{ url('/') }}" class="assessment-btn mt-3">
                        Return to Learning Programs
                    </a>

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

<style>
/* ==========================
   HERO SECTION
========================== */
.hero {
  min-height: 30vh;
  position: relative;
  text-align: center;
  overflow: hidden;
}

/* Background image */
.hero .hero-bg img {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  z-index: 1;
}

/* Dark overlay */
.hero .hero-overlay {
  position: absolute;
  inset: 0;
  background: rgba(90, 90, 90, 0.55);
  z-index: 2;
}

/* Content above overlay */
.hero .container {
  position: relative;
  z-index: 3;
  padding: 120px 15px;
}

/* Title */
.hero-title,
.hero h1 {
  color: #ffffff;
  font-size: 46px;
  font-weight: 700;
}

/* Breadcrumb */
.hero .breadcrumb {
  background: transparent !important;
  padding: 0;
  margin-bottom: 15px;
}

.hero .breadcrumb-item,
.hero .breadcrumb-item a {
  color: #ffffff;
}

/* Button */
.assessment-btn {
  background: #D7263D;
  color: #ffffff;
  padding: 14px 40px;
  font-size: 18px;
  border-radius: 12px;
  text-decoration: none;
  display: inline-block;
}

.assessment-btn:hover {
  background: #c21f34;
}

.hero.hero-with-breadcrumb h1,
.hero.hero-with-breadcrumb .hero-title {
    color: #ffffff !important;
}

.assessment-btn,
.assessment-btn:hover,
.assessment-btn:focus,
.assessment-btn:active {
    color: #ffffff !important;
    text-decoration: none;
}

</style>
@endsection
