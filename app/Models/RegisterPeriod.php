<?php

namespace Corox\Models;

use Illuminate\Database\Eloquent\Model;

class RegisterPeriod extends Model
{
    protected $fillable = [
        'corox_model_id',
        'period_name',
        'period_date',
    ];
     public $timestamps=false;
   protected $table='register_period';
   protected $primaryKey='id';
}
