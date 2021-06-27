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
            $table->timestamp('timestamp')->primary();
            $table->char('station', 48)->index();
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
        Schema::dropIfExists('meteobridge_observations');
    }
}
