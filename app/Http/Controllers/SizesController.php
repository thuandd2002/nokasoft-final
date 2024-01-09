<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Sizes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SizesController extends Controller
{
    protected $_size;
    function __construct(Sizes $size){
        $this->_size = $size;
    }
    function list(){
        $items = Sizes::all();
        return view('admin/templates/size.list',['items' => $items]);
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
            DB::table('sizes')->insert($param);
            Session::flash('success', 'Sizes added successfully');
            return redirect()->route('route_admin_sizes_list');
        }
        return view('admin.templates.size.add');
    }

    function detail($id, Request $request) {
        $items=DB::table('sizes')->where('id',$id)->first();
        return view('admin.templates.size.detail',['items'=>$items]);
    }

    function update($id, Request $request){
        $sizes = Sizes::find($id);
        if ($request->hasFile('image')&& $request->file('image')->isValid()){
            $image = $request->file('image')->store('uploads', 'public');
            $sizes->image = $image;
        }
        $sizes->name = $request->input('name');
        $sizes->update();
        Session::flash('success', 'Update record #' . $sizes->id . ' successfully');
        return redirect()->route('route_admin_sizes_list');
    }

    function delete($id, Request $request) {
        $sizes = Sizes::find($id);
        $sizes->delete();
        Session::flash('success', ' Delete record #' . $sizes->id . ' successfully');
        return redirect()->route('route_admin_sizes_list');
    }
}
