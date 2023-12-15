<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Categories;
use Illuminate\Support\Facades\Session;

class CategoriesController extends Controller
{

    public function list(){
        $items = DB::table('categories')->get();
        return view('admin/templates/categories.list',['items' => $items]);
    }
    public function add(Request $request){
        if ($request->isMethod('POST')) {
            $param = [];
            $param['cols'] = $request->post();
            unset($param['cols']['_token']);
            DB::table('categories')->insert($param);
            Session::flash('success', 'Category added successfully');
            return redirect()->route('route_admin_category_list');
        }
        return view('admin.templates.categories.add');
    }
    function detail($id){
       $items=DB::table('categories')->where('id',$id)->first();
       return view('admin.templates.categories.detail',['items'=>$items]);
    }
    function update($id, Request $request){ 
        $categories = Categories::find($id);
        $categories->name = $request->input('name');
        $categories->update();
        Session::flash('success', 'Update record #' . $categories->id . ' successfully');
        return redirect()->route('route_admin_category_list');
    }
    function delete($id, Request $request) {
        $categories = Categories::find($id);
        $categories->delete();
        Session::flash('success', ' Delete record #' . $categories->id . ' successfully');
        return redirect()->route('route_admin_category_list');
    }
}