<?php

namespace Corox\Models;

use Illuminate\Database\Eloquent\Model;

class RegisterStudentInformation extends Model
{
   public $timestamps=false;
     protected $fillable = [
        'corox_model_id',
        'user_corox_model_id',
        'student_profile_image',        
        'student_firstname',
        'student_middlename',
        'student_lastname',            
        'student_email',
        'student_gender',            
        'student_phone',
        'student_dob',
        'student_disability',
        'student_list_disability',
        'student_hobbies',
        'student_registration_number',
        'student_address',
        'student_city',
        'student_class_id',
        'student_session',
        'student_parent_id',
        'student_state',
        'student_localG',

    ];   
   protected $table='register_student_informations';
   protected $primaryKey='id';  
}
