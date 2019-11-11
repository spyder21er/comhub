<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
            return 'Cancel Fetch';
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
            return 'Fetch';
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

        return null;
    }

    /**
     * Determine if this user is a driver and has trip today
     */
    public function driverHasTripToday()
    {
        if ($this->isDriver())
            return $this->driver->trips()->today()->get()->isNotEmpty();
    }
    
    /**
     * Determine if this user is a passenger and has trip today
     */
    public function passengerHasTripToday()
    {
        if ($this->isPassenger())
            return $this->trips()->today()->get()->isNotEmpty();
    }
}
