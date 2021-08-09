<?php

namespace TromsFylkestrafikk\Meteobridge\Models;

use Illuminate\Database\Eloquent\BroadcastsEvents;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use TromsFylkestrafikk\Meteobridge\Events\ObservationCreated;

class Observation extends Model
{
    use BroadcastsEvents;
    use HasFactory;

    protected $table = 'meteobridge_observations';
    public $timestamps = false;
    protected $guarded = ['id', 'station_id'];

    protected $dispatchesEvents = [
        'created' => ObservationCreated::class,
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    /**
     * Get the channel the model should broadcast on.
     *
     * @param string $event
     * @return array
     */
    public function broadcastOn($event)
    {
        if ($event === 'created') {
            return [$this->station];
        }
    }
}
