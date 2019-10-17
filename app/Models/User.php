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
    protected $fillable = [
        'name', 'email', 'password', 'role_id',
    ];

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

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function trips()
    {
        $relation = $this->belongsToMany(Trip::class);
        if ($this->isPassenger())
            return $relation->withPivot([
                    'passenger_comment',
                    'passenger_rate',
                    'complied',
                ]);
        elseif ($this->isDriver()) {
            return $relation;
        }

        // 
        return null;
    }

    public function hasTripToday()
    {
        return $this->trips()->today()->get()->isNotEmpty();
    }

    public function isPassenger()
    {
        return $this->isRole('passenger');
    }

    public function isDriver()
    {
        return $this->isRole('driver');
    }

    public function isRole($name)
    {
        return $this->role == Role::where('name', '=', $name)->first();
    }

    public function leaveButtonName()
    {
        if ($this->isPassenger())
            return 'Leave';
        elseif ($this->isDriver()) {
            return 'Cancel Fetch';
        }

        return null;
    }

    public function joinButtonName()
    {
        if ($this->isPassenger())
            return 'Join';
        elseif ($this->isDriver()) {
            return 'Fetch';
        }

        return null;
    }
}
