<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    redirect()->route('store');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/store', 'HomeController@store')->name('store');

Route::get('/products', 'ProductController@index')->name('products.index');

Route::delete('/products/{product}','ProductController@destroy')->name('product.destroy');

Route::put('/products/{product}','ProductController@update')->name('product.update');

Route::get('/addToCart/{product}', 'ProductController@addToCart')->name('cart.add');

Route::get('/shopping-cart', 'ProductController@show')->name('cart.show');

Route::get('/checkout/{amount}', 'ProductController@checkout')->name('cart.checkout')->middleware('auth');

Route::post('/charge', 'ProductController@charge')->name('cart.charge')->middleware('auth');

Route::get('/ordres', 'OrderController@index')->name('order.index')->middleware('auth');
