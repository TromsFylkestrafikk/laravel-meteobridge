<?php

namespace TromsFylkestrafikk\Meteobridge\Console;

use Exception;
use Illuminate\Console\Command;
use TromsFylkestrafikk\Meteobridge\Models\Station;

class StationAdd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'meteobridge:add
                           { --N|name= : Station name (*) }
                           { --s|station= : What hardware this station has }
                           { --m|mac= : Meteobridge MAC address }
                           { --a|latitude= : Latitude of station (*) }
                           { --o|longitude= : Longitude of station (*) }
                           { --hash : Create hash used for authorized data push }
                           { --f|force : Force add even if exists. Missing fields becomes NULL. }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a new meteobridge weather station to receiver pool';

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
        $this->info("Adding new weather station");
        $station = $this->aquireStationInfo();
        $station->save();
        $this->info(sprintf("New station added with ID: %d", $station->id));
        if ($this->option('hash')) {
            $this->info(sprintf("Authentication hash: %s", $station->hash));
        }
        return 0;
    }

    protected function aquireStationInfo(): Station
    {
        $station = new Station();
        $confirmed = false;
        while (!$confirmed) {
            $station->fill([
                'name' => $this->cliOrAsk('name', "Station name", true),
                'station' => $this->cliOrAsk('station', "Station name and model"),
                'mac' => $this->cliOrAsk('mac', "Meteobridge MAC address"),
                'latitude' => floatval($this->cliOrAsk('latitude', "Latitude", true)),
                'longitude' => floatval($this->cliOrAsk('longitude', "Longitude", true)),
            ]);
            if ($this->option('force')) {
                break;
            }
            $confirmed = $this->confirm(sprintf(
                "Creating a new station with the following params:\n\t Name: %s\n\t Station: %s\n\t MAC: %s\n\t Lat/Lng: [%2.5f, %2.5f]\n\n Is this correct?",
                $station->name,
                $station->station,
                $station->mac,
                $station->latitude,
                $station->longitude
            ), true);
            if ($confirmed) {
                $confirmed = $this->confirmCreateIfExists($station);
            }
        }
        if ($this->option('hash')) {
            $station->hash = sha1(uniqid("", true));
        }
        return $station;
    }

    protected function confirmCreateIfExists(Station $station)
    {
        $existing = Station::where('name', $station->name)->first();
        return $existing ? $this->confirm(
            "An existing station with the same name already exists.\n Really create new? (Abort with ^C if provided with --name)",
            false
        ) : true;
    }

    protected function cliOrAsk($param, $question, $required = false)
    {
        if ($this->option($param)) {
            return $this->option($param);
        }
        $force = $this->option('force');
        while ($required) {
            if ($force) {
                throw new Exception("Missing required values when using --force");
            }
            $value = $this->ask($question . ' *');
            if ($value) {
                return $value;
            }
        }
        if ($force) {
            return null;
        }
        return $this->ask($question);
    }
}
