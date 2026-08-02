<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSlide extends Model
{
    protected $fillable = [
        'badge', 'headline', 'description',
        'cta1_text', 'cta1_url', 'cta2_text', 'cta2_url',
        'desktop_image', 'mobile_image', 'alt_text',
        'focal_position', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_active'   => 'boolean',
        'sort_order'  => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function getDesktopImageUrlAttribute(): string
    {
        $img = $this->desktop_image;
        if (!$img) return 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=1600&q=80';
        if (str_starts_with($img, 'http://') || str_starts_with($img, 'https://')) return $img;
        return asset('storage/' . $img);
    }

    public function getMobileImageUrlAttribute(): string
    {
        $img = $this->mobile_image ?: $this->desktop_image;
        if (!$img) return 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=800&q=80';
        if (str_starts_with($img, 'http://') || str_starts_with($img, 'https://')) return $img;
        return asset('storage/' . $img);
    }
}
