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
    Route::get('/', function () {
        $roleId = Auth::user()->role->id;
        switch ($roleId)
        {
            case 1:
                return redirect('/admin_dashboard');
            case 2:
                return redirect('/driver_dashboard');
            case 3:
                return redirect('/passenger_dashboard');
        }
    });

    Route::get('/passenger_dashboard', 'PassengerController@index')->name('passenger.index');
    Route::post('/passenger_dashboard', 'PassengerController@createTrip')->name('createTrip');
    Route::get('/driver_dashboard', 'DriverController@index')->name('driver.index');
    Route::get('/admin_dashboard', 'AdminController@index')->name('admin.index');
});

Auth::routes();
