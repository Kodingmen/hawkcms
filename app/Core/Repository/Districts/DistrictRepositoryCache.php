<?php
namespace App\Core\Repository\Districts;

use System\Repository\RepositoryCache;

class DistrictRepositoryCache extends RepositoryCache implements DistrictRepositoryContract{

    public function repository(): string
    {
        return DistrictRepository::class;
    }
}
