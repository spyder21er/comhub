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
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        if (!Auth::user()->admin->active)
            return view('admin.deactivated');

        $drivers = (Auth::user()->admin->drivers) ?? null;

        // We lift suspension if it is already expired
        $drivers = $this->lift_driver_penalties_if_expired($drivers);
        $trips = Trip::forMe()->today()->get();
        return view('admin.index', compact('drivers', 'trips'));
    }

    public function register_driver()
    {
        $this->createDriver();
        return redirect()->route('admin.index')->with('success', 'Succesfully registered new driver account!');
    }

    protected function validateDriverDetails()
    {
        return request()->validate([
            'plate_number' => 'required',
            'license_number' => 'required',
            'license_expiry' => 'required|date',
        ]);
    }

    /**
     * Show edit admin form
     */
    public function edit_admin(Admin $admin)
    {
        $towns = Town::all()->pluck('name', 'id');
        $edit_mode = 1;
        return view('superadmin.edit-admin', compact('admin', 'towns', 'edit_mode'));
    }

    /**
     * Update admin information
     */
    public function update_admin(Admin $admin)
    {
        $updateUser = $this->validateUserInformation(true, $admin->user);
        $updateAdmin = $this->validateAdminInformation();
        $admin->user->update($updateUser);
        $admin->update($updateAdmin);

        $admin->user->town()->associate(
            Town::find(request()->validate([
                'town_id' => 'required|numeric'
            ])['town_id'])
        )->save();

        return redirect()->route('admin.super')->with('success', 'Succesfully updated admin information!');
    }

    /**
     * Validate input from user registration form
     */
    protected function validateUserInformation($edit_mode = false, $user = null)
    {
        $columns = [
            'first_name' => 'required',
            'middle_name' => '',
            'last_name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user),
            ],
            'phone' => 'required',
            'birthday' => '',
        ];

        if (!$edit_mode)
        {
            $columns['password'] = 'required|confirmed|min:8';
        }

        return request()->validate($columns);
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
        $admins = Admin::orderBy('active', 'desc')->get();
        $towns = Town::all()->pluck('name', 'id');
        $edit_mode = 0;
        return view('superadmin.index', compact('towns', 'admins', 'edit_mode'));
    }

    /**
     * Admin registration logic
     */
    public function register_admin()
    {
        $user = $this->validateUserInformation();
        $admin = $this->validateAdminInformation();
        $user['role_id'] = 2;
        $town = request()->validate([
            'town_id' => 'required|numeric'
        ]);

        $user = $this->createUser($user, Town::find($town['town_id']));
        $admin = Admin::create($admin);
        $admin->user()->associate($user);
        $admin->save();

        return redirect()->back()->with('success', 'Succesfully registered new admin account!');
    }

    /**
     * Validate inputs from Admin Registration Form
     */
    protected function validateAdminInformation()
    {
        return request()->validate([
            'org_acronym'   => 'required',
            'org_name'      => 'required|max:255',
        ]);
    }

    /**
     * Ban driver
     */
    public function ban_driver()
    {
        // validate input
        $input = request()->validate([
            "driver_id" => 'required|numeric',
        ]);

        $driver = Driver::find($input['driver_id']);
        $driver->status = "banned";
        $driver->save();

        return redirect()
            ->route('admin.index')
            ->with('warning', $driver->name . " was banned!");
    }

    /**
     * Suspend driver
     */
    public function suspend_driver()
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

        return redirect()
            ->route('admin.index')
            ->with('warning', $driver->name . " was suspended for " . $input['duration'] . " " . $input['duration_units'] . "(s)");
    }

    /**
     * Lift bans and suspensions to drivers
     */
    public function lift_driver_penalties_if_expired($drivers)
    {
        if ($drivers)
        {
            $now = Carbon::now();
            $drivers->each(function($driver) use ($now) {
                if ($driver->penalty_lifted_at)
                {
                    if ($driver->penalty_lifted_at->lessThanOrEqualTo($now))
                    {
                        $driver->status = 'active';
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
    public function lift_driver_penalty()
    {
        // validate input
        $input = request()->validate([
            "driver_id" => 'required|numeric',
        ]);

        $driver = Driver::find($input['driver_id']);
        $this->lift_penalty($driver);

        return redirect()
            ->route('admin.index')
            ->with('info', "Penalty for " . $driver->name . " was lifted!");
    }

    public function lift_penalty($driver)
    {
        $driver->status = 'active';
        $driver->penalty_lifted_at = null;
        $driver->save();
    }

    /**
     * Toggle account status of this admin
     */
    public function changeAdminStatus(Admin $admin)
    {
        // if (request()->ajax())
        // {
        //     $message['success'] = 'test succes woot! wehe';
        //     return response()->json(['success' => 'test succes woot! wehe']);
        // }
        // only super admin can change this
        if (Auth::user()->isSuperAdmin())
        {
            $admin->active = !$admin->active;
            $admin->save();
            if (request()->ajax())
            {
                return response()->json([
                    'account_status' => $admin->account_status,
                    'button_style' => $admin->button_style,
                    'change_status_command' => $admin->change_status_command,
                ]);
            }
            return redirect()->back();
        }
    }
}
