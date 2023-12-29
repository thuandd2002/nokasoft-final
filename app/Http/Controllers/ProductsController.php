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
    protected $product;
    function __construct(Products $product)
    {
        $this->product = $product;
    }
    public function listProducts()
    {
        $items = Products::paginate(7);
        return view('admin.templates.product.list', ['items' => $items]);
    }
    function add(Request $request)
    {
        if ($request->isMethod('POST')) {
            $selectedSize = $request->input('size');
            $selectedColor = $request->input('color');
            $selectedCategorie = $request->input('categorie');
            $product = new Products;
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $image = $request->file('image')->store('uploads', 'public');
                $product->image = $image;
            }
            $product->name = $request->input('name');
            $product->price = $request->input('price');
            $product->save();

            $product->size()->attach($selectedSize);
            $product->color()->attach($selectedSize);
            $product->category()->attach($selectedCategorie);

            Session::flash('success', 'Product added successfully');
            return redirect()->route('route_admin_products_list');
        }
        $sizes = Sizes::all();
        $colors = Colors::all();
        $categories = Categories::all();

        return view('admin.templates.product.add', compact('sizes', 'colors', 'categories'));
    }
    public function detail($id, Request $request)
    {
        $items = Products::find($id);
        $selectedSizes = [];
        $selectedColors = [];
        $selectedCategories = [];
        foreach ($items->size as $size) {
            array_push($selectedSizes, $size->id);
        }
        foreach ($items->color as $color) {
            array_push($selectedColors, $color->id);
        }
        foreach ($items->category as $category) {
            array_push($selectedCategories, $category->id);
        }
        $sizes = Sizes::all();
        $colors = Colors::all();
        $categories = Categories::all();
        return view('admin.templates.product.detail', compact('sizes', 'colors', 'categories', 'selectedSizes', 'selectedColors', 'selectedCategories'), ['items' => $items]);
    }

    function update($id, Request $request)
    {
        $products = Products::find($id);
        $selectedSize = $request->input('size');
        $selectedColor = $request->input('color');
        $selectedCategorie = $request->input('categorie');
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $image = $request->file('image')->store('uploads', 'public');
            $products->image = $image;
        }
        $products->name = $request->input('name');
        $products->price = $request->input('price');
        $products->save();

        $products->size()->sync($selectedSize);
        $products->color()->sync($selectedColor);
        $products->category()->sync($selectedCategorie);
        Session::flash('success', 'Update record #' . $products->id . ' successfully');
        return redirect()->route('route_admin_products_list');
    }

    function delete($id)
    {
        $colors = Products::find($id);
        $colors->delete();
        Session::flash('success', ' Delete record #' . $colors->id . ' successfully');
        return redirect()->route('route_admin_products_list');
    }
    function deleteMutiple(Request $request)
    {
        $productIds = $request->input('product_ids');
    
        // Xóa các sản phẩm có ID nằm trong mảng $productIds
        Products::whereIn('id', $productIds)->delete();
    
        return response()->json(['message' => 'Đã xóa sản phẩm thành công.']);
    }
}
