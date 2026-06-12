<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class PropertyType extends Model {
    protected $fillable = ['name','slug','icon','description','is_active','sort_order'];
    public function properties() { return $this->hasMany(Property::class); }
}
