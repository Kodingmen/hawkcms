<?php
namespace App\Core\Providers;


use App\Core\Commands\KodingRepository;
use App\Core\Commands\MakeNewApp;
use App\Core\Core;
use App\Core\Mixins\RouterMixin;
use App\Core\Repository\Cities\CityRepositoryCache;
use App\Core\Repository\Cities\CityRepositoryContract;
use App\Core\Repository\Districts\DistrictRepositoryCache;
use App\Core\Repository\Districts\DistrictRepositoryContract;
use App\Core\Repository\Wards\WardRepositoryCache;
use App\Core\Repository\Wards\WardRepositoryContract;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class CoreServiceProvider extends ServiceProvider{
    public function register()
    {
        include dirname(__DIR__) . DIRECTORY_SEPARATOR . "functions.php";



        $this->app->singleton("core", function (){
            return new Core();
        });

        $this->commands([
            MakeNewApp::class
        ]);

        $this->loadMigrationsFrom((dirname(__DIR__) . DIRECTORY_SEPARATOR . "Database/Migration"));
    }

    public function boot(){
//        \Illuminate\Routing\Route::mixin(new RouterMixin());
        $this->app->bind(CityRepositoryContract::class, CityRepositoryCache::class);
        $this->app->bind(DistrictRepositoryContract::class, DistrictRepositoryCache::class);
        $this->app->bind(WardRepositoryContract::class, WardRepositoryCache::class);
    }
}