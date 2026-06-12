<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Menu, MenuItem, Page};
use Illuminate\Http\Request;

class MenuController extends Controller {
    public function index() {
        $menus = Menu::withCount('allItems')->get();
        return view('admin.menus.index', compact('menus'));
    }
    
    public function show(Menu $menu) {
        $menu->load(['items.children']);
        $pages = Page::where('is_published',true)->get();
        return view('admin.menus.show', compact('menu','pages'));
    }
    
    public function store(Request $request) {
        $request->validate(['name' => 'required','location' => 'required']);
        Menu::create($request->only('name','location','is_active'));
        return back()->with('success','Menu created.');
    }
    
    public function addItem(Request $request, Menu $menu) {
        $request->validate(['label' => 'required']);
        $menu->allItems()->create([
            'label' => $request->label,
            'url' => $request->url,
            'page_slug' => $request->page_slug,
            'parent_id' => $request->parent_id,
            'open_new_tab' => $request->boolean('open_new_tab'),
            'sort_order' => $request->sort_order ?? 0,
        ]);
        return back()->with('success','Menu item added.');
    }
    
    public function removeItem(MenuItem $item) {
        $item->delete();
        return back()->with('success','Menu item removed.');
    }
    
    public function destroy(Menu $menu) {
        $menu->delete();
        return redirect()->route('admin.menus.index')->with('success','Menu deleted.');
    }
}
