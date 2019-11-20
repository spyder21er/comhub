<?php

namespace App\Http\Controllers;

use App\Models\Town;
use App\Models\Trip;
use Illuminate\Support\Carbon;
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

        $my_trips = Auth::user()->trips()->orderBy('created_at', 'desc')->get();
        $trips = Trip::today()->with('passengers')->get();

        $my_trip_today = null;
        foreach ($trips as $key => $trip)
        {
            // if the user is a passenger of this trip
            // let's move this trip to the top of the list
            if ($trip->passengers->contains(Auth::user()))
            {
                $my_trip_today = $trips->pull($key);
                break;
            }
        }
        if ($my_trip_today) $trips->prepend($my_trip_today);

        $towns = Town::all()->pluck('name', 'id');
        return view('passenger.index', compact('towns', 'trips', 'my_trips'));
    }

    public function createTrip()
    {
        if (Auth::user()->hasTripToday())
            return redirect()->back()->with(
                'danger', "Can't create new trip if you have existing trip for the day."
            );

        $validated = request()->validate([
            'origin_id' => 'required',
            'destination_id' => 'required',
            'departure_time' => ['required', 'regex:/[0-1]?[0-9]:[0-5][0-9] (A|P)M/i'],
            'guest_count' => 'required',
        ]);

        // Naga (id=11) should be in origin only or destination only
        if (($validated['origin_id'] == 11) == ($validated['destination_id'] == 11))
        {
            return redirect()->back()->with(
                'info', "Sorry, there is no available trip from "
                    . Town::find((int) $validated['origin_id'])->name
                    . " to "
                    . Town::find((int) $validated['destination_id'])->name
                    . "."
            );
        }

        $same_trip = Trip::today()->where([
            ['origin_id',       '=', $validated['origin_id']],
            ['destination_id',  '=', $validated['destination_id']],
            ['departure_time',  '=', (new Carbon($validated['departure_time']))->format('H:i:s')],
        ])->get();

        // if there is same trip existing
        if (!$same_trip->isEmpty())
        {
            foreach ($same_trip as $trip)
            {
                // if the same trip is not full
                if (!$trip->isFull())
                {
                    $trip->passengers()->attach(Auth::user());
                    return redirect()->route('passenger.index');
                }
            }
        }
        Trip::create($validated)->passengers()->attach(Auth::user());

        return redirect()->route('passenger.index');
    }
}
