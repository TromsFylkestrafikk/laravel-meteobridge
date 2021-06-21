<?php

namespace TromsFylkestrafikk\Meteobridge\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    use HasFactory;

    protected $table = 'meteobridge_stations';
}
