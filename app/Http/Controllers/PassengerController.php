<?php

namespace App\Http\Controllers;

use App\Models\Town;
use App\Models\Trip;
use Carbon\Carbon;

class PassengerController extends Controller
{
    public function __construct()
    {
        $this->middleware('passenger');
    }

    /**
     * Handle index request
     * 
     * @return View
     */
    public function index()
    {
        $trips = Trip::whereDate('created_at', Carbon::today())->get();
        $towns = Town::all()->pluck('name', 'id');
        return view('passenger.index', compact('towns', 'trips'));
    }

    public function createTrip()
    {
        $validated = request()->validate([
            'origin' => 'required',
            'destination' => 'required',
            'departure_time' => ['required', 'regex:/[0-1]?[0-9]:[0-5][0-9] (A|P)M/i'],
            'passenger_count' => 'required',
        ]);

        dd($validated);
    }
}
