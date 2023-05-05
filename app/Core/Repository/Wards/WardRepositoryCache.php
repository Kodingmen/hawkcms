<?php
namespace App\Core\Repository\Wards;

use System\Repository\RepositoryCache;

class WardRepositoryCache extends RepositoryCache implements WardRepositoryContract{

    public function repository(): string
    {
        return WardRepository::class;
    }
}
