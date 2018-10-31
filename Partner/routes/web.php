<?php

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

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});



Route::get('/home', 'HomeController@index')->name('home');
//Partner
Route::get('partners', 'PartnerController@index');
Route::get('partner/create', 'PartnerController@create');
Route::post('partner', 'PartnerController@store');

//Customer
Route::get('customers', 'CustomerController@index');
Route::get('customer/create', 'CustomerController@create');
Route::post('customer', 'CustomerController@store');
Route::get('buyDomain', 'CustomerController@buyDomain');
Route::post('checkDomain', 'CustomerController@checkDomain');
Route::post('storeAction', 'CustomerController@storeAction');
