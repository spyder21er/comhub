<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Town;
use Illuminate\Support\Facades\Auth;
class DriverController extends Controller
{
    public function __construct()
    {
        $this->middleware('driver');
    }

    public function index()
    {
        $my_trips = Auth::user()->trips()->get();
        $trips = Trip::today()->get();
        $test = Trip::first();
        dd($test->driver);
        $towns = Town::all()->pluck('name', 'id');
        return view('passenger.index', compact('towns', 'trips', 'my_trips'));
    }
}
