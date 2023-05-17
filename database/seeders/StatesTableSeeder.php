<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class StatesTableSeeder extends Seeder
{
    public function run()
    {
        $states = \Illuminate\Support\Facades\DB::table('country_states')->find(1);
        if(empty($states)){
            DB::table('country_states')->delete();
            $states = json_decode(file_get_contents(database_path('Data/states.json')), true);
            DB::table('country_states')->insert($states);
        }
    }
}