<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegisterStudentInformations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('register_student_informations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('student_firstname');
            $table->string('student_middlename');
            $table->string('student_lastname');            
            $table->string('student_email')->unique();
            $table->string('student_gender');            
            $table->string('student_phone');
            $table->string('student_dob');
            $table->string('student_disability');
            $table->string('student_list_disability');
            $table->string('student_hobbies');
            $table->string('student_registration_number');            
            $table->string('student_address');
            $table->string('student_city');
            $table->string('student_class_id');
            $table->string('student_parent_id');                      
            $table->string('student_social_media');
            $table->string('student_state');
            $table->string('student_localG');
            $table->string('student_profile_image');            
            $table->integer('user_corox_model_id');            
            $table->integer('corox_model_id')->unsigned()->nullable();
        });
         Schema::table('register_student_informations', function (Blueprint $table) {
              $table->foreign('corox_model_id')->references('id')->on('corox_models');
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('register_student_informations');
    }
}
