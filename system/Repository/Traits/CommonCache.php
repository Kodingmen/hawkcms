<?php
namespace System\Repository\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Traits\ForwardsCalls;

trait CommonCache{
    public function all($columns = ["*"], array $with = []){
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    public function updateOrCreate($condition, $value){
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }

    public function create($data){
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }

    public function whereIn($fied, $data){
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    public function whereNotIn($field, $data){
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    public function where($column, $operator, $value){
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }


    use ForwardsCalls;
    public function __call($method, $parameters)
    {
        if(Str::contains($method, ['create', 'update'])){
            return $this->forwardCallTo($this->flushCacheAndUpdateData(__FUNCTION__, func_get_args()), $method, $parameters);
        }

        return $this->forwardCallTo($this->getDataIfExistCache(__FUNCTION__, func_get_args()), $method, $parameters);
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

}
