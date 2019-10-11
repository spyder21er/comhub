<?php

namespace App\Http\Controllers;

use App\Models\Passenger;
use App\Models\Town;
use App\Models\Trip;
use Illuminate\Support\Facades\Auth;

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
        $my_trips = Auth::user()->trips()->today()->get();
        $trips = Trip::today()->get();
        $towns = Town::all()->pluck('name', 'id');
        return view('passenger.index', compact('towns', 'trips', 'my_trips'));
    }

    public function createTrip()
    {
        // TODO
        // 1. Check if user has existing trip today
        // if (Auth::user()->hasTripToday())
        // prevent trip creation
        // flash error message
        // redirect back

        $validated = request()->validate([
            'origin_id' => 'required',
            'destination_id' => 'required',
            'departure_time' => ['required', 'regex:/[0-1]?[0-9]:[0-5][0-9] (A|P)M/i'],
            'guest_count' => 'required',
        ]);

        $same_trip = Trip::today()->where([
            ['origin_id',       '=', $validated['origin_id']],
            ['destination_id',  '=', $validated['destination_id']],
        ])->get();
        
        if ($same_trip->isEmpty())
        {
            Trip::create($validated)->passengers()->attach(Auth::user());
            return redirect()->route('passenger.index');
        }
        
        return redirect()->route('trip.includeUser', ['trip' => $same_trip->first()->id]);
    }
}
