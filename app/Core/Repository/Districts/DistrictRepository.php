<?php
namespace App\Core\Repository\Districts;

use App\Core\Models\District;
use System\Repository\BaseRepository;

class DistrictRepository extends BaseRepository implements DistrictRepositoryContract{

    public function model(): string
    {
        return District::class;
    }
}
