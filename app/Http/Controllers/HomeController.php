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

    function index()
    {
        $cart = session()->get('cart', []);
        $colectionProduct = Products::paginate(12);
        $colectionCategories = $this->_categories->get();
        $colectionSizes = $this->_sizes->get();
        $colectionColors = $this->_colors->get();

        return view(
            'client.templates.home',
            [
                'itemsProdcuts' => $colectionProduct,
                'itemsCategories' => $colectionCategories,
                'itemsSizes' => $colectionSizes,
                'itemsColors' => $colectionColors,
                'cart' => $cart,
            ]
        );
    }

    function productDetail($id, Request $request)
    {
        $items = Products::find($id);
        // dd($items->color);
        $colectionCategories = $this->_categories->get();
        $colectionSizes = $this->_sizes->get();
        $colectionColors = $this->_colors->get();
        return view(
            'client.templates.product.detail',
            [
                'itemsCategories' => $colectionCategories,
                'itemsSizes' => $colectionSizes,
                'itemsColors' => $colectionColors,
                'item' => $items,
            ]
        );
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $products = Products::where('name', 'like', "%$keyword%")->get();
        $itemsCategories = $this->_categories->get();
        $itemsSizes = $this->_sizes->get();
        $itemsColors = $this->_colors->get();

        return view('client.templates.product.search', compact('products', 'keyword', 'itemsCategories', 'itemsSizes', 'itemsColors'));
    }

    function searchByCategory($categoryName)
    {
        $category = Categories::where('name', $categoryName)->first();
        $itemsCategories = $this->_categories->get();
        $itemsSizes = $this->_sizes->get();
        $itemsColors = $this->_colors->get();
        $products = $category->products;

        return view('client.templates.product.search', compact('products', 'categoryName', 'itemsCategories', 'itemsSizes', 'itemsColors'));
    }

    function searchByColor($colorName)
    {
        $color = Colors::where('name', $colorName)->first();
        $itemsCategories = $this->_categories->get();
        $itemsSizes = $this->_sizes->get();
        $itemsColors = $this->_colors->get();
        $products = $color->products;

        return view('client.templates.product.search', compact('products', 'colorName', 'itemsCategories', 'itemsSizes', 'itemsColors'));
    }
}
