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
    }
}
