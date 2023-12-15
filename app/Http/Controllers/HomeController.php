<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \App\Models\Products;

class HomeController extends Controller
{
    function getProduct()
    {
        $items = Products::all();
        return view('client.templates.home', ['items' => $items]);
    }
    function admin()
    {
        if (Auth::check()) {
            return view('admin.layout.layout');
        } else {
            return view('auth.login');
        }
     
    }

    function login()
    {
        return view('auth.login');
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
