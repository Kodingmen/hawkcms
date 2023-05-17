<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Ward extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['name', 'slug', 'type', 'name_with_type', 'code' , 'path', 'path_with_type', 'parent_code'];

    public function district(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(District::class);
    }

}
