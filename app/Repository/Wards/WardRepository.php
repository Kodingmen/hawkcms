<?php
namespace App\Repository\Wards;
use App\Models\Ward;
use System\Repository\BaseRepository;

class WardRepository extends BaseRepository implements WardRepositoryContract{

    public function model(): string
    {
        return Ward::class;
    }
}
