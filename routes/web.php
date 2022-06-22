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

Route::get('/', 'App\Http\Controllers\HomeController@index')->name('home');

Route::prefix('account')->middleware(['auth'])->group(function () {
    Route::get('/', 'App\Http\Controllers\AccountController@index')->name('account');
    Route::post('/edit', 'App\Http\Controllers\AccountController@edit')->name('account.edit');
});

require __DIR__.'/auth.php';
