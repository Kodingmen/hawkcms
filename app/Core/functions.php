<?php
if(!function_exists("core")){
    function core(): \App\Core\Core{
        return \Illuminate\Support\Facades\App::make("core");
    }
}

if (! function_exists('theme')) {
    /**
     * Get the evaluated view contents for the given view.
     *
     * @param  string|null  $view
     * @param  \Illuminate\Contracts\Support\Arrayable|array  $data
     * @param  array  $mergeData
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    function theme($view = null, $data = [], $mergeData = [])
    {
        $factory = app(\Illuminate\Contracts\View\Factory::class);

        if (func_num_args() === 0) {
            return $factory;
        }

        return $factory->make($view, $data, $mergeData);
    }
}