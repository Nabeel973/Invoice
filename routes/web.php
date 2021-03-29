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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('invoice')->name('invoice.')->group(function () {
    Route::get('create', 'InvoiceController@index')->name('index');
    Route::post('submit','InvoiceController@submit')->name('submit');
    Route::get('/report','InvoiceController@report_index')->name('report');
    Route::get('list','InvoiceController@list')->name('list');
    Route::post('/image','InvoiceController@image')->name('image');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
