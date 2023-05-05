<?php
namespace System\Repository;

use System\Repository\Eloquent;
use System\Repository\RepositoryException;
use Botble\Base\Supports\RepositoryHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use System\Repository\Traits\Common;

abstract class Repository implements RepositoryContract{

    use Common;

    protected $model;

    protected $originalModel;

    public function __construct()
    {
        $this->originalModel = $this->makeModel();
        $this->model = $this->originalModel;
    }

    public function makeModel(): Model
    {
        $model = App::make($this->model());
        if (!$model instanceof Model)
            throw new \Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");

        return $this->model = $model;
    }



    public function getModel() : Model
    {
        if(!$this->model) $this->originalModel = $this->makeModel();
        return $this->model;
    }

    public function getTable()
    {
        return $this->model->getTable();
    }

    public function with(array $with = [])
    {
        $model = $this->getModel();

        if (!empty($with)) {
            $this->model = $model->with($with);
        }

        return $this->model;
    }

    public function resetModel()
    {
        $this->model = new $this->originalModel();
        return $this;
    }

    /**
     * @param array $where
     * @param null|Eloquent\|Builder $model
     */
    public function applyConditions(array $where, &$model = null)
    {
        if (!$model) {
            $newModel = $this->model;
        } else {
            $newModel = $model;
        }

        foreach ($where as $field => $value) {
            if (is_array($value)) {
                [$field, $condition, $val] = $value;
                switch (strtoupper($condition)) {
                    case 'IN':
                        $newModel = $newModel->whereIn($field, $val);
                        break;
                    case 'NOT_IN':
                        $newModel = $newModel->whereNotIn($field, $val);
                        break;
                    default:
                        $newModel = $newModel->where($field, $condition, $val);
                        break;
                }
            } else {
                $newModel = $newModel->where($field, $value);
            }
        }

        if (!$model) {
            $this->model = $newModel;
        } else {
            $model = $newModel;
        }
    }

    protected function applyBeforeExecuteQuery($data)
    {
        $this->resetModel();
        return $data;
    }

}
