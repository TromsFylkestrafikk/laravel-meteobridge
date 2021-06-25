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
            $table->id();
            $table->string('uuid', 512)->index();
            $table->string('name', 256)->nullable();
            $table->string('hardware', 256)->nullable();
            $table->string('ip', 256)->nullable();
            $table->float('latitude', 9, 5)->nullable();
            $table->float('longitude', 9, 5)->nullable();
            $table->timestamps();
        });

        Schema::create('meteobridge_data', function (Blueprint $table) {
            $table->id();
            $table->integer('station');
            $table->timestamp('timestamp')->unique();
            $table->float('temp', 5, 2);
            $table->float('humidity', 6, 2);
            $table->float('pressure', 7, 2);
            $table->float('sea_pressure', 7, 2);
            $table->float('wind', 6, 2);
            $table->float('wind_avg', 6, 2);
            $table->integer('direction');
            $table->float('rain_rate', 6, 2);
            $table->float('rain_total', 6, 2);
            $table->smallInteger('uv_index');
            $table->integer('radiation');
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
        Schema::dropIfExists('meteobridge_data');
    }
}
