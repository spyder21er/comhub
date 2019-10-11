<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Support\Facades\Auth;

class TripController extends Controller
{
    public function includeUser(Trip $trip)
    {
        $trip->passengers()->attach(Auth::user());
        dd($trip);
    }
}
