<?php
namespace App\Core\Datatables;

use Carbon\Carbon;

trait TableBuilderHelper{

    public function prepareQuery(){
        $query = $this->query();

        if(request()->has('startDate')){
            $parsedUrl['startDate'] = request()->get('startDate');
            $this->startDate = !empty($parsedUrl['startDate'])
                ? Carbon::createFromTimeString($parsedUrl['startDate'] . " 00:00:01")->format('Y-m-d 00:00:00')
                : Carbon::createFromTimeString(Carbon::now()->subDays(30)->format('Y-m-d') . " 00:00:01")->format('Y-m-d 00:00:00');
        }
        if(request()->has('endDate')){
            $parsedUrl['endDate'] = request()->get('endDate');
            $this->endDate = !empty($parsedUrl['endDate'])
                ? Carbon::createFromTimeString($parsedUrl['endDate']. " 23:59:59")->format('Y-m-d 23:59:59')
                : Carbon::now()->format('Y-m-d 23:59:59');
        }

        return $this->prepareQuerySearch($query);
    }
    public function prepareTables(){

        $builder = \Yajra\DataTables\Facades\DataTables::of($this->prepareQuery());

        $rawColumns = [];

        foreach ($this->columns as $column){
            if(isset($column['render'])){
                $builder = $builder->addColumn($column['data'], function ($value) use ($column){
                    return call_user_func($column['render'], $value);
                });
            }else{
                $builder = $builder->addColumn($column['data'], function ($value) use ($column){
                    return $value->{$column['data']};
                });
            }
//            if(isset($column['orderable']) && $column['orderable'] == false){
//                $builder = $builder->orderColumn($column['data'], false);
//            }

            if(isset($column['raw']) && $column['raw'] == true){
                $rawColumns[] = $column['data'];
            }
        }
        if(!empty($rawColumns)){
            $builder = $builder->rawColumns($rawColumns);
        }

        return $builder->make(true);
    }

    private function prepareQuerySearch($query){
        if(request()->has('columns')) {
            $columns = request()->get('columns');
        }
        if(request()->has('search')){
            $search_arr = request()->get('search');
            $searchKey = $search_arr['value'];

            if(!empty($searchKey)){
                $query = $query->where(function ($q) use($columns, $searchKey){
                    $flag = false;
                    foreach ($columns as $stt => $column){
                        if($column['searchable'] != 'false'){
                            if($flag == true){
                                $q = $q->orWhere($column['data'] , 'LIKE', '%'.$searchKey.'%');
                            }else{
                                $q = $q->where($column['data'] , 'LIKE', '%'.$searchKey.'%');
                                $flag = true;
                            }
                        }
                    }
                    return $q;
                });
            }else{
                $query = $query->where(function ($q) use($columns){
                    foreach ($columns as $stt => $column){
                        if($column['search']['value'] != null){
                                $q = $q->where($column['data'] , 'LIKE', '%'.$column['search']['value'].'%');
                        }
                    }
                    return $q;
                });
            }
        }
        return $query;
    }

}