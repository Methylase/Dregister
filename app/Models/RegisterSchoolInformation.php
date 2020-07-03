<?php

namespace Corox\Models;

use Illuminate\Database\Eloquent\Model;

class RegisterSchoolInformation extends Model
{
    //
    
   public $timestamps=true;
     protected $fillable = [
        'corox_model_id',
        'school_profile_image',
        'school_name',
        'school_email',
        'school_phone1',
        'school_phone2',
        'school_address',
        'school_license',
        'school_city',
        'school_social_media',
        'school_state',
        'school_localG',
        'school_number_of_staffs',
        'school_description',
        'school_services',
        'school_establish_date',
        'school_license_number',                 
        'school_postal_address',
        'school_enable',
    ];   
   protected $table='register_school_information';
   protected $primaryKey='id';   
}
