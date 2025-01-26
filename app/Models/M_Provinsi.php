<?php
//Prototypes Model modul provinsi developed by Dani Gunawan
// 31 may 2017

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class M_Provinsi extends Model
{
	protected $table ='kmu_ms_rg_provinces';
	protected $primaryKey ='id';

	public $timestamps = false;

	public function toDocters(){
		return $this->hasMany(M_Dokter::class,'provinsi_dokter');
	}
	public function toPatients(){
		return $this->hasMany(M_Patient::class,'provinsi_pasien');
	}
}
