<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Booking, Property, User};
use Illuminate\Http\Request;

class BookingController extends Controller {
    public function index(Request $request) {
        $query = Booking::with(['property','user']);
        if ($request->search) {
            $query->where('booking_reference','like','%'.$request->search.'%')
                  ->orWhere('customer_name','like','%'.$request->search.'%')
                  ->orWhere('customer_email','like','%'.$request->search.'%');
        }
        if ($request->status) $query->where('booking_status', $request->status);
        if ($request->payment_status) $query->where('payment_status', $request->payment_status);
        $bookings = $query->latest()->paginate(20);
        return view('admin.bookings.index', compact('bookings'));
    }
    
    public function show(Booking $booking) {
        $booking->load(['property','user','room','payments']);
        return view('admin.bookings.show', compact('booking'));
    }
    
    public function updateStatus(Request $request, Booking $booking) {
        $request->validate(['booking_status' => 'required']);
        $booking->update(['booking_status' => $request->booking_status]);
        return back()->with('success','Booking status updated.');
    }
    
    public function create() {
        $properties = Property::where('status','published')->get();
        return view('admin.bookings.create', compact('properties'));
    }
    
    public function store(Request $request) {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'customer_name' => 'required',
            'customer_email' => 'required|email',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
            'guests' => 'required|integer|min:1',
        ]);
        
        $property = Property::findOrFail($request->property_id);
        $nights = \Carbon\Carbon::parse($request->check_in_date)->diffInDays($request->check_out_date);
        $pricePerNight = $property->effective_price;
        $subtotal = $pricePerNight * $nights;
        
        $taxPercent = \App\Models\Setting::get('tax_percentage', 0);
        $serviceCharge = \App\Models\Setting::get('service_charge', 0);
        $tax = ($subtotal * $taxPercent) / 100;
        $total = $subtotal + $tax + $serviceCharge;
        
        Booking::create([
            'property_id' => $request->property_id,
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'nights' => $nights,
            'guests' => $request->guests,
            'price_per_night' => $pricePerNight,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'service_charge' => $serviceCharge,
            'total_amount' => $total,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'special_request' => $request->special_request,
            'booking_status' => $request->booking_status ?? 'confirmed',
            'payment_status' => 'pending',
            'source' => 'admin',
        ]);
        
        return redirect()->route('admin.bookings.index')->with('success','Booking created.');
    }
}
