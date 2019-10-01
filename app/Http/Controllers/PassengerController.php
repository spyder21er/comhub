<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return view('passenger.index');
    }

    public function createTrip(Request $request)
    {
        dump($request->has('exclusive'));
        dd($request->all());
    }
}
