<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 0; }
.container { max-width: 600px; margin: 30px auto; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
.header { background: #1a1a2e; color: white; padding: 30px; text-align: center; }
.header h1 { margin: 0; font-size: 24px; }
.header p { margin: 5px 0 0; opacity: 0.8; }
.body { padding: 30px; }
.booking-ref { background: #f8f9fa; border-left: 4px solid #c9a84c; padding: 15px; margin-bottom: 25px; border-radius: 4px; }
.booking-ref strong { color: #c9a84c; font-size: 18px; }
.details-table { width: 100%; border-collapse: collapse; margin-bottom: 25px; }
.details-table td { padding: 10px; border-bottom: 1px solid #eee; }
.details-table td:first-child { color: #666; width: 40%; }
.details-table td:last-child { font-weight: bold; }
.total-row td { background: #1a1a2e; color: white; padding: 12px 10px; font-size: 16px; }
.footer { background: #f8f9fa; padding: 20px 30px; text-align: center; color: #666; font-size: 13px; }
.btn { display: inline-block; background: #c9a84c; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 15px 0; }
</style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Onpointluxury</h1>
        <p>Premium Apartment &amp; Hotel Bookings</p>
    </div>
    <div class="body">
        <h2 style="color:#1a1a2e;">Booking Confirmed!</h2>
        <p>Dear {{ $booking->customer_name }}, your booking has been confirmed. Here are your booking details:</p>

        <div class="booking-ref">
            <strong>Booking Reference: {{ $booking->booking_reference }}</strong>
        </div>

        <table class="details-table">
            <tr><td>Property</td><td>{{ $booking->property->name }}</td></tr>
            <tr><td>Location</td><td>{{ $booking->property->location }}</td></tr>
            <tr><td>Check-in</td><td>{{ $booking->check_in_date->format('D, d M Y') }} from {{ $booking->property->check_in_time }}</td></tr>
            <tr><td>Check-out</td><td>{{ $booking->check_out_date->format('D, d M Y') }} by {{ $booking->property->check_out_time }}</td></tr>
            <tr><td>Nights</td><td>{{ $booking->nights }}</td></tr>
            <tr><td>Guests</td><td>{{ $booking->guests }}</td></tr>
            <tr><td>Price per Night</td><td>&#8358;{{ number_format($booking->price_per_night, 2) }}</td></tr>
            @if($booking->tax > 0)
            <tr><td>Tax</td><td>&#8358;{{ number_format($booking->tax, 2) }}</td></tr>
            @endif
            @if($booking->service_charge > 0)
            <tr><td>Service Charge</td><td>&#8358;{{ number_format($booking->service_charge, 2) }}</td></tr>
            @endif
            <tr class="total-row"><td>Total Amount</td><td>&#8358;{{ number_format($booking->total_amount, 2) }}</td></tr>
        </table>

        @if($booking->special_request)
        <p><strong>Special Request:</strong> {{ $booking->special_request }}</p>
        @endif

        <p style="color:#666;">For any queries, please contact us via WhatsApp or email. We look forward to hosting you!</p>

        <center><a href="{{ url('/booking/' . $booking->id . '/confirmation') }}" class="btn">View Booking Details</a></center>
    </div>
    <div class="footer">
        <p>Onpointluxury &mdash; Premium Living Experiences</p>
        <p>This is an automated email. Please do not reply directly.</p>
    </div>
</div>
</body>
</html>
