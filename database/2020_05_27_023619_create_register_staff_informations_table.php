<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegisterStaffInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::defaultStringLength(191);
        Schema::create('register_staff_informations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('staff_firstname');
            $table->string('staff_midlename');
            $table->string('staff_lastname');            
            $table->string('staff_email')->unique();
            $table->string('staff_marital_status');
            $table->string('staff_gender');            
            $table->string('staff_phone');
            $table->string('staff_dob');
            $table->string('staff_disability');
            $table->string('staff_list_disability');
            $table->string('staff_hobbies');
            $table->string('staff_address');
            $table->string('staff_city');
            $table->string('staff_social_media');
            $table->string('staff_state');
            $table->string('staff_localG');
            $table->integer('corox_model_id')->unsigned()->nullable();
            $table->timestamps();
        });
         Schema::table('register_staff_informations', function (Blueprint $table) {
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
        Schema::dropIfExists('register_staff_informations');
    }
}
