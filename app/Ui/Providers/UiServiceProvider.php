<?php
namespace App\Ui\Providers;

use App\Ui\Providers\EventServiceProvider;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class UiServiceProvider extends ServiceProvider{

    public function register()
    {
        Route::middleware('web')->group(__DIR__ . '/../Routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views', 'ui');
        $this->mergeConfigFrom(__DIR__ . '/../Configs/ui.php', 'ui');
        $this->loadMigrationsFrom((dirname(__DIR__) . DIRECTORY_SEPARATOR . "Database/Migrations"));
        $this->app->register(EventServiceProvider::class);
    }

    public function boot(){

    }
}