<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Support\Facades\Auth;

class TripController extends Controller
{
    public function includeUser(Trip $trip)
    {
        $this->getTrip()->passengers()->attach(Auth::user());

        return redirect()->route('passenger.index');
    }
    
    public function excludeUser()
    {
        $this->getTrip()->passengers()->detach(Auth::user());

        return redirect()->route('passenger.index');
    }

    protected function getTrip()
    {
        return Trip::findOrFail(request()->validate([
            'trip_id' => 'required|numeric',
        ])['trip_id']);
    }

    public function show(Trip $trip)
    {
        dd($trip);
    }
}
