<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class BlogPost extends Model {
    protected $fillable = ['user_id','title','slug','featured_image','category','excerpt','content','seo_title','seo_description','is_published','published_at'];
    protected $casts = ['is_published' => 'boolean', 'published_at' => 'datetime'];
    public function author() { return $this->belongsTo(User::class, 'user_id'); }
}
