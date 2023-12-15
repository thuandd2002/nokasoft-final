<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;
    protected $table = "categories";
    protected $fillable = ['id', 'product_id', 'name'];

    // public function loadListWithPager($params = [])
    // {   
    //     $query = DB::table($this->table)
    //         ->select($this->fillable);
    //     $list = $query->paginate(10);
    //     return $list;
    // }
}