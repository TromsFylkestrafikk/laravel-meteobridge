<?php

namespace TromsFylkestrafikk\Meteobridge\Models;

use Illuminate\Broadcasting\Channel;
use Illuminate\Database\Eloquent\BroadcastsEvents;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observation extends Model
{
    use BroadcastsEvents;
    use HasFactory;

    protected $table = 'meteobridge_observations';
    public $timestamps = false;
    protected $guarded = ['id', 'station_id'];

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
            return new Channel($this->station);
        }
    }
}
