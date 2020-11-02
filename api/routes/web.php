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
    return view('welcome');
});

Route::get('/cart', 'CartController@index')->name('cart');
Route::post('/cart/store', 'CartController@store')->name('cart.insere');

Route::get('admin', 'Web\LoginController@admin')->name('admin');

Route::get('entrar', 'Web\LoginController@index')->name('entrar');
Route::post('entrando', 'Web\LoginController@login')->name('entrando');
Route::get('saindo', 'Web\LoginController@logout')->name('saindo');

Route::resource('product', 'ProductController');
