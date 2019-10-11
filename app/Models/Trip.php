<?php

namespace App\Models;

use App\MOdels\Passenger;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Faker;

class Trip extends Model
{
    protected $hidden = [
        'driver_compliance_code',
        'passenger_compliance_code',
    ];

    protected $attributes = [
        'exclusive' => false,
    ];

    protected $guarded = [];

    /**
     * Format departure time when printing HH:MM AM/PM.
     */
    public function getDepartureTimeAttribute($value)
    {
        $value = new Carbon($value);
        return $value->format('h:i A');
    }

    public function getCreatedAtAttribute($value)
    {
        return (new Carbon($value))->format('m-d-y');
    }

    /**
     * Which town this trip is leaving from.
     */
    public function origin()
    {
        return $this->belongsTo(Town::class);
    }

    /**
     * Which town this trip is going to.
     */
    public function destination()
    {
        return $this->belongsTo(Town::class);
    }

    /**
     * The passengers that join this trip.
     */
    public function passengers()
    {
        return $this
            ->belongsToMany(Passenger::class, 'trip_user', 'trip_id', 'user_id')
            ->withPivot([
                'passenger_comment',
                'passenger_rate',
                'complied',
            ]);
    }

    /**
     * Get the status of the currently authenticatied user for this trip
     */
    public function status()
    {
        // Todo
    }

    /**
     * Scope a query to only include trips today.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeToday($query)
    {
        return $query->whereDate($this->getTable() . '.created_at', Carbon::today());
    }

    /**
     * Scope a query to include passengers joined in this trip.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithPassengers($query)
    {
        return $query->with('passengers');
    }

    public function passengerCount()
    {
        return $this->passengers()->count() + $this->guest_count;
    }

    public function max_passenger()
    {
        return min($this->origin->max_passengers, $this->destination->max_passengers);
    }

    public static function create($data)
    {
        $data['departure_time']             = new Carbon($data['departure_time']);
        // We need to exclude the creator from the guest count
        $data['guest_count']--;
        $faker = Faker\Factory::create();
        $codes = [
            'code'                          => $faker->regexify('[A-Z]{3}[0-9]{6}'),
            'driver_compliance_code'        => $faker->regexify('[a-z0-9]{8}'),
            'passenger_compliance_code'     => $faker->regexify('[a-z0-9]{8}'),
        ];
        $model = static::query()->create(array_merge($data, $codes));

        return $model;
    }

}
