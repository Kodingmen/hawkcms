<?php
namespace App\Admin\Providers;

use App\Admin\Providers\EventServiceProvider;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AdminServiceProvider extends ServiceProvider{

    public function register()
    {
        Route::middleware('web')->group(__DIR__ . '/../Routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views', 'admin');
        $this->mergeConfigFrom(__DIR__ . '/../Configs/admin.php', 'admin');
        $this->loadMigrationsFrom((dirname(__DIR__) . DIRECTORY_SEPARATOR . "Database/Migrations"));
        $this->app->register(EventServiceProvider::class);
    }

    public function boot(){

    }
}