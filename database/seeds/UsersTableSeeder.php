<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = factory(User::class)->create();
        $user->name = 'Allen Mabz';
        $user->email = 'spyder21er@gmail.com';
        $user->role_id = 1;
        $user->save();
        $user = factory(User::class)->create();
        $user->name = 'John Doe';
        $user->email = 'test.admin@comhub.com';
        $user->role_id = 2;
        $user->save();
        $user = factory(User::class)->create();
        $user->name = 'John Doe';
        $user->email = 'test.driver@comhub.com';
        $user->role_id = 3;
        $user->save();
        $user = factory(User::class)->create();
        $user->name = 'John Doe';
        $user->email = 'test.passenger@comhub.com';
        $user->role_id = 4;
        $user->save();
    }
}
