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
        $towns = Town::all()->pluck('name', 'id');
        return view('superadmin.index', compact('towns'));
    }

    /**
     * Admin registration logic
     */
    public function register_admin()
    {
        $user = $this->validateUserInformation();
        $admin = $this->validateAdminRegistration();
        $user['role_id'] = 2;
        $town_id = request()->validate([
            'town_id' => 'required|numeric'
        ]);

        $this->createUser($user, $town_id);

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
}
