<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MeteobridgeCreateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meteobridge_stations', function (Blueprint $table) {
            $table->char('id', 48);
            $table->string('name', 256);
            $table->string('hardware', 256);
            $table->string('ip', 256);
            $table->string('hash', 512);
            $table->float('latitude', 9, 5);
            $table->float('longitude', 9, 5);
            $table->timestamps();
        });

        Schema::create('meteobridge_weather', function (Blueprint $table) {
            $table->id();
            $table->timestamp('timestamp');
            $table->float('temp', 5, 2);
            $table->float('humidity', 6, 2);
            $table->float('pressure', 7, 2);
            $table->float('sea_pressure', 7, 2);
            $table->float('wind', 6, 2);
            $table->integer('direction');
            $table->float('rain_rate', 6, 2);
            $table->float('rain_total', 6, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meteobridge_stations');
    }
}
