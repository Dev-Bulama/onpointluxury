<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller {
    public function index() {
        $testimonials = Testimonial::orderBy('sort_order')->paginate(20);
        return view('admin.testimonials.index', compact('testimonials'));
    }
    
    public function store(Request $request) {
        $request->validate(['name' => 'required','comment' => 'required']);
        $data = $request->except(['_token','avatar']);
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('testimonials','public');
        }
        Testimonial::create($data);
        return back()->with('success','Testimonial created.');
    }
    
    public function destroy(Testimonial $testimonial) {
        if ($testimonial->avatar) Storage::disk('public')->delete($testimonial->avatar);
        $testimonial->delete();
        return back()->with('success','Testimonial deleted.');
    }
}
