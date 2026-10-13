@extends('admin.layouts.app')

@section('title','Tutor Payouts')

@section('links')
@include('admin.includes.links')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
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
        <div class="col-sm-12">
            <h1 class="page-title">Tutor Weekly Payouts</h1>
        </div>
    </div>

    {{-- ✅ Commission & Filter Bar --}}



  @include('admin.includes.message')


   <style>
    .pay-btn {
        padding: 12px 40px; 
        font-size: 18px;
    }
    .form-section {
        margin-bottom: 20px;
    }
</style>

<form id="payoutForm" method="POST" action="{{ route('admin.payouts.pay') }}">
@csrf

<!-- Row 1 -->
<div class="row form-section">

    <div class="col-md-4">
        <label>Pay From</label>
        <input type="date" name="from_date" id="from_date" class="form-control" value="{{ $from }}" required>  
    </div>

    <div class="col-md-4">
        <label>Pay To</label>
        <input type="date" name="to_date" id="to_date" class="form-control" value="{{ $to }}" required>
    </div>

    <div class="col-md-4">
        <label>Select Tutor</label>
        <select name="tutor_id" id="tutor_id" class="form-control">
            <option value="">-- Select Tutor --</option>
            @foreach($eligibleTutors as $t)
                <option value="{{ $t->tutor_id }}">
                  {{ $t->unique_id }} -{{ $t->f_name }} {{ $t->l_name }}
                </option>
            @endforeach
        </select>
    </div>

</div>

<!-- Row 2 -->
<div class="row form-section">

    <div class="col-md-4">
        <label>Tutor ID</label>
        <input type="text" id="display_tutor_uid" class="form-control" readonly>
    </div>
   <div class="col-md-4">
    <label>Tutor Name</label>
    <input type="text" id="display_tutor_name" class="form-control" readonly>
</div>
    <div class="col-md-4">
        <label>Payment Date</label>
        <input type="date" name="from_date" id="from_date" class="form-control" value=" " required>  
    </div>
  </div>
<div class="row form-section">
    <div class="col-md-4">
        <label>Gross Pay</label>
        <input type="text" name="gross_pay" id="gross_pay" class="form-control" readonly>
    </div>



<!-- Row 3 -->


    <div class="col-md-4">
        <label>Commission</label>
        <input type="text" name="commission" id="commission" class="form-control" readonly>
    </div>

    <div class="col-md-4">
        <label>Deductions</label>
        <input type="text" name="deductions" id="deductions" class="form-control" value="0.00" readonly>
    </div>
  </div>
<div class="row form-section">
    <div class="col-md-4">
        <label>Net Pay</label>
        <input type="text" name="net_pay" id="net_pay" class="form-control" readonly>
    </div>

</div>

<!-- Center Button -->
<div class="text-center mt-4">
    <button id="payBtn" type="submit" class="btn btn-primary pay-btn" disabled>
        Pay Tutor
    </button>
</div>

</form>



    {{-- Summary Table for all tutors in the window (with payable data) --}}
    <div class="panel panel-default">
      <div class="panel-heading"><strong>Payout Summary (Not Settled)</strong></div>
      <div class="panel-body">
        @if($summary->count())
          <div class="table-responsive">
            <table class="table table-bordered table-striped">
              <thead style="background:#f7f7f7;">
                <tr>
                  <th>Tutor ID</th>
                  <th>Tutor Name</th>
                  <th>Pay From</th>
                  <th>Pay To</th>
                  <th>Payment Date</th>
                  <th>Gross Pay</th>
                  <th>Commission</th>
                  <th>Deductions</th>
                  <th>Net Pay</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              @foreach($summary as $row)
                <tr>
                  <td>{{ $row->unique_id }}</td>
                  <td>{{ $row->f_name }} {{ $row->l_name }}</td>
                  <td>{{ $from }}</td>
                  <td>{{ $to }}</td>
                  <td>—</td>
                  <td>{{ number_format($row->gross_pay, 2) }}</td>
                  <td>{{ number_format($row->commission, 2) }}</td>
                  <td>{{ number_format($row->deductions, 2) }}</td>
                  <td>{{ number_format($row->net_pay, 2) }}</td>
                  <td>
                    <button class="btn btn-sm btn-info view-details"
                            data-tutor="{{ $row->tutor_id }}"
                            data-from="{{ $from }}"
                            data-to="{{ $to }}">
                      View Details
                    </button>
                  </td>
                </tr>
              @endforeach
              </tbody>
            </table>
          </div>
        @else
          <div class="alert alert-info">No payable rows found for the selected dates.</div>
        @endif
      </div>
    </div>

  </div>
</div>

