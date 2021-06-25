<?php

namespace TromsFylkestrafikk\Meteobridge\Console;

use Illuminate\Console\Command;
use Ramsey\Uuid\Uuid;
use TromsFylkestrafikk\Meteobridge\Models\Station;

class StationAdd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'meteobridge:add
                           { --N|name= : Name / placement on station }
                           { --H|hardware= : What hardware this station has }
                           { --a|latitude= : Latitude of station }
                           { --o|longitude= : Longitude of station }
                           { --hash : Create hash used for authorized data push } ';

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
        $station = $this->aquireStationData();
        $station->save();
        $this->info(sprintf("New station added with ID: %s", $station->uuid));
        return 0;
    }

    protected function aquireStationData(): Station
    {
        $station = new Station();
        $confirmed = false;
        while (!$confirmed) {
            $station->fill([
                'name' => $this->cliOrAsk('name', "Station name"),
                'hardware' => $this->cliOrAsk('hardware', "Station hardware"),
                'latitude' => floatval($this->cliOrAsk('latitude', "Latitude")),
                'longitude' => $this->cliOrAsk('longitude', "Longitude"),
            ]);
            $confirmed = $this->confirm(sprintf(
                "Creating a new station with the following params:\n\t name: %s\n\t hardware: %s\n\t lat/lng: [%2.5f, %2.5f]\n\n Is this correct?",
                $station->name,
                $station->hardware,
                $station->latitude,
                $station->longitude
            ), true);
        }
        $station->uuid =  Uuid::uuid4();
        if ($this->option('hash')) {
            $station->hash = uniqid("", true);
        }
        return $station;
    }

    protected function cliOrAsk($param, $question)
    {
        if ($this->option($param)) {
            return $this->option($param);
        }
        return $this->ask($question);
    }
}
