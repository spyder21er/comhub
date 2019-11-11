<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Driver;
use App\Models\Role;
use App\Models\Trip;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $drivers = Auth::user()->admin->drivers;
        return view('admin.index', compact('drivers'));
    }

    public function register_driver()
    {
        $this->createDriver();
        return redirect()->route('admin.index');
    }

    protected function createDriver()
    {
        // Before we create we need to validate input first
        $validated_user = request()->validate([
            'first_name' => 'required',
            'middle_name' => '',
            'last_name' => 'required',
            'email' => 'required|email',
            "phone" => 'required',
            "password" => 'required|confirmed|min:8',
            "birthday" => '',
        ]);

        $validated_user['birthday'] = (new Carbon($validated_user['birthday']));
        $validated_user['role_id'] = 3;
        $user = User::create($validated_user);
        $user->town()->associate(Auth::user()->town);
        $user->save();

        $validated_driver = request()->validate([
            'plate_number' => 'required',
            'license_number' => 'required',
        ]);

        $driver = Driver::create($validated_driver);

        $driver->user()->associate($user);
        $driver->admin()->associate(Admin::where('user_id', $user->id)->first());
        $driver->save();

        // dump($driver);
        // dd($user);

        return $driver;
    }

    public function super()
    {
        return view('admin.super');
    }

    public function showDriver(Driver $driver)
    {
        // If driver is under admin, show driver profile
        if (Auth::user()->admin->drivers->contains($driver))
            return view('admin.driver-profile', compact('driver'));

        // Redirect to admin index otherwise
        return redirect()->route('admin.index');
    }
}
