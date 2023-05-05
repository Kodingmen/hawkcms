<?php

namespace App\Core\Database\Seeders;
use App\Core\Repository\Cities\CityRepositoryContract;
use App\Core\Repository\Districts\DistrictRepositoryContract;
use App\Core\Repository\Wards\WardRepositoryContract;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use Illuminate\Database\Seeder;

class CountriesSeeder extends Seeder
{
    public function run(){
        $countries = json_decode(file_get_contents(base_path("Data/countries.json")), true);
        DB::table('countries')->insert($countries);
    }
}