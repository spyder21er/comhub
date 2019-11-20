<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Driver;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
            return redirect()->back()->with('danger', $assigment['message']);
        }

        return redirect()->back()->with($assigment['status'], $assigment['message']);
    }

    protected function assignDriver()
    {
        $trip = $this->validateTrip();
        $driver = (request()->has('driver_id')) ? $this->validateDriver() : Auth::user()->driver;
        if ($driver->cannotPickUpTrips()) {
            $status = 'fail';
            $message = 'You cannot pick up trips because you are ' . Str::lower($driver->status) . ($driver->status == "Banned" ? "." : " until " . $driver->penalty_lifted_at . ".");
            return compact('status', 'message');
        }
        if ($driver->hasTripToday())
        {
            if (Auth::user()->isAdmin())
            {
                return redirect()->back()->with(
                    'danger', 'Cannot assign driver.
                    The driver already has trip today or the driver already picked up the same trip.',
                );
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
            return redirect()
                ->back()
                ->with('info', $trip->link . " was assigned to " . $driver->name);
        }
        $status = 'success';
        $message = "You are picking up a trip with trip code: " . $trip->link;
        return compact('status', 'message');
    }

    protected function includePassenger()
    {
        $trip = $this->validateTrip();
        if ($trip->isFull())
        {
            $status = 'fail';
            $message = 'Cannot join. Trip is already full.';
        } else {
            $trip->passengers()->attach(Auth::user());
            $status = 'success';
            $message = 'You joined a trip going from '
                . $trip->origin->name
                . ' to '
                . $trip->destination->name
                . " with trip code: "
                . $trip->link;
        }
        return compact('status', 'message');
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
                $code = 'success';
                $msg = 'You canceled picking up trip with code ' . $trip->link . ".";
            }
            elseif (Auth::user()->isPassenger())
            {
                $trip->passengers()->detach(Auth::user());
                $code = 'success';
                $msg = 'You left trip with code ' . $trip->link . ".";
            }
        } else {
            $code = 'danger';
            $msg = 'Cannot cancel/leave trips from history.';
        }

        return redirect()->back()->with($code, $msg);
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
        return view('trips.show', compact('trip'));
    }
}
