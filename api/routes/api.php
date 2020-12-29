<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', function(){
    return 'API Loja do Kevin Smith';
});

Route::apiResource('/payment-types','PaymentTypeController');

Route::apiResource('/products','ProductController');

Route::apiResource('/product-images','ProductImagesController');

Route::apiResource('/orders','OrderController');

Route::apiResource('/order-items','OrderItemController');

Route::apiResource('/cart','CartController');

Route::apiResource('/cart-products','CartProductController');

Route::apiResource('/address','AddressController');

Route::group([

    'middleware' => 'api','admin',
    'prefix' => 'auth'

], function ($router) {

    Route::post('/login', ['as' => 'login', 'uses' => 'Auth\AuthController@login']);
    Route::post('register', 'Auth\AuthController@register');
    Route::post('/logout', 'Auth\AuthController@logout');
    Route::get('/refresh', 'Auth\AuthController@refresh');
    Route::get('/me', 'Auth\AuthController@me');

});
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
