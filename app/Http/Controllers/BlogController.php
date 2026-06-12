<?php
namespace App\Http\Controllers;

use App\Models\BlogPost;

class BlogController extends Controller
{
    public function index()
    {
        $posts = BlogPost::with('author')
            ->where('status', 'published')
            ->latest('published_at')
            ->paginate(9);
        return view('frontend.blog.index', compact('posts'));
    }

    public function show($slug)
    {
        $post = BlogPost::with('author')
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $related = BlogPost::where('id', '!=', $post->id)
            ->where('status', 'published')
            ->latest('published_at')
            ->take(3)->get();

        return view('frontend.blog.show', compact('post', 'related'));
    }
}
