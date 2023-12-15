<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use \App\Models\Products;

class ProductController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    protected $_products;
    function __construct(Products $products)
    { {
            $this->_products = $products;
        }
    }
    public function test()
    {
        return view('client.templates.home');
    }
    function getProduct(){
        $items = $this->_products->get();
        return view('client.templates.home', ['items' => $items]);
    }
}
