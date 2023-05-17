<?php
namespace App\Repository\Districts;

use App\Models\District;
use System\Repository\BaseRepository;

class DistrictRepository extends BaseRepository implements DistrictRepositoryContract{

    public function model(): string
    {
        return District::class;
    }
}
