<?php
namespace App\Core\Mixins;

class RouterMixin{
    public function permission(){
        return function ($name){
            $this->defaults("permission", $name);
            return $this;
        };
    }

    public function getPermisison(){
        return function (){
            return $this->defaults['permission'];
        };
    }
}