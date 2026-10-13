<table class="table table-bordered">
<thead>
<tr>
<th>#</th>
<th>Booking Date</th>
<th>Session</th>
<th>Status</th>
<th>Tutor Amount</th>
<th>Commission</th>
<th>Deduction</th>
<th>Final Tutor Pay</th>
</tr>
</thead>
<tbody>
@foreach($rows as $i => $p)

@php
    $price = $p->tutor_amount + $p->commission_amount;
    $ded = 0;
    $booking = Carbon\Carbon::parse($p->created_at);
    $session = $p->booking_date ? Carbon\Carbon::parse($p->booking_date) : null;
    $cancel = $p->updated_at ?? $booking;

    if($p->booking_status != 1) {
        if ($booking->diffInMinutes($cancel) <= 30) $refund = $price;
        else {
            if (!$session) $refund = $price;
            else {
                $hrs = $cancel->floatDiffInHours($session,false);
                if ($hrs > 24) $refund = $price;
                elseif ($hrs >= 6) $refund = $price * 0.50;
                else $refund = 0;
            }
        }
        $ded = round($refund * 0.70,2);
    }
@endphp

<tr>
<td>{{ $i+1 }}</td>
<td>{{ $p->created_at }}</td>
<td>{{ $p->booking_date }}</td>
<td>{{ $p->booking_status == 1 ? "Completed":"Cancelled" }}</td>
<td>${{ number_format($p->tutor_amount,2) }}</td>
<td>${{ number_format($p->commission_amount,2) }}</td>
<td>${{ number_format($ded,2) }}</td>
<td>${{ number_format(max(0,$p->tutor_amount - $ded),2) }}</td>
</tr>
@endforeach
</tbody>
</table>
