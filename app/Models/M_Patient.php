<?php
//Prototypes Model modul pasien developed by Dani Gunawan
// 31 may 2017

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class M_Patient extends Model
{
    protected $table ='kmu_us_patient';
    protected $primaryKey = 'code_patient';
    
    public $incrementing = false; //dipakai karena primaryKey id_user pada table pasien tidak auto increment, increment tidak false maka akan eror pada table yang berelasi pada eloquent case ini digunakan untuk membuat Kode Rekam Medis fungsi ini digunakan untuk trigger

    public $timestamps = true; // jika false maka updated_at dan created_at tidak running

    protected $fillable = [
        'code_patient',
        'code_user',
        'id_rekam_medis',
        'nik',
        'gelar',
        'nama_pasien',
        'tanggal_lahir',
        'jenis_kelamin',
        'gambar_profilpasien',
        'alamat',
        'email',
        'telepon',
        'handphone',
        'negara_pasien',
        'provinsi_pasien',
        'kota_pasien',
        'kecamatan_pasien',
        'kelurahan_pasien',
        'gol_darah',
        'riwayat_penyakit',
        'no_asuransi',
        'nama_ibu',
        'nama_wali',
        'nomor_telepon_wali',
        'email_wali',
        'hubungan_wali',
        'status_pasien',
        'status_row',
    ];


    // public function kepemeriksaan(){
    //     return $this->hasMany(modul_pemeriksaan::class,'id_pasien');
    // }

    public function toUsers(){
        return $this->belongsTo(User::class,'code_user', 'code_user'); // dokter milik si user
    }

    public function toCountries(){
        return $this->belongsTo(M_Negara::class, "negara_pasien"); //negara milik si dokter
    }

    public function toProvinces(){
        return $this->belongsTo(M_Provinsi::class,'provinsi_pasien'); //provinsi milik si pasien
    }

    public function toRegencies(){
        return $this->belongsTo(M_Kota::class,'kota_pasien'); //kota milik si pasien
    }

    public function toDistricts(){
        return $this->belongsTo(M_Kecamatan::class,'kecamatan_pasien'); //kecamatan milik si pasien
    }

    public function toVillages(){
        return $this->belongsTo(M_Kelurahan::class,'kelurahan_pasien'); //kelurahan milik si pasien
    }


    // public function kepenjualan(){
    //     return $this->hasOne(modul_penjualan::class,'id_penjualan');
    // }


    public function scopeSearchByKeyword($query, $keyword){
        if ($keyword != '') {
            $query->where(function ($query) use ($keyword) {
                 $query->where('id_generate_pasien', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('nama_pasien', 'LIKE', '%'.$keyword.'%');
            });
        }

        return $query;
    }

}
