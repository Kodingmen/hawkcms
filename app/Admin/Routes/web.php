<?php
use Illuminate\Support\Facades\Route;

Route::get("/admin", function (){
    $city = app(\App\Core\Repository\Cities\CityRepositoryContract::class);
    dump(\App\Core\Models\City::with('districts')->where('id', '=',2)->get());
    dump(\App\Core\Models\City::with('districts')->where(function ($q){
        return $q->where('id', '=',3);
    })->get());
    dump($city->with('districts')->where(function ($q){
        return $q->where('id', '=',2);
    })->get());
    dump($city->with('districts')->where('id', '!=',6)->where('id', '=',2)->get());
    dump($city->with('districts')->where('id', '=',2)->where('id', '!=',6)->get());
});