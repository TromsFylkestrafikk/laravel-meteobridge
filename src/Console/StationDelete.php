<?php

namespace TromsFylkestrafikk\Meteobridge\Console;

use Illuminate\Console\Command;
use TromsFylkestrafikk\Meteobridge\Models\Station;
use TromsFylkestrafikk\Meteobridge\Models\Observation;

class StationDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'meteobridge:del
                           { id : Station ID }
                           { --o|observations : Delete weather observations too }
                           { --f|force : Force delete }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete station';

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
        if (
            !$this->option('force') && !$this->confirm(sprintf(
                "Really delete station '%s' with id %s",
                $station->name,
                $station->id
            ), false)
        ) {
            $this->info("Deletion aborted");
            return 0;
        }
        if ($this->option('observations')) {
            Observation::where('station', $station->id)->delete();
        }
        $station->delete();
        $this->info("Successfully deleted station " . $station->name);
        return 0;
    }
}
