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
        Schema::create('barbershop', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 500);
            $table->string('contact_name', 1000);
            $table->string('contact_phone', 10);
            $table->string('registration_number', 10);
            $table->string('postal_code', 8);
            $table->string('country', 1000);
            $table->string('state', 1000);
            $table->string('city', 1000);
            $table->string('street', 1000);
            $table->string('number', 1000);
            $table->string('active', 1);
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
        Schema::dropIfExists('barbershop');
    }
};
