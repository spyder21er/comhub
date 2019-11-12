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

    protected function validateDriverDetails()
    {
        $user = request()->validate([
            'first_name' => 'required',
            'middle_name' => '',
            'last_name' => 'required',
            'email' => 'required|email',
            "phone" => 'required',
            "password" => 'required|confirmed|min:8',
            "birthday" => '',
        ]);
        $user['birthday'] = (new Carbon($user['birthday']));
        $user['role_id'] = 3;

        $driver = request()->validate([
            'plate_number' => 'required',
            'license_number' => 'required',
        ]);

        return compact('user', 'driver');
    }

    protected function createUser($validated_user)
    {
        $user = User::create($validated_user);
        $user->town()->associate(Auth::user()->town);
        $user->save();

        return $user;
    }

    protected function createDriver()
    {
        // Before we create we need to validate input first
        $validated = $this->validateDriverDetails();
        $user = $this->createUser($validated['user']);
        $driver = Driver::create($validated['driver']);
        $driver->user()->associate($user);
        $driver->admin()->associate(Auth::user()->admin);
        $driver->save();

        return $driver;
    }

    public function super()
    {
        return view('admin.super');
    }
}
