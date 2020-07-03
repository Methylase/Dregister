<?php
namespace Corox\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Corox_model extends Authenticatable
{
  // use Notifiable;
  protected $hidden = [
        'password', 'remember_token',
    ];
    protected $fillable = ['username', 'email', 'password'];
   public $timestamps=false;
   protected $table='corox_models';
   protected $primaryKey='id';
    public function roles(){
      return  $this->belongsToMany(Role::class); 
     }
      public function isAdmin(){
      foreach($this->roles()->get() as $role){
            if($role->role=='admin'){
              return true;
            }else{
              return false;
            }
      }
     }
      public function isMember(){
        foreach($this->roles()->get() as $role){
              if($role->role=='member'){
                return true;
              }else{
                return false;
              }
        }
     }
          public function isContributor(){
      foreach($this->roles()->get() as $role){
            if($role->role=='contributor'){
              return true;
            }else{
              return false;
            }
      }
     } 
}

