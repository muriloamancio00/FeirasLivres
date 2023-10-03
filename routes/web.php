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

Auth::routes();

Route::get('/category',function(){
    return view('app.category');
})->name('category')->middleware('auth');

Route::get('/stand',function(){
    return view('app.stand');
})->name('stand')->middleware('auth');

Route::get('/fair',function(){
    return view('app.fair');
})->name('fair')->middleware('auth');

Route::get('/fairs_events',function(){
    return view('app.fairsEvents');
})->name('fairs_events')->middleware('auth');

Route::get('/fairs_categories',function(){
    return view('app.fairsCategories');
})->name('fairs_categories')->middleware('auth');

Route::get('/product',function(){
    return view('app.product');
})->name('product')->middleware('auth');

Route::get('/event',function(){
    return view('app.event');
})->name('event')->middleware('auth');



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
