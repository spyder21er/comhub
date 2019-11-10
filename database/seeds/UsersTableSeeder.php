<?php

use App\Models\Admin;
use App\Models\Driver;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Town;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // superadmin
        $user = factory(User::class)->create();
        $user->first_name = 'Allen';
        $user->middle_name = 'Besmonte';
        $user->last_name = 'Mabana';
        $user->email = 'spyder21er@gmail.com';
        $user->role_id = 1;
        $user->save();

        $towns = Town::all();

        $roles = [2 => 'admin', 3 => 'driver', 4 => 'passenger'];

        // let's create user for each role and each town
        foreach ($roles as $role_id => $role)
        {
            foreach ($towns as $town)
            {
                if ($town->id == 11 && ($role == 'admin' || $role == 'driver')) continue;
                $town_name = Str::lower($town->name);

                $user = factory(User::class)->create();
                $user->role_id = $role_id;
                $user->town_id = $town->id;
                $user->email = $town_name . "." . $role . "@comhub.com";
                $user->save();

                if ($role == 'admin')
                {
                    $admin = factory(Admin::class)->create();
                    $admin->user_id = $user->id;
                    $admin->save();
                }

                if ($role == 'driver')
                {
                    $driver = factory(Driver::class)->create();
                    $driver->user_id = $user->id;
                    $driver->admin_id =
                        Admin::where('user_id',
                                User::where('town_id', $town->id)
                                    ->where('role_id', 2)
                                    ->first()
                                    ->id
                            )
                            ->first()
                            ->id;
                    $driver->save();
                }
            }
        }

        // Let's create more drivers
        $this->call(DriversTableSeeder::class);

        // Let's create more passengers
        factory(User::class, 400)->create();
    }
}
