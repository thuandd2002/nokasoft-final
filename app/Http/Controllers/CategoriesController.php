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
            if ($request->hasFile('image')&& $request->file('image')->isValid()){
                $image = $request->file('image')->store('uploads', 'public');
                $param['cols']['images'] = $image;
            }
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
        if ($request->hasFile('image')&& $request->file('image')->isValid()){
            $image = $request->file('image')->store('uploads', 'public');
            $categories->image = $image;
        }
        $categories->name = $request->input('name');
        $categories->update();
        Session::flash('success', 'Update record #' . $categories->id . ' successfully');
        return redirect()->route('route_admin_category_list');
    }
    function delete($id, Request $request) {

        if ($request->ajax()) {
            $categories = Categories::find($id);
            if ($categories) {
                $categories->delete();
                Session::flash('success', ' Delete record #' . $categories->id . ' successfully');
                return response()->json(['success' => true]);
            } else {
                return response()->json(['error' => 'categories not found'], 404);
            }
        }
        return abort(404);
        // $categories = Categories::find($id);
        // $categories->delete();
        // Session::flash('success', ' Delete record #' . $categories->id . ' successfully');
        // return redirect()->route('route_admin_category_list');
    }
}
