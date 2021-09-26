<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AbsenData extends Model
{
    protected $table = 'absen_data';

    public $timestamps = false;

    protected $fillable = [
        'tanggal', 'masuk', 'istirahat', 'masuk2', 'pulang', 'kd_skpd', 'nip', 'status'
    ];

    # status 
    # 0. masuk
    # 1. istirahat
    # 2. masuk2
    # 3. pulang
}
