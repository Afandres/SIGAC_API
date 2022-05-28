<?php

namespace Modules\SICA\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\SICA\Entities\Program;
use Modules\SICA\Entities\Line;

class Network extends Model
{

    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $hidden = ['created_at','updated_at'];
    protected $fillable = ['name','line_id'];

    public function programs(){
        return $this->hasMany(Program::class);
    }

    public function line(){
        return $this->belongsTo(Line::class);
    }

}
