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
            $assigment = $this->assignDriver();
        }
        elseif (Auth::user()->isPassenger())
        {
            $assigment = $this->includePassenger();
        }

        if ($assigment['status'] == 'fail')
        {
            return redirect()->back()->withErrors([
                'default' => $assigment['message'],
            ]);
        }

        return redirect()->route('passenger.index');
    }

    protected function assignDriver()
    {
        $trip = $this->getTrip();
        if ($trip->hasDriver())
        {
            $status = 'fail';
            $message = 'Cannot pick up. Trip already has a driver.';
            return compact('status', 'message');
        }
        $trip->driver()->associate(Auth::user()->driver);
        $trip->save();
    }

    protected function includePassenger()
    {
        if ($this->getTrip()->isFull())
        {
            $status = 'fail';
            $message = 'Cannot join. Trip is already full.';
            return compact('status', 'message');
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
