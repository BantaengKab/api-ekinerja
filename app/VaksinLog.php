<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VaksinLog extends Model
{
    protected $table = 'vaksin_log';
    protected $guarded = ['id'];

    public function detail()
    {
        return $this->belongsTo(Vaksin::class, 'nik', 'nik');
    }
}
