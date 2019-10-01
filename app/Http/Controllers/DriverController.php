<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
