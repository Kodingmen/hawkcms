<?php
namespace App\Core\Datatables\Contracts;
interface DatatablesBuilderContract{
    public function columns(): array;
    public function addColumn(array $column);
    public function prepareQuery();
}