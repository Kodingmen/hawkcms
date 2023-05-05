<?php
namespace System\Repository;

use Illuminate\Database\Eloquent\Model;

interface RepositoryContract{
    public function model():string;
    public function getModel(): Model;
    public function applyConditions(array $where, &$model = null);


}
