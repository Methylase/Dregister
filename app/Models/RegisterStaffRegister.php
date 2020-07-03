<?php

namespace Corox\Models;

use Illuminate\Database\Eloquent\Model;

class RegisterStaffRegister extends Model
{
    protected $fillable = [
        'corox_model_id',
        'staff_id',
        'register_date',
        'register_time',
    ];
    public $timestamps=false;
   protected $table='register_staff_register';
   protected $primaryKey='id';
}
