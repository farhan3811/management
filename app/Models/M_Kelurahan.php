<?php
//Prototypes Model modul kelurahan developed by Dani Gunawan
// 31 may 2017

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class M_Kelurahan extends Model
{
    //deklarasi kelurahan
    protected $table = 'kmu_ms_rg_villages';
    protected $primarykey = 'id';

    public $timestamps = false;

    public function toDocters(){
        return $this->hasMany(M_Dokter::class, 'kelurahan_dokter');
    }
    public function toPatients(){
        return $this->hasMany(M_Patient::class, 'kelurahan_pasien');
    }

    public function toKecamatan(){
        return $this->belongsTo(M_Kecamatan::class,'district_id', 'id');
    }
}
