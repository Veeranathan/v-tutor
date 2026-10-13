@extends('layouts.app')

@section('page_title', 'Program Detail')

@section('left_part')
@include('include.header_menu_part')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<style>
/* ================= MODERN CARD HERO ================= */
.hero-card-section {
  background-color: #f8fafc;
}

.hero-compact-card {
  background: #FFF9EC;
  border-radius: 12px;
  /* padding: 16px 24px; */
  border: 1px solid #e2e8f0;
}

/* Breadcrumbs */
.hero-compact-card .breadcrumb {
  font-size: 12.5px;
}

.hero-compact-card .breadcrumb-item,
.hero-compact-card .breadcrumb-item a {
  color: #64748b;
  text-decoration: none;
}

.hero-compact-card .breadcrumb-item a:hover {
  color: #D7263D;
}

.hero-compact-card .breadcrumb-item.active {
  color: #0f172a;
  font-weight: 600;
}
.top-programs-box {
  position: relative;
  padding: 32px 34px;
  border-radius: 16px;
  /*background: linear-gradient(
    135deg,
    #ffffff 0%,
    #ffffff 60%,
    rgba(215, 38, 61, 0.08) 100%
  );*/
  background:#FFF9EC;
  box-shadow: 0 14px 36px rgba(0, 0, 0, 0.12);
  overflow: hidden;
}
.breadcrumb {
  background-color: #FFF9EC !important;
}
.top-programs-box ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.top-programs-box ul li {
  display: flex;
  gap: 12px;
  margin-bottom: 12px;
  font-size: 15.5px;
  color: #555;
}

.top-programs-box ul li i {
  color: #D7263D;
  font-size: 18px;
  margin-top: 2px;
}

.top-programs-box::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 6px; 
  height: 100%;
  background-color: #D7263D;
  border-top-left-radius: 14px;   
  border-bottom-left-radius: 14px; 
}
.top-programs-box .buy-now-btn {
  border-radius: 999px;
} 
.program-info-box {
  position: relative;
 /* background: linear-gradient(180deg, #ffffff 0%, #fafafa 100%);*/
 background: #FFF9EC;
  border-radius: 18px;
  padding: 36px 40px 40px;
  box-shadow:
    0 18px 38px rgba(0, 0, 0, 0.08),
    inset 0 0 0 1px rgba(0, 0, 0, 0.04);
}

.program-info-box::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 5px;
  background: linear-gradient(
    to right,
    #D7263D,
    rgba(215, 38, 61, 0.35)
  );
  border-radius: 18px 18px 0 0;
}

.program-info-box h4 {
  font-size: 22px;
  font-weight: 700;
  margin-bottom: 18px;
  padding-top: 6px;
}

.program-info-list {
  list-style: none;
  padding: 0;
  margin: 0;
}

.program-info-list li {
  padding: 8px 0;
  border-bottom: 1px dashed rgba(0, 0, 0, 0.06);
}

.program-info-list li:last-child {
  border-bottom: none;
}

.program-info-list .label {
  display: block;
  font-size: 12px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.6px;
  color: #888;
  margin-bottom: 2px;
}

.program-info-list .value {
  display: block;
  font-size: 15px;
  font-weight: 500;
  color: #222;
  line-height: 1.4;
}

.program-description p {
  font-size: 15px;
  color: #444;
  margin-top: 14px;
  line-height: 1.6;
}

.btn-primary {
  background-color: #D7263D !important;
  border-color: #D7263D !important;
  color: #ffffff !important;
}

.btn-primary:hover {
  background-color: #c21f34 !important;
  border-color: #c21f34 !important;
}

.program-info-box .buy-now-btn {
  margin-top: 22px;
  padding: 14px 38px;
  font-size: 16px;
  font-weight: 600;
  border-radius: 999px;
  box-shadow: 0 10px 22px rgba(215, 38, 61, 0.25);
}

@media (max-width: 767px) {
  .program-info-box {
    padding: 26px 24px 28px;
  }

  .top-programs-box {
    margin-bottom: 24px;
  }
}
.final-price {
  font-size: 34px;
  font-weight: 700;
  color: #d85a56;
}

.regular-price {
  display: flex;
  align-items: left;
  gap: 10px;
  font-size: 26px;
  margin-top: 6px;
  text-align: center;
}

.regular-price .strike {
  text-decoration: line-through;
  color: #999;
}

.regular-price .offer {
  color: #28a745;
  font-weight: 500;
}
.price-text {
    font-size: 28px !important; 
    font-weight: 700  !important;  
    color: #D7263D !important;    
    display: inline-block;
    padding: 6px 12px;
    background: linear-gradient(90deg, #ffe6e6, #fff0f0);
    border-radius: 8px;
}
.buy-now-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 24px rgba(215, 38, 61, 0.35);
    transition: all 0.3s ease;
}
.program-info-list li + li {
    border-top: 1px solid rgba(215, 38, 61, 0.05);
}
.rating-stars {
    display: flex;
    gap: 4px;
    margin-bottom: 16px;
}

