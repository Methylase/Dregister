<?php

namespace Corox\Models;

use Illuminate\Database\Eloquent\Model;

class RegisterSubject extends Model
{
    protected $fillable = [
        'corox_model_id',
        'subject_name',
        'date',
    ];
     public $timestamps=false;
   protected $table='register_subject';
   protected $primaryKey='id';
}
