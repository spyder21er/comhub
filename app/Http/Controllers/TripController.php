<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TripController extends Controller
{
    /**
     *  Include the passenger or driver associated with this trip
     */
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

    /**
     * Assign driver for this trip
     */
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

    /**
     *  Include the authenticated passenger to this trip
     */
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

    /**
     *  Remove the passenger or driver associated with this trip
     */
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

    /**
     * Validate trip id from input
     */
    protected function validateTrip()
    {
        return Trip::findOrFail(request()->validate([
            'trip_id' => 'required|numeric',
        ])['trip_id']);
    }

    /**
     * Validate driver id from input
     */
    protected function validateDriver()
    {
        return Driver::findOrFail(request()->validate([
            'driver_id' => 'required|numeric',
        ])['driver_id']);
    }

    /**
     * Show the information of this trip
     */
    public function show(Trip $trip)
    {
        $trip = Trip::with('passengers')->find($trip->id);
        return view('trips.show', compact('trip'));
    }

    /**
     * Add or edit a comment for this trip
     */
    public function comment(Trip $trip)
    {
        if ($trip->passengers->contains(Auth::user())) {
            // we dont need to validate the comment so;
            $trip->passengers()->updateExistingPivot(Auth::user()->id, ['passenger_comment' => request()->passenger_comment]);
            $code = "success";
            $msg = "Successfully added/edited comment!";
        } else {
            $code = "danger";
            $msg = "Cannot add a comment to a trip you don't belong to.";
        }
        return redirect()->back()->with($code, $msg);
    }

    /**
     * Add or edit a comment for this trip
     */
    public function comply(Trip $trip)
    {
        if ($trip->passengers->contains(Auth::user())) {
            // we dont need to validate the comment so;
            if ($trip->passenger_compliance_code == request()->compliance_code)
            {
                $trip->passengers()->updateExistingPivot(Auth::user()->id, ['passenger_complied' => 1]);
                $code = "success";
                $msg = "Successfully complied!";
            }
            else
            {
                $code = "danger";
                $msg = "Incorrect compliance code!";
            }
        } else {
            $code = "danger";
            $msg = "Cannot comply to a trip you don't belong to.";
        }
        return redirect()->back()->with($code, $msg);
    }
}