.rating-stars i {
    color: #FFD700;
    font-size: 18px;
}
.product-enquiry-box {
    /*background: linear-gradient(180deg, #ffffff 0%, #fafafa 100%);*/
    background: #FFF9EC;
    border-radius: 18px;
    padding: 30px;
    box-shadow: 0 18px 38px rgba(0, 0, 0, 0.08);
    position: relative;
}

.product-enquiry-box::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: linear-gradient(to right, #D7263D, rgba(215, 38, 61, 0.35));
    border-radius: 18px 18px 0 0;
}

.product-enquiry-box h4 {
    font-weight: 700;
}

.form_area label {
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 5px;
    display: block;
    color: #555;
}

.form_area input {
    width: 100%;
    padding: 10px 12px;
    border-radius: 8px;
    border: 1px solid #ddd;
    transition: all 0.3s ease;
}

.form_area input:focus {
    outline: none;
    border-color: #D7263D;
    box-shadow: 0 0 0 2px rgba(215, 38, 61, 0.1);
}

.enquiry-btn {
    border-radius: 999px;
    padding: 12px;
    font-weight: 600;
    margin-top: 10px;
}

</style> 
@endsection

@section('content')

<!-- ======= HERO SECTION ======= -->
<section id="hero" class="hero-card-section py-3">
  <div class="container">
    <div class="hero-compact-card text-center mx-auto shadow-sm">
      
      <!-- Breadcrumb -->
      <nav aria-label="breadcrumb" class="d-flex justify-content-center mb-1 breadcrumb-section">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item">
            <a href="{{ url('/') }}"><i class="bi bi-house-door-fill me-1"></i>Home</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            Program Detail
          </li>
        </ol>
      </nav>
    </div>
  </div>
</section>

