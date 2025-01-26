<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class M_Consult extends Model
{
    protected $table = 'kmu_ps_consult';
    protected $primarykey = 'code_consult';

    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'code_consult',
        'code_queue_docter',
        'is_glasses',
        'is_medicine',
        'is_refer',
        'is_operation',
        'on_behalf_of',
        'is_done',
        'is_billed',
        'created_by',
        'updated_date',
        'updated_by',
        'deleted_date',
        'deleted_by',
        'state',
    ];

    public function toQueueVisusDocter(){
        return $this->belongsTo(M_Queue_Consult::class,'code_queue_docter','code_queue_docter');
    }
    public function user(){
        return $this->belongsTo('App\User','on_behalf_of','code_user');
    }
    public function toMedicine(){
        return $this->belongsTo(M_Medicine::class,'code_consult','code_consult');
    }
    public function toOperationAgreement(){
        return $this->belongsTo(M_Consult_Operation_Agreement::class, 'code_consult', 'code_consult');
    }
    public function toRequestLab(){
        return $this->belongsTo(M_Consult_Lab_Val::class,'code_consult','code_consult');
    }
    public function toAfctMedicine(){
        return $this->belongsTo(M_Consult_Medicine::class,'code_consult','code_consult');
    }
}
