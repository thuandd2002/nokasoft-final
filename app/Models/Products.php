<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Products extends Model
{
    use HasFactory;
    protected $table = "products";
    protected $fillable = ['id', 'site_id', 'color_id', 'category_id', 'name','images','description'];

    public function loadListWithPager($params = [])
    {   
        $query = DB::table($this->table)
            ->select($this->fillable);
        $list = $query->paginate(10);
        return $list;
    }
    public function color()
    {
        return $this->hasMany('App\Models\Colors','product_id','id');
    }
}
