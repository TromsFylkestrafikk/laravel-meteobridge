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
                           { id : Station ID }
                           { --i|interval=10 : Intervals (in minutes) between expected observations }';

    /**
     * Map between db/model property and meteobridge template equivalent.
     *
     * The macros should include everything up to :replacement, as this is
     * handled during template generation. I.e, the values should have the
     * format:
     *
     *     sensor-selector=converter.decimals
     *
     * @see https://www.meteobridge.com/wiki/index.php/Templates
     *
     * @var string[]
     */
    protected $argMap = [
        'temp' => 'th0temp-act.2',
        'humidity' => 'th0hum-act.1',
        'pressure' => 'thb0press-act.2',
        'pressure_sea' => 'thb0seapress-act.2',
        'wind' => 'wind0wind-act.2',
        'direction' => 'wind0dir-act.0',
        'rain_rate' => 'rain0rate-act.2',
        'rain_total' => 'rain0total-daysum.2',
        'uv_index' => 'uv0index-act.0',
        'radiation' => 'sol0rad-act.0',
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
        if (!$this->generateIntervalMacros()) {
            return 1;
        }
        $base = route('meteobridge.observe', ['station' => $station->id]);
        $args = ['timestamp=[YYYY]-[MM]-[DD]T[hh]:[mm]:[ss]'];
        foreach ($this->argMap as $arg => $template) {
            $args[] = $this->macroIfThenElse(
                sprintf("{*[%s:-9999]!=-9999*}", $template),
                sprintf("&%s=[%s]", $arg, $template),
                ''
            );
        }
        $this->line($base . '?' . implode("", $args));
        return 0;
    }

    /**
     * Generate the macros for min, max and avg values between reports.
     *
     * @return bool
     */
    protected function generateIntervalMacros()
    {
        $interval = intval($this->option('interval'), 10);
        if ($interval < 1 || $interval > 60) {
            $this->error("The interval can only be between 1 and 60 minutes");
            return false;
        }
        $this->argMap['wind_max'] = "wind0wind-max{$interval}.2";
        $this->argMap['wind_min'] = "wind0wind-min{$interval}.2";
        $this->argMap['wind_avg'] = "wind0wind-avg{$interval}.2";
        return true;
    }

    /**
     * Wrapper around the if/then/else syntax in Metrobridge templates.
     */
    protected function macroIfThenElse($test, $thenVal, $elseVal = '')
    {
        return sprintf("#if#%s#then#%s#else#%s#fi#", $test, $thenVal, $elseVal);
    }
}
