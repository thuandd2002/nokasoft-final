<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Models\Products;
use App\Models\Colors;
use App\Models\Categories;
use App\Models\Sizes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    protected $_products;
    protected $_categories;
    protected $_sizes;
    protected $_colors;

    public function __construct(Products $products, Categories $categories, Sizes $sizes, Colors $colors)
    {
        $this->_products = $products;
        $this->_categories = $categories;
        $this->_colors = $colors;
        $this->_sizes = $sizes;
    }


    function addToCart($id, Request $request)
    {
        $items = Products::find($id);
        if (Auth::check()) {
            $user = Auth::user();
            $cart = $user->cart ?? [];
            $cart = json_decode($user->cart, true);
            if (isset($cart[$id])) {
                $cart[$id]['quantity'] += 1;
            } else {
                $cart[$id] = [
                    'id' => $items->id,
                    'name' => $items->name,
                    'price' => $items->price,
                    'image' => $items->image,
                    'quantity' => 1,
                ];
            }
            $user->cart = $cart;
            $user->save();
            Session::put('cart', $cart);
        } else {
            $cart = Session::get('cart', []);
            if (isset($cart[$id])) {
                $cart[$id]['quantity'] += 1;
            } else {
                $cart[$id] = [
                    'id' => $items->id,
                    'name' => $items->name,
                    'price' => $items->price,
                    'image' => $items->image,
                    'quantity' => 1,
                ];
            }
            Session::put('cart', $cart);
        }
        session()->flash('success', 'Products added successfully');
        return redirect('/');
    }
    function showCart()
    {
        $colectionProduct = $this->_products->get();
        $colectionCategories = $this->_categories->get();
        $colectionSizes = $this->_sizes->get();
        $colectionColors = $this->_colors->get();

        if (Auth::check()) {
            $user = Auth::user();
            $cart = $user->cart ?? [];
            $cart = json_decode($user->cart, true);
        } else {
            $cart = session()->get('cart', []);
        }

        return view(
            'client.templates.cart.index',
            [
                'itemsProdcuts' => $colectionProduct,
                'itemsCategories' => $colectionCategories,
                'itemsSizes' => $colectionSizes,
                'itemsColors' => $colectionColors,
                'cart' => $cart,
            ]
        );
    }
    function increaseQuantity($id)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $cart = $user->cart ?? [];
            $cart = json_decode($user->cart, true);
            if (isset($cart[$id])) {
                $cart[$id]['quantity']++;
                $user->cart = $cart;
                $user->save();
                return redirect()->route('show-cart');
            } else {
                dd('error');
            }
        } else {
            $cart = session()->get('cart', []);
            if (isset($cart[$id])) {
                $cart[$id]['quantity']++;
                session()->put('cart', $cart);
                return redirect()->route('show-cart');
            }
        }
    }

    function decreaseQuantity($id)
    {
        if (Auth::check()) {

            $user = Auth::user();
            $cart = $user->cart ?? [];
            $cart = json_decode($user->cart, true);
            if (isset($cart[$id])) {
                $cart[$id]['quantity']--;
                if ($cart[$id]['quantity'] <= 0) {
                    unset($cart[$id]);
                }
                $user->cart = $cart;
                $user->save();
                return redirect()->route('show-cart');
            }
        } else {
            $cart = session()->get('cart', []);
            if (isset($cart[$id])) {
                $cart[$id]['quantity']--;
                if ($cart[$id]['quantity'] <= 0) {
                    unset($cart[$id]);
                }
                session()->put('cart', $cart);
                return redirect()->route('show-cart');
            }
        }
    }
    public function placeOrder(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user->cart = null;
            $user->save();
            session()->flash('success', 'Products order successfully');
            return redirect()->route('homepage');
        } else {
            $cart = session()->get('cart', []);
            session()->forget('cart');
            session()->flash('success', 'Products order successfully');
            return redirect()->route('homepage');
        }
    }
}
