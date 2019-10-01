<?php

namespace App\Http\Controllers;

class DriverController extends Controller
{
    public function __construct()
    {
        $this->middleware('driver');
    }

    public function index()
    {
        return view('driver.index');
    }
}