{{-- Details Modal --}}
<div class="modal fade" id="payoutDetailsModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document" style="width: 95%;">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Booking Details</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                style="border:none;background:transparent;font-size:28px;line-height:1;">
          &times;
        </button>
      </div>
      <div class="modal-body" id="payout-details-body">
        <div class="text-center p-3">Loading…</div>
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
<script>
(function() {

  // Reload table when dates change
  function reloadWithDates() {
    const from = document.getElementById('from_date').value;
    const to   = document.getElementById('to_date').value;

    const url  = new URL(window.location.href);
    url.searchParams.set('from_date', from);
    url.searchParams.set('to_date', to);
    url.searchParams.delete('tutor_id'); // reset tutor filter

    window.location.href = url.toString();
  }

  document.getElementById('from_date').addEventListener('change', reloadWithDates);
  document.getElementById('to_date').addEventListener('change', reloadWithDates);

  const tutorSelect = document.getElementById('tutor_id');
  const payBtn = document.getElementById('payBtn');

  tutorSelect.addEventListener('change', function() {

    payBtn.disabled = true;

    const tutorId = this.value;
    const from = document.getElementById('from_date').value;
    const to   = document.getElementById('to_date').value;

    // Reset all fields
    document.getElementById('display_tutor_uid').value = '';
    document.getElementById('display_tutor_name').value = '';
    document.getElementById('gross_pay').value = '';
    document.getElementById('commission').value = '';
    document.getElementById('deductions').value = '0.00';
    document.getElementById('net_pay').value = '';

    if(!tutorId) return;

    const url = `{{ route('admin.payouts.tutorTotals') }}?from_date=${encodeURIComponent(from)}&to_date=${encodeURIComponent(to)}&tutor_id=${encodeURIComponent(tutorId)}`;

    fetch(url)
      .then(r => r.json())
      .then(res => {

        console.log("API Response:", res); // ✅ Debug output

        if(!res.ok) return;

        // Tutor info
        document.getElementById('display_tutor_uid').value  = res?.tutor?.unique_id ?? '';
        document.getElementById('display_tutor_name').value = `${res?.tutor?.f_name ?? ''} ${res?.tutor?.l_name ?? ''}`.trim();

        // Fallback key options (in case backend names differ)
        const gross     = res.gross_pay     ?? res.total_amount     ?? 0;
        const commission= res.commission    ?? res.fee              ?? 0;
        const deductions= res.deductions    ?? 0;
        const net       = res.net_pay       ?? res.final_amount     ?? 0;

        // Set values
        document.getElementById('gross_pay').value  = Number(gross).toFixed(2);
        document.getElementById('commission').value = Number(commission).toFixed(2);
        document.getElementById('deductions').value = Number(deductions).toFixed(2);
        document.getElementById('net_pay').value    = Number(net).toFixed(2);

        // Enable button only if payable
        payBtn.disabled = Number(net) <= 0;
      })
      .catch(err => {
        console.error("Fetch Error:", err);
      });

  });
(function () {

  function reloadWithDates() {
    const from = document.getElementById('from_date').value;
    const to   = document.getElementById('to_date').value;

    const url  = new URL(window.location.href);
    url.searchParams.set('from_date', from);
    url.searchParams.set('to_date', to);
    url.searchParams.delete('tutor_id');

    window.location.href = url.toString();
  }

  document.getElementById('from_date').addEventListener('change', reloadWithDates);
  document.getElementById('to_date').addEventListener('change', reloadWithDates);

  const tutorSelect = document.getElementById('tutor_id');
  const payBtn      = document.getElementById('payBtn');

  tutorSelect.addEventListener('change', function () {

    payBtn.disabled = true;

    const tutorId = this.value;
    const from    = document.getElementById('from_date').value;
    const to      = document.getElementById('to_date').value;

    // Clear fields
    document.getElementById('display_tutor_uid').value  = '';
    document.getElementById('display_tutor_name').value = '';
    document.getElementById('gross_pay').value          = '';
    document.getElementById('commission').value         = '';
    document.getElementById('deductions').value         = '0.00';
    document.getElementById('net_pay').value            = '';

    if (!tutorId) return;

    const url = `{{ route('admin.payouts.tutorTotals') }}?from_date=${encodeURIComponent(from)}&to_date=${encodeURIComponent(to)}&tutor_id=${encodeURIComponent(tutorId)}`;

    fetch(url)
      .then(res => res.json())
      .then(res => {

        console.log("Debug API Response:", res); // ✅ See values in console

        if (!res.ok) return;

        // Tutor Information
        document.getElementById('display_tutor_uid').value  = res.tutor?.unique_id ?? '';
        document.getElementById('display_tutor_name').value = `${res.tutor?.f_name ?? ""} ${res.tutor?.l_name ?? ""}`.trim();

        // Amounts (ensure numbers before toFixed)
        document.getElementById('gross_pay').value  = Number(res.gross_pay).toFixed(2);
        document.getElementById('commission').value = Number(res.commission).toFixed(2);
        document.getElementById('deductions').value = Number(res.deductions).toFixed(2);
        document.getElementById('net_pay').value    = Number(res.net_pay).toFixed(2);

        // Enable Pay button only if net_pay > 0
        payBtn.disabled = Number(res.net_pay) <= 0;
      })
      .catch(err => console.error("Fetch Error:", err));
  });



  // View Details button → modal
  document.addEventListener('click', function(e) {
    if (!e.target.classList.contains('view-details')) return;

    const btn  = e.target;
    const id   = btn.getAttribute('data-tutor');
    const from = btn.getAttribute('data-from');
    const to   = btn.getAttribute('data-to');

    const body = document.getElementById('payout-details-body');
    body.innerHTML = '<div class="text-center p-3">Loading…</div>';

    const url = `{{ url('admin/tutor-payouts/details') }}/${id}?from_date=${encodeURIComponent(from)}&to_date=${encodeURIComponent(to)}`;

    fetch(url).then(r => r.text()).then(html => {
      body.innerHTML = html;
      $('#payoutDetailsModal').modal('show');
    }).catch(() => {
      body.innerHTML = '<div class="text-danger p-3">Failed to load details.</div>';
      $('#payoutDetailsModal').modal('show');
    });
  });

});
})();
</script>
@endsection