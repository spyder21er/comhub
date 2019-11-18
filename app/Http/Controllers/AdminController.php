<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Driver;
use App\Models\Town;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Support\Carbon;
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
        $drivers = (Auth::user()->admin->drivers) ?? null;

        // We lift suspension if it is already expired
        $drivers = $this->liftPenaltiesIfExpired($drivers);
        $trips = Trip::forMe()->today()->get();
        return view('admin.index', compact('drivers', 'trips'));
    }

    public function register_driver()
    {
        $this->createDriver();
        return redirect()->route('admin.index');
    }

    protected function validateDriverDetails()
    {
        return request()->validate([
            'plate_number' => 'required',
            'license_number' => 'required',
        ]);
    }

    /**
     * Validate input from user registration form
     */
    protected function validateUserInformation()
    {
        return $this->carbonizeBirthday(request()->validate([
            'first_name' => 'required',
            'middle_name' => '',
            'last_name' => 'required',
            'email' => 'required|email',
            "phone" => 'required',
            "password" => 'required|confirmed|min:8',
            "birthday" => '',
        ]));
    }

    /**
     * Convert birthday key into Carbon instance
     */
    protected function carbonizeBirthday($user)
    {
        $user['birthday'] = (new Carbon($user['birthday']));
        return $user;
    }

    protected function createUser($validated_user, $town)
    {
        $validated_user['password'] = Hash::make($validated_user['password']);
        $user = User::create($validated_user);
        $user->town()->associate($town);
        $user->save();

        return $user;
    }

    protected function createDriver()
    {
        // Before we create we need to validate input first
        $driver = $this->validateDriverDetails();
        $user = $this->validateUserInformation();
        $user['role_id'] = 3;
        $user = $this->createUser($user, Auth::user()->town);
        $driver = Driver::create($driver);
        $driver->user()->associate($user);
        $driver->admin()->associate(Auth::user()->admin);
        $driver->save();

        return $driver;
    }

    /**
     * Super admin dashboard and admin registration form.
     */
    public function super()
    {
        $admins = Admin::all();
        $towns = Town::all()->pluck('name', 'id');
        return view('superadmin.index', compact('towns', 'admins'));
    }

    /**
     * Admin registration logic
     */
    public function register_admin()
    {
        $user = $this->validateUserInformation();
        $admin = $this->validateAdminRegistration();
        $user['role_id'] = 2;
        $town = request()->validate([
            'town_id' => 'required|numeric'
        ]);

        $user = $this->createUser($user, Town::find($town['town_id']));
        $admin = Admin::create($admin);
        $admin->user()->associate($user);
        $admin->save();

        return redirect()->route('admin.super');
    }

    /**
     * Validate inputs from Admin Registration Form
     */
    protected function validateAdminRegistration()
    {
        return request()->validate([
            'org_acronym'   => 'required',
            'org_name'      => 'required|max:255',
        ]);
    }

    /**
     * Ban driver
     */
    public function banDriver()
    {
        // validate input
        $input = request()->validate([
            "driver_id" => 'required|numeric',
        ]);

        $driver = Driver::find($input['driver_id']);
        $driver->status = "banned";
        $driver->save();

        return redirect()->route('admin.index');
    }

    /**
     * Suspend driver
     */
    public function suspendDriver()
    {
        // validate input
        $input = request()->validate([
            "driver_id" => 'required|numeric',
            "duration" => 'required|numeric',
            "duration_units" => 'required',
        ]);
        $until = Carbon::now();
        if ($input['duration_units'] == 'day')
        {
            $until->addDay($input['duration']);
        }
        elseif ($input['duration_units'] == 'month')
        {
            $until->addMonth($input['duration']);
        }

        $driver = Driver::find($input['driver_id']);
        $driver->status = "suspended";
        $driver->penalty_lifted_at = $until;
        $driver->save();

        return redirect()->route('admin.index');
    }

    /**
     * Lift bans and suspensions to drivers
     */
    public function liftPenaltiesIfExpired($drivers)
    {
        if ($drivers)
        {
            $now = Carbon::now();
            $drivers->each(function($driver) use ($now) {
                if ($driver->penalty_lifted_at)
                {
                    if ($driver->penalty_lifted_at->lessThanOrEqualTo($now))
                    {
                        $driver->status = null;
                        $driver->penalty_lifted_at = null;
                        $driver->save();
                    }
                }
            });
        }

        return $drivers;
    }

    /**
     * Lift penalty of driver
     */
    public function liftPenaltyDriver()
    {
        // validate input
        $input = request()->validate([
            "driver_id" => 'required|numeric',
        ]);

        $driver = Driver::find($input['driver_id']);
        $this->liftPenalties($driver);

        return redirect()->route('admin.index');
    }

    public function liftPenalties($driver)
    {
        $driver->status = null;
        $driver->penalty_lifted_at = null;
        $driver->save();
    }
}
