<?php

namespace Database\Seeders;
use App\Core\Repository\Cities\CityRepositoryContract;
use App\Core\Repository\Districts\DistrictRepositoryContract;
use App\Core\Repository\Wards\WardRepositoryContract;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use Illuminate\Database\Seeder;

class CountriesSeeder extends Seeder
{
    public function run(){
        $countries = \Illuminate\Support\Facades\DB::table('countries')->find(1);
        if(empty($countries)){
            DB::table('countries')->delete();
            $countries = json_decode(file_get_contents(database_path("Data/countries.json")), true);
            DB::table('countries')->insert($countries);
        }
    }
}