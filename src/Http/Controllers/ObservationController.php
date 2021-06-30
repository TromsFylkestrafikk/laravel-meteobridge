<?php

namespace TromsFylkestrafikk\Meteobridge\Http\Controllers;

use TromsFylkestrafikk\Meteobridge\Models\Station;
use TromsFylkestrafikk\Meteobridge\Models\Observation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ObservationController extends Controller
{
    /**
     * Register weather observation for station
     *
     * @param  \TromsFylkestrafikk\Meteobridge\Models\Station  $station
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request, Station $station, $hash)
    {
        if ($station->hash && $station->hash !== $hash) {
            return response("Authentication failed", Response::HTTP_FORBIDDEN);
        }
        $observation = new Observation();
        $observation->station_id = $station->id;
        $observation->fill($request->query());
        $observation->save();
        // Use 'updated_at' column as indication of last communication with
        // station.
        $station->touch();
        return response('Success');
    }
}
