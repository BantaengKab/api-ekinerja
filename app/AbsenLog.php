<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AbsenLog extends Model
{
    protected $table = 'absen_log';

    public $timestamps = false;

    protected $fillable = [
        'tanggal', 'masuk', 'istirahat', 'masuk2', 'pulang', 'kd_skpd', 'nip', 'status'
    ];



    public function dataAbsen()
    {
        return $this->hasMany(AbsenData::class, 'absen_id', 'id');
    }
    # status
    # 0. biasa
    # 1. jumat
    # 2. shift




}
