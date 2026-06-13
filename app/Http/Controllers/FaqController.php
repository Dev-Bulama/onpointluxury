<?php
namespace App\Http\Controllers;

use App\Models\Faq;

class FaqController extends Controller
{
    public function index()
    {
        $grouped = Faq::where('is_active', true)->orderBy('sort_order')->get()->groupBy('category');
        $faqs = $grouped->flatten();
        return view('frontend.faq', compact('faqs', 'grouped'));
    }
}
