<?php
namespace System\Repository;

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

    protected $chain;

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
    protected function isSaveOrUpdateAction($method){
        return Str::contains($method, ['find', 'all', 'create', 'update']) || $method === 'get';
    }

    public function __call($method, $parameters)
    {
        $this->chain[] = [$method, $parameters];

        if(! $this->isSaveOrUpdateAction(Str::lower($method))){
            return $this;
        }

        return $this->resolveChain();

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

    private function resolveChain(){
        $this->generateCacheKey();
        return $this->resolveDataChain();
    }

    private function reset(){
        $this->model = null;
        $this->result = null;
        $this->cacheKey = null;
        $this->chain = null;
    }

    private function generateCacheKey(){
        foreach ($this->chain as $callback){
            $method = $callback[0];
            $parameters = $callback[1];

            $this->cacheKey[] = md5(
                get_class($this) .
                $method .
                serialize(json_encode($parameters))
            );
        }
        $this->finalCacheKey = implode('_',Arr::sort($this->cacheKey));
    }

    private function resolveDataChain(){
        if (Cache::has($this->finalCacheKey)) {
            $result =  Cache::get($this->finalCacheKey);
            return tap($result, function (){
                $this->reset();
            });
        }

        foreach ($this->chain as $callback) {
            $this->result = $this->executeMethod($callback[0], $callback[1]);
        }

        Cache::put($this->finalCacheKey, $this->result);

        return tap($this->result , function (){
            $this->reset();
        });
    }

    private function executeMethod($method, $parameters){
        if(is_null($this->model)){
            $this->model = $this->getModel();
            return call_user_func_array([$this->model, $method], $parameters);
        }
        return call_user_func_array([$this->result, $method], $parameters);
    }

}