<!-- ======= SUCCESS CONTENT ======= -->
<section class="program-detail-section py-5">
  <div class="container">
    <div class="row gy-4 align-items-start">

     

      <!-- Left : Program Details -->
      <div class="col-lg-8  mb-4 mb-lg-0">
        <div class="program-info-box">

          <h4 class="mb-3 flexibility-title">Program Information</h4>
          <div class="rating-stars">
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
          </div>
          <ul class="program-info-list">

            <li>
              <span class="label">Name:</span>
              <span class="value">{{ $program->name }}</span>
            </li>
            <li>
              <span class="label">Price:</span>
               <span class="value price-text">${{ \App\Helpers\PriceHelper::format($program->price) }}</span>
               @if(!empty($program->regular_price) && $program->discount >= 1)
                <div class="regular-price mt-2 ml-2" style="margin-left:14px !important;">
                    <div class="strike">
                     ${{ \App\Helpers\PriceHelper::format($program->regular_price) }}
                    </div>
                    <div class="offer">
                     ({{ \App\Helpers\PriceHelper::format($program->discount) }} % Off)
                    </div>
                </div>
               @endif
            </li>
            <li>
              <span class="label">Subject:</span>
              <span class="value">{{ $program->branch->branch_name  }}</span>
            </li>
            <li>
              <span class="label">Year:</span>
              <span class="value">{{ $program->grade->grade_name }}</span>
            </li>
            <li>
              <span class="label">Description:</span>
              <span class="value">{{$program->program_detail}}</span>
            </li>
            <li>
              <span class="label">Outcome:</span>
              <span class="value">{{$program->outcome}}</span>
            </li>
            <li>
              <span class="label">Type:</span>
              <span class="value">{{ $program->program_type }}</span>
            <li>
              <span class="label">Total Sessions:</span>
              <span class="value">{{ $program->number_of_sessions }} hrs</span>
            </li>
            <li>
              <span class="label">Session Duration:</span>
              <span class="value">1 Hour</span>
            </li>
            </li>
              <span class="label">Validity:</span>
              <span class="value">{{ $program->validity }} Days</span>
            </li>
             <li>
              <span class="label">Mode of Delivery:</span>
              <span class="value">{{ $program->mode_of_delivery }}</span>
            </li>
            <li>
              <span class="label">Program Tutor:</span>
              <span class="value">{{ $program->program_tutor }}</span>
            </li>
            <li>
              <span class="label">Booking Method:</span>
              <span class="value">
                {{ $program->booking_method }}
              </span>
            </li>

           <li>
            <span class="label">Assessments:</span>
            <span class="value">
              @if(!empty($program->assessments) && is_array($program->assessments))

               @php
                  $assessmentLabels = [
                    'Diagnostic Assessment' => 'Diagnostic Assessment (Beginning of Program)',
                    'Micro Assessments'     => 'Micro-assessments (During & After Every Session)',
                    'Main Assessment'       => 'Main Assessment (End of Program)',
                  ];
              @endphp

              {!! collect($program->assessments)
                ->map(fn($item) => $assessmentLabels[$item] ?? $item)
                ->implode('<br>') !!}

              @else
                N/A
              @endif
            </span>
          </li>

          </ul>
          <div class="d-flex flex-column flex-md-row gap-3 mt-4">
           <a href="{{ route('cart.buyNow', $program->id) }}"
               class="btn btn-primary px-4 buy-now-btn w-100 flex-md-fill">
              Get Now
            </a>

           <a href="https://outlook.office.com/bookwithme/user/afc138ab2d934547a2160371735b38e9@afor.com.au/meetingtype/z6rInP8MT0iOAWyKLg5lFQ2?anonymous&ismsaljsauthenabled&ep=mcard"
            class="btn btn-primary px-4 buy-now-btn w-100 flex-md-fill" target="_blank">Meet Advisor</a>
          </div>
        </div>
      </div>

       <!-- Right : Program Feature Box -->
      <div class="col-lg-4">
        <div class="flexibility-content-box top-programs-box">

          <h4 class="flexibility-title">
            {{ $program->name }}
          </h4>

          <ul class="flexibility-list mt-3">
           @foreach($features as $feature)
            <li>
                <i class="bi {{ $feature['icon'] }}"></i>
                    {{ $feature['title'] }}
            </li>
            @endforeach

          </ul>

          <div class="d-flex flex-column flex-md-row gap-3 mt-4">
            <a href="{{ url()->previous() }}"
              class="btn btn-primary buy-now-btn w-100 flex-md-fill">
              Back
            </a>
            <a href="{{ route('cart.buyNow', $program->id) }}"
               class="btn btn-primary  buy-now-btn w-100 flex-md-fill">
              Get Now
            </a>
          </div>

        </div>
        
        <!-- Product Enquiry Box -->
        <div class="product-enquiry-box mt-4">
          <h4 class="mb-3 text-center flexibility-title">Program Enquiry</h4>
          <p class="mb-2 text-center">Share your details and we'll reach out shortly</p>
          <form id="enquiryFrm">
            <div class="form_area mb-3">
              <label>Your Name</label>
              <input type="text" name="name">
            </div>
            <div class="form_area mb-3">
              <label>Email Address</label>
              <input type="email" name="email">
            </div>
            <div class="form_area mb-3">
              <label>Phone Number</label>
              <input type="text" name="phone">
            </div>
            <input type="hidden" name="program_id" value="{{ $program->id }}">
            <input type="hidden" name="program_name" value="{{ $program->name }}">
            <input type="hidden" name="program_type" value="{{ $program->code }}">
            <button type="button" class="btn btn-primary w-100 enquiry-btn" id="enquirySubmitBtn">
              Request Callback
            </button>
          </form>
          <div id="enquirySuccessMessage" class="alert alert-success mt-3" style="display:none;"></div>

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
    <script>
$(document).ready(function () {

    $('#enquiryFrm').validate({
        rules: {
            name: {
                required: true,
                minlength: 3,
                maxlength: 50
            },
            email: {
                required: true,
                email: true
            },
        },
        messages: {
            name: {
                required: "Name is required",
                minlength: "Minimum 3 characters required"
            },
            email: {
                required: "Email is required",
                email: "Enter valid email address"
            },
        }
    });

    $("#enquirySubmitBtn").on("click", function () {

        if (!$('#enquiryFrm').valid()) return;

        $(".backend-error").remove();

        let btn = $(this);
        btn.prop("disabled", true).html(
            `<span class="spinner-border spinner-border-sm"></span> Sending...`
        );

        fetch("{{ route('program.enquiry') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            },
            body: new FormData(document.getElementById("enquiryFrm"))
        })
        .then(res => res.json())
        .then(data => {

            if (data.success) {

                $("#enquirySuccessMessage")
                    .text(data.message)
                    .fadeIn();

                setTimeout(() => 
                    $("#enquirySuccessMessage").fadeOut(), 3000
                );

                $('#enquiryFrm')[0].reset();
                $('#enquiryFrm').validate().resetForm();
                $('#enquiryFrm .error').removeClass('error');

            } 
            else if (data.errors) {

                $.each(data.errors, function (field, messages) {
                    let input = $('[name="' + field + '"]');
                    if (input.length) {
                        input.after(
                            `<label class="error backend-error">${messages[0]}</label>`
                        );
                    }
                });

            }

        })
        .catch(() => alert("Something went wrong"))
        .finally(() => {
            btn.prop("disabled", false).text("Send Enquiry");
        });

    });

});
</script>

@endsection
