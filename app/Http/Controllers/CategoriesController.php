<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Categories;
use Illuminate\Support\Facades\Session;

class CategoriesController extends Controller
{

    public function list()
    {
        $items = Categories::paginate(8);
        return view('admin.templates.categories.list', ['items' => $items]);
    }
    public function add(Request $request)
    {
        if ($request->isMethod('POST')) {
            $param = [];
            $param['cols'] = $request->post();
            unset($param['cols']['_token']);
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $image = $request->file('image')->store('uploads', 'public');
                $param['cols']['images'] = $image;
            }
            DB::table('categories')->insert($param);
            Session::flash('success', 'Category added successfully');
            return redirect()->route('route_admin_category_list');
        }
        return view('admin.templates.categories.add');
    }
    function detail($id)
    {
        $item = Categories::find($id);

        if (!$item) {
            abort(404); 
        }
        
        return view('admin.templates.categories.detail', ['items' => $item]);
    }

    function update($id, Request $request)
    {
        $categories = Categories::find($id);
        if ($request->hasFile('images') && $request->file('images')->isValid()) {
            $image = $request->file('images')->store('uploads', 'public');
            $categories->images = $image;
        }
        $categories->name = $request->input('name');
        $categories->save();
        Session::flash('success', 'Update record #' . $categories->id . ' successfully');
        return redirect()->route('route_admin_category_list');
    }

    function delete($id)
    {
        $cate = Categories::find($id);
        $cate->delete();
        Session::flash('success', ' Delete record #' . $cate->id . ' successfully');
        return redirect()->route('route_admin_category_list');
    }
}
