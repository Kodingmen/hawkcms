<?php
namespace App\Core\Repository\Cities;

use System\Repository\RepositoryCache;

class CityRepositoryCache extends RepositoryCache implements CityRepositoryContract{

    public function repository(): string
    {
        return CityRepository::class;
    }
}
