<?php

namespace App\Models;

use App\Scopes\DriverScope;

class Driver extends User
{
    /**
     * Table associated with this model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Booting method and add global scope for this model.
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DriverScope);
    }

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
}
