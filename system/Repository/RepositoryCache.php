<?php
namespace System\Repository;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use System\Repository\Traits\CommonCache;

abstract class RepositoryCache implements RepositoryContract{
    use CommonCache;

    protected $repository;
    public function __construct()
    {
        $this->repository = $this->makeRepository();
    }

    public function model():string{
        return $this->repository->model();
    }

    public abstract function repository() : string;

    public function makeRepository() {
        $repository = App::make($this->repository());
        return $this->repository = $repository;
    }

    /**
     * @return Cache
     */
    public function getCacheInstance()
    {
        return $this->cache;
    }

    /**
     * @param string $function
     * @param array $args
     * @return mixed
     */
    public function getDataIfExistCache($function, array $args)
    {
        if (!config('enable_cache', false)) {
            return call_user_func_array([$this->repository, $function], $args);
        }

        try {
            $cacheKey = md5(
                get_class($this) .
                $function .
                serialize(request()->input()) . serialize(url()->current()) .
                serialize(json_encode($args))
            );

            if (Cache::has($cacheKey)) {
                return Cache::get($cacheKey);
            }

            $cacheData = call_user_func_array([$this->repository, $function], $args);

            // Store in cache for next request
            Cache::put($cacheKey, $cacheData);

            return $cacheData;
        } catch (\Exception | \InvalidArgumentException $ex) {
            info($ex->getMessage());
            return call_user_func_array([$this->repository, $function], $args);
        }
    }

    /**
     * @param string $function
     * @param array $args
     * @return mixed
     */
    public function getDataWithoutCache($function, array $args)
    {
        return call_user_func_array([$this->repository, $function], $args);
    }

    /**
     * @param string $function
     * @param array $args
     * @param boolean $flushCache
     * @return mixed
     */
    public function flushCacheAndUpdateData($function, $args, $flushCache = true)
    {
        if ($flushCache) {
            try {
                Cache::flush();
            } catch (FileNotFoundException $exception) {
                info($exception->getMessage());
            }
        }

        return call_user_func_array([$this->repository, $function], $args);
    }


    public function getModel():Model
    {
        return $this->repository->getModel();
    }

    public function applyBeforeExecuteQuery($data)
    {
        return $this->repository->applyBeforeExecuteQuery($data);
    }

    public function applyConditions(array $where, &$model = null)
    {
       return $this->repository->applyConditions($where, $model);
    }




}
