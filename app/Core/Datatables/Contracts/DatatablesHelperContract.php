<?php
namespace App\Core\Datatables\Contracts;
interface DatatablesHelperContract{
    public function columns();
    public function addColumn(array $column);
    public function prepareQuery();
}