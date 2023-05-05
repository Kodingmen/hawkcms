<?php
namespace App\Core\Datatables;



use App\Core\Datatables\Contracts\DatatablesHelperContract;

abstract class DatatablesService implements DatatablesHelperContract {
    use TableBuilderHelper, HtmlBuilder;

    protected $builder;

    protected $columns;

    protected $rawColumns;

    protected $itemsPerPage = 50;

    protected $startDate = '';
    protected $endDate = '';

    protected $scriptColumns;

    protected $request;

    protected $operators = [
        'eq'       => '=',
        'lt'       => '<',
        'gt'       => '>',
        'lte'      => '<=',
        'gte'      => '>=',
        'neqs'     => '<>',
        'neqn'     => '!=',
        'eqo'      => '<=>',
        'like'     => 'like',
        'blike'    => 'like binary',
        'nlike'    => 'not like',
        'ilike'    => 'ilike',
        'and'      => '&',
        'bor'      => '|',
        'regex'    => 'regexp',
        'notregex' => 'not regexp',
    ];



    public abstract function query();

    public abstract function columns();

    public function addColumn($column){
        $this->columns[] = $column;
        $this->addScriptColumn($column);
    }

    public function addScriptColumn($column){
        unset($column['title']);
        unset($column['render']);
        unset($column['raw']);
        unset($column['exportable']);
        unset($column['printable']);
        if(!isset($column['searchable'])){
            $column['searchable'] = false;
        }
        if(!isset($column['sortable'])){
            $column['sortable'] = false;
        }
        $this->scriptColumns[] = $column;
    }

    public function render($view, $data = []){
        $this->request = request()->except("_token");
        $this->columns();
        if (request()->ajax()) {
            return $this->prepareTables();
        }
        return view($view, array_merge([
            'datatables' => $this,
        ], $data));
    }

 }