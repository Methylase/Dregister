<?php

namespace Corox\Models;

use Illuminate\Database\Eloquent\Model;

class RegisterStaffInformation extends Model
{
    
   public $timestamps=true;
     protected $fillable = [
        'corox_model_id',
        'user_corox_model_id',
        'staff_profile_image',        
        'staff_firstname',
        'staff_middlename',
        'staff_lastname',            
        'staff_email',
        'staff_marital_status',
        'staff_gender',            
        'staff_phone',
        'staff_dob',
        'staff_disability',
        'staff_list_disability',
        'staff_hobbies',
        'staff_address',
        'staff_city',
        'staff_social_media',
        'staff_state',
        'staff_localG',

    ];   
   protected $table='register_staff_informations';
   protected $primaryKey='id';   
}
