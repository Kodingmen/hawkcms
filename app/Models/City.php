<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class City extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = ['name', 'slug', 'type', 'name_with_type', 'code', 'order'];

    public function districts(){
        return $this->hasMany(District::class);
    }
}
