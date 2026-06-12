<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class PageSection extends Model {
    protected $fillable = ['page_id','section_type','title','subtitle','description','image','background_image','background_color','button_text','button_link','extra_data','sort_order','is_active'];
    protected $casts = ['extra_data'=>'array','is_active'=>'boolean'];
    public function page() { return $this->belongsTo(Page::class); }
}
