<!DOCTYPE html>
<html>
<head>
    <title>V-Tutor Academic Program Purchase Successful</title>
</head>
<body style="font-family: Arial, sans-serif;">

    <h2>Hi {{ $name }},</h2>

    <p>
        Thank you for your purchase on <strong>V-Tutor</strong>.
        Your payment has been completed successfully.
    </p>

    <p>
        <strong>Order ID:</strong> {{ $order_id }}
    </p>

    <h3>Purchased Items</h3>

    <table width="100%" border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse;">
        <thead>
            <tr>
                <th align="left">Program</th>
                <th align="center">Qty</th>
                <th align="right">Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td align="center">{{ $item['qty'] }}</td>
                    <td align="right">AUD {{ number_format($item['price'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br>

    <!-- PAYMENT SUMMARY -->
    <table width="100%" cellpadding="6" cellspacing="0">
        <tr>
            <td align="right">Subtotal:</td>
            <td align="right">AUD {{ number_format($subTotal, 2) }}</td>
        </tr>
        <tr>
            <td align="right">GST (10%):</td>
            <td align="right">AUD {{ number_format($gst, 2) }}</td>
        </tr>
        <tr>
            <td align="right"><strong>Total Paid:</strong></td>
            <td align="right"><strong>AUD {{ number_format($total, 2) }}</strong></td>
        </tr>
    </table>

    <p style="margin-top:15px;">
        This amount is inclusive of GST as per Australian tax regulations.
    </p>
    
    <p style="font-family:Arial; font-size:14px; font-weight:500; color:#363839;margin: 0 0 10px 0;">Thanks and Regards</p>
    <p style="font-family:Arial; font-size:14px; font-weight:500; color:#363839;margin: 0 0 10px 0;">Team V-Tutor</p>
    <p style="font-family:Arial; font-size:14px; font-weight:500; color:#363839;margin: 0 0 10px 0;">
        <a href="{{ url('/') }}">{{ url('/') }}</a>
    </p>

    <p style="font-style: italic !important;font-size:13px;">
        This email and its attachments are confidential and intended only for the named recipient.
        If you received this message in error, please notify us immediately and delete it.
    </p>

</body>
</html>
