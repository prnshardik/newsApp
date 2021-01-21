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

    Route::group(['middleware' => ['prevent-back-history']], function(){
        Route::group(['prefix' => 'admin', 'namespace' => 'Backend'], function(){
            Route::group(['middleware' => ['guest']], function () {
                Route::get('/', 'AuthController@login')->name('admin.login');
                Route::post('signin', 'AuthController@signin')->name('admin.signin');

                Route::get('forget-password', 'AuthController@forget_password')->name('admin.forget.password');
                Route::get('recover-password', 'AuthController@recover_password')->name('admin.recover.password');
            });

            Route::group(['middleware' => ['auth']], function () {
                Route::get('logout', 'AuthController@logout')->name('admin.logout');

                Route::get('dashboard', 'DashboardController@index')->name('admin.dashboard');
            });
        });

        Route::any('/{slug?}', function(){ return view('backend.404');});
    });

