<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Products extends Model
{
    use HasFactory;

    protected $table = "products";
    protected $fillable = ['id','name','description','image','price'];


    public function color()
    {
        return $this->belongsToMany('App\Models\Colors','product_color','product_id','color_id');
    }
        /**
     * Get all of the size for the Products
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function size()
    {
        return $this->belongsToMany('App\Models\Sizes','product_size','product_id','size_id');
    }

    public function category()
    {
        return $this->belongsToMany('App\Models\Categories','product_categorie','product_id','categorie_id');
    }
}
