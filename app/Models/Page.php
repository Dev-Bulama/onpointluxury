<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Page extends Model {
    protected $fillable = ['title','slug','parent_id','template','featured_image','content','seo_title','seo_description','is_published','sort_order'];
    protected $casts = ['is_published'=>'boolean'];
    public function parent() { return $this->belongsTo(Page::class, 'parent_id'); }
    public function children() { return $this->hasMany(Page::class, 'parent_id'); }
    public function sections() { return $this->hasMany(PageSection::class)->orderBy('sort_order'); }
}
