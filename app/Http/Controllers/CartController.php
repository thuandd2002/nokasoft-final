<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Models\Products;
use App\Models\Colors;
use App\Models\Categories;
use App\Models\Sizes;
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

    
    function addToCart($id, Request $request) {
       
        $items =Products::find($id);
        $cart = session()->get('cart', []);
        if (isset($cart[$items->id])) {
            // Nếu sản phẩm đã tồn tại trong giỏ hàng, cập nhật số lượng
            $cart[$items->id]['quantity'] += 1;
        } else {
            // Nếu sản phẩm chưa tồn tại trong giỏ hàng, thêm mới
            $cart[$items->id] = [
                'name' => $items->name,
                'price' => $items->price,
                'image' => $items->image,
                'quantity' => 1,
            ];
        }
        session()->put('cart', $cart);
        session()->flash('success', 'Products added successfully');
        return redirect('/');
    }
    function showCart() {

        $cart = session()->get('cart', []);
        $colectionProduct = $this->_products->get();
        $colectionCategories = $this->_categories->get();
        $colectionSizes = $this->_sizes->get();
        $colectionColors = $this->_colors->get();
        return view('client.templates.cart.index',
         ['itemsProdcuts' => $colectionProduct,
         'itemsCategories' => $colectionCategories,
         'itemsSizes' => $colectionSizes,
         'itemsColors' => $colectionColors,
         'cart'=>$cart,
         ]
        );
    }
    public function placeOrder(Request $request)
    {
        // Lấy thông tin đơn hàng từ giỏ hàng
        $cart = session()->get('cart', []);

        // Xử lý đặt hàng ở đây...

        // Xóa giỏ hàng khỏi session sau khi đặt hàng thành công
        session()->forget('cart');

        // Đặt thông báo thành công vào session flash
        session()->flash('success', 'Products order successfully');

        // Chuyển hướng hoặc trả về view thành công
        return redirect()->route('homepage');
    }
}
