<?php

namespace App\Http\Controllers;

use App\Models\Trip;
class DriverController extends Controller
{
    public function __construct()
    {
        $this->middleware('driver');
    }

    public function index()
    {
        $trips = Trip::today()->get();
        return view('driver.index', compact('trips'));
    }
}
