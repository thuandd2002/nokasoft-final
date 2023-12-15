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
Route::post('/admin/login', 'HomeController@postLogin')->name('admin/login');
Route::get('/admin', 'HomeController@admin');
Route::get('/admin/logout', "HomeController@getLogout")->name('admin/logout');

Route::prefix('admin')-> middleware(['auth.admin.middleware'])->group(
    function () {
        //Categories
        Route::get('categories/list', 'CategoriesController@list')->name('route_admin_category_list');
        Route::match(['get', 'post'], 'categories/add', 'CategoriesController@add')->name('route_admin_category_add');
        Route::get('categories/detail/{id}', 'CategoriesController@detail')->name('route_admin_category_detail');
        Route::post('/categories/update/{id}', 'CategoriesController@update')
            ->name('route_admin_category_update');
        Route::get('categories/delete/{id}', 'CategoriesController@delete')->name('route_admin_category_delete');
    }
);