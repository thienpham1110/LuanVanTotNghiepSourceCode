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
// Client
Route::get('/','HomeController@index');



// Admin
Route::get('/admin','AdminHomeController@index');
Route::get('/resetpass','AdminHomeController@reset_password');
Route::get('/loginadmin','AdminHomeController@login_admin');
Route::get('/logout','AdminHomeController@logout');
Route::get('/dashboard','AdminHomeController@show_dashboard');
Route::post('/admin-dashboard','AdminHomeController@dashboard');


//Category admin
Route::get('/product-type','ProductTypeController@index');
Route::get('/product-type-add','ProductTypeController@product_type_add');
Route::get('/product-type-edit','ProductTypeController@product_type_edit');
Route::post('/product-type-save','ProductTypeController@product_type_save');
