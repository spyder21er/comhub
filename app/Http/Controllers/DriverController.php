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
        $my_trips = Auth::user()->driver->trips()->latest()->get();
        $trips = Trip::today()->forMe(Auth::user())->get();
        return view('passenger.index', compact('trips', 'my_trips'));
    }
}
