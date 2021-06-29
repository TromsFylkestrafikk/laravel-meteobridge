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
            $table->char('id', 48)->primary();
            $table->string('name', 256)->nullable();
            $table->string('station', 256)->nullable();
            $table->string('ip', 256)->nullable();
            $table->char('mac', 18)->nullable()->comment("Meteobridge MAC address");
            $table->string('mb_version', 16)->nullable()->comment("Meteobridge software version");
            $table->float('latitude', 12, 8)->nullable();
            $table->float('longitude', 12, 8)->nullable();
            $table->timestamps();
        });

        Schema::create('meteobridge_observations', function (Blueprint $table) {
            $table->id();
            $table->char('station_id', 48);
            $table->dateTime('timestamp');
            $table->float('temp', 5, 2)->nullable();
            $table->float('humidity', 6, 2)->nullable();
            $table->float('pressure', 7, 2)->nullable();
            $table->float('pressure_sea', 7, 2)->nullable();
            $table->float('wind', 6, 2)->nullable();
            $table->float('wind_avg', 6, 2)->nullable()->comment("Average wind since last report");
            $table->float('wind_min', 6, 2)->nullable()->comment("Minimum wind since last report");
            $table->float('wind_max', 6, 2)->nullable()->comment("Maximum wind (gust) since last report");
            $table->integer('direction')->nullable();
            $table->float('rain_rate', 6, 2)->nullable();
            $table->float('rain_total', 6, 2)->nullable();
            $table->smallInteger('uv_index')->nullable();
            $table->integer('radiation')->nullable();
            $table->unique(['timestamp', 'station_id'], 'meteobridge_observations__station_timestamp_index');
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
        Schema::dropIfExists('meteobridge_observations');
    }
}
