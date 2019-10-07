<?php

use Illuminate\Database\Seeder;
use App\Models\Town;

class TownsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $towns = [
            ['name' => 'Balatan',       'max_passengers' => 15],
            ['name' => 'Bombon',        'max_passengers' => 15],
            ['name' => 'Calabanga',     'max_passengers' => 15],
            ['name' => 'Caramoan',      'max_passengers' => 15],
            ['name' => 'Del Gallego',   'max_passengers' => 15],
            ['name' => 'Garchitorena',  'max_passengers' => 15],
            ['name' => 'Goa',           'max_passengers' => 15],
            ['name' => 'Lagonoy',       'max_passengers' => 15],
            ['name' => 'Libmanan',      'max_passengers' => 15],
            ['name' => 'Lupi',          'max_passengers' => 15],
            ['name' => 'Naga',          'max_passengers' => 15],
            ['name' => 'Pasacao',       'max_passengers' => 15],
            ['name' => 'Presentacion',  'max_passengers' => 15],
            ['name' => 'Ragay',         'max_passengers' => 15],
            ['name' => 'Sagñay',        'max_passengers' => 15],
            ['name' => 'San Jose',      'max_passengers' => 15],
            ['name' => 'Sipocot',       'max_passengers' => 15],
            ['name' => 'Siruma',        'max_passengers' => 15],
            ['name' => 'Tigaon',        'max_passengers' => 15],
            ['name' => 'Tinambac',      'max_passengers' => 15],
        ];

        foreach($towns as $town)
        {
            Town::create($town);
        }
    }
}
