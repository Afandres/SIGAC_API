<?php

namespace Modules\SIGAC\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExcuseType extends Model
{
    use HasFactory;

    public function excuses()
    {
        return $this->hasMany(Excuse::class);
    }  
}
