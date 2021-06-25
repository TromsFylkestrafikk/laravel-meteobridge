<?php

namespace TromsFylkestrafikk\Meteobridge\Console;

use Illuminate\Console\Command;
use TromsFylkestrafikk\Meteobridge\Models\Station;

class StationList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'meteobridge:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List weather stations';

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
        $this->table(
            ['id', 'name', 'station', 'lat', 'lng', 'seen'],
            Station::all(['id', 'name', 'station', 'latitude', 'longitude', 'updated_at'])
        );
        return 0;
    }
}
