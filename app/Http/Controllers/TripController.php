<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Driver;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TripController extends Controller
{
    public function includeUser()
    {
        if (Auth::user()->isDriver()) {
            $this->assignDriver();
        }
        elseif (Auth::user()->isPassenger())
        {
            $this->includePassenger();
        }

        return redirect()->route('passenger.index');
    }

    protected function assignDriver()
    {
        $trip = $this->getTrip();
        $trip->driver()->associate(Auth::user()->driver);
        $trip->save();
    }

    protected function includePassenger()
    {
        if ($this->getTrip()->isFull())
        {
            return redirect()->back()->withErrors([
                'default' => 'Cannot join. Trip is already full.',
            ]);
        }
        $this->getTrip()->passengers()->attach(Auth::user());
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
