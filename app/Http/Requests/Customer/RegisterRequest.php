<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'repassword' => 'required|same:password',
            'phone' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'password.required' => 'Please enter password',
            'name.required' => 'Please enter name',
            'email.required' => 'Please enter email',
            'email.unique' => 'Email address already exists',
            'phone.required' => 'Please enter phone',
            'repassword.required' => 'Please enter confirm password',
        ];
    }
}