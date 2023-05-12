<?php
namespace Tuezy\Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

abstract class BaseRepository implements RepositoryContract
{
    protected $result;

    protected $model;

    protected $cacheKey;

    protected $finalCacheKey;


    public function getModel(): Model
    {
       return $this->model ?? $this->makeModel();
    }

    public function makeModel(): Model
    {
        $model = App::make($this->model());

        if (!$model instanceof Model)
            throw new \Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");

        return $this->model = $model;
    }

    public function __call($method, $parameters)
    {

        return $this->getDataWithCache($method, $parameters);
    }

    /**
     * Handle dynamic static method calls into the model.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        return (new static)->$method(...$parameters);
    }

    private function getDataWithCache($method, $parameters){
        if(config("app.enable_repository_cache", false)) {
            $this->cacheKey[] = md5(
                get_class($this) .
                $method .
                serialize(request()->input()) . serialize(url()->current()) .
                serialize(json_encode($parameters))
            );

            if (Cache::has($this->finalCacheKey)) {
                return Cache::get($this->finalCacheKey);
            }
        }
        return $this->getData($method, $parameters);

    }

    private function getData($method, $parameters){
        if(!$this->model){
            $this->model = $this->getModel();
            $this->result = $this->model->$method(...$parameters);
        }else{
            $this->result = $this->result->$method(...$parameters);
        }

        if(Str::contains(Str::lower($method), ['get', 'find', 'all'])){
            if(config("app.enable_repository_cache", false)){
                $this->finalCacheKey = implode('_',Arr::sort($this->cacheKey));
                Cache::put($this->finalCacheKey, $this->result);
            }
            return tap($this->result , function (){
                $this->model = null;
                $this->result = null;
            });
        }
        return $this;
    }
}