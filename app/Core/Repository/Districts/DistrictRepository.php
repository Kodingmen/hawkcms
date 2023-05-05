<?php
namespace App\Core\Repository\Districts;

use App\Core\Models\District;
use System\Repository\Repository;

class DistrictRepository extends Repository implements DistrictRepositoryContract{

    public function model(): string
    {
        return District::class;
    }
}
