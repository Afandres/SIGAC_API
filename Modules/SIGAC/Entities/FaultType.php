<?php

namespace Modules\SIGAC\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaultType extends Model
{
    use HasFactory;

    public function faults()
    {
        return $this->hasMany(Fault::class);
    } 
}
