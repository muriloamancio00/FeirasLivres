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

Route::resource('category', 'App\Http\Controllers\CategoryController');
Route::resource('product', 'App\Http\Controllers\ProductController');
Route::resource('fair', 'App\Http\Controllers\FairController');
Route::resource('fairsCategories', 'App\Http\Controllers\FairsCategoriesController');

