<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AbsenRadius extends Model
{
    protected $table = 'absen_radius';

    public $timestamps = false;

    protected $fillable = [
        'lat', 'long', 'radius', 'kd_skpd', 'nama_lokasi'
    ];
}
