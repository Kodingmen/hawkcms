<?php
namespace App\Core\Datatables;

trait HtmlBuilder{
    public function addCheckbox(){

    }
    public function includeScript(){
        return view("dashboard.ui.datatables.include-scripts");
    }
    public function includeStyles(){
        return view("dashboard.ui.datatables.include-styles",[
            'options'   => [
                'hideSearch' => true,
                'hideChangeLength' => true
            ]
        ]);
    }

    public function html(){
        return view("dashboard.ui.datatables.ui", [
            "columns" => $this->columns
        ]);
    }

    public function script(){

        return view("dashboard.ui.datatables.script", [
            "columns" => $this->scriptColumns
        ]);
    }
}