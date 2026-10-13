@extends('layouts.app')

@section('page_title', 'V-Tutor | Learning Program Assessment')
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">
@section('left_part')
@include('include.header_menu_part')
<style>
/* ==========================
   HERO
========================== */
.hero {
  min-height: 30vh;
  position: relative;
  text-align: center;
  overflow: hidden;
}

.hero .hero-bg img {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  z-index: 1;
}

.hero .hero-bg::before {
  content: "";
  position: absolute;
  inset: 0;
  background: rgba(90, 90, 90, 0.55);
  z-index: 2;
}

.hero .container {
  position: relative;
  z-index: 3;
  padding: 120px 15px;
}

.hero h1 {
  font-size: 48px;
  font-weight: 700;
  color: #ffffff !important;
}

/* ==========================
   HERO BREADCRUMB
========================== */
.hero-with-breadcrumb .hero-breadcrumb {
  margin-bottom: 18px;
}

.hero-with-breadcrumb .breadcrumb {
  background: transparent;
  padding: 0;
  margin: 0;
}

.hero-with-breadcrumb .breadcrumb-item,
.hero-with-breadcrumb .breadcrumb-item a {
  color: rgba(255, 255, 255, 0.9);
  font-size: 14px;
}

/* =========================
   BUTTON
========================= */
.assessment-btn {
  background: #D7263D;
  color: #fff;
  padding: 16px 45px;
  font-size: 18px;
  border-radius: 12px;
  border: none;
  transition: all 0.25s ease;
}

.assessment-btn:hover {
  background: #c21f34;
  transform: translateY(-2px);
  box-shadow: 0 10px 20px rgba(184, 15, 10, 0.25);
}

/* =========================
   CART PAGE
========================= */
.cart-page h2 {
  font-weight: 600;
}

/* =========================
   CART TABLE
========================= */
.cart-table {
  background: #fff;
  border: 1px solid #e5e7eb;
  border-radius: 10px;
  overflow: hidden;
}

/* Header + Rows */
.cart-header,
.cart-row {
  display: grid;
  grid-template-columns: 60px 1fr 140px 120px 80px;
  align-items: center;
  padding: 14px 20px;
  column-gap: 20px;
}
.col-price {
  padding-left: 10px;
}

/* Header */
.cart-header {
  background: #f9fafb;
  font-weight: 600;
  color: #6b7280;
  border-bottom: 1px solid #e5e7eb;
  text-align: left;
}

/* Rows */
.cart-row {
  border-bottom: 1px solid #e5e7eb;
}

.cart-row:last-child {
  border-bottom: none;
}

/* Column alignment */
.cart-header .col-sn,
.cart-row .col-sn {
  text-align: center;
}

.cart-header .col-name,
.cart-row .col-name {
  text-align: left;
  font-size: 16px;
}

.cart-header .col-qty,
.cart-row .col-qty {
  display: flex;
  justify-content: center;
}

.cart-header .col-price,
.cart-row .col-price {
  font-weight: 600;
}

.cart-header .col-action,
.cart-row .col-action {
  text-align: center;
}

/* Quantity box */
.qty-box {
  display: inline-flex;
  align-items: center;
  gap: 6px;
}

.qty-box input {
  width: 42px;
  height: 32px;
  text-align: center;
  border: 1px solid #ddd;
  border-radius: 6px;
  font-size: 14px;
}

.qty-btn {
  width: 32px;
  height: 32px;
  border: 1px solid #ddd;
  background: #f9fafb;
  cursor: pointer;
}

/* Remove */
.remove-btn {
  background: transparent;
  border: none;
  color: #dc3545;
  font-size: 18px;
  cursor: pointer;
}

/* =========================
   ORDER SUMMARY
========================= */
.order-summary-card {
  background: #fff;
  border: 1px solid #e5e7eb;
  border-radius: 10px;
  padding: 25px;
}

.summary-row {
  display: flex;
  justify-content: space-between;
  margin-bottom: 10px;
}

.summary-row.total {
  font-size: 18px;
  font-weight: 600;
}

