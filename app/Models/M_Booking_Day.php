<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class M_Booking_Day extends Model
{
    protected $table = 'kmu_us_docter_schedule_day';
    protected $primarykey = 'code_us_docter_schedule_day';

    public $timestamps = false;

    protected $fillable = [
        'code_us_docter_schedule_day',
        'code_docter',
        'day',
        'created_by',
        'created_date',
        'updated_date',
        'updated_by',
        'deleted_date',
        'deleted_by',
        'state',
    ];

    public function toBookingTime(){
        return $this->hasMany(M_Dokter_Waktu::class, 'code_us_docter_schedule_day', 'code_us_docter_schedule_day');
    }
    public function toDocter(){
        return $this->belongsTo(M_Dokter::class,'code_docter', 'code_docter');
    }
}
