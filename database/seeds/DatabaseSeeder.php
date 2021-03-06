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
        $this->call([
            RolesTableSeeder::class,
            TownsTableSeeder::class,
        ]);

        // superadmin
        $user = new User;
        $user->first_name = 'Allen';
        $user->middle_name = 'Besmonte';
        $user->last_name = 'Mabana';
        $user->email = 'spyder21er@gmail.com';
        $user->password = '$2y$10$ByS1iS7fWqWnZYD0CMV9muX2N2ahCswhDQb4uud09WLbwSBxIQCq.';
        $user->town_id = 11;
        $user->role_id = 1;
        $user->save();
    }
}
