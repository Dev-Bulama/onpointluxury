<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class PropertyCategory extends Model {
    protected $fillable = ['name','slug','image','description','is_active','sort_order'];
    public function properties() { return $this->hasMany(Property::class); }
}
