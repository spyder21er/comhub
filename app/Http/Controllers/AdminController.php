<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Trip;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $drivers = Admin::find(Auth::user()->id)->drivers;
        return view('admin.index', compact('drivers'));
    }
}
