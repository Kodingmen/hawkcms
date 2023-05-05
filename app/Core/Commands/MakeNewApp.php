<?php

namespace App\Core\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class MakeNewApp extends KodingCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:app {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        $ucfirstName = ucfirst($name);
        $pluralName = ucfirst(Str::plural($name));
        File::ensureDirectoryExists(app_path($ucfirstName. "/Configs"));
        File::ensureDirectoryExists(app_path($ucfirstName. "/Providers"));
        File::ensureDirectoryExists(app_path($ucfirstName. "/Models"));
        File::ensureDirectoryExists(app_path($ucfirstName. "/Http"));
        File::ensureDirectoryExists(app_path($ucfirstName. "/Http/Controllers"));
        File::ensureDirectoryExists(app_path($ucfirstName. "/Commands"));
        File::ensureDirectoryExists(app_path($ucfirstName. "/Repositories"));
        File::ensureDirectoryExists(app_path($ucfirstName. "/Facades"));
        File::ensureDirectoryExists(app_path($ucfirstName. "/Database"));
        File::ensureDirectoryExists(app_path($ucfirstName. "/Database/Migrations"));
        File::ensureDirectoryExists(app_path($ucfirstName. "/Database/Factories"));
        File::ensureDirectoryExists(app_path($ucfirstName. "/Database/Seeders"));
        File::ensureDirectoryExists(app_path($ucfirstName. "/Resources"));
        File::ensureDirectoryExists(app_path($ucfirstName. "/Resources/Views"));
        File::ensureDirectoryExists(app_path($ucfirstName. "/Routes"));

        file_put_contents(app_path($ucfirstName. "/Configs/".strtolower(Str::studly($name)).".php"), $this->replace($name, 'app/config'));
        file_put_contents(app_path($ucfirstName. "/Routes/web.php"), $this->replace($name, 'app/route'));
        file_put_contents(app_path($ucfirstName. "/Http/Controllers/Controller.php"), $this->replace($name, 'app/base-controller'));

        $this->info("generate config: ". app_path($ucfirstName. "/Configs/".strtolower(Str::studly($name)).".php"));
        $this->info("generate route: ". app_path($ucfirstName. "/Routes/web.php"));

        $this->createMockServiceProviders($name);

    }

    private function createMockServiceProviders($name){
        $name = Str::studly($name);
        $ucfirstName = ucfirst($name);
        $pluralName = ucfirst(Str::plural($name));
        file_put_contents(app_path($ucfirstName ."/Providers/{$ucfirstName}ServiceProvider.php"), $this->replace($name, 'app/app-service-provider'));
        file_put_contents(app_path($ucfirstName ."/Providers/EventServiceProvider.php"), $this->replace($name, 'app/event-service-provider'));
        $this->info("generate Service Provider: ". app_path($ucfirstName ."/Providers/{$ucfirstName}ServiceProvider.php"));
    }
}