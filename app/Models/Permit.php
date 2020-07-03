<?php

namespace Corox\Models;

use Illuminate\Database\Eloquent\Model;

class Permit extends Model
{
     protected $fillable = [
        'corox_model_id', 'role_id', 
    ];
     public $timestamps=false;
   protected $table='corox_model_role';
   protected $primaryKey='id';
}
