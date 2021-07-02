<?php

namespace TromsFylkestrafikk\Meteobridge\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use TromsFylkestrafikk\Meteobridge\Events\ObservationCreated;

class Observation extends Model
{
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
}
