<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroSlideController extends Controller
{
    public function index()
    {
        $slides = HeroSlide::orderBy('sort_order')->get();
        return view('admin.hero-slides.index', compact('slides'));
    }

    public function create()
    {
        $slide = new HeroSlide(['focal_position' => 'center', 'is_active' => true, 'sort_order' => HeroSlide::max('sort_order') + 1]);
        return view('admin.hero-slides.create', compact('slide'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        if ($request->hasFile('desktop_image')) {
            $data['desktop_image'] = $request->file('desktop_image')->store('hero', 'public');
        } elseif ($request->filled('desktop_image_url')) {
            $data['desktop_image'] = $request->input('desktop_image_url');
        }

        if ($request->hasFile('mobile_image')) {
            $data['mobile_image'] = $request->file('mobile_image')->store('hero', 'public');
        }

        if (!isset($data['sort_order'])) {
            $data['sort_order'] = HeroSlide::max('sort_order') + 1;
        }

        HeroSlide::create($data);

        return redirect()->route('admin.hero-slides.index')->with('success', 'Hero slide created successfully.');
    }

    public function edit(HeroSlide $heroSlide)
    {
        $slide = $heroSlide;
        return view('admin.hero-slides.edit', compact('slide'));
    }

    public function update(Request $request, HeroSlide $heroSlide)
    {
        $data = $this->validated($request);

        if ($request->hasFile('desktop_image')) {
            $this->deleteFile($heroSlide->desktop_image);
            $data['desktop_image'] = $request->file('desktop_image')->store('hero', 'public');
        } elseif ($request->filled('desktop_image_url')) {
            $data['desktop_image'] = $request->input('desktop_image_url');
        }

        if ($request->hasFile('mobile_image')) {
            $this->deleteFile($heroSlide->mobile_image);
            $data['mobile_image'] = $request->file('mobile_image')->store('hero', 'public');
        } elseif ($request->boolean('clear_mobile_image')) {
            $this->deleteFile($heroSlide->mobile_image);
            $data['mobile_image'] = null;
        }

        $heroSlide->update($data);

        return redirect()->route('admin.hero-slides.index')->with('success', 'Hero slide updated.');
    }

    public function destroy(HeroSlide $heroSlide)
    {
        $this->deleteFile($heroSlide->desktop_image);
        $this->deleteFile($heroSlide->mobile_image);
        $heroSlide->delete();
        return redirect()->route('admin.hero-slides.index')->with('success', 'Slide deleted.');
    }

    public function reorder(Request $request)
    {
        foreach ($request->input('order', []) as $sort => $id) {
            HeroSlide::where('id', (int)$id)->update(['sort_order' => (int)$sort]);
        }
        return response()->json(['success' => true]);
    }

    public function toggleActive(HeroSlide $heroSlide)
    {
        $heroSlide->update(['is_active' => !$heroSlide->is_active]);
        return response()->json(['is_active' => $heroSlide->is_active]);
    }

    private function validated(Request $request): array
    {
        $rules = [
            'badge'          => 'nullable|string|max:120',
            'headline'       => 'required|string|max:255',
            'description'    => 'nullable|string|max:500',
            'cta1_text'      => 'required|string|max:60',
            'cta1_url'       => 'required|string|max:255',
            'cta2_text'      => 'nullable|string|max:60',
            'cta2_url'       => 'nullable|string|max:255',
            'alt_text'       => 'nullable|string|max:255',
            'focal_position' => 'nullable|in:center,top,bottom,left,right',
            'sort_order'     => 'nullable|integer|min:0',
            'desktop_image_url' => 'nullable|url|max:500',
        ];

        $data = $request->validate($rules);
        $data['is_active'] = $request->boolean('is_active');
        unset($data['desktop_image_url']);

        return $data;
    }

    private function deleteFile(?string $path): void
    {
        if ($path && !str_starts_with($path, 'http')) {
            Storage::disk('public')->delete($path);
        }
    }
}
