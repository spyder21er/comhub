<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Admin;
use App\Models\Driver;
use App\Models\Passenger;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Required for production
        $this->call(TownsTableSeeder::class);

        // For development only:
        $this->call([
            RolesTableSeeder::class,
            UsersTableSeeder::class,
        ]);
        $this->call(TripsTableSeeder::class);
    }
}
