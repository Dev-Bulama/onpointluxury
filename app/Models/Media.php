<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Media extends Model {
    protected $fillable = ['user_id','filename','original_name','mime_type','size','path','title','alt_text','caption'];
    public function user() { return $this->belongsTo(User::class); }
    public function getUrlAttribute() { return asset('storage/' . $this->path); }
}
