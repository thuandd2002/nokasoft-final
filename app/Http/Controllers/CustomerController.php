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

class CustomerController extends Controller
{

    function register(Request $request)
    {
        if ($request->isMethod('post')) {
            $rules = [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                'repassword' => 'required|same:password',
                'phone' => 'required'
            ];
            $messages = [
                'password.required' => 'Please enter password',
                'name.required' => 'Please enter name',
                'email.required' => 'Please enter email',
                'phone.required' => 'Please enter phone',
                'repassword.required' => 'Please entern confirm password',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect('route.customer.register')->withErrors($validator);
            } else {
                $params = [];
                $params['cols'] = $request->post();
                unset($params['cols']['_token']);
                unset($params['cols']['repassword']);
                $params['cols']['password'] = Hash::make($params['cols']['password']);
                DB::table('users')->insert($params);
                Session::flash('success', 'Customer register successfully');
                return redirect()->route('route.customer.login');
            }
        }
        return view('client.templates.auth.register');
    }

    function login()
    {
        return view('client.templates.auth.login');
    }
    function postLogin(Request $request)
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
            if (Auth::attempt(['email' => $email, 'password' => $password, 'roles' => 0])) {
                $sessionCart = session('cart', []);
                $user = Auth::user();
                $user->cart = $sessionCart;
                $user->update();
                return redirect('/');
            } else {
                Session::flash('error', 'Email hoặc mật khẩu k đúng');
                return redirect()->route('route.customer.login');
            }
        }
    }

    function getLogout()
    {
        Auth::logout();
        return redirect('/');
    }

    function forgotPassword(Request $request)
    {
        if ($request->isMethod('POST')) {
            //validate
            $rules = [
                'email' => 'required|exists:users',
            ];
            $messages = [
                'email.required' => 'Mời bạn nhập vào email',
                'email.email' => 'Mời bạn nhập đúng định dạng email',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect('route.customer.forgot')->withErrors($validator);
            } else {

                $user = User::where('email', $request->input('email'))->first();
                $token = strtoupper(Str::random(6));
                $user->update(['remember_token' => $token]);
                // $user->update(['name' => 'abc']);
                Mail::send('emails.client.forgot-password', compact('user'), function ($email) use ($user) {

                    $email->subject('Noka - Password Reset');

                    $email->to($user->email, $user->name);
                });
                Session::flash('success', 'Please check the email to reset password');
                return redirect()->route('route.customer.forgot');
            }
        }
        return view('client.templates.auth.forgot-password');
    }

    function changePassword(User $user, Request $request, $id, $remember_token)
    {
        $user = User::find($id);
        if ($request->isMethod('POST')) {
            $rules = [
                'password' => 'required',
                'confirmPassword' => 'required|same:password',
            ];
            $messages = [
                'password.required' => 'Please enter password',
                'confirmPassword.required' => 'Please entern confirm password',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->route('route.customer.changePassword', ['id' => $user->id, 'remember_token' => $user->remember_token])->withErrors($validator);
            } else {
                $password = $request->input('password');
                $password_h = bcrypt($password);
                $user->update(['password' => $password_h, 'remember_token' => null]);
                Session::flash('success', 'Password change was successful');
                return redirect()->route('route.customer.login');
            }
        }
        if ($remember_token === $user->remember_token) {
            return view('client.templates.auth.change-password', ['user' => $user]);
        } else {
            return abort(404);
        }
    }
}