/* Continue shopping */
.btn-outline-primary {
  color: #D7263D;
  border-color: #D7263D;
}

.btn-outline-primary:hover {
  color: #fff;
  background-color: #D7263D;
  border-color: #D7263D;
}
/* =====================
   RESPONSIVE CART
===================== */

/* Desktop only */
.desktop-cart {
  display: block;
}

.mobile-cart {
  display: none;
}

/* Mobile layout */
@media (max-width: 768px) {

  .desktop-cart {
    display: none;
  }

  .mobile-cart {
    display: block;
  }

  .mobile-cart-item {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 15px;
    margin-bottom: 15px;
  }

  .mobile-product-name {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 6px;
  }

  .mobile-price {
    font-size: 15px;
    font-weight: 600;
    margin-bottom: 10px;
  }

  .mobile-actions {
    display: flex;
    align-items: center;
    gap: 15px;
  }

  .mobile-actions .qty-box {
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }

  .mobile-actions .remove-btn {
    background: none;
    border: none;
    color: #dc3545;
    font-size: 18px;
  }
}
@media (max-width: 768px) {
  .continue-shopping-btn {
    display: none;
  }
}
/* ===============================
   PREMIUM CART & ORDER SUMMARY
================================ */

/* Card look */
.cart-table,
.mobile-cart-item,
.order-summary-card {
  background: #ffffff;
  border-radius: 16px;
  border: none;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
}

/* Cart header */
.cart-header {
  background: linear-gradient(180deg, #fafafa, #f1f1f1);
  font-size: 13px;
  letter-spacing: 0.6px;
  text-transform: uppercase;
}

/* Cart rows */
.cart-row {
  padding: 18px 20px;
  transition: background 0.2s ease;
}

.cart-row:hover {
  background: #fafafa;
}

/* Product name */
.cart-row .col-name strong,
.mobile-product-name {
  font-size: 16px;
  font-weight: 600;
  color: #111827;
}

/* Price */
.col-price,
.mobile-price {
  font-size: 16px;
  font-weight: 700;
  color: #16a34a;
}

/* Quantity buttons */
.qty-btn {
  background: #ffffff;
  border: 1px solid #e5e7eb;
  border-radius: 8px;
  font-weight: 600;
  transition: all 0.2s ease;
}

.qty-btn:hover {
  background: #D7263D;
  color: #ffffff;
  border-color: #D7263D;
}

.qty-box input {
  border-radius: 8px;
  font-weight: 600;
}

/* Remove button */
.remove-btn {
  opacity: 0.6;
  transition: all 0.2s ease;
}

.remove-btn:hover {
  opacity: 1;
  transform: scale(1.15);
}

/* Order summary */
.order-summary-card {
  position: sticky;
  top: 100px;
  padding: 30px;
}

/* Summary text */
.summary-row {
  font-size: 15px;
  color: #374151;
}

.summary-row.total {
  font-size: 20px;
  font-weight: 700;
  color: #111827;
}

/* Checkout button */
.assessment-btn {
  background: linear-gradient(135deg, #D7263D, #b91c1c);
  box-shadow: 0 12px 30px rgba(215, 38, 61, 0.35);
}

.assessment-btn:active {
  transform: scale(0.98);
}
/* =========================
   CHECKOUT CONFIRM MODAL
========================= */

/* Reduce button size */
#checkoutConfirmModal .btn {
  padding: 10px 14px;
  font-size: 14px;
  white-space: normal;
}

/* Modal text size */
#checkoutConfirmModal p {
  font-size: 14px;
  line-height: 1.5;
}

/* Mobile: stack buttons vertically */
@media (max-width: 576px) {
  #checkoutConfirmModal .d-flex {
    flex-direction: column;
  }

  #checkoutConfirmModal .btn {
    width: 100% !important;
  }
}
.login-text-link {
  color: #D7263D;
  text-decoration: underline;
  font-size: 18px;
  font-weight: 600;
  cursor: pointer;
  transition: filter 0.25s ease, opacity 0.25s ease;
}

.login-text-link:hover {
  color: #d61b34;
  text-decoration: underline;
}

