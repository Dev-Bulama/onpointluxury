<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Room extends Model {
    protected $fillable = ['property_id','name','room_type','price_per_night','quantity','max_guests','beds','bathrooms','description','image','is_available','status'];
    public function property() { return $this->belongsTo(Property::class); }
    public function bookings() { return $this->hasMany(Booking::class); }
}
