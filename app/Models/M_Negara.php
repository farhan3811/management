<?php
//Prototypes Model modul negara developed by Dani Gunawan
// 31 may 2017

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class M_Negara extends Model
{
    //deklarasi model negara
    protected $table = "kmu_ms_rg_countries";
    protected $primarykey = "id";

    public $timestamps = false;

    public function toDocters(){
        return $this->hasMany(M_Dokter::class, "negara_dokter");
    }
    public function toPatients(){
        return $this->hasMany(M_Patient::class, "negara_pasien");
    }
}
