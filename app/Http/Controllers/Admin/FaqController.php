<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller {
    public function index() {
        $faqs = Faq::orderBy('sort_order')->paginate(20);
        return view('admin.faqs.index', compact('faqs'));
    }
    
    public function store(Request $request) {
        $request->validate(['question' => 'required','answer' => 'required']);
        Faq::create($request->only('question','answer','category','sort_order','is_active'));
        return back()->with('success','FAQ created.');
    }
    
    public function update(Request $request, Faq $faq) {
        $faq->update($request->only('question','answer','category','sort_order','is_active'));
        return back()->with('success','FAQ updated.');
    }
    
    public function destroy(Faq $faq) {
        $faq->delete();
        return back()->with('success','FAQ deleted.');
    }
}
