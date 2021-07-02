<?php

namespace TromsFylkestrafikk\Meteobridge\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use TromsFylkestrafikk\Meteobridge\Models\Observation;

class ObservationCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $observation;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Observation $observation)
    {
        $this->observation = $observation;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('meteobridge-' . $this->station_id);
    }
}
