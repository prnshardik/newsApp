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
        Route::group(['namespace' => 'Backend'], function(){
            Route::group(['middleware' => ['guest']], function () {
                Route::get('/', 'AuthController@login')->name('admin.login');
                Route::post('signin', 'AuthController@signin')->name('admin.signin');

                Route::get('forget-password', 'AuthController@forget_password')->name('admin.forget.password');
                Route::get('recover-password', 'AuthController@recover_password')->name('admin.recover.password');
            });

            Route::group(['middleware' => ['auth']], function () {
                Route::get('logout', 'AuthController@logout')->name('admin.logout');

                Route::get('dashboard', 'DashboardController@index')->name('admin.dashboard');
                
            /** Country */
                Route::any('country', 'CountryController@index')->name('admin.country');
                Route::get('country/create', 'CountryController@create')->name('admin.country.create');
                Route::post('country/insert', 'CountryController@insert')->name('admin.country.insert');
                Route::get('country/view', 'CountryController@view')->name('admin.country.view');
                Route::get('country/edit', 'CountryController@edit')->name('admin.country.edit');
                Route::patch('country/update/{id?}', 'CountryController@update')->name('admin.country.update');
                Route::post('country/delete', 'CountryController@delete')->name('admin.country.delete');
            /** Country */
                

            /** State */
                Route::any('state', 'StateController@index')->name('admin.state');
                Route::get('state/create', 'StateController@create')->name('admin.state.create');
                Route::post('state/insert', 'StateController@insert')->name('admin.state.insert');
                Route::get('state/view', 'StateController@view')->name('admin.state.view');
                Route::get('state/edit', 'StateController@edit')->name('admin.state.edit');
                Route::patch('state/update/{id?}', 'StateController@update')->name('admin.state.update');
                Route::post('state/delete', 'StateController@delete')->name('admin.state.delete');
            /** State */

            
            /** City */
                Route::any('city', 'CityController@index')->name('admin.city');
                Route::get('city/create', 'CityController@create')->name('admin.city.create');
                Route::post('city/insert', 'CityController@insert')->name('admin.city.insert');
                Route::get('city/view', 'CityController@view')->name('admin.city.view');
                Route::get('city/edit', 'CityController@edit')->name('admin.city.edit');
                Route::patch('city/update/{id?}', 'CityController@update')->name('admin.city.update');
                Route::post('city/delete', 'CityController@delete')->name('admin.city.delete');

            /** City */
            });
        });

        Route::any('/{slug?}', function(){ return view('backend.404');});
    });

