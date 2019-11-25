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
        return redirect()->route(Auth::user()->getHomeView());
    })->name('home');
    Route::get('/change_password', 'UserController@getChangePasswordForm')->name('get.change.password');
    Route::post('/change_password', 'UserController@postChangePasswordForm')->name('post.change.password');
    Route::get('/passenger_dashboard', 'PassengerController@index')->name('passenger.index');
    Route::post('/passenger_dashboard', 'PassengerController@createTrip')->name('createTrip');
    Route::post('/trip/exclude_user', 'TripController@excludeUser')->name('trip.excludeUser');
    Route::post('/trip/include_user', 'TripController@includeUser')->name('trip.includeUser');
    Route::get('/trips/{trip}', 'TripController@show')->name('trip.show');
    Route::post('/trips/{trip}/comply', 'TripController@comply')->name('trip.comply');
    Route::post('/trips/{trip}/comment', 'TripController@comment')->name('trip.comment');
    Route::post('/trips/{trip}/rate', 'TripController@rate')->name('trip.rate');
    Route::get('/drivers/{driver}', 'DriverController@show')->name('driver_profile');
    Route::middleware('driver')->group(function () {
        Route::get('/driver_dashboard', 'DriverController@index')->name('driver.index');
    });
    Route::middleware('admin')->group(function() {
        Route::get('/admin_dashboard', 'AdminController@index')->name('admin.index');
        Route::middleware('active.admin')->group(function() {
            Route::post('/admin/register_driver', 'AdminController@register_driver')->name('register.driver');
            Route::post('/admin/assign_driver', 'TripController@assignDriver')->name('assign.driver');
            Route::post('/admin/ban_driver', 'AdminController@ban_driver')->name('ban.driver');
            Route::post('/admin/suspend_driver', 'AdminController@suspend_driver')->name('suspend.driver');
            Route::post('/admin/liftPenalty_driver', 'AdminController@lift_driver_penalty')->name('liftPenalty.driver');
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
