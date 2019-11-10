<?php

use App\Models\Admin;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Database\Seeder;

class DriversTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // let's create 4 drivers for each admin
        $admins = Admin::all();

        foreach ($admins as $admin)
        {
            $users = factory(User::class, 4)->create();

            foreach ($users as $user)
            {
                $user->role_id = 3;
                $user->town_id = $admin->town->id;
                $user->save();
                $driver = factory(Driver::class)->create();
                $driver->user_id = $user->id;
                $driver->admin_id = $admin->id;
                $driver->save();
            }
        }
    }
}
