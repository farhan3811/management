<?php
//Prototypes Model modul dokter developed by Dani Gunawan
// 31 may 2017

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class M_Dokter_Waktu extends Model
{
    protected $table ='kmu_us_docter_schedule_time';
    protected $primaryKey = 'code_us_docter_schedule_time';
    
    public $incrementing = false; //dipakai karena primaryKey id_user pada table dokter tidak auto increment, increment tidak false maka akan eror pada table yang berelasi pada eloquent case ini digunakan untuk membuat Kode Rekam Medis fungsi ini digunakan untuk trigger

    public $timestamps = true; // jika false maka updated_at dan created_at tidak running

    protected $fillable = [
        'id',
        'code_us_docter_schedule_time',
        'code_us_docter_schedule_day',
        'time_start',
        'time_end',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted_at',
        'deleted_by',
        'state'
    ];

    public function toScheduleDay(){
        return $this->belongsTo(M_Dokter_Hari::class, 'kmu_us_docter_schedule_day'); // dokter milik si user
    }

}
