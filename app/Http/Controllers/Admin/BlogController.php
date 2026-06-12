<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller {
    public function index() {
        $posts = BlogPost::latest()->paginate(15);
        return view('admin.blog.index', compact('posts'));
    }
    
    public function create() {
        return view('admin.blog.create');
    }
    
    public function store(Request $request) {
        $request->validate(['title' => 'required','content' => 'required']);
        $data = $request->except(['_token','featured_image']);
        $data['slug'] = Str::slug($request->title) . '-' . Str::random(4);
        $data['user_id'] = auth()->id();
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('blog','public');
        }
        if ($request->is_published) $data['published_at'] = now();
        BlogPost::create($data);
        return redirect()->route('admin.blog.index')->with('success','Blog post created.');
    }
    
    public function edit(BlogPost $blog) {
        return view('admin.blog.edit', compact('blog'));
    }
    
    public function update(Request $request, BlogPost $blog) {
        $request->validate(['title' => 'required','content' => 'required']);
        $data = $request->except(['_token','_method','featured_image']);
        if ($request->hasFile('featured_image')) {
            if ($blog->featured_image) Storage::disk('public')->delete($blog->featured_image);
            $data['featured_image'] = $request->file('featured_image')->store('blog','public');
        }
        if ($request->is_published && !$blog->published_at) $data['published_at'] = now();
        $blog->update($data);
        return redirect()->route('admin.blog.index')->with('success','Blog post updated.');
    }
    
    public function destroy(BlogPost $blog) {
        if ($blog->featured_image) Storage::disk('public')->delete($blog->featured_image);
        $blog->delete();
        return redirect()->route('admin.blog.index')->with('success','Blog post deleted.');
    }
}
