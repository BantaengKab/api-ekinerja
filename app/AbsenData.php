<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AbsenData extends Model
{
    protected $table = 'absen_data';

    public $timestamps = false;

    protected $fillable = [
        'absen_id', 'foto', 'kd_absen', 'lat', 'long'
    ];

    # kd_absen 
    # 0. masuk
    # 1. istirahat
    # 2. masuk2
    # 3. pulang
}
