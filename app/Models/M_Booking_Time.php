<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class M_Booking_Time extends Model
{
    protected $table = 'kmu_us_docter_schedule_time';
    protected $primarykey = 'code_us_docter_schedule_time';

    public $timestamps = false;

    protected $fillable = [
        'code_us_docter_schedule_time',
        'code_us_docter_schedule_day',
        'time_start',
        'time_end',
        'created_by',
        'created_date',
        'updated_date',
        'updated_by',
        'deleted_date',
        'deleted_by',
        'state',
    ];

    public function toBooking(){
        return $this->hasMany(M_Booking::class, 'code_us_docter_schedule_time', 'code_us_docter_booking_time');
    }
    public function toBookingDay(){
        return $this->belongsTo(M_Booking_Day::class,'code_us_docter_schedule_day', 'code_us_docter_schedule_day');
    }
}
