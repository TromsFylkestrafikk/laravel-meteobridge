<?php

namespace TromsFylkestrafikk\Meteobridge\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observation extends Model
{
    use HasFactory;

    protected $table = 'meteobridge_observations';
}
