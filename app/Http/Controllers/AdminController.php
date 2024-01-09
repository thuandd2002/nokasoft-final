<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\ForgotPasswordRequest;
use Illuminate\Http\Request;
use \App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Admin\LoginRequest;
use App\Http\Requests\Customer\ChangePasswordRequest;
use App\Http\Requests\Customer\RegisterRequest;

class AdminController extends Controller
{
    function admin()
    {
        return Auth::check() ? view('admin.layout.layout') : view('admin.auth.login');
    }

    function login()
    {
        return view('admin.auth.login');
    }

    public function postLogin(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('admin');
        } else {
            Session::flash('error', 'Email hoặc mật khẩu không đúng');
            return redirect()->route('admin/login');
        }
    }

    public function getLogout()
    {
        Auth::logout();
        return redirect('admin/login');
    }

    function forgotPassword()
    {
        return view('admin.auth.forgot-password');
    }

    function postForgotPassword(ForgotPasswordRequest $request)
    {
        $user = User::where('email', $request->input('email'))->first();
        $token = strtoupper(Str::random(6));
        $user->update(['remember_token' => $token]);
        Mail::send('emails.forgot-password', compact('user'), function ($email) use ($user) {

            $email->subject('Noka - Password Reset');

            $email->to($user->email, $user->name);
        });
        Session::flash('success', 'Please check the email to reset password');

        return redirect()->route('route_admin_forgot_password');
    }

    function changePassword($id, $remember_token)
    {
        $user = User::find($id);

        if ($remember_token === $user->remember_token) {
            return view('admin.auth.change-password', ['user' => $user]);
        } else {
            return abort(404);
        }
    }
    
    function postChangePassword(ChangePasswordRequest $request, $id)
    {
        $user = User::find($id);
        $password = $request->input('password');
        Hash::make($password);
        $user->update(['password' => $password, 'remember_token' => null]);
        Session::flash('success', 'Password change was successful');

        return redirect()->route('route_admin_register');
    }


    function register()
    {
        return view('admin.auth.register');
    }

    function postRegister(RegisterRequest $request)
    {

        $params = [];
        $params['cols'] = $request->post();
        $params['cols']['roles'] = 1;
        unset($params['cols']['_token']);
        unset($params['cols']['repassword']);
        $params['cols']['password'] = Hash::make($params['cols']['password']);
        DB::table('users')->insert($params);
        Session::flash('success', 'User register successfully');
        return redirect()->route('route_admin_register');
    }
}
