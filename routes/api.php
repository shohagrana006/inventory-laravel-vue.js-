<?php

use App\Http\Controllers\Api\SalaryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

// employee controller
Route::apiResource('/employee', 'Api\EmployeeController');
Route::apiResource('/supplier', 'Api\SupplierController');
Route::apiResource('/category', 'Api\CategoryController');
Route::apiResource('/product',  'Api\ProductController');
Route::apiResource('/expense',  'Api\ExpenseController');
Route::apiResource('/customer', 'Api\CustomerController');

// salary controller
Route::post('/salary/paid/{id}', 'Api\SalaryController@paid');
Route::get('/salary', 'Api\SalaryController@index');
Route::get('/view/salary/{id}', 'Api\SalaryController@viewSalary');
Route::get('/edit/salary/{id}', 'Api\SalaryController@editSalary');
Route::post('/update/salary/{id}', 'Api\SalaryController@updateSalary');

// stock
Route::post('/product/update/{id}', 'Api\ProductController@quantityUpdate');

// pos
Route::get('/get/product/{id}', 'Api\PosController@getProduct');

// cart
Route::get('/cart/add/{id}', 'Api\CartController@addCart');
Route::get('/show/cart', 'Api\CartController@showCart');
Route::get('/delete/cart/{id}', 'Api\CartController@deleteCart');
Route::get('/increment/{id}', 'Api\CartController@increment');
Route::get('/decrement/{id}', 'Api\CartController@decrement');

// vat
Route::get('/vat', 'Api\CartController@vat');

// order
Route::post('/orderdone', 'Api\PosController@orderDone');
Route::get('/order', 'Api\OrderCotroller@order');
Route::get('/order/details/{id}', 'Api\OrderCotroller@orderDetails');
Route::get('/order/orderdetails/{id}', 'Api\OrderCotroller@orderDetailsAll');
Route::post('/search/order', 'Api\PosController@searchOrder');

// dashboard api
Route::get('/today/sell', 'Api\PosController@todaySell');
Route::get('/today/income', 'Api\PosController@todayIncome');
Route::get('/today/due', 'Api\PosController@todayDue');
Route::get('/today/expense', 'Api\PosController@todayExpense');
Route::get('/today/stockout', 'Api\PosController@stockOut');
