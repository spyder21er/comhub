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

Route::middleware('auth')->group(function () {
    Route::get('/home', function () {
        return redirect('/');
    });
    Route::get('/', function () {
        if (Auth::user()->isSuperAdmin())
            return redirect()->route('admin.super');
        if (Auth::user()->isAdmin())
            return redirect()->route('admin.index');
        if (Auth::user()->isDriver())
            return redirect()->route('driver.index');
        if (Auth::user()->isPassenger())
            return redirect()->route('passenger.index');
    });

    Route::get('/passenger_dashboard', 'PassengerController@index')->name('passenger.index');
    Route::post('/passenger_dashboard', 'PassengerController@createTrip')->name('createTrip');
    Route::post('/trip/exclude_user', 'TripController@excludeUser')->name('trip.excludeUser');
    Route::post('/trip/include_user', 'TripController@includeUser')->name('trip.includeUser');
    Route::get('/trips/{trip}', 'TripController@show')->name('trip.show');
    Route::get('/drivers/{driver}', 'DriverController@show')->name('driver_profile');
    Route::middleware('driver')->group(function () {
        Route::get('/driver_dashboard', 'DriverController@index')->name('driver.index');
    });
    Route::middleware('admin')->group(function() {
        Route::get('/admin_dashboard', 'AdminController@index')->name('admin.index');
        Route::middleware('active.admin')->group(function() {
            Route::post('/admin/register_driver', 'AdminController@register_driver')->name('register.driver');
            Route::post('/admin/assign_driver', 'TripController@assignDriver')->name('assign.driver');
            Route::post('/admin/ban_driver', 'AdminController@banDriver')->name('ban.driver');
            Route::post('/admin/suspend_driver', 'AdminController@suspendDriver')->name('suspend.driver');
            Route::post('/admin/liftPenalty_driver', 'AdminController@liftPenaltyDriver')->name('liftPenalty.driver');
        });
    });
    Route::middleware('super.admin')->group(function() {
        Route::get('/superadmin_dashboard', 'AdminController@super')->name('admin.super');
        Route::post('/superadmin/register_admin', 'AdminController@register_admin')->name('register.admin');
        Route::get('/superadmin/edit/{admin}', 'AdminController@edit_admin')->name('edit.admin');
        Route::put('/superadmin/update/{admin}', 'AdminController@update_admin')->name('update.admin');
        Route::post('/superadmin/changeAdminStatus/{admin}', 'AdminController@changeAdminStatus')->name('change.admin.status');
    });
});

Auth::routes();
