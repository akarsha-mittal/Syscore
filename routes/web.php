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

Route::group(['namespace' => 'App\Http\Controllers'], function()
{
    Route::get('/', 'LoginController@show')->name('welcome');
    Route::group(['middleware' => ['guest']], function() {
        /**
         * Register Routes
         */
        Route::get('/register', 'RegisterController@show')->name('register.show');
        Route::post('/register', 'RegisterController@register')->name('register.perform');

        /**
         * Login Routes
         */
        Route::get('/login', 'LoginController@show')->name('login.show');
        Route::post('/login', 'LoginController@login')->name('login.perform');

    });

    Route::group(['middleware' => ['auth']], function() {
        /**
         * Logout Routes
         */
        Route::get('/invoices', 'InvoiceController@index')->name('invoices');
        Route::get('/invoices/add', 'InvoiceController@show')->name('invoices.show');
        Route::post('/invoices/add', 'InvoiceController@store')->name('invoices.add');
        Route::get('/invoices/download/{id}', 'InvoiceController@downloadInvoice')->name('download.invoice');
        Route::get('/invoices/download_invoices/{startdate}/{enddate}', 'InvoiceController@downloadInvoicesBasedOnDate')->name('download.invoice-datewise');
        Route::get('/logout', 'LogoutController@perform')->name('logout.perform');
    });
});
