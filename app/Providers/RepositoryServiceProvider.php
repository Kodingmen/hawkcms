<?php

namespace App\Providers;

use App\Repository\Cities\CityRepository;
use App\Repository\Cities\CityRepositoryContract;
use App\Repository\Districts\DistrictRepository;
use App\Repository\Districts\DistrictRepositoryContract;
use App\Repository\Wards\WardRepository;
use App\Repository\Wards\WardRepositoryContract;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CityRepositoryContract::class, CityRepository::class);
        $this->app->bind(DistrictRepositoryContract::class, DistrictRepository::class);
        $this->app->bind(WardRepositoryContract::class, WardRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
