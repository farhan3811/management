<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class M_Income_Medicine extends Model
{
    protected $table = 'kmu_ps_income_medicine';
    protected $primarykey = 'code_ps_income_medicine';

    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'code_ps_income_medicine',
        'code_afct_medicine',
        'total',
        'price',
        'is_paid',
        'created_by',
        'updated_date',
        'updated_by',
        'deleted_date',
        'deleted_by',
        'state',
    ];

    // public function toQueueVisusNormal(){
    //     return $this->belongsTo(M_Queue_Visus::class,'code_queue_visus_normal','code_queue_visus_normal');
    // }
    // public function toQueueDokter(){
    //     return $this->belongsTo(M_Queue_Consult::class,'code_visus','code_visus');
    // }
}
