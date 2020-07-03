<?php

namespace Corox;

use Illuminate\Database\Eloquent\Model;

class Corox_model extends Model
{
    protected $fillable = ['username', 'email', 'password'];
   public $timestamps=false;
   protected $table='registration';
}
