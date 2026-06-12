<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Payment extends Model {
    protected $fillable = ['booking_id','user_id','amount','currency','paystack_reference','payment_channel','status','gateway_response','paid_at','raw_response'];
    protected $casts = ['paid_at'=>'datetime','raw_response'=>'array'];
    public function booking() { return $this->belongsTo(Booking::class); }
    public function user() { return $this->belongsTo(User::class); }
}
