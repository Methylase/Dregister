<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegisterStaffRegister extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('register_staff_register', function (Blueprint $table) {
            $table->increments('id');
            $table->string('staff_id');
            $table->date('register_date');
            $table->string('register_time');
            $table->integer('corox_model_id')->unsigned()->nullable();
            
        });
         Schema::table('register_staff_teacher', function (Blueprint $table) {
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
        Schema::dropIfExists('register_staff_register');
    }
}
