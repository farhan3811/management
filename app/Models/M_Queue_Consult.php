<?php
//Prototypes Model modul pasien developed by Dani Gunawan
// 31 may 2017

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class M_Queue_Consult extends Model
{
    protected $table ='kmu_ps_queue_docter';
    protected $primaryKey = 'code_queue_docter';
    
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'code_queue_docter',
        'code_visus',
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

    public function toVisus(){
        return $this->belongsTo(M_Visus::class,'code_visus', 'code_visus');
    }
    public function toConsult(){
        return $this->belongsTo(M_Consult::class,'code_queue_docter', 'code_queue_docter');
    }

}
