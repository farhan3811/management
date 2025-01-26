<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class M_Visus_Kacamata extends Model
{
    protected $table = 'kmu_ps_afct_glasses';
    protected $primarykey = 'code_afct_glasses';

    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'code_afct_glasses',
        'code_queue_visus_glasses',
        'tipe',
        'pro',
        'tahun',
        'is_done',
        'is_billed',
        'created_by',
        'updated_date',
        'updated_by',
        'deleted_date',
        'deleted_by',
        'state',
    ];

    public function toQueueVisusGlasses(){
        return $this->belongsTo(M_Queue_Kacamata::class,'code_queue_visus_glasses','code_queue_visus_glasses');
    }
    public function toVisusGlassesReceipt(){
        return $this->hasMany(M_Visus_Kacamata_Receipt::class,'code_afct_glasses','code_afct_glasses');
    }
}
