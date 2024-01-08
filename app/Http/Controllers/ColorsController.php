<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Colors;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Models\Categories;
class ColorsController extends Controller
{
    function list(){
        $items = Colors::all();
        return view('admin.templates.color.list',['items' => $items]);
    }
    public function add(Request $request){
        if ($request->isMethod('POST')) {
            $param = [];
            $param['cols'] = $request->post();
            unset($param['cols']['_token']);
            if ($request->hasFile('image')&& $request->file('image')->isValid()){
                $image = $request->file('image')->store('uploads', 'public');
                $param['cols']['image'] = $image;
            }
            DB::table('colors')->insert($param);
            Session::flash('success', 'colors added successfully');
            return redirect()->route('route_admin_colors_list');
        }
        return view('admin.templates.color.add');
    }

    function detail($id, Request $request) {
        $item = Categories::find($id);

        if (!$item) {
            abort(404); 
        }
        return view('admin.templates.color.detail',['items'=>$item]);
    }

    function update($id, Request $request){
        $colors = Colors::find($id);
        if ($request->hasFile('image')&& $request->file('image')->isValid()){
            $image = $request->file('image')->store('uploads', 'public');
            $colors->image = $image;
        }
        $colors->name = $request->input('name');
        $colors->update();
        Session::flash('success', 'Update record #' . $colors->id . ' successfully');
        return redirect()->route('route_admin_colors_list');
    }

    function delete($id) {
        $colors = Colors::find($id);
        $colors->delete();
        Session::flash('success', ' Delete record #' . $colors->id . ' successfully');
        return redirect()->route('route_admin_colors_list');
    }
}
