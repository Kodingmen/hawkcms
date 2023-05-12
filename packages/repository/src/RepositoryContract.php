<?php
namespace Tuezy\Repository;

use Illuminate\Database\Eloquent\Model;

interface RepositoryContract{
    public function model():string;
    public function getModel(): Model;

}
