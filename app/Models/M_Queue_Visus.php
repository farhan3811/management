<?php
//Prototypes Model modul pasien developed by Dani Gunawan
// 31 may 2017

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class M_Queue_Visus extends Model
{
    protected $table ='kmu_ps_queue_visus_normal';
    protected $primaryKey = 'code_queue_visus_normal';
    
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'code_queue_visus_normal',
        'code_booking',
        'queue_no',
        'is_called',
        'is_skipped',
        'is_canceled',
        'created_by',
        'created_at',
        'updated_date',
        'updated_by',
        'deleted_date',
        'deleted_by',
        'state',
    ];

    public function toBooking(){
        return $this->belongsTo(M_Booking::class,'code_booking', 'code_booking');
    }
    public function toVisus(){
        return $this->belongsTo(M_Visus::class,'code_queue_visus_normal', 'code_queue_visus_normal');
    }
}
