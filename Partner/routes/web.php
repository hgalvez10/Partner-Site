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

Route::get('/', function () 
{
	return view('welcome', compact('user'));
	
});



Route::get('/home', 'HomeController@index')->name('home');
Route::get('domains', 'HomeController@all_Domains');
//Partner
Route::get('partners', 'PartnerController@index');
Route::get('partner/create', 'PartnerController@create');
Route::post('partner', 'PartnerController@store');
Route::get('mytransactions', 'PartnerController@getTransactions');
Route::get('/domains/{customer}/view', 'CustomerController@getDomainsByCustomer');

//Customer
Route::get('customers', 'CustomerController@index');
Route::get('customer/create', 'CustomerController@create');
Route::post('customer', 'CustomerController@store');
Route::get('buyDomain', 'CustomerController@buyDomain');
Route::post('checkDomain', 'CustomerController@checkDomain');
Route::post('storeAction', 'CustomerController@storeAction');
Route::get('myDomains', 'CustomerController@getDomains');
Route::get('myOrders', 'CustomerController@getOrders');
Route::post('domain/renew/{domain}','CustomerController@renewDomain');
Route::post('/createContactAdmin', 'CustomerController@createContact');
Route::post('/createContactBilling', 'CustomerController@createContact');
Route::post('/createContactTech', 'CustomerController@createContact');