</style>
<script src="https://js.stripe.com/v3/"></script>
@endsection

@section('content')
@php
$title = 'Cart';
@endphp
<!-- ================= HERO (Modern Card Header) ================= -->
@include('include.page_hero', [
    'title' => $title,
    'showBreadcrumb' => false
])
<!-- =======================
     CART SECTION
======================== -->
<section class="cart-page py-5">
    <div class="container">
          @php
            $cartItems = session('cart.items', []); // session key 'cart.items' will hold all items
          @endphp
          @if(empty($cartItems))
          <div class="text-center py-5">
            <h3>Your cart is empty 🛒</h3>
            <a href="{{ url('/') }}" class="btn btn-primary mt-3">
              Go Back to Home
            </a>
          </div>
        @else

        <h2 class="mb-4">Your Cart</h2>
        <div class="row">
            <!-- LEFT: CART ITEMS -->
            <div class="col-lg-8">
                <!-- DESKTOP CART -->
                <div class="desktop-cart">
                    <div class="cart-table">
                        <!-- Header -->
                        <div class="cart-header">
                            <div class="col-sn">#</div>
                            <div class="col-name">Product</div>
                            <div class="col-qty">Qty</div>
                            <div class="col-price">Price</div>
                            <div class="col-action">Remove</div>
                        </div>
                   
                        @foreach($cartItems as $index => $item)
                        <div class="cart-row" data-id="{{ $item['id'] }}">
                            <div class="col-sn">{{ $index + 1 }}</div>
                            <div class="col-name"><strong>{{ $item['name'] }}</strong></div>
                            <div class="col-qty">
                                <div class="qty-box">
                                    <button class="qty-btn qty-minus">-</button>
                                     <input type="text" class="qty-input" value="{{ $item['qty'] }}" readonly>
                                    <button class="qty-btn qty-plus">+</button>
                                </div>
                            </div>
                            <div class="col-price">$<span class="unit-price">{{ number_format($item['price'], 2) }}</span></div>
                            <div class="col-action">
                                <button class="remove-btn remove-cart">🗑</button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <!-- MOBILE CART -->
                <div class="mobile-cart">
                    @foreach($cartItems as $index => $item)
                    <div class="mobile-cart-item" data-id="{{ $item['id'] }}">
                        <div class="mobile-product-name">
                            {{ $item['name'] }}
                        </div>
                    <div class="mobile-price">
                        $<span class="unit-price">{{ number_format($item['price'], 2) }}</span>
                    </div>
                    <div class="mobile-actions">
                    <div class="qty-box">
                        <button class="qty-btn qty-minus">-</button>
                         <input type="text" class="qty-input" value="{{ $item['qty'] }}" readonly>
                        <button class="qty-btn qty-plus">+</button>
                    </div>
                        <button class="remove-btn remove-cart">🗑</button>
                    </div>
                    </div>
                    @endforeach
                </div>
                  @if($isLoggedIn && $showGradeWarning)
                  <div class="alert alert-warning mt-3">
                  <strong>Note:</strong> 
                  The learning program in your cart do not match your grade 
                  ({{ $userGradeName ?? 'Your Grade' }}).
                  <br>
                  Please review your selection to ensure it aligns with your academic level.
                </div>
                @endif
                  <a href="{{ session('cart.back_url', url('/')) }}" class="btn btn-outline-primary mt-3 continue-shopping-btn">
                    ← Back
                  </a>
              </div>

            <!-- RIGHT: ORDER SUMMARY -->
            <div class="col-lg-4">

                <div class="order-summary-card">
                    <h5 class="mb-3">Order Summary</h5>
                    
                    <div class="summary-row">
                        <span>Order ID</span>
                        <span><strong>{{ $orderId }}</strong></span>
                    </div>
                    @php
                      $subtotal = collect($cartItems)->sum(fn($i) => $i['price'] * $i['qty']);
                      $gst = $subtotal * 0.10;
                      $total = $subtotal + $gst;
                    @endphp
                    <div class="summary-row">
                      <span>Subtotal</span>
                      <span id="subTotal">{{ number_format($subtotal, 2) }}</span>
                    </div>

                    <div class="summary-row">
                      <span>GST (10%)</span>
                      <span>$<span id="gstAmount">{{ number_format($gst, 2) }}</span></span>
                    </div>

                    <hr>
                    <div class="summary-row total">
                      <span>Total</span>
                      <span id="totalAmount">{{ number_format($total, 2) }}</span>
                    </div>

                    @if(!$isLoggedIn)
                    <div id="guestForm" class="guest-checkout-form mt-4">
                      <div class="upper-login mb-3">
                        <h5 class="mb-1">Contact Details</h5>
                          <p class="text-muted mb-0">Please fill in the details to continue checkout</p>
                      </div>

                    <div class="double-from">
                      <div class="form_area">
                        <input type="text"  class="texxt_box" placeholder="First Name"  id="f_name" name="f_name">
                        <small class="text-danger d-none" id="error_f_name"></small>       
                      </div>

                      <div class="form_area">
                        <input type="text"  class="texxt_box" placeholder="Last Name" id="l_name" name="l_name">
                        <small class="text-danger d-none" id="error_l_name"></small>
                      </div>
                    </div>

                    <div class="form_area">
                      <input type="email" class="texxt_box" placeholder="Email address" id="email"  name="email">
                      <small class="text-danger d-none" id="error_email"></small>
                    </div>

                    <div class="form_area">
                      @php
                        $states = \App\Models\State::orderBy('id', 'asc')->get();
                      @endphp
                      <select name="parent_state" id="parent_state" class="texxt_box">
                        <option value="">Select State</option>
                          @foreach ($states as $st)
                            <option value="{{ $st->id }}" data-timezone="{{ $st->time_zone }}">
                              {{ $st->state_name }}
                            </option>
                          @endforeach
                      </select>

                    <input type="hidden" id="timezone_id">
                      <small class="text-danger d-none" id="error_parent_state"></small>
                    </div>
                  </div>
                  @endif
                  <button id="checkoutBtn" class="assessment-btn w-100 mt-4">
                    Proceed to Checkout
                  </button>
                  <div id="guestError" class="text-danger mt-2 d-none"></div>
                    <div id="loginPrompt" class="mt-3 d-none text-center">
                      <p class="text-danger mb-2"></p>
                      <a href="{{ route('login') }}" class="login-text-link">
                        Login
                      </a>
                  </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
