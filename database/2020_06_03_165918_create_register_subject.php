<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegisterSubject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::defaultStringLength(191);        
        Schema::create('register_subject', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subject_name');         
            $table->integer('corox_model_id')->unsigned()->nullable();
            $table->timestamps();
        });
         Schema::table('register_subject', function (Blueprint $table) {
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
        Schema::dropIfExists('register_subject');
    }
}
