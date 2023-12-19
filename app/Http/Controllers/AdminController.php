<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
class AdminController extends Controller
{
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
                return redirect('route_admin_forgot_password')->withErrors($validator);
            } else {
               
                $user = User::where('email', $request->input('email'))->first();
                $token = strtoupper(Str::random(6));
                $user->update(['remember_token' => $token]);
                $user->update(['name' => 'abc']);
                Mail::send('emails.forgot-password', compact('user'), function ($email) use ($user) {
                   
                    $email->subject('Noka - Password Reset');
                  
                    $email->to($user->email, $user->name);
                  
                });
                Session::flash('success', 'Please check the email to reset password');  
                return redirect()->route('route_admin_forgot_password');
            }
        }
        return view('admin.auth.forgot-password');
    }
    
    function changePassword(User $user, Request $request, $id, $remember_token) {
        $user = User::find($id);     
        if ($request->isMethod('POST')){
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
                return redirect()->route('route_admin_change_password',['id'=>$user->id, 'remember_token'=>$user->remember_token])->withErrors($validator);
            }else{
                $password = $request->input('password');
                $password_h = bcrypt($password);
                $user->update(['password' => $password_h, 'remember_token' => null]);
                Session::flash('success', 'Password change was successful');  
                return redirect()->route('admin_login');
            }
        }
        if($remember_token === $user->remember_token) {
            return view('admin.auth.change-password',['user' => $user]);
        }else{
            return abort(404);
        }   
    }
}
