<?php

namespace App\Core\Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class StatesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('country_states')->delete();

        $states = json_decode(file_get_contents(base_path('Data/states.json')), true);

        DB::table('country_states')->insert($states);
    }
}