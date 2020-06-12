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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', 'AuthController@register');

Route::post('/login', 'AuthController@login');
Route::get('/me', 'AuthController@me');
Route::delete('/customers/{id}', 'CustomerController@deleteCustomer');

Route::get('/priceCodes', 'PriceCodeController@getPriceCodes');

Route::get('/productCategory', 'ProductCategoryController@getProductCategories');

Route::group(['middleware' => ['jwt.auth']], function() {
    Route::get('logout', 'AuthController@logout');
    Route::get('/products', 'ProductController@index');
    Route::post('/products', 'ProductController@saveProduct');



    Route::get('/customers', 'CustomerController@index');
    Route::post('/customers', 'CustomerController@saveCustomer');
    Route::patch('/customers/{id}', 'CustomerController@updateCustomer');


    Route::get('test', function(){
        return response()->json(['foo'=>'bar']);
    });
});
