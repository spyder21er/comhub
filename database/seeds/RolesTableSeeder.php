<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userRoles = ['super_admin', 'admin', 'driver', 'passenger'];
        foreach($userRoles as $userRole) {
            $newRole = new Role;
            $newRole->name = $userRole;
            $newRole->save();
        }
    }
}
