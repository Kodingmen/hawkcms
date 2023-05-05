<?php

namespace App\Core\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class District extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['name', 'slug', 'type', 'name_with_type', 'code' , 'path', 'path_with_type', 'parent_code'];

    public function cities(){
        return $this->belongsTo(City::class);
    }

    public function wards(){
        return $this->hasMany(Ward::class);
    }
}
