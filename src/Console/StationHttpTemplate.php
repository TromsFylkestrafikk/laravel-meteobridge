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
     * Map between db/model property and meteobridge template equivalent.
     *
     * @var string[]
     */
    protected $argMap = [
        'temp' => 'th0temp-act.2:--',
        'humidity' => 'th0hum-act.1:--',
        'pressure' => 'thb0press-act.2:--',
        'pressure_sea' => 'thb0seapress-act.2:--',
        'wind' => 'wind0wind-act.2:--',
        'wind_avg' => 'wind0avgwind-act.2:--',
        'direction' => 'wind0dir-act.0:--',
        'rain_rate' => 'rain0rate-act.2:--',
        'rain_total' => 'rain0total-daysum:.2:--',
        'uv_index' => 'uv0index-act.0:--',
        'radiation' => 'sol0rad-act:0:--',
    ];

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
        $base = route('meteobridge.observe', ['station' => $station->id]);
        $args = [];
        foreach ($this->argMap as $arg => $template) {
            $args[] = sprintf("%s=[%s]", $arg, $template);
        }
        $this->line($base . '?' . implode('&', $args));
        return 0;
    }
}
