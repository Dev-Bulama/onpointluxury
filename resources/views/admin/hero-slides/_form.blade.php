<div class="grid lg:grid-cols-3 gap-6">

    {{-- Left / main --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Images --}}
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <h3 class="font-semibold text-gray-800 mb-4 pb-2 border-b">Slide Images</h3>

            {{-- Desktop image --}}
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-2">Desktop / Main Image</label>
                @if($slide->desktop_image_url && $slide->exists)
                <div class="relative mb-3 group w-full h-40 rounded-xl overflow-hidden bg-gray-100">
                    <img src="{{ $slide->desktop_image_url }}" class="w-full h-full object-cover" alt="Current desktop image">
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-white text-xs font-medium">
                        Upload below to replace
                    </div>
                </div>
                @endif
                <div class="grid sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Upload file</label>
                        <input type="file" name="desktop_image" accept="image/*"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm file:mr-2 file:py-1 file:px-3 file:rounded file:border-0 file:bg-blue-50 file:text-blue-700 file:text-xs">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Or paste image URL (Unsplash, etc.)</label>
                        <input type="url" name="desktop_image_url" placeholder="https://images.unsplash.com/..."
                               value="{{ $slide->exists && str_starts_with($slide->desktop_image ?? '', 'http') ? $slide->desktop_image : '' }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    </div>
                </div>
                <p class="text-xs text-gray-400 mt-1.5">Recommended: 1920×1080px or wider. JPEG/WebP preferred. Under 1.5MB ideal.</p>
            </div>

            {{-- Mobile image --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Mobile Image <span class="text-gray-400 font-normal">(optional — uses desktop image if not set)</span></label>
                @if($slide->mobile_image && $slide->exists)
                <div class="flex items-start gap-3 mb-3">
                    <div class="w-24 h-16 rounded-lg overflow-hidden bg-gray-100 flex-shrink-0">
                        <img src="{{ $slide->mobile_image_url }}" class="w-full h-full object-cover" alt="Mobile image">
                    </div>
                    <label class="flex items-center gap-2 mt-2 cursor-pointer">
                        <input type="checkbox" name="clear_mobile_image" value="1" class="w-4 h-4 text-red-500 rounded">
                        <span class="text-sm text-red-600">Remove mobile image (use desktop image on mobile)</span>
                    </label>
                </div>
                @endif
                <input type="file" name="mobile_image" accept="image/*"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm file:mr-2 file:py-1 file:px-3 file:rounded file:border-0 file:bg-gray-50 file:text-gray-700 file:text-xs">
                <p class="text-xs text-gray-400 mt-1.5">Recommended: 768×1024px portrait crop. For close-up on key image area.</p>
            </div>
        </div>

        {{-- Image settings --}}
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <h3 class="font-semibold text-gray-800 mb-4 pb-2 border-b">Image Display Settings</h3>
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Focal / Anchor Position</label>
                    <select name="focal_position" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        @foreach(['center'=>'Center (default)','top'=>'Top','bottom'=>'Bottom','left'=>'Left','right'=>'Right'] as $val=>$label)
                        <option value="{{ $val }}" {{ old('focal_position', $slide->focal_position ?? 'center') === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-400 mt-1">Controls which part of the image stays visible when cropped on different screens.</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Image Alt Text <span class="text-gray-400 font-normal">(for accessibility &amp; SEO)</span></label>
                    <input type="text" name="alt_text" placeholder="e.g. Modern luxury apartment living room in Lagos"
                           value="{{ old('alt_text', $slide->alt_text) }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                </div>
            </div>
        </div>

        {{-- Slide content --}}
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <h3 class="font-semibold text-gray-800 mb-4 pb-2 border-b">Slide Content</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Badge / Eyebrow Text <span class="text-gray-400 font-normal">(small text above headline — optional)</span></label>
                    <input type="text" name="badge" maxlength="120"
                           placeholder="e.g. PREMIUM LIVING, PERFECTLY BOOKED"
                           value="{{ old('badge', $slide->badge) }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Headline <span class="text-red-400">*</span></label>
                    <input type="text" name="headline" maxlength="255" required
                           placeholder="e.g. Explore. Discover. Live."
                           value="{{ old('headline', $slide->headline) }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    <p class="text-xs text-gray-400 mt-1">Keep this short and punchy (3–8 words ideal). Use | to split into two lines.</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description <span class="text-gray-400 font-normal">(optional)</span></label>
                    <textarea name="description" maxlength="500" rows="2"
                              placeholder="A short supporting sentence about this slide..."
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">{{ old('description', $slide->description) }}</textarea>
                </div>
            </div>
        </div>

        {{-- CTAs --}}
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <h3 class="font-semibold text-gray-800 mb-4 pb-2 border-b">Call-to-Action Buttons</h3>
            <div class="grid sm:grid-cols-2 gap-4">
                <div class="space-y-3 p-3 bg-amber-50 rounded-lg border border-amber-100">
                    <p class="text-xs font-semibold text-amber-700 uppercase tracking-wide">Primary Button (amber)</p>
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Button Label <span class="text-red-400">*</span></label>
                        <input type="text" name="cta1_text" required maxlength="60"
                               placeholder="Explore Properties"
                               value="{{ old('cta1_text', $slide->cta1_text ?? 'Explore Properties') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">URL / Link <span class="text-red-400">*</span></label>
                        <input type="text" name="cta1_url" required maxlength="255"
                               placeholder="/properties"
                               value="{{ old('cta1_url', $slide->cta1_url ?? '/properties') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    </div>
                </div>
                <div class="space-y-3 p-3 bg-gray-50 rounded-lg border border-gray-100">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Secondary Button (outline) — optional</p>
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Button Label</label>
                        <input type="text" name="cta2_text" maxlength="60"
                               placeholder="Book Your Stay"
                               value="{{ old('cta2_text', $slide->cta2_text) }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">URL / Link</label>
                        <input type="text" name="cta2_url" maxlength="255"
                               placeholder="/properties"
                               value="{{ old('cta2_url', $slide->cta2_url) }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Right sidebar --}}
    <div class="space-y-5">

        {{-- Publish --}}
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <h3 class="font-semibold text-gray-800 mb-4">Publish</h3>
            <label class="flex items-center gap-3 cursor-pointer mb-4">
                <div class="relative">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1"
                           {{ old('is_active', $slide->is_active ?? true) ? 'checked' : '' }}
                           class="sr-only peer" id="is_active_toggle">
                    <div class="w-11 h-6 bg-gray-200 peer-checked:bg-green-500 rounded-full peer transition-colors"></div>
                    <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full shadow peer-checked:translate-x-5 transition-transform"></div>
                </div>
                <label for="is_active_toggle" class="text-sm text-gray-700 font-medium cursor-pointer">
                    Show on homepage
                </label>
            </label>
            <div>
                <label class="block text-xs text-gray-500 mb-1">Display Order</label>
                <input type="number" name="sort_order" min="0"
                       value="{{ old('sort_order', $slide->sort_order ?? 0) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                <p class="text-xs text-gray-400 mt-1">Lower numbers appear first. You can also drag-reorder from the list view.</p>
            </div>
        </div>

        {{-- Actions --}}
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 space-y-2">
            <button type="submit" class="w-full bg-blue-600 text-white py-2.5 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
                <i class="fas fa-save mr-1"></i> {{ $slide->exists ? 'Update Slide' : 'Create Slide' }}
            </button>
            <a href="{{ route('admin.hero-slides.index') }}" class="block text-center text-sm text-gray-500 hover:text-gray-700 py-2">
                Cancel
            </a>
        </div>

        {{-- Tips --}}
        <div class="bg-amber-50 rounded-xl p-4 border border-amber-100">
            <p class="text-xs font-semibold text-amber-700 mb-2"><i class="fas fa-lightbulb mr-1"></i> Image Tips</p>
            <ul class="text-xs text-amber-700 space-y-1">
                <li>• Use high-quality property interior/exterior photos</li>
                <li>• Landscape images (16:9) work best on desktop</li>
                <li>• Avoid text-heavy images — headline overlays them</li>
                <li>• Choose images with clear focal subjects</li>
                <li>• Try different focal positions if subject gets cropped</li>
            </ul>
        </div>

    </div>
</div>
