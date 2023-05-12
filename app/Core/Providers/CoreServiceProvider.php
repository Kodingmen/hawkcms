<?php
namespace App\Core\Providers;


use App\Core\Commands\MakeNewApp;
use App\Core\Core;
use App\Core\Repository\Cities\CityRepository;
use App\Core\Repository\Cities\CityRepositoryContract;
use Illuminate\Support\ServiceProvider;

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
        $this->app->bind(CityRepositoryContract::class, CityRepository::class);
    }
}