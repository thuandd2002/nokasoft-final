<?php

use App\Http\Middleware\AdminAuthenticate;
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

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('homepage');
Route::get('addToCart/{id}','CartController@addToCart')->name('add-to-cart');
Route::get('cart','CartController@showCart')->name('show-cart');
Route::post('place-order/','CartController@placeOrder')->name('place-order');

Route::prefix('admin')->group(
    function () {
        Route::match(['get','post'],'register','AdminController@register')->name('route_admin_register');
        Route::get('/login', 'HomeController@login')->name('admin_login');
        Route::post('/login', 'HomeController@postLogin')->name('admin/login');
        Route::get('/', 'HomeController@admin');
        Route::get('/logout', "HomeController@getLogout")->name('admin/logout');
        Route::match(['get', 'post'], 'forgot-password', 'AdminController@forgotPassword')->name('route_admin_forgot_password');
        Route::match(['get', 'post'], 'change-password/{id}/{remember_token}/', 'AdminController@changePassword')->name('route_admin_change_password');
    }
);

Route::prefix('admin')->middleware(['auth.admin.middleware'])->group(
    function () {
        //Categories
        Route::get('categories/list', 'CategoriesController@list')->name('route_admin_category_list');
        Route::match(['get', 'post'], 'categories/add', 'CategoriesController@add')->name('route_admin_category_add');
        Route::get('categories/detail/{id}', 'CategoriesController@detail')->name('route_admin_category_detail');
        Route::post('/categories/update/{id}', 'CategoriesController@update')
            ->name('route_admin_category_update');
        Route::delete('/categories/delete/{id}', 'CategoriesController@delete')->name('route_admin_category_delete');
        //products
        Route::get('products/list', 'ProductsController@listProducts')->name('route_admin_products_list');
        Route::match(['get', 'post'], 'product/add', 'ProductsController@add')->name('route_admin_products_add');
        Route::get('products/detail/{id}', 'ProductsController@detail')->name('route_admin_products_detail');
        Route::post('/products/update/{id}', 'ProductsController@update')
            ->name('route_admin_products_update');
        Route::get('/products/delete/{id}', 'ProductsController@delete')->name('route_admin_products_delete');
        Route::delete('product/delete-multiple', 'ProductsController@deleteMutiple');
        //endproducts
        //sizes
        Route::get('sizes/list', 'SizesController@list')->name('route_admin_sizes_list');
        Route::match(['get', 'post'], 'sizes/add', 'SizesController@add')->name('route_admin_sizes_add');
        Route::get('sizes/detail/{id}', 'SizesController@detail')->name('route_admin_sizes_detail');
        Route::post('/sizes/update/{id}', 'SizesController@update')
            ->name('route_admin_sizes_update');
        Route::get('/sizes/delete/{id}', 'SizesController@delete')->name('route_admin_sizes_delete');
        //c
        Route::get('colors/list', 'ColorsController@list')->name('route_admin_colors_list');
        Route::match(['get', 'post'], 'colors/add', 'ColorsController@add')->name('route_admin_colors_add');
        Route::get('colors/detail/{id}', 'ColorsController@detail')->name('route_admin_colors_detail');
        Route::post('/colors/update/{id}', 'ColorsController@update')
            ->name('route_admin_colors_update');
        Route::get('/colors/delete/{id}', 'ColorsController@delete')->name('route_admin_colors_delete');
    }
);


