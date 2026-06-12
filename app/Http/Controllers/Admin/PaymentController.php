<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller {
    public function index(Request $request) {
        $query = Payment::with(['booking.property','user']);
        if ($request->status) $query->where('status', $request->status);
        $payments = $query->latest()->paginate(20);
        $totalRevenue = Payment::where('status','success')->sum('amount');
        return view('admin.payments.index', compact('payments','totalRevenue'));
    }
    
    public function show(Payment $payment) {
        $payment->load(['booking.property','user']);
        return view('admin.payments.show', compact('payment'));
    }
}
