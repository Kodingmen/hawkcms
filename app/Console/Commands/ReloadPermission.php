<?php

namespace App\Console\Commands;

use App\Models\Permission;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class ReloadPermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:reload';

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

        $routes = Collection::make(Route::getRoutes()->getRoutesByName())
            ->filter(function (\Illuminate\Routing\Route $route) {
                return strpos($route->getName(), 'dashboard.') === 0;
            });

        DB::table('permissions')->delete();

        $roles = Role::with('permissions')->get();
        $now = Carbon::now();
        $stt = 0;
        foreach ($routes as $route){

            if(!isset($route->defaults['permission'])) continue;
            $name = $route->getName();
            $group = explode('.', $name);
            DB::table('permissions')->insert([
                'id'            => ++$stt,
                'title'         => $route->getPermisison(),
                'code'           => $route->getName(),
                'route'         => $route->getName(),
                'group'         => $group[1],
                'created_at'    => $now,
                'updated_at'    => $now,
            ]);
        }

        //restore old permission
        $old = [];
        foreach ($roles as $role){
            if($role->permissions->isEmpty()) continue;
            foreach ($role->permissions as $permission){
                if(!isset($old[$permission->code])){
                    $old[$permission->code] = Permission::where('code', '=', $permission->code)->first();
                }
                $role->permissions()->attach($old[$permission->code]);
            }

        }
    }
}
