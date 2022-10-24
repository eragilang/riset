<?php

use App\Http\Controllers\UserController;
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
    Route::get('/', 'FrontController@index')->middleware('auth')->name('dashboard');
    Route::get('/detail', 'FrontController@detail')->middleware('auth')->name('detail');
    Route::get('/input', 'FrontController@input')->middleware('auth')->name('input');

    Route::group(['middleware' => ['auth', 'permission', 'verified']], function() {
        /**
         * User Routes
         */
        Route::group(['prefix' => 'users'], function() {
            Route::get('/', 'UsersController@index')->name('users.index');
            Route::get('/create', 'UsersController@create')->name('users.create');
            Route::post('/create', 'UsersController@store')->name('users.store');
            Route::get('/{user}/show', 'UsersController@show')->name('users.show');
            Route::get('/{user}/edit', 'UsersController@edit')->name('users.edit');
            Route::patch('/{user}/update', 'UsersController@update')->name('users.update');
            Route::delete('/{user}/delete', 'UsersController@destroy')->name('users.destroy');
        });

        /**
         * User Routes
         */
        Route::group(['prefix' => 'hewan'], function() {
            Route::get('/', 'HewanController@index')->name('hewan.index');
            Route::get('/create', 'HewanController@create')->name('hewan.create');
            Route::post('/create', 'HewanController@store')->name('hewan.store');
            Route::get('/{hewan}/show', 'HewanController@show')->name('hewan.show');
            Route::get('/{hewan}/edit', 'HewanController@edit')->name('hewan.edit');
            Route::patch('/{hewan}/update', 'HewanController@update')->name('hewan.update');
            Route::delete('/{hewan}/delete', 'HewanController@destroy')->name('hewan.destroy');
        });

        /**
         * User Routes
         */
        Route::group(['prefix' => 'detail-hewan'], function() {
            Route::get('/', 'DetailHewanController@index')->name('detail-hewan.index');
            Route::get('/create', 'DetailHewanController@create')->name('detail-hewan.create');
            Route::post('/create', 'DetailHewanController@store')->name('detail-hewan.store');
            Route::get('/{hewan}/show', 'DetailHewanController@show')->name('detail-hewan.show');
            Route::get('/{hewan}/edit', 'DetailHewanController@edit')->name('detail-hewan.edit');
            Route::patch('/{hewan}/update', 'DetailHewanController@update')->name('detail-hewan.update');
            Route::delete('/{hewan}/delete', 'DetailHewanController@destroy')->name('detail-hewan.destroy');
        });

        Route::resource('roles', RolesController::class);
        Route::resource('permissions', PermissionsController::class);
    });
});

require __DIR__.'/auth.php';
