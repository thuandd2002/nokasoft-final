<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Str;
use App\Http\Requests\Customer\RegisterRequest;
use App\Http\Requests\Customer\LoginRequest;
use App\Http\Requests\Customer\ForgotPasswordRequest;
use App\Http\Requests\Customer\ChangePasswordRequest;

class CustomerController extends Controller
{

    function register()
    {
        return view('client.templates.auth.register');
    }
    function postRegister(RegisterRequest $request)
    {
        $params = [];
        $params['cols'] = $request->post();
        unset($params['cols']['_token']);
        unset($params['cols']['repassword']);
        $params['cols']['password'] = Hash::make($params['cols']['password']);
        DB::table('users')->insert($params);
        Session::flash('success', 'Customer register successfully');

        return redirect()->route('route.customer.login');
    }

    function login()
    {
        return view('client.templates.auth.login');
    }
    function postLogin(LoginRequest $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        if (Auth::attempt(['email' => $email, 'password' => $password, 'roles' => 0])) {
            $sessionCart = session('cart', []);
            $user = Auth::user();
            $userCart = json_decode($user->cart, true);
            foreach ($sessionCart as $productId => $sessionItem) {
                if (isset($userCart[$productId])) {
                    $userCart[$productId]['quantity'] += $sessionItem['quantity'];
                } else {
                    $userCart[$productId] = $sessionItem;
                }
            }
            $user->cart =  json_encode($userCart);
            $user->update();
            session(['cart' => []]);
            return redirect('/');
        } else {
            Session::flash('error', 'Email hoặc mật khẩu k đúng');
            return redirect()->route('route.customer.login');
        }
    }

    function getLogout()
    {
        Auth::logout();
        return redirect('/');
    }

    function forgotPassword()
    {
        return view('client.templates.auth.forgot-password');
    }
    
    function postForgotPassword(ForgotPasswordRequest $request)
    {
        $user = User::where('email', $request->input('email'))->first();
        $token = strtoupper(Str::random(6));
        $user->update(['remember_token' => $token]);
        Mail::send('emails.client.forgot-password', compact('user'), function ($email) use ($user) {

            $email->subject('Noka - Password Reset');

            $email->to($user->email, $user->name);
        });
        Session::flash('success', 'Please check the email to reset password');
        return redirect()->route('route.customer.forgot');
    }

    function changePassword(User $user, $id, $remember_token)
    {
        $user = User::find($id);

        if ($remember_token === $user->remember_token) {
            return view('client.templates.auth.change-password', ['user' => $user]);
        } else {
            return abort(404);
        }
    }

    function postChangePassword( ChangePasswordRequest $request,User $user, $id)
    { 
        $user = User::find($id);
        $password = $request->input('password');
        Hash::make($password);
        $user->update(['password' => $password, 'remember_token' => null]);
        Session::flash('success', 'Password change was successful');
        return redirect()->route('route.customer.login');
    }
}