<!-- Checkout Confirmation Modal -->
<div class="modal fade" id="checkoutConfirmModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">

      <div class="modal-body text-center p-4">
        <p class="mb-4">
          You will now be redirected to our trusted external payment gateway to
          complete your booking. Your session details are saved, and you’ll be
          returned here automatically after payment.
          <br><br>
          <strong>Please don’t close this window during checkout.</strong>
        </p>

        <div class="d-flex justify-content-between gap-3">
          <button type="button"
                  class="btn btn-outline-secondary w-50"
                  data-dismiss="modal">
            Cancel
          </button>

          <button type="button"
                  class="btn btn-danger w-50"
                  id="payNowBtnConfirm">
            Continue to Payment
          </button>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection

@section('footer')
    @include('include.footer')
@endsection

@section('script')
@include('include.script')
<script>
/* FIELD ERROR HELPERS */
function showFieldError(field, message) {
    const el = document.getElementById('error_' + field);
    if (el) {
        el.innerText = message;
        el.classList.remove('d-none');
    }
}

function clearFieldError(field) {
    const el = document.getElementById('error_' + field);
    if (el) {
        el.innerText = '';
        el.classList.add('d-none');
    }
}

function clearAllFieldErrors() {
    document.querySelectorAll('[id^="error_"]').forEach(el => {
        el.innerText = '';
        el.classList.add('d-none');
    });

    const loginPrompt = document.getElementById('loginPrompt');
    if (loginPrompt) loginPrompt.classList.add('d-none');
}

function debounce(fn, delay = 300) {
    let timer;
    return function (...args) {
        clearTimeout(timer);
        timer = setTimeout(() => fn.apply(this, args), delay);
    };
}

const GST_RATE = 0.10;

