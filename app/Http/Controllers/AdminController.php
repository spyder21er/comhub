<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Driver;
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

    public function register_driver()
    {
        $driver = $this->getDriverDetails();
        dd($driver);
        return redirect()->route('admin.index');
    }

    protected function getDriverDetails()
    {
        $validated = request()->validate([
            'first_name' => 'required',
            'middle_name' => '',
            'last_name' => 'required',
            'email' => 'required|email',
        ]);

        $newDriver['name'] = $validated['first_name'] . " " . $validated['last_name'];
        $newDriver['admin_id'] = Auth::user()->id;
        // TODO what about default password?

        $driver = Driver::create(array_merge($validated, $newDriver));

        return $driver;
    }
}
