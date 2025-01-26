<?php
//Prototypes Model modul dokter developed by Dani Gunawan
// 31 may 2017

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class M_Dokter extends Model
{
    protected $table ='kmu_us_docter';
    protected $primaryKey = 'code_docter';
    
    public $incrementing = false; //dipakai karena primaryKey id_user pada table dokter tidak auto increment, increment tidak false maka akan eror pada table yang berelasi pada eloquent case ini digunakan untuk membuat Kode Rekam Medis fungsi ini digunakan untuk trigger

    public $timestamps = true; // jika false maka updated_at dan created_at tidak running

    protected $fillable = [
        'code_docter',
        'code_user',
        'code_poliklinik',
        'nik',
        'telepon',
        'handphone',
        'email',
        'nama_dokter',
        'jenis_kelamin',
        'gelar',
        'gambar_profildokter',
        'tanggal_lahir',
        'negara_dokter',
        'provinsi_dokter',
        'kota_dokter',
        'kecamatan_dokter',
        'kelurahan_dokter',
        'id_spesialisasi',
        'id_poliklinik',
        'status_dokter',
        'alamat',
        'kodepos',
        'state'
    ];



    public function toUsers(){
        return $this->belongsTo(User::class,'code_user', 'code_user'); // dokter milik si user
    }

    // public function kepemeriksaan(){
    //     return $this->hasMany(modul_pemeriksaan::class,'id_dokter'); // one to many ya
    // }

    public function toCountries(){
        return $this->belongsTo(M_Negara::class, "negara_dokter"); //negara milik si dokter
    }

    public function toProvinces(){
        return $this->belongsTo(M_Provinsi::class,'provinsi_dokter'); //provinsi milik si dokter
    }

    public function toRegencies(){
        return $this->belongsTo(M_Kota::class,'kota_dokter'); //kota milik si dokter
    }

    public function toDistricts(){
        return $this->belongsTo(M_Kecamatan::class,'kecamatan_dokter'); //kecamatan milik si dokter
    }

    public function toVillages(){
        return $this->belongsTo(M_Kelurahan::class,'kelurahan_dokter'); //kelurahan milik si dokter
    }

    public function toPoliklinik(){
        return $this->belongsTo(M_Poliklinik::class,'code_poliklinik', 'code_poliklinik'); 
    }

    public function toBooking(){
        return $this->hasMany(M_Booking::class,'code_docter', 'code_docter'); 
    }


    public function toScheduleDay(){
        return $this->hasMany(M_Booking_Day::class,'code_docter', 'code_docter'); 
    }
}
