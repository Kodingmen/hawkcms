<?php
namespace App\Repository\Cities;

use App\Models\City;
use System\Repository\BaseRepository;

class CityRepository extends BaseRepository implements CityRepositoryContract {

    public function model(): string
    {
        return City::class;
    }

}
