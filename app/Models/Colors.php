<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Colors extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "colors";
    protected $fillable = ['id', 'product_id', 'name'];
    public function products()
    {
        return $this->belongsToMany(Products::class, 'product_color','product_id','color_id');
    }
}
