<?php

namespace TromsFylkestrafikk\Meteobridge\Console;

use Illuminate\Console\Command;
use TromsFylkestrafikk\Meteobridge\Models\Station;

class StationHttpTemplate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'meteobridge:http-template
                           { id : Station ID }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Meteobridge HTTP event url template for given station';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $station = Station::find($this->argument('id'));
        if (!$station) {
            $this->error("Station not found: " . $this->argument('id'));
            return 1;
        }
        $this->info(url('meteobridge/observation'));
        return 0;
    }
}
