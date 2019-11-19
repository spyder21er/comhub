<?php

namespace App\Models\Traits;

use App\Models\User;
use Illuminate\Support\Carbon;

trait PersonTrait
{
    /**
     * Associated user account of this driver
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the town model for this user
     */
    public function town()
    {
        return $this->user->town();
    }

    /**
     * Get town name of this user
     */
    public function getTownNameAttribute()
    {
        return $this->town->name;
    }

    /**
     * Get the name of this user
     */
    public function getNameAttribute()
    {
        return $this->user->name;
    }

    /**
     * Get phone of this user
     */
    public function getPhoneAttribute()
    {
        return $this->user->phone;
    }

    /**
     * Get email of this user
     */
    public function getEmailAttribute()
    {
        return $this->user->email;
    }

    /**
     * Get age of this user
     */
    public function getAgeAttribute()
    {
        return Carbon::parse($this->user->birthday)->age;
    }

    /**
     * Get first name of this user
     */
    public function getFirstNameAttribute()
    {
        return $this->user->first_name;
    }

    /**
     * Get last name of this user
     */
    public function getLastNameAttribute()
    {
        return $this->user->last_name;
    }

    /**
     * Get middle name of this user
     */
    public function getMiddleNameAttribute()
    {
        return $this->user->middle_name;
    }

    /**
     * Get birhtday of this user
     */
    public function getBirthdayAttribute()
    {
        return $this->user->birthday;
    }

    /**
     * Get hometown of this user
     */
    public function getTownIdAttribute()
    {
        return $this->user->town_id;
    }
}
