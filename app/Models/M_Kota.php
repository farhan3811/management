<?php
//Prototypes Model modul kota developed by Dani Gunawan
// 31 may 2017

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class M_Kota extends Model
{
    //deklarasi
	protected $table = 'kmu_ms_rg_regencies';
	protected $primarykey = 'id';

	public $timestamps = false;

	public function toDocters(){
		return $this->hasMany(M_Dokter::class, 'kota_dokter');
	}
	public function toPatients(){
		return $this->hasMany(M_Patient::class, 'kota_pasien');
	}
    public function toProvinsi(){
        return $this->belongsTo(M_Provinsi::class,'province_id', 'id');
    }
    public function toKecamatan(){
        return $this->hasMany(M_Kecamatan::class, 'regency_id');
    }
}
