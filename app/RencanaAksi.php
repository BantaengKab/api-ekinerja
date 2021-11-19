<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RencanaAksi extends Model
{
    protected $table = 'sisma_bkd_rencana_aksi_tahunan';

    public function urian()
    {
        return $this->belongsTo(UrianTupoksi::class, 'tupoksi_uraian_id', 'id');
    }
}


// 