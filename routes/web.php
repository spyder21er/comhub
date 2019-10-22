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

use App\Http\Controllers\AdminController;

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        $roleId = Auth::user()->role->id;
        switch ($roleId)
        {
            case 1:
                return redirect()->route('admin.super');
                break;
            case 2:
                return redirect()->route('admin.index');
                break;
            case 3:
                return redirect()->route('driver.index');
                break;
            case 4:
                return redirect()->route('passenger.index');
                break;
        }
    });

    Route::get('/passenger_dashboard', 'PassengerController@index')->name('passenger.index');
    Route::get('/superadmin_dashboard', 'AdminController@super')->name('admin.super');
    Route::post('/passenger_dashboard', 'PassengerController@createTrip')->name('createTrip');
    Route::get('/driver_dashboard', 'DriverController@index')->name('driver.index');
    Route::get('/admin_dashboard', 'AdminController@index')->name('admin.index');
    Route::post('/trip/exclude_user', 'TripController@excludeUser')->name('trip.excludeUser');
    Route::post('/trip/include_user', 'TripController@includeUser')->name('trip.includeUser');
    Route::get('/trip/{trip}', 'TripController@show')->name('trip.show');
    Route::post('/admin/register_driver', 'AdminController@register_driver')->name('register.driver');
});

Route::get('/home', function() {
    return redirect('/');
});

Auth::routes();
