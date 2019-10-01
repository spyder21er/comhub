<?php

use Illuminate\Database\Seeder;
use App\Models\UserRole;

class UserRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userRoles = ['SuperAdmin', 'Admin', 'Driver', 'Passenger'];
        foreach($userRoles as $userRole) {
            $newRole = new UserRole;
            $newRole->name = $userRole;
            $newRole->save();
        }
    }
}
