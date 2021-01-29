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
                Route::post('password-forget', 'AuthController@password_forget')->name('admin.password.forget');
                Route::get('forget-password-page/{mail}', 'AuthController@forget_password_page')->name('admin.forget.password.page');
                Route::get('reset-password/{string}', 'AuthController@reset_password')->name('admin.reset.password');
                Route::post('recover-password', 'AuthController@recover_password')->name('admin.recover.password');
            });

            Route::group(['middleware' => ['auth']], function () {
                Route::get('logout', 'AuthController@logout')->name('admin.logout');

                Route::get('dashboard', 'DashboardController@index')->name('admin.dashboard');

                /** profile */
                    Route::get('admin/profile', 'DashboardController@profile')->name('admin.profile');
                    Route::get('admin/profile-edit', 'DashboardController@profile_edit')->name('admin.profile.edit');
                    Route::PATCH('admin/profile-update', 'DashboardController@profile_update')->name('admin.profile.update');

                    Route::get('admin/profile-change-password', 'DashboardController@change_password')->name('admin.profile.change.password');
                    Route::post("admin/profile-reset-password", "DashboardController@reset_password")->name('admin.profile.reset.password');
                /** profile */

                /** access control */
                    /** role */
                        Route::any('role', 'RoleController@index')->name('admin.role');
                        Route::get('role/create', 'RoleController@create')->name('admin.role.create');
                        Route::post('role/insert', 'RoleController@insert')->name('admin.role.insert');
                        Route::get('role/edit', 'RoleController@edit')->name('admin.role.edit');
                        Route::patch('role/update/{id?}', 'RoleController@update')->name('admin.role.update');
                        Route::get('role/view', 'RoleController@view')->name('admin.role.view');
                        Route::post('role/delete', 'RoleController@delete')->name('admin.role.delete');
                    /** role */

                    /** permission */
                        Route::any('permission', 'PermissionController@index')->name('admin.permission');
                        Route::get('permission/create', 'PermissionController@create')->name('admin.permission.create');
                        Route::post('permission/insert', 'PermissionController@insert')->name('admin.permission.insert');
                        Route::get('permission/edit', 'PermissionController@edit')->name('admin.permission.edit');
                        Route::patch('permission/update/{id?}', 'PermissionController@update')->name('admin.permission.update');
                        Route::get('permission/view', 'PermissionController@view')->name('admin.permission.view');
                        Route::post('permission/delete', 'PermissionController@delete')->name('admin.permission.delete');
                    /** permission */
                /** access control */

                /** region */
                    /** District */
                        Route::any('district', 'DistrictsController@index')->name('admin.district');
                        Route::get('district/create', 'DistrictsController@create')->name('admin.district.create');
                        Route::post('district/insert', 'DistrictsController@insert')->name('admin.district.insert');
                        Route::get('district/edit', 'DistrictsController@edit')->name('admin.district.edit');
                        Route::patch('district/update/{id?}', 'DistrictsController@update')->name('admin.district.update');
                        Route::get('district/view', 'DistrictsController@view')->name('admin.district.view');
                        Route::post('district/change_status', 'DistrictsController@change_status')->name('admin.district.change.status');
                    /** District */

                    /** Taluka */
                        Route::any('taluka', 'TalukasController@index')->name('admin.taluka');
                        Route::get('taluka/create', 'TalukasController@create')->name('admin.taluka.create');
                        Route::post('taluka/insert', 'TalukasController@insert')->name('admin.taluka.insert');
                        Route::get('taluka/edit', 'TalukasController@edit')->name('admin.taluka.edit');
                        Route::patch('taluka/update/{id?}', 'TalukasController@update')->name('admin.taluka.update');
                        Route::get('taluka/view', 'TalukasController@view')->name('admin.taluka.view');
                        Route::post('taluka/change_status', 'TalukasController@change_status')->name('admin.taluka.change.status');
                    /** Taluka */

                    /** City */
                        Route::any('city', 'CitiesController@index')->name('admin.city');
                        Route::get('city/create', 'CitiesController@create')->name('admin.city.create');
                        Route::post('city/insert', 'CitiesController@insert')->name('admin.city.insert');
                        Route::get('city/edit', 'CitiesController@edit')->name('admin.city.edit');
                        Route::patch('city/update/{id?}', 'CitiesController@update')->name('admin.city.update');
                        Route::get('city/view', 'CitiesController@view')->name('admin.city.view');
                        Route::post('city/change_status', 'CitiesController@change_status')->name('admin.city.change.status');

                        Route::post('city/get/talukas', 'CitiesController@get_talukas')->name('admin.city.get.talukas');
                        Route::post('city/get/cities', 'CitiesController@get_cities')->name('admin.city.get.cities');
                    /** City */
                /** region */

                /** Reporter */
                    Route::any('reporter', 'ReporterController@index')->name('admin.reporter');
                    Route::get('reporter/create', 'ReporterController@create')->name('admin.reporter.create');
                    Route::post('reporter/insert', 'ReporterController@insert')->name('admin.reporter.insert');
                    Route::get('reporter/view', 'ReporterController@view')->name('admin.reporter.view');
                    Route::get('reporter/edit', 'ReporterController@edit')->name('admin.reporter.edit');
                    Route::patch('reporter/update/{id?}', 'ReporterController@update')->name('admin.reporter.update');
                    Route::post('reporter/change_status', 'ReporterController@change_status')->name('admin.reporter.change.status');
                    Route::post("reporter/profile-remove", "ReporterController@profile_remove")->name('admin.reporter.profile.remove');
                /** Reporter */

                /** subscriber */
                    Route::any('subscriber', 'SubscriberController@index')->name('admin.subscriber');
                    Route::get('subscriber/create', 'SubscriberController@create')->name('admin.subscriber.create');
                    Route::post('subscriber/insert', 'SubscriberController@insert')->name('admin.subscriber.insert');
                    Route::get('subscriber/edit', 'SubscriberController@edit')->name('admin.subscriber.edit');
                    Route::patch('subscriber/update/{id?}', 'SubscriberController@update')->name('admin.subscriber.update');
                    Route::get('subscriber/view', 'SubscriberController@view')->name('admin.subscriber.view');
                    Route::post('subscriber/change_status', 'SubscriberController@change_status')->name('admin.subscriber.change.status');

                    Route::any('subscriber/filter', 'SubscriberController@filter')->name('admin.subscriber.filter');
                    Route::get('subscriber/excel/{filter?}', 'SubscriberController@excel')->name('admin.subscriber.excel');
                /** subscriber */
            });
        });

        Route::any('/{slug?}', function(){ return view('backend.404');});
    });
