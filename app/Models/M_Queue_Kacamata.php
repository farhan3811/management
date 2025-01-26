<?php
//Prototypes Model modul pasien developed by Dani Gunawan
// 31 may 2017

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class M_Queue_Kacamata extends Model
{
    protected $table ='kmu_ps_queue_visus_glasses';
    protected $primaryKey = 'code_queue_visus_glasses';
    
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'code_queue_visus_glasses',
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
    public function toVisusGlasses(){
        return $this->belongsTo(M_Visus_Kacamata::class,'code_queue_visus_glasses', 'code_queue_visus_glasses');
    }

}
