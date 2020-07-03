<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegisterPeriod extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('register_period', function (Blueprint $table) {
            $table->increments('id');
            $table->string('period_name');         
            $table->unsignedBigInteger('corox_model_id');
            $table->date('period_date');
        });
         Schema::table('register_period', function (Blueprint $table) {
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
        Schema::dropIfExists('register_period');
    }
}
