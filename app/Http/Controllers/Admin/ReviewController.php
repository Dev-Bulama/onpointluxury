<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller {
    public function index(Request $request) {
        $query = Review::with(['property','user']);
        if ($request->status) $query->where('status', $request->status);
        $reviews = $query->latest()->paginate(20);
        return view('admin.reviews.index', compact('reviews'));
    }
    
    public function approve(Review $review) {
        $review->update(['status' => 'approved']);
        $property = $review->property;
        $avgRating = $property->reviews()->avg('rating');
        $count = $property->reviews()->count();
        $property->update(['rating' => round($avgRating, 2), 'review_count' => $count]);
        return back()->with('success','Review approved.');
    }
    
    public function reject(Review $review) {
        $review->update(['status' => 'rejected']);
        return back()->with('success','Review rejected.');
    }
    
    public function destroy(Review $review) {
        $review->delete();
        return back()->with('success','Review deleted.');
    }
}
