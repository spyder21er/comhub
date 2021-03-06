<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the role of this user.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the town of this user.
     */
    public function town()
    {
        return $this->belongsTo(Town::class);
    }

    /**
     * Get the trips of this user.
     */
    public function trips()
    {
        if ($this->isPassenger())
            return $this
                ->belongsToMany(Trip::class, 'trip_user', 'user_id', 'trip_id')
                ->withPivot([
                    'passenger_comment',
                    'passenger_rating',
                    'passenger_complied',
                ]);
        elseif ($this->isDriver())
        {
            return $this->hasManyThrough(Trip::class, Driver::class);
        }

        return null;
    }

    /**
     * Mutate birthday to carbon instance before saving
     */
    public function setBirthdayAttribute($value)
    {
        $this->attributes['birthday'] = (new Carbon($value));
    }

    /**
     * Accessor for birthday
     */
    public function getBirthdayAttribute()
    {
       return (new Carbon($this->attributes['birthday']));
    }

    /**
     * Determine if user has trip today.
     */
    public function hasTripToday()
    {
        if ($this->isDriver())
            return $this->driverHasTripToday();
        elseif ($this->isPassenger())
            return $this->passengerHasTripToday();
    }

    /**
     * Determine if user is passenger.
     */
    public function isPassenger()
    {
        return $this->isRole('passenger');
    }

    /**
     * Determine if user is admin.
     */
    public function isAdmin()
    {
        return $this->isRole('admin');
    }

    /**
     * Determine if user is super admin.
     */
    public function isSuperAdmin()
    {
        return $this->isRole('super_admin');
    }

    /**
     * Determine if user is driver.
     */
    public function isDriver()
    {
        return $this->isRole('driver');
    }

    /**
     * Determine if user has the role specified.
     *
     * @param string $name
     * @return bool
     */
    public function isRole($name)
    {
        return $this->role == Role::where('name', '=', $name)->first();
    }

    /**
     * Returns the text of leave button used in view.
     */
    public function leaveButtonName()
    {
        if ($this->isPassenger())
            return 'Leave';
        elseif ($this->isDriver()) {
            return 'Cancel Pick up';
        }

        return null;
    }

    /**
     * Returns the text of join button used in view.
     */
    public function joinButtonName()
    {
        if ($this->isPassenger())
            return 'Join';
        elseif ($this->isDriver()) {
            return 'Pick up';
        }

        return null;
    }

    /**
     * Determine if this user has trip on specified date.
     *
     * @param Carbon $date
     * @return bool
     */
    public function hasTripOn(Carbon $date)
    {
        return $this->trips()->where('created_at', '=', $date)->get()->isNotEmpty();
    }

    /**
     * To append on brand name
     */
    public function brandAppend()
    {
        if ($this->isAdmin() || $this->isDriver())
        {
            return " - " . $this->organization;
        }

        return '';
    }

    /**
     * Get organization of this user if admin or driver
     */
    public function getOrganizationAttribute()
    {
        if ($this->isAdmin() || $this->isDriver()) {
            if ($this->isDriver()) {
                return Driver::where('user_id', $this->id)->first()->organization;
            }
            return Admin::where('user_id', $this->id)->first()->org_acronym;
        }

        return '';
    }

    /**
     * Get name of this user
     */
    public function getNameAttribute()
    {
        return $this->first_name . " " . $this->last_name;
    }

    /**
     * Get driver model for this user if this is a driver
     */
    public function driver()
    {
        if ($this->isDriver()) {
            return $this->hasOne(Driver::class);
        }
    }

    /**
     * Get admin model for this user if this is a admin
     */
    public function admin()
    {
        if ($this->isAdmin()) {
            return $this->hasOne(Admin::class);
        }
    }

    /**
     * Determine if this user is a driver and has trip today
     */
    public function driverHasTripToday()
    {
        if ($this->isDriver())
            return $this->driver->hasTripToday();
    }

    /**
     * Determine if this user is a passenger and has trip today
     */
    public function passengerHasTripToday()
    {
        if ($this->isPassenger())
            return $this->trips()->today()->get()->isNotEmpty();
    }

    /**
     * Determine if this user can assign a driver to a trip
     */
    public function canAssignDriver()
    {
        return $this->isAdmin() || $this->isDriver();
    }

    /**
     * Get the comment of this user for the given trip id
     */
    public function comment($trip)
    {
        if ($this->joined($trip))
        {
            if ($trip instanceof Trip)
                $trip = $trip->id;

            return $this->trips()->where('trip_id', $trip)->first()->pivot->passenger_comment;
        }
    }

    /**
     * Determine if this user complied for the given trip id
     */
    public function complied($trip)
    {
        if ($this->joined($trip))
        {
            if (!($trip instanceof Trip))
                $trip = Trip::findOrFail($trip);

            if ($this->isDriver())
                return $trip->driver_complied;
            else
            {
                return $this->trips()->where('trip_id', $trip->id)->first()->pivot->passenger_complied;
            }
        }

        return false;
    }

    /**
     * Determine if this user joined in given trip id
     */
    public function joined($trip)
    {
        if ($this->isDriver() || $this->isPassenger())
        {
            if (!($trip instanceof Trip))
                $trip = Trip::findOrFail($trip);
            return $this->trips->contains($trip);
        }

        return false;
    }

    /**
     * Get home view for this user
     */
    public function getHomeView()
    {
        if ($this->isSuperAdmin())
            return 'admin.super';
        if ($this->isAdmin())
            return 'admin.index';
        if ($this->isDriver())
            return 'driver.index';

        return 'passenger.index';
    }
}
