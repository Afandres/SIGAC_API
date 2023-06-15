<?php

namespace Modules\SIGAC\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionType extends Model
{
    use HasFactory;

    public function apprenticepermissions()
    {
        return $this->hasMany(ApprenticePermission::class);
    }
}
