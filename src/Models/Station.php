<?php

namespace TromsFylkestrafikk\Meteobridge\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    use HasFactory;

    protected $table = 'meteobridge_stations';
    protected $guarded = ['id'];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function observations()
    {
        return $this->hasMany(Observation::class);
    }
}
