<?php
//Prototypes Model modul poliklinik developed by Dani Gunawan
// 31 may 2017

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class M_Poliklinik extends Model
{
    protected $table = 'kmu_ms_poliklinik';
    protected $primaryKey = 'code_poliklinik';
    protected $fillable = [
        'code_poliklinik',
        'nama_poliklinik', 
        'deskripsi_poliklinik',
        'gambar_poliklinik'
    ];
    
    public $incrementing = false; //dipakai karena primaryKey id_user pada table pasien tidak auto increment, increment tidak false maka akan eror pada table yang berelasi pada eloquent case ini digunakan untuk membuat Kode Rekam Medis 

    public $timestamps = true; // jika false maka updated_at dan created_at tidak running

    public function toDocters(){
        return $this->hasMany(M_Dokter::class, 'code_poliklinik', 'code_poliklinik');
    }
}
