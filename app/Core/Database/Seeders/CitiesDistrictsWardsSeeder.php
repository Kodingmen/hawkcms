<?php

namespace App\Core\Database\Seeders;
use App\Core\Repository\Cities\CityRepositoryContract;
use App\Core\Repository\Districts\DistrictRepositoryContract;
use App\Core\Repository\Wards\WardRepositoryContract;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use Illuminate\Database\Seeder;

class CitiesDistrictsWardsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cityRepository = app(CityRepositoryContract::class);
        $districtRepository = app(DistrictRepositoryContract::class);
        $wardRepository = app(WardRepositoryContract::class);

        $city = \Illuminate\Support\Facades\DB::table('cities')->find(1);

        if (empty ($city)) {

            $client = new Client();
            $body = $client->get('https://raw.githubusercontent.com/madnh/hanhchinhvn/master/dist/tree.json')->getBody();
            $cities = json_decode($body);
            // Import cities
//            DB::table('cities')->truncate();
//            DB::table('districts')->truncate();
//            DB::table('wards')->truncate();

            $highOrderCities = ['ho-chi-minh', 'ha-noi', 'da-nang'];

            foreach ($cities as $city) {
                $newCity = $cityRepository->create([
                    'name' => $city->name,
                    'slug' => $city->slug,
                    'type' => $city->type,
                    'name_with_type' => $city->name_with_type,
                    'code' => $city->code,
                    'order' => in_array($city->slug, $highOrderCities) ? 1 : 0
                ]);
                $this->command->getOutput()->writeln("city <info>" . $city->name . "</info> is created successfully");



                foreach ($city->{"quan-huyen"} as $quan_huyen) {
                    $newDistrict = $districtRepository->create([
                        'name' => $quan_huyen->name,
                        'slug' => $quan_huyen->slug,
                        'type' => $quan_huyen->type,
                        'name_with_type' => $quan_huyen->name_with_type,
                        'path' => $quan_huyen->path,
                        'path_with_type' => $quan_huyen->path_with_type,
                        'code' => $quan_huyen->code,
                        'parent_code' => $quan_huyen->parent_code,
                        'city_id' => $newCity->id
                    ]);
                    $this->command->getOutput()->writeln("quan_huyen <info>" . $quan_huyen->name_with_type . "</info> is created successfully");

                    try {
                        foreach ($quan_huyen->{"xa-phuong"} as $xa_phuong) {
                            $wardRepository->create([
                                'name' => $xa_phuong->name,
                                'slug' => $xa_phuong->slug,
                                'type' => $xa_phuong->type,
                                'name_with_type' => $xa_phuong->name_with_type,
                                'path' => $xa_phuong->path,
                                'path_with_type' => $xa_phuong->path_with_type,
                                'code' => $xa_phuong->code,
                                'parent_code' => $xa_phuong->parent_code,
                                'district_id' => $newDistrict->id
                            ]);
                            $this->command->getOutput()->writeln("xa_phuong <info>" . $xa_phuong->name_with_type . "</info> is created successfully");
                        }
                    } catch (\Exception $e) {
                    }
                }

            }
        }
    }
}