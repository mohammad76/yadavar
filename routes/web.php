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

use Illuminate\Support\Facades\Route;


Route::get('/', 'HomeController@index')->name('index');
Route::get('/order/{package}', 'Front\OrderController@index')->name('order-index');

Route::get('/pay/{package}', 'Front\PayController@index')->name('pay-index');
Route::get('/verify-pay', 'Front\PayController@verify')->name('pay-verify');


Route::get('/my-account', 'Auth\MainController@index')->name('auth-index');

Route::get('/my-account/people', 'Front\Account\PersonController@index')->name('people-index');
Route::get('/my-account/people/create', 'Front\Account\PersonController@create')->name('people-create');
Route::post('/my-account/people/create', 'Front\Account\PersonController@store')->name('people-store');
Route::get('/my-account/people/edit/{person}', 'Front\Account\PersonController@edit')->name('people-edit');
Route::post('/my-account/people/edit/{person}', 'Front\Account\PersonController@update')->name('people-update');
Route::get('/my-account/people/destroy/{person}', 'Front\Account\PersonController@destroy')->name('people-destroy');

Route::get('/my-account/events', 'Front\Account\EventController@index')->name('event-index');
Route::get('/my-account/event/create', 'Front\Account\EventController@create')->name('event-create');
Route::post('/my-account/event/create', 'Front\Account\EventController@store')->name('event-store');
Route::get('/my-account/event/edit/{event}', 'Front\Account\EventController@edit')->name('event-edit');
Route::post('/my-account/event/edit/{event}', 'Front\Account\EventController@update')->name('event-update');
Route::get('/my-account/event/destroy/{event}', 'Front\Account\EventController@destroy')->name('event-destroy');

Route::get('/my-account/credit', 'Front\Account\CreditController@index')->name('credit-index');
Route::post('/my-account/credit', 'Front\Account\CreditController@pay')->name('credit-pay');

Route::get('/logout', 'Auth\MainController@logout')->name('auth-logout');
Route::post('/user/register', 'Auth\MainController@register')->name('auth-register');
Route::post('/user/login', 'Auth\MainController@login')->name('auth-login');
