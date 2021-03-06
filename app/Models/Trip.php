<?php

namespace App\Models;

use App\Models\Passenger;
use Illuminate\Support\Carbon;
use Faker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Trip extends Model
{
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'driver_compliance_code',
        'passenger_compliance_code',
    ];

    protected $attributes = [
        'exclusive' => false,
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Format departure time when printing. (HH:MM AM/PM)
     */
    public function getDepartureTimeAttribute($value)
    {
        $value = new Carbon($value);
        return $value->format('h:i A');
    }

    /**
     * The town which this trip is leaving from.
     */
    public function origin()
    {
        return $this->belongsTo(Town::class);
    }

    /**
     * The town which this trip is going to.
     */
    public function destination()
    {
        return $this->belongsTo(Town::class);
    }

    /**
     * The passengers that joined this trip.
     */
    public function passengers()
    {
        return $this
            ->belongsToMany(Passenger::class, 'trip_user', 'trip_id', 'user_id')
            ->withPivot([
                'passenger_comment',
                'passenger_rating',
                'passenger_complied',
            ]);
    }

    /**
     * The driver of this trip.
     */
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    /**
     * Scope a query to only include trips today.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeToday(Builder $query)
    {
        return $query->whereDate($this->getTable() . '.created_at', Carbon::today());
    }

    /**
     * Scope sort by origin name
     */
    public function scopeByOrigin(Builder $query)
    {
        return $query->rightJoin('towns', 'towns.id', '=', 'trips.origin_id')->orderBy('towns.name');
    }

    /**
     * Scope a query to include passengers joined in this trip.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithPassengers(Builder $query)
    {
        return $query->with('passengers');
    }

    /**
     * Available trips for the logged in user
     */
    public function scopeForMe(Builder $query)
    {
        return $query->where('destination_id', Auth::user()->town_id)->orWhere('origin_id', Auth::user()->town_id);
    }

    /**
     * The total passengers included in this trip.
     *
     * @return int
     */
    public function passengerCount()
    {
        return $this->passengers()->count() + $this->guest_count;
    }

    /**
     * The maximum number of passengers allowed to join this trip.
     *
     * @return int
     */
    public function max_passenger()
    {
        return min($this->origin->max_passengers, $this->destination->max_passengers);
    }

    /**
     * Set the departure time.
     *
     * @param  string $value
     * @return void
     */
    public function setDepartureTimeAttribute($value)
    {
        $this->attributes['departure_time'] = new Carbon($value);
    }

    /**
     * Create a new trip instance with the specified data.
     *
     * @return App\Models\Trip
     */
    public static function create($data)
    {
        // First we need to exclude the creator from the guest count
        $data['guest_count']--;

        // We are going to use faker to generate codes necessary for this trip
        $faker = Faker\Factory::create();

        // Generate codes
        $codes = [
            'code'                          => $faker->regexify('[A-Z]{3}[0-9]{6}'),
            'driver_compliance_code'        => $faker->regexify('[a-z0-9]{8}'),
            'passenger_compliance_code'     => $faker->regexify('[a-z0-9]{8}'),
        ];

        $model = static::query()->create(array_merge($data, $codes));

        return $model;
    }

    /**
     * Determines if this trip is full
     */
    public function isFull()
    {
        return $this->passengerCount() == $this->max_passenger();
    }

    /**
     * Provide a link for this trip
     */
    public function getLinkAttribute()
    {
        return "<a href=" . route('trip.show', $this->id) . ">" . $this->code . "</a>";
    }

    /**
     * Determine if this trip has an associated driver
     */
    public function hasDriver()
    {
        return !is_null($this->driver);
    }

    /**
     * Determin if trip is today
     */
    public function isNotToday()
    {
        return $this->created_at->toDateString() != Carbon::today()->toDateString();
    }

    /**
     * Get compliance code depending on role of auth user
     */
    public function getComplianceCodeAttribute()
    {
        if (Auth::user()->isDriver())
            return $this->passenger_compliance_code;

        if (Auth::user()->isPassenger())
            return $this->driver_compliance_code;
    }
}
