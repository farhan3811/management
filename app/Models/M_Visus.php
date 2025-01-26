<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class M_Visus extends Model
{
    protected $table = 'kmu_ps_visus';
    protected $primarykey = 'code_visus';

    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'code_visus',
        'code_queue_visus_normal',
        'visus_mata_kanan',
        'visus_mata_kiri',
        'segment_anterior',
        'segment_posterior',
        'penglihatan_warna',
        'keterangan',
        'saran',
        'is_done',
        'is_billed',
        'is_glasses_direct_from_visus',
        'created_by',
        'updated_date',
        'updated_by',
        'deleted_date',
        'deleted_by',
        'state',
    ];

    public function toQueueVisusNormal(){
        return $this->belongsTo(M_Queue_Visus::class,'code_queue_visus_normal','code_queue_visus_normal');
    }
    public function toQueueDokter(){
        return $this->belongsTo(M_Queue_Consult::class,'code_visus','code_visus');
    }
}
