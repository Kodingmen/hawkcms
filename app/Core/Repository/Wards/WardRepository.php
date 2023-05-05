<?php
namespace App\Core\Repository\Wards;
use App\Core\Models\Ward;
use System\Repository\Repository;

class WardRepository extends Repository implements WardRepositoryContract{

    public function model(): string
    {
        return Ward::class;
    }
}
