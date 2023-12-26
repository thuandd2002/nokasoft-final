<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;
    protected $table = "categories";
    protected $fillable = ['id', 'product_id', 'name'];

    public function products()
    {
        return $this->belongsToMany(Products::class, 'product_categorie','product_id','categorie_id');
    }
}
