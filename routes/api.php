<?php

use Illuminate\Http\Request;

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

Route::get('products/getall', 'API\ProductController@getAll');
Route::get('products/getbycategoryid/{id}', 'API\ProductController@getByCategoryId');
Route::get('products/getbyid/{id}', 'API\ProductController@getById');
Route::post('products/add', 'API\ProductController@store');
Route::put('products/update/{product}', 'API\ProductController@update');
Route::get('products/delete/{id}', 'API\ProductController@destroy');
Route::get('products/getbyfilter', 'API\ProductController@getByFilter');
Route::get('products/getpopularproduct', 'API\ProductController@getPopularProductsAll');
Route::get('products/getnewestsproduct', 'API\ProductController@getNewestsProductsAll');

Route::get('categories/getall', 'API\CategoryController@getAll');
Route::get('categories/getpopularcategories', 'API\CategoryController@getPopularCategories');
Route::get('categories/getbyid/{id}', 'API\CategoryController@getById');
Route::post('categories/add', 'API\CategoryController@store');
Route::put('categories/update/{category}', 'API\CategoryController@update');
Route::get('categories/delete/{id}', 'API\CategoryController@destroy');
Route::get('categories/getbyfilter', 'API\CategoryController@getByFilter');

Route::post('categoryImage/uploadImage', 'API\CategoryImageController@uploadImage');
Route::get('categoryImage/getbyid/{id}', 'API\CategoryImageController@getById');

Route::post('productImage/uploadImage', 'API\ProductImageController@uploadImage');
Route::get('productImage/getbyid/{id}', 'API\ProductImageController@getById');