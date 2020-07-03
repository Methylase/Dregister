<?php

namespace Corox\Models;

use Illuminate\Database\Eloquent\Model;

class RegisterParentInformation extends Model
{
   public $timestamps=false;
     protected $fillable = [
        'corox_model_id',
        'parent_profile_image',        
        'parent_firstname',
        'parent_middlename',
        'parent_lastname',            
        'parent_email',
        'parent_marital_status',
        'parent_gender',            
        'parent_phone',
        'parent_dob',
        'parent_disability',
        'parent_list_disability',
        'parent_hobbies',
        'parent_address',
        'parent_city',
        'parent_social_media',
        'user_corox_model_id',
        'parent_state',
        'parent_localG',

    ];   
   protected $table='register_parent_informations';
   protected $primaryKey='id'; 
}
