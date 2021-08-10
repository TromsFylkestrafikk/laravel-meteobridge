<?php

namespace TromsFylkestrafikk\Meteobridge\Console;

use Illuminate\Console\Command;
use TromsFylkestrafikk\Meteobridge\Models\Station;

class StationRehash extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'meteobridge:hash
                           { id : Station ID }
                           { --r|remove : Remove existing hash }
                           { --f|force : Force rehash without confirmation }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create or reset station authentication hash.';

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
        $hashOpStr = $this->option('remove') ? 'remove' : 'create new';
        if (!$this->option('force') && !$this->confirm("Really {$hashOpStr} hash for this station?", false)) {
            $this->info("Password hash operation aborted");
            return 0;
        }
        $station->hash = $this->option('remove') ? null : sha1(uniqid("", true));
        $station->save();
        $this->info(sprintf("New authentication hash created for station %d (%s):", $station->id, $station->name));
        $this->line($station->hash);
        return 0;
    }
}
