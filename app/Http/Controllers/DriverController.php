<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Town;
use App\Models\Driver;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
class DriverController extends Controller
{
    public function __construct()
    {
        $this->middleware('driver');
    }

    public function index()
    {
        $my_trips = Driver::find(Auth::user()->id)->trips()->orderBy('created_at', 'desc')->get();
        $trips = Trip::today()->forMe(Auth::user())->get();
        $towns = Town::all()->pluck('name', 'id');
        return view('passenger.index', compact('towns', 'trips', 'my_trips'));
    }
}
