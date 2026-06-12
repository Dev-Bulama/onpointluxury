<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class AvailabilityBlock extends Model {
    protected $fillable = ['property_id','room_id','start_date','end_date','reason','type'];
    protected $casts = ['start_date'=>'date','end_date'=>'date'];
    public function property() { return $this->belongsTo(Property::class); }
    public function room() { return $this->belongsTo(Room::class); }
}
