<?php
//Prototypes Model modul kecamatan developed by Dani Gunawan
// 31 may 2017

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class M_Kecamatan extends Model
{
    //deklarasi ke kecamatan
    protected $table = 'kmu_ms_rg_districts';
    protected $primarykey = 'id';

    public $timestamps = false;

    public function toDocters(){
        return $this->hasMany(M_Dokter::class, 'kecamatan_dokter');
    }
    public function toPatients(){
        return $this->hasMany(M_Patient::class, 'kecamatan_kepasien');
    }

    public function ToKota(){
        return $this->belongsTo(M_Kota::class,'regency_id', 'id');
    }
    public function toKelurahan(){
        return $this->hasMany(M_Kelurahan::class, 'district_id');
    }
}
