<?php
namespace App\Core;
use App\Models\Setting;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Support\Facades\Cache;

class Core{

    /**
     * Get the available auth instance.
     *
     * @param  string|null  $guard
     * @return \Illuminate\Contracts\Auth\Factory|\Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     */
    public function auth(string $guard = null): \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard|\Illuminate\Contracts\Auth\Factory
    {
        if (is_null($guard)) {
            $guard = $this->detectGuard();
        }

        return app(\Illuminate\Contracts\Auth\Factory::class)->guard($guard);
    }

    public function detectGuard(){
        if(
            is_numeric(strpos(request()->getRequestUri() , config("admin.admin_prefix","dashboard"))) &&
            strpos(request()->getRequestUri() , config("admin.admin_prefix","dashboard")) <= 1){
            return config("admin.guard");
        }
        return "customers";
    }


    /**
     * Get the evaluated view contents for the given view.
     *
     * @param  string|null  $view
     * @param  \Illuminate\Contracts\Support\Arrayable|array  $data
     * @param  array  $mergeData
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    function view($view = null, $data = [], $mergeData = [])
    {
        $factory = app(ViewFactory::class);

        if (func_num_args() === 0) {
            return $factory;
        }

        return $factory->make($view, $data, $mergeData);
    }
    public function format_money($value, $postfix = ''){
        return number_format($value) . $postfix;
    }


}