document.addEventListener('DOMContentLoaded', function () {

    const stripeKey = "{{ config('services.stripe.stripe-publishable') }}";
    if (!stripeKey) return;

    const stripe      = Stripe(stripeKey);
    const checkoutBtn = document.getElementById('checkoutBtn');
    const confirmBtn  = document.getElementById('payNowBtnConfirm');
    const subTotalEl = document.getElementById('subTotal');
    const gstEl      = document.getElementById('gstAmount');
    const totalEl    = document.getElementById('totalAmount');

    const isLoggedIn  = {{ $isLoggedIn ? 'true' : 'false' }};

    /*  PROCEED CLICK */
    checkoutBtn.addEventListener('click', function () {

        clearAllFieldErrors();

        if (isLoggedIn) {
            $('#checkoutConfirmModal').modal('show');
            return;
        }

        const fields = {
            f_name: document.getElementById('f_name').value.trim(),
            l_name: document.getElementById('l_name').value.trim(),
            email:  document.getElementById('email').value.trim(),
            parent_state: document.getElementById('parent_state').value,
            timezone_id: document.getElementById('timezone_id').value
        };

        let hasError = false;

        const nameRegex = /^[A-Za-z\s]+$/;
        // First Name
        if (!fields.f_name) {
          showFieldError('f_name', 'First name is required');
          hasError = true;
        } else if (fields.f_name.length < 3) {
          showFieldError('f_name', 'First name must be at least 3 characters');
          hasError = true;
        } else if (!nameRegex.test(fields.f_name)) {
          showFieldError('f_name', 'Only letters are allowed');
          hasError = true;
        }
        // Last Name
        if (!fields.l_name) {
          showFieldError('l_name', 'Last name is required');
          hasError = true;
        } else if (fields.l_name.length < 3) {
          showFieldError('l_name', 'Last name must be at least 3 characters');
          hasError = true;
        } else if (!nameRegex.test(fields.l_name)) {
          showFieldError('l_name', 'Only letters and spaces are allowed');
          hasError = true;
        }
        // Email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!fields.email) {
          showFieldError('email', 'Email address is required');
          hasError = true;
        } else if (!emailRegex.test(fields.email)) {
          showFieldError('email', 'Please enter a valid email address');
          hasError = true;
        }
        // State
        if (!fields.parent_state) {
          showFieldError('parent_state', 'Please select a state');
          hasError = true;
        }

        if (hasError) return;

        fetch("{{ route('student.guest.checkExists') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                email: fields.email,
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.exists) {
                 let message = '';

              if (data.email) {
                message = 'Email is already registered.';
              }

              const loginPrompt = document.getElementById('loginPrompt');
              const p = loginPrompt.querySelector('p');
              if (p) {
                p.innerHTML = `${message}<br>Please login to continue your purchase.`;
              }

              loginPrompt.classList.remove('d-none');
              return;
            }
              $('#checkoutConfirmModal').modal('show');
          })
          .catch(() => {
            showFieldError('email', 'Unable to validate details. Please try again.');
        });
    });

    /* CONFIRM & PAY */
    confirmBtn.addEventListener('click', function () {

        confirmBtn.disabled = true;
        confirmBtn.innerText = 'Processing...';

        if (isLoggedIn) {
            createStripeSession();
        } else {
            createGuestAndCheckout();
        }
    });

    function createGuestAndCheckout() {

        clearAllFieldErrors();

        const payload = {
            f_name: document.getElementById('f_name').value.trim(),
            l_name: document.getElementById('l_name').value.trim(),
            email:  document.getElementById('email').value.trim(),
            parent_state: document.getElementById('parent_state').value,
            timezone_id: document.getElementById('timezone_id').value
        };

        let hasError = false;

        Object.entries(payload).forEach(([key, value]) => {
            if (!value) {
                showFieldError(key, 'This field is required');
                hasError = true;
            }
        });

        if (hasError) {
            resetConfirmBtn();
            return;
        }

        fetch("{{ route('student.guest.register') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                createStripeSession();
            } else {
                resetConfirmBtn();
            }
        })
        .catch(() => resetConfirmBtn());
    }

    function createStripeSession() {

        fetch("{{ route('stripe.program.session') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                order_id: "{{ $orderId }}",
                amount: parseFloat(document.getElementById('totalAmount').innerText.replace(/,/g, ''))
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.id) {
                stripe.redirectToCheckout({ sessionId: data.id });
            } else {
                resetConfirmBtn();
            }
        })
        .catch(() => resetConfirmBtn());
    }

    function resetConfirmBtn() {
        confirmBtn.disabled = false;
        confirmBtn.innerText = 'Continue to Payment';
    }

    /* CLEAR ERRORS ON INPUT */
    ['f_name','l_name','email','parent_state','timezone_id'].forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener('input', () => clearFieldError(id));
            el.addEventListener('change', () => clearFieldError(id));
        }
    });

     /* qty click handler (mobile + desktop) */
    document.addEventListener('click', function (e) {

        if (!e.target.classList.contains('qty-plus') &&
            !e.target.classList.contains('qty-minus')) return;

        const container =
            e.target.closest('.cart-row') ||
            e.target.closest('.mobile-cart-item');

        if (!container) return;

        const input = container.querySelector('.qty-input');
        let qty = parseInt(input.value);

        if (e.target.classList.contains('qty-plus')) qty++;
        if (e.target.classList.contains('qty-minus') && qty > 1) qty--;

        syncQtyUI(container.dataset.id, qty);
        updateAmounts();
        debouncedSyncQty(container.dataset.id, qty);
    });

});

