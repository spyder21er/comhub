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
        if (Auth::user()->canAssignDriver()) {
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
        $trip = $this->validateTrip();
        $driver = (request()->has('driver_id')) ? $this->validateDriver() : Auth::user()->driver;
        if ($driver->cannotPickUpTrips()) {
            $status = 'fail';
            $message = 'Cannot pick up trips. You are banned or suspended.';
            return compact('status', 'message');
        }
        if ($driver->hasTripToday())
        {
            if (Auth::user()->isAdmin())
            {
                return redirect()->back()->withErrors([
                    'default' => 'Cannot assign driver.
                    The driver already has trip today or the driver already picked up the same trip.',
                ]);
            }
            $status = 'fail';
            $message = 'Cannot pick up. You already have trip today.';
            return compact('status', 'message');
        }
        if ($trip->hasDriver())
        {
            $status = 'fail';
            $message = 'Cannot pick up. Trip already has a driver.';
            return compact('status', 'message');
        }
        $trip->driver()->associate($driver);
        $trip->save();
        if (Auth::user()->isAdmin())
        {
            return redirect()->route('admin.index');
        }
    }

    protected function includePassenger()
    {
        if ($this->validateTrip()->isFull())
        {
            $status = 'fail';
            $message = 'Cannot join. Trip is already full.';
            return compact('status', 'message');
        }
        $this->validateTrip()->passengers()->attach(Auth::user());
    }

    public function excludeUser()
    {
        $trip = $this->validateTrip();
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

    protected function validateTrip()
    {
        return Trip::findOrFail(request()->validate([
            'trip_id' => 'required|numeric',
        ])['trip_id']);
    }

    protected function validateDriver()
    {
        return Driver::findOrFail(request()->validate([
            'driver_id' => 'required|numeric',
        ])['driver_id']);
    }

    public function show(Trip $trip)
    {
        dd($trip);
    }
}
