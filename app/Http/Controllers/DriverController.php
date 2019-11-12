<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Driver;
use Illuminate\Support\Facades\Auth;

class DriverController extends Controller
{
    public function index()
    {
        $my_trips = Auth::user()->driver->trips()->latest()->get();
        $trips = Trip::today()->forMe(Auth::user())->get();
        return view('passenger.index', compact('trips', 'my_trips'));
    }

    /**
     * Show driver profile
     */
    public function show(Driver $driver)
    {
        return view('admin.driver-profile', compact('driver'));
    }
}
