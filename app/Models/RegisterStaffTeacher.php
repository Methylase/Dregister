<?php

namespace Corox\Models;

use Illuminate\Database\Eloquent\Model;

class RegisterStaffTeacher extends Model
{
    protected $fillable = [
        'corox_model_id',
        'staff_id',
        'teacher_role',
        'class_id',
    ];
    public $timestamps=false;
   protected $table='register_staff_teacher';
   protected $primaryKey='id';
}
