<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class PropertyImage extends Model {
    protected $fillable = ['property_id','image','caption','sort_order'];
    public function property() { return $this->belongsTo(Property::class); }
    public function getImageUrlAttribute() {
        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }
        return asset('storage/' . $this->image);
    }
}
