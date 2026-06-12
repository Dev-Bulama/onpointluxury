<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Property extends Model {
    protected $fillable = [
        'user_id','property_type_id','property_category_id','name','slug','location','city','state','country',
        'address','short_description','description','featured_image','video_link','price_per_night',
        'weekend_price','monthly_price','discount_price','bedrooms','bathrooms','max_guests','beds',
        'property_size','check_in_time','check_out_time','cancellation_policy','house_rules','refund_policy',
        'rating','review_count','is_featured','status','seo_title','seo_description','latitude','longitude'
    ];
    protected $casts = ['is_featured'=>'boolean','price_per_night'=>'decimal:2'];

    protected static function boot() {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
        });
    }

    public function manager() { return $this->belongsTo(User::class, 'user_id'); }
    public function propertyType() { return $this->belongsTo(PropertyType::class); }
    public function propertyCategory() { return $this->belongsTo(PropertyCategory::class); }
    public function amenities() { return $this->belongsToMany(Amenity::class, 'property_amenity'); }
    public function images() { return $this->hasMany(PropertyImage::class)->orderBy('sort_order'); }
    public function rooms() { return $this->hasMany(Room::class); }
    public function bookings() { return $this->hasMany(Booking::class); }
    public function reviews() { return $this->hasMany(Review::class)->where('status','approved'); }
    public function availabilityBlocks() { return $this->hasMany(AvailabilityBlock::class); }
    public function favorites() { return $this->hasMany(Favorite::class); }

    public function getEffectivePriceAttribute() {
        return $this->discount_price ?? $this->price_per_night;
    }

    public function getFeaturedImageUrlAttribute() {
        if ($this->featured_image) {
            return asset('storage/' . $this->featured_image);
        }
        return asset('images/property-placeholder.jpg');
    }

    public function isAvailable($checkIn, $checkOut) {
        return !$this->availabilityBlocks()
            ->where(function($q) use ($checkIn, $checkOut) {
                $q->where('start_date', '<', $checkOut)
                  ->where('end_date', '>', $checkIn);
            })->exists() &&
            !$this->bookings()
            ->whereIn('booking_status', ['confirmed','paid','checked_in'])
            ->where(function($q) use ($checkIn, $checkOut) {
                $q->where('check_in_date', '<', $checkOut)
                  ->where('check_out_date', '>', $checkIn);
            })->exists();
    }
}
