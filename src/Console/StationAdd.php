<?php

namespace TromsFylkestrafikk\Meteobridge\Console;

use Illuminate\Console\Command;

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
                           { --lat= : Latitude of station }
                           { --long= : Longitude of station }
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
        return 0;
    }

    protected function cliOrAsk($param, $question)
    {
        if ($this->argument($param)) {
            return $this->argument($param);
        }
        return $this->ask($question);
    }
}
