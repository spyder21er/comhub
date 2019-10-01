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
        $this->call([
            UserRolesTableSeeder::class,
            UsersTableSeeder::class,
        ]);

        factory(User::class, 30)->create();
    }
}
