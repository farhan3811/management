<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class M_Consult_Lab_Val extends Model
{
    protected $table = 'kmu_ps_afct_reqlab';
    protected $primarykey = 'code_reqlab';

    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'code_afct_lab',
        'code_reqlab',
        'value',
        'positif_or_negatif',
        'is_done',
        'is_billed',
        'created_by',
        'updated_date',
        'updated_by',
        'deleted_date',
        'deleted_by',
        'state',
    ];

    public function toReqLabDetail(){
        return $this->belongsTo(M_Consult_Reqlab_Det::class,'code_reqlab', 'code_reqlab');
    }
}
