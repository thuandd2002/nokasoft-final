<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Products;

class HomeController extends Controller
{
    function getProduct(){
        $items = Products::all();
        return view('client.templates.home',['items' => $items]);
    }
    function admin(){
        return view('admin.layout.layout');
    }

    function register(){
        return view('auth.register');
    }   
}
