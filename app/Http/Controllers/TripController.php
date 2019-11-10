<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TripController extends Controller
{
    public function includeUser(Trip $trip)
    {
        if (Auth::user()->isDriver()) {
            $trip = $this->getTrip();
            $trip->driver()->associate(Auth::user());
            $trip->save();
        }
        elseif(Auth::user()->isPassenger())
        {
            $this->getTrip()->passengers()->attach(Auth::user());
        }

        return redirect()->route('passenger.index');
    }

    public function excludeUser()
    {
        $trip = $this->getTrip();
        // Trips can only be cancelled if it is today
        if ($trip->created_at->isSameDay(Carbon::today())) {
            if (Auth::user()->isDriver())
            {
                $trip->driver()->dissociate();
                $trip->save();
            }
            elseif (Auth::user()->isPassenger())
            {
                $trip->passengers()->detach(Auth::user());
            }
        }

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
