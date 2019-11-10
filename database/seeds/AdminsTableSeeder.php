<?php

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\User;
use App\Models\Town;
use Illuminate\Support\Str;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orgs = [
            [
                'org_acronym'   => 'NAPAVCO',
                'org_name'      => 'Naga Pasacao Van Cooperative',
                'town_id'       => 12
            ],
            [
                'org_acronym'   => 'LIBTRASCO',
                'org_name'      => 'Libmanan Transport Cooperative',
                'town_id'       => 9
            ],
            [
                'org_acronym'   => 'CAMDETRASCO',
                'org_name'      => 'Calabanga Multi-Purpose Development And Transport Service',
                'town_id'       => 3
            ],
        ];

        foreach ($orgs as $org)
        {
            $user = factory(User::class)->create();
            $user->role_id = 2;
            $user->town_id = $org['town_id'];
            $user->email = Str::lower(Town::find($user->town_id)->name) . '.admin@comhub.com';
            $user->save();
            $admin = array_merge($org, ['user_id' => $user->id]);
            unset($admin['town_id']);
            Admin::create($admin);
        }
    }
}
