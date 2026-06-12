<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller {
    public function index() {
        $pages = Page::with('parent')->orderBy('sort_order')->paginate(20);
        return view('admin.pages.index', compact('pages'));
    }
    
    public function create() {
        $pages = Page::whereNull('parent_id')->get();
        return view('admin.pages.create', compact('pages'));
    }
    
    public function store(Request $request) {
        $request->validate(['title' => 'required']);
        $data = $request->except(['_token']);
        $data['slug'] = $request->slug ?? Str::slug($request->title);
        $data['is_published'] = $request->boolean('is_published');
        Page::create($data);
        return redirect()->route('admin.pages.index')->with('success','Page created.');
    }
    
    public function edit(Page $page) {
        $pages = Page::whereNull('parent_id')->where('id','!=',$page->id)->get();
        return view('admin.pages.edit', compact('page','pages'));
    }
    
    public function update(Request $request, Page $page) {
        $request->validate(['title' => 'required']);
        $data = $request->except(['_token','_method']);
        $data['is_published'] = $request->boolean('is_published');
        $page->update($data);
        return redirect()->route('admin.pages.index')->with('success','Page updated.');
    }
    
    public function destroy(Page $page) {
        $page->delete();
        return redirect()->route('admin.pages.index')->with('success','Page deleted.');
    }
}
