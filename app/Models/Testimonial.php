<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Testimonial extends Model {
    protected $fillable = ['name','title','avatar','rating','comment','is_active','sort_order'];
    protected $casts = ['is_active' => 'boolean'];
}
