<?php
namespace App\Core\Repository\Wards;
use App\Core\Models\Ward;
use System\Repository\BaseRepository;

class WardRepository extends BaseRepository implements WardRepositoryContract{

    public function model(): string
    {
        return Ward::class;
    }
}
