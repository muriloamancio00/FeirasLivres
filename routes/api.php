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

Route::middleware('admin')->group(function(){
    Route::get('admin', function (){
       dd('Você é admin');
    });
});

Route::middleware('feirante')->group(function(){
    Route::get('feirante', function (){
        dd('Você é feirante');
    });
});

Route::middleware('super')->group(function(){
    Route::get('super', function (){
        dd('Você é super');
    });
});

Route::prefix('v1')->middleware('jwt.auth')->group(function(){
    Route::get('me','App\Http\Controllers\AuthController@me');
    Route::post('logout','App\Http\Controllers\AuthController@logout');
    Route::post('update_auth','App\Http\Controllers\AuthController@updateProfile');
    Route::resource('fair', 'App\Http\Controllers\FairController');
    Route::resource('fairs_categories', 'App\Http\Controllers\FairsCategoriesController');
    Route::resource('fairs_events', 'App\Http\Controllers\FairsEventsController');
    Route::resource('product', 'App\Http\Controllers\ProductController');
    Route::resource('category', 'App\Http\Controllers\CategoryController');
    //incompletos?
    Route::resource('stand', 'App\Http\Controllers\FairController');
    Route::resource('event', 'App\Http\Controllers\EventController');
});

Route::post('login','App\Http\Controllers\AuthController@login');
Route::post('refresh','App\Http\Controllers\AuthController@refresh');