function updateAmounts() {
    let subtotal = 0;
    const counted = new Set();

    document.querySelectorAll('[data-id]').forEach(item => {

        const id = item.dataset.id;
        if (counted.has(id)) return;
        counted.add(id);

        const priceEl = item.querySelector('.unit-price');
        const qtyEl   = item.querySelector('.qty-input');

        if (!priceEl || !qtyEl) return;

        const price = parseFloat(priceEl.innerText.replace(/,/g, ''));
        const qty   = parseInt(qtyEl.value);

        subtotal += price * qty;
    });

    const gst   = subtotal * GST_RATE;
    const total = subtotal + gst;

    document.getElementById('subTotal').innerText = subtotal.toFixed(2);
    document.getElementById('gstAmount').innerText = gst.toFixed(2);
    document.getElementById('totalAmount').innerText = total.toFixed(2);
}

function syncQtyUI(programId, qty) {
    document
        .querySelectorAll(`[data-id="${programId}"] .qty-input`)
        .forEach(el => el.value = qty);
}

function syncQty(programId, qty) {
    fetch("{{ route('cart.updateQty') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            program_id: programId,
            qty: qty
        })
    });
}

const debouncedSyncQty = debounce(syncQty, 400);

/* REMOVE CART ITEM (desktop + mobile) */
document.addEventListener('click', function (e) {

    if (!e.target.classList.contains('remove-cart')) return;

    const item = e.target.closest('[data-id]');
    if (!item) return;

    const programId = item.dataset.id;

    fetch("{{ route('cart.remove') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ program_id: programId })
    })
    .then(res => res.json())
    .then(data => {
        if (!data.success) return;

        /* REMOVE BOTH DESKTOP + MOBILE ITEMS */
        document
            .querySelectorAll(`[data-id="${programId}"]`)
            .forEach(el => el.remove());

        updateAmounts();
        location.reload();
        /* CART EMPTY CHECK */
        const remaining =
            document.querySelectorAll('.cart-row, .mobile-cart-item');

        if (remaining.length === 0) {
            window.location.href = "{{ url('/') }}";
        }
    });
});
const stateSelect   = document.getElementById('parent_state');
const timezoneInput = document.getElementById('timezone_id');

function setTimezone() {
    var selectedOption = stateSelect.options[stateSelect.selectedIndex];
    timezoneInput.value = selectedOption.getAttribute('data-timezone') || '';
}
if (stateSelect) {
    stateSelect.addEventListener('change', setTimezone);
    if (stateSelect.value) {
        setTimezone();
    }
}
</script>
@endsection
      