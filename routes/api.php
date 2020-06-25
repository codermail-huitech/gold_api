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


Route::get('/products', 'ProductController@index');

Route::post('/orders', 'OrderMasterController@saveOrder');
Route::get('/orders', 'OrderMasterController@index');
Route::patch('/orders', 'OrderMasterController@updateOrder');
Route::patch('/orderMaster', 'OrderMasterController@updateMaster');
Route::delete('/orderMasterDelete/{id}', 'OrderMasterController@deleteOrderMaster');
Route::post('/orderDetails', 'OrderDetailController@fetchingDetails');
Route::get('/agents', 'AgentController@index');



//secured links here
Route::group(['middleware' => ['jwt.auth']], function() {
    Route::get('logout', 'AuthController@logout');

    Route::post('/products', 'ProductController@saveProduct');
    Route::patch('/products', 'ProductController@updateProduct');
    Route::delete('/products/{id}', 'ProductController@deleteProduct');

    Route::get('/materials', 'MaterialController@getMaterials');
    Route::get('/orderMaterials', 'MaterialController@getOrderMaterials');


    Route::get('/customers', 'CustomerController@index');
    Route::post('/customers', 'CustomerController@saveCustomer');
    Route::patch('/customers/{id}', 'CustomerController@updateCustomer');

    Route::delete('/ordersDetailsDelete/{id}', 'OrderDetailController@deleteOrder');

    Route::get('test', function(){
        return response()->json(['foo'=>'bar']);
    });
});
