<?php

namespace App\Core\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class KodingRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'koding:repository {name : Class (singular)} {--m} {--force}';

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


    protected function model($name)
    {
        file_put_contents(app_path("Models/{$name}.php"), $this->replace($name, 'model'));
        $this->info("generate Model: ". app_path("Models/{$name}.php"));
    }

    protected function repository($name, $type = 'repository')
    {
        $pluralName = ucfirst(Str::plural($name));

        $folder = app_path("/Repository/{$pluralName}");

        if(!File::exists($folder)){
            File::makeDirectory($folder, 0777, true);
        }
        switch ($type){
            case 'repository':
                $file ="{$name}Repository";
                break;
            case 'repository-contract':
                $file = "{$name}RepositoryContract";
                break;
            case 'repository-cache':
                $file = "{$name}RepositoryCache";
                break;
        }

        $phpFile = $folder. "/{$file}.php";

        file_put_contents($phpFile, $this->replace($name, $type));

        $this->info("generate: ". $phpFile);
        return 'App\\Repository\\'.$pluralName.'\\'.$file;
    }

    protected function datatables($name)
    {
        File::ensureDirectoryExists(app_path("/Datatables"));
        file_put_contents(app_path("/Datatables/{$name}Tables.php"), $this->replace($name,'datatables'));

        $this->info("generate: ". app_path("/Datatables/{$name}Tables.php"));
    }

    protected function migration($name)
    {
        $name = strtolower($name);

        $time = date('Y_m_d_His');

        $file = database_path("/migrations/{$time}_create_{$name}_tables.php");
        file_put_contents($file, $this->replace($name,'migration'));

        $this->info("generate: ". $file);
    }

    protected function controllerDashboards($name)
    {
        File::ensureDirectoryExists(app_path("/Http/Controllers/Dashboard/"));
        file_put_contents(app_path("/Http/Controllers/Dashboard/{$name}Controller.php"), $this->replace($name,'controller-dashboard'));

        File::copyDirectory(__DIR__ ."/stub/dashboard-page",resource_path('views/dashboard/pages/'.strtolower(Str::plural($name))));

        $this->info("generate: ". app_path("/Http/Controllers/Dashboard/{$name}Controller.php"));
    }

    protected function routes($name)
    {
        File::ensureDirectoryExists(base_path("routes/admin"));
        file_put_contents(base_path("routes/admin/{$name}.json"), $this->replace($name,'routes'));
        $this->info("generate: ". base_path("routes/admin/{$name}.json"));
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');

        if(File::exists(app_path("Models/{$name}.php"))  && !$this->option('force') ){
            $this->error("Already exist. Replace with --force");
            return;
        }

        $this->model($name);
        $repositoryContract = $this->repository($name, 'repository-contract');
        $repository = $this->repository($name, 'repository');
        $repositoryCache = $this->repository($name, 'repository-cache');
        $this->datatables($name);
        $this->controllerDashboards($name);

        if($this->option('m')){
            $this->migration($name);
        }

        if(! File::exists(base_path('metadata.json'))){
            File::put(base_path('metadata.json'),'{}');
        }

        if(! File::exists(base_path('routes.json'))){
            File::put(base_path('routes.json'),'{}');
        }

        $repositoryMapper =
            array_merge(
                json_decode(file_get_contents(base_path('metadata.json')), true),
                [
                    $repositoryContract => $repositoryCache
                ]
            );
        file_put_contents(base_path('metadata.json'), json_encode($repositoryMapper));

        $routesMapper =
            array_merge(
                json_decode(file_get_contents(base_path('routes.json')), true),
                [
                   ucfirst(Str::plural($name))
                ]
            );

        file_put_contents(base_path('routes.json'), json_encode($routesMapper));
    }

    protected function replace($name,$type){
        return str_replace(
            [
                '{{modelName}}',
                '{{modelNamePluralLowerCase}}',
                '{{modelNameSingularLowerCase}}',
                '{{modelNamePluralUpperCase}}',
                '{{modelNameSingularUpperCase}}',
            ],
            [
                Str::studly($name),
                strtolower(Str::pluralStudly($name)),
                strtolower(Str::studly($name)),
                ucfirst(Str::pluralStudly($name)),
                ucfirst(Str::studly($name))
            ],
            $this->getStub($type)
        );
    }

    protected function getStub($type)
    {
        return file_get_contents(__DIR__ . ("/stub/$type.stub"));
    }
}
