<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class M_Booking extends Model
{
    protected $table = 'kmu_ps_booking';
    protected $primarykey = 'code_booking';

    public $timestamps = true;
    public $incrementing = false;

    protected $fillable = [
        'code_booking',
        'code_patient',
        'code_docter',
        'code_us_docter_booking_time',
        'booking_dari',
        'booking_tanggal',
        'created_by',
        'created_date',
        'updated_date',
        'updated_by',
        'deleted_date',
        'deleted_by',
        'state',
        'is_finished',
    ];

    public function toBookingTime(){
        return $this->belongsTo(M_Booking_Time::class,'code_us_docter_booking_time','code_us_docter_schedule_time');
    }
    public function toPatient(){
        return $this->belongsTo(M_Patient::class,'code_patient','code_patient');
    }
    public function toQueueVisus(){
        return $this->belongsTo(M_Queue_Visus::class,'code_booking', 'code_booking');
    }
    public function toQueueGlasses(){
        return $this->belongsTo(M_Queue_Kacamata::class,'code_booking', 'code_booking');
    }
}
