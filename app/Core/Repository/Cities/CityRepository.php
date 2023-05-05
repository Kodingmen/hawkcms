<?php
namespace App\Core\Repository\Cities;

use App\Core\Models\City;

use System\Repository\Repository;

class CityRepository extends Repository implements CityRepositoryContract {

    public function model(): string
    {
        return City::class;
    }
}
