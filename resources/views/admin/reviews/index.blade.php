@extends('layouts.admin')
@section('title','Reviews') @section('page-title','Property Reviews')
@section('content')
<div class="mb-5">
<form method="GET" class="flex gap-3">
<select name="status" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
<option value="">All Status</option>
<option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
<option value="approved" {{ request('status')=='approved'?'selected':'' }}>Approved</option>
<option value="rejected" {{ request('status')=='rejected'?'selected':'' }}>Rejected</option>
</select>
<button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-lg text-sm">Filter</button>
</form>
</div>
<div class="space-y-4">
@forelse($reviews as $review)
<div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
<div class="flex items-start justify-between flex-wrap gap-3">
<div class="flex-1">
<div class="flex items-center gap-2 mb-1">
<p class="font-semibold text-sm">{{ $review->reviewer_name ?? $review->user?->name ?? 'Anonymous' }}</p>
<div class="flex">@for($i=1;$i<=5;$i++)<i class="fas fa-star text-xs {{ $i<=$review->rating?'text-amber-400':'text-gray-200' }}"></i>@endfor</div>
<span class="text-xs px-2 py-0.5 {{ $review->status==='approved'?'bg-green-100 text-green-700':($review->status==='rejected'?'bg-red-100 text-red-700':'bg-yellow-100 text-yellow-700') }} rounded-full capitalize">{{ $review->status }}</span>
</div>
<p class="text-sm text-gray-500 mb-1">On: <strong>{{ $review->property->name }}</strong></p>
<p class="text-sm text-gray-700">{{ $review->comment }}</p>
</div>
<div class="flex items-center gap-2">
@if($review->status !== 'approved')
<form method="POST" action="{{ route('admin.reviews.approve',$review) }}">@csrf
<button type="submit" class="bg-green-600 text-white px-3 py-1.5 rounded-lg text-xs hover:bg-green-700">Approve</button>
</form>
@endif
@if($review->status !== 'rejected')
<form method="POST" action="{{ route('admin.reviews.reject',$review) }}">@csrf
<button type="submit" class="bg-gray-500 text-white px-3 py-1.5 rounded-lg text-xs hover:bg-gray-600">Reject</button>
</form>
@endif
<form method="POST" action="{{ route('admin.reviews.destroy',$review) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')
<button type="submit" class="text-red-400 hover:text-red-600 text-sm"><i class="fas fa-trash"></i></button>
</form>
</div>
</div>
</div>
@empty
<div class="bg-white rounded-xl p-12 text-center text-gray-400 shadow-sm border border-gray-100">No reviews found</div>
@endforelse
</div>
<div class="mt-4">{{ $reviews->links() }}</div>
@endsection
