<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegisterParentInformations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('register_parent_informations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('parent_firstname');
            $table->string('parent_midlename');
            $table->string('parent_lastname');            
            $table->string('parent_email')->unique();
            $table->string('parent_marital_status');
            $table->string('parent_gender');            
            $table->string('parent_phone');
            $table->string('parent_dob');
            $table->string('parent_disability');
            $table->string('parent_list_disability');
            $table->string('parent_hobbies');
            $table->string('parent_address');
            $table->string('parent_city');
            $table->string('parent_social_media');
            $table->string('parent_state');
            $table->string('parent_localG');
            $table->integer('corox_model_id')->unsigned()->nullable();
        });
         Schema::table('register_parent_informations', function (Blueprint $table) {
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
        Schema::dropIfExists('register_parent_informations');
    }
}
