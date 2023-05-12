<?php
namespace System\Repository;

use Illuminate\Database\Eloquent\Model;

interface RepositoryContract{
    public function model():string;
}
