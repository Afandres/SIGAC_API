<?php

namespace Modules\SIGAC\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    use HasFactory;


    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}
