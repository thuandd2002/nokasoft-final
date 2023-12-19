<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \App\Models\Products;
use \App\Models\Categories;
use \App\Models\Sizes;
use \App\Models\Colors;

class HomeController extends Controller
{

    protected $_products;
    protected $_categories;
    protected $_colors;
    protected $_sizes;

    function __construct(Products $products, Categories $categories, Colors $colors, Sizes $sizes)
    {
        $this->_products = $products;
        $this->_categories = $categories;
        $this->_colors = $colors;
        $this->_sizes = $sizes;
    }
    function index ()
    {
        $colectionProduct = $this->_products->get();
        $colectionCategories = $this->_categories->get();
        $colectionSizes = $this->_sizes->get();
        $colectionColors = $this->_colors->get();
        return view('client.templates.home',
         ['itemsProdcuts' => $colectionProduct,
         'itemsCategories' => $colectionCategories,
         'itemsSizes' => $colectionSizes,
         'itemsColors' => $colectionColors
         ]
        );
    }
    function admin()
    {
        if (Auth::check()) {
            return view('admin.layout.layout');
        } else {
            return view('admin.auth.login');
        }
     
    }

    function login()
    {
        return view('admin.auth.login');
    }

    public function postLogin(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required'
        ];
        $messages = [
            'email.required' => 'Mời bạn nhập vào email',
            'email.email' => 'Mời bạn nhập đúng định dạng email',
            'password.required' => 'Mời bạn nhập password',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect('admin/login')->withErrors($validator);
        } else {
            $email = $request->input('email');
            $password = $request->input('password');
            if (Auth::attempt(['email' => $email, 'password' => $password])) {
                return redirect('admin');
            } else {
                Session::flash('error', 'Email hoặc mật khẩu k đúng');
                return redirect('admin/login');
            }
        }
    }
    public function getLogout()
    {
        Auth::logout();
        return redirect('admin/login');
    }
}
