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
        return $this
            ->belongsToMany(Trip::class)
            ->withPivot([
                'passenger_comment',
                'passenger_rate',
                'complied',
            ]);
    }

    public function hasTripToday()
    {
        return $this->trips()->today()->get()->isNotEmpty();
    }

    public function isPassenger()
    {
        return $this->role == Role::where('name', '=', 'passenger')->first();
    }

    public function isDriver()
    {
        return $this->role == Role::where('name', '=', 'driver')->first();
    }
}
