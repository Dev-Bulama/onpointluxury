<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;

class MessageController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::latest()->paginate(20);
        return view('admin.messages.index', compact('messages'));
    }

    public function show(ContactMessage $message)
    {
        $message->update(['is_read' => true]);
        return view('admin.messages.show', compact('message'));
    }

    public function markRead(ContactMessage $message)
    {
        $message->update(['is_read' => true]);
        return back()->with('success', 'Marked as read.');
    }

    public function destroy(ContactMessage $message)
    {
        $message->delete();
        return redirect()->route('admin.messages.index')->with('success', 'Message deleted.');
    }
}
