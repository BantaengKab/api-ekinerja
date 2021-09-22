<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permohonan extends Model
{
    protected $table = 'sisma_bkd_permohonan';
    
     protected $fillable = [
        'pegawai_id', 'kd_skpd', 'jenis_permohonan',
        'tgl_mulai','tgl_selesai','long','lat','gambar','site','creation_date',
        'created_by',
    ];
    
    public $timestamps = false;
}
