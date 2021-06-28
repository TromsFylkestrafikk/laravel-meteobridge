<?php

namespace TromsFylkestrafikk\Meteobridge\Http\Controllers;

use TromsFylkestrafikk\Meteobridge\Models\Station;
use TromsFylkestrafikk\Meteobridge\Models\Observation;
use Illuminate\Http\Request;

class ObservationController extends Controller
{
    /**
     * Register weather observation for station
     *
     * @param  \TromsFylkestrafikk\Meteobridge\Models\Station  $station
     * @return \Illuminate\Http\Response
     */
    public function register(Station $station)
    {
        return response('Success');
    }
}
