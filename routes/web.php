<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [\App\Http\Controllers\HomeController::class,'getProduct']);
// Route::get('/admin', [\App\Http\Controllers\HomeController::class, 'admin']);

Route::get('/admin/login', 'HomeController@login')->name('admin/login');
Route::post('/admin/login', 'HomeController@postLogin');
Route::get('/admin', 'HomeController@admin');
Route::get('/admin/logout', "HomeController@getLogout")->name('admin/logout');