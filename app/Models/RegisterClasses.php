<?php

namespace Corox\Models;

use Illuminate\Database\Eloquent\Model;

class RegisterClasses extends Model
{
    protected $fillable = [
        'corox_model_id',
        'class_name',
        'class_date',
    ];
     public $timestamps=false;
   protected $table='register_classes';
   protected $primaryKey='id';
}
