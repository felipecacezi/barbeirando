<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barbershop_config', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('barbershop_id');
            $table->dateTime('open_time');
            $table->dateTime('close_time');
            $table->dateTime('close_lunch');
            $table->dateTime('open_lunch');
            $table->string('close_to_lunch', 1);
            $table->integer('service_coast');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barbershop_config');
    }
};
