<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
// use App\Models\Colors;
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
        return $this->hasMany(Colors::class,'product_id','id');
    }
}
