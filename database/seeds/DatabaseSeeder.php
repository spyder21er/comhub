<?php

use Illuminate\Database\Seeder;
use App\Models\User;

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
        factory(User::class, 250)->create();
        $this->call(TripsTableSeeder::class);
    }
}
