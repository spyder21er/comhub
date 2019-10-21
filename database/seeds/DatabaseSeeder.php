<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Admin;

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
        factory(Admin::class, 25)->create();
        factory(User::class, 350)->create();
        $this->call(TripsTableSeeder::class);
    }
}
