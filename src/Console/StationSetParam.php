<?php

namespace TromsFylkestrafikk\Meteobridge\Console;

use Illuminate\Console\Command;
use TromsFylkestrafikk\Meteobridge\Models\Station;

class StationSetParam extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'meteobridge:set
                           { id : Station ID }
                           { param : Station parameter to set }
                           { value : Parameter value }';

    /**
     * List of model properties that may be overridden.
     */
    protected $params = ['name', 'station', 'ip', 'mac', 'mb_version', 'latitude', 'longitude'];

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set meteobridge station parameters';

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
        $param = $this->argument('param');
        if (!in_array($this->argument('param'), $this->params)) {
            $this->error("Invalid parameter: " . $param);
            return 1;
        }
        $station->{$param} = $this->argument('value');
        $station->save();
        $this->info(sprintf("Updated station %s with %s = '%s'", $station->id, $param, $this->argument('value')));
        return 0;
    }
}
