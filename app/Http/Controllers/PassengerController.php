<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PassengerController extends Controller
{
    /**
     * Handle index request
     * 
     * @return View
     */

    public function index()
    {
        return view('passenger.index');
    }
}
