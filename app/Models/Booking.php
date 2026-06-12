<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Booking extends Model {
    protected $fillable = [
        'booking_reference','user_id','property_id','room_id','check_in_date','check_out_date',
        'nights','guests','price_per_night','subtotal','discount','tax','service_charge','total_amount',
        'payment_status','booking_status','customer_name','customer_email','customer_phone',
        'special_request','source'
    ];
    protected $casts = ['check_in_date'=>'date','check_out_date'=>'date'];

    protected static function boot() {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->booking_reference)) {
                $model->booking_reference = 'OPL-' . strtoupper(Str::random(8));
            }
        });
    }

    public function user() { return $this->belongsTo(User::class); }
    public function property() { return $this->belongsTo(Property::class); }
    public function room() { return $this->belongsTo(Room::class); }
    public function payments() { return $this->hasMany(Payment::class); }

    public function getStatusBadgeAttribute() {
        $colors = [
            'pending' => 'yellow', 'reserved' => 'blue', 'confirmed' => 'indigo',
            'paid' => 'green', 'checked_in' => 'teal', 'checked_out' => 'gray',
            'cancelled' => 'red', 'refunded' => 'orange', 'expired' => 'gray'
        ];
        return $colors[$this->booking_status] ?? 'gray';
    }
}
