<?php
namespace App\Core\Repository\Cities;

use App\Core\Models\City;
use System\Repository\BaseRepository;

class CityRepository extends BaseRepository implements CityRepositoryContract {

    public function model(): string
    {
        return City::class;
    }

}
