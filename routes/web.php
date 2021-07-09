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

Route::get('/',array("as"=>"booking.view","uses"=>"front\BookingController@bookingView"));
Route::get('/checkAmount',array("as"=>"booking.amount","uses"=>"front\BookingController@checkAmount"));

Route::get('/admin/rates/view',array("as"=>"rates.view","uses"=>"admin\HotelController@viewRate"));
Route::post('/admin/rates/store',array("as"=>"rates.store","uses"=>"admin\HotelController@storeRate"));
Route::get('/admin/rates/edit/{id}',array("as"=>"rates.edit","uses"=>"admin\HotelController@editRate"));
Route::post('/admin/rates/update',array("as"=>"rates.update","uses"=>"admin\HotelController@updateRate"));

Route::get('/admin/rates/delete/{id}',array("as"=>"rates.delete","uses"=>"admin\HotelController@deleteRate"));