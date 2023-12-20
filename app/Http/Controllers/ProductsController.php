<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\Colors;
use App\Models\Products;
use App\Models\Sizes;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Collection;

class ProductsController extends Controller
{
    public function listProducts()
    {
        $test= Products::all();
        foreach ($test as $a){
          echo  $a->name;
          echo"<br>";
          dd($a->color);
          echo $a->color->name;
          echo "<br>";
        }
       die;

        $items = DB::table('products')->get();
        $size=[];
        $colors = [];
        foreach ($items as $item){
            $sizeItems = DB::table('sizes')->where('product_id', '=',$item->id)->get();
            $colorsItems = DB::table('colors')->where('product_id', '=',$item->id)->get();
            if(!$sizeItems->isEmpty()){
                array_push($size,$sizeItems);
            }
            if(!$colorsItems->isEmpty()){
                array_push($colors,$colorsItems);
            }
        }
        return view('admin.templates.product.list', ['items' => $items, 'size'=>$size, 'colors'=>$colors]);
    }
    function delete($id, Request $request) {
        $colors = Products::find($id);
        $colors->delete();
        Session::flash('success', ' Delete record #' . $colors->id . ' successfully');
        return redirect()->route('route_admin_colors_list');
    }
}
