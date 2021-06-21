<?php

namespace TromsFylkestrafikk\Meteobridge;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class MeteobridgeServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->registerMigrations();
    }

    /**
     * Setup migrations
     */
    protected function registerMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}
