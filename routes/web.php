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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('users', 'UserController');
Route::resource('cars', 'CarController');
Route::get('cars/destroyMe/{id}', 'CarController@destroyMe')->name('AutoTorles');
Route::resource('costs', 'CostController');
Route::get('costs/destroyMe/{id}', 'CostController@destroyMe')->name('KTTorles');
Route::resource('partners', 'PartnerController');
Route::get('partners/destroyMe/{id}', 'PartnerController@destroyMe')->name('PartnerTorles');
Route::resource('doctypes', 'DoctypeController');
Route::get('doctypes/destroyMe/{id}', 'DoctypeController@destroyMe')->name('DTTorles');
Route::resource('documents', 'DocumentController');
Route::get('documents/destroyMe/{id}', 'DocumentController@destroyMe')->name('DocTorles');
Route::resource('accounts', 'AccountController');
Route::get('accounts/destroyMe/{id}', 'AccountController@destroyMe')->name('SzamlaTorles');
Route::resource('rxe', 'RXEController');
Route::get('rxe/destroyMe/{id}', 'RXEController@destroyMe')->name('RXETorles');
Route::resource('rvp', 'RVPController');
Route::get('rvp/destroyMe/{id}', 'RVPController@destroyMe')->name('RVPTorles');
Route::resource('ntv', 'NTVController');
Route::get('ntv/destroyMe/{id}', 'NTVController@destroyMe')->name('NTVTorles');
Route::resource('nes', 'NESController');
Route::get('nes/destroyMe/{id}', 'NESController@destroyMe')->name('NESTorles');
Route::resource('ioaccounts', 'IoaccountsController');
Route::get('ioaccounts/destroyMe/{id}', 'IoaccountController@destroyMe')->name('IoSzamlaTorles');
Route::resource('oiaccounts', 'OiaccountsController');
Route::get('oiaccounts/destroyMe/{id}', 'OiaccountController@destroyMe')->name('OiSzamlaTorles');

Route::resource('autokoltseg', 'AutoKoltsegController');
Route::resource('ktgtipus', 'KtgTipusOsszController');
