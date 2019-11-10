<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    /**
     * Trips fetched by this driver
     */
    public function trips()
    {
        return $this->hasMany(Trip::class);
    }

    /**
     * Administrator of this driver.
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * Total number of trips hailed by this driver.
     */
    public function hailedTrips()
    {
        return $this->trips->count();
    }

    /**
     * Total number of confirmed trips
     */
    public function confirmedTrips()
    {
        // TODO: This should be fixed
        return $this->trips->count();
    }

    /**
     * Total number of unconfirmed trips
     */
    public function unconfirmedTrips()
    {
        // TODO: This should be fixed
        return $this->trips->count();
    }

    /**
     * Ratio of confirmed trips to total trips hailed.
     */
    public function credibilityPoints()
    {
        if ($this->hailedTrips() == 0)
            return "None";

        return $this->confirmedTrips() / $this->hailedTrips() * 100;
    }

    /**
     * Town of this driver
     */
    public function town()
    {
        return $this->hasOneThrough(Town::class, User::class, 'id', 'id', 'user_id', 'town_id');
    }

    /**
     * Associated user account of this driver
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Organization of this driver
     */
    public function getOrganizationAttribute()
    {
        return $this->admin->org_acronym;
    }

    /**
     * Scope to filter drivers that belongs to a particular town
     */
    public function scopeWhereTown($query, $town_id)
    {
        return $query->whereHas('user', function($q) use ($town_id) {
            $q->where('town_id', $town_id);
        });
    }
}
