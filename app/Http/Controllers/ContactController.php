<?php
namespace App\Http\Controllers;

use App\Models\{ContactMessage, Setting};
use App\Mail\ContactFormNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show()
    {
        return view('frontend.contact');
    }

    public function send(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $msg = ContactMessage::create([
            'name'    => $request->name,
            'email'   => $request->email,
            'phone'   => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        try {
            $adminEmail = Setting::get('admin_email', config('mail.from.address'));
            Mail::to($adminEmail)->send(new ContactFormNotification($msg));
        } catch (\Exception $e) {}

        return back()->with('success', 'Your message has been sent! We\'ll get back to you shortly.');
    }
}
