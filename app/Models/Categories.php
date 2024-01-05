<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categories extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "categories";
    protected $fillable = ['id', 'product_id', 'name'];

    public function products()
    {
        return $this->belongsToMany(Products::class, 'product_categorie','product_id','categorie_id');
    }
}
