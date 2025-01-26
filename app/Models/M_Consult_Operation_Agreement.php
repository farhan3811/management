<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class M_Consult_Operation_Agreement extends Model
{
    protected $table = 'kmu_ps_afct_operation_agreement';
    protected $primarykey = 'code_operation_agreement';

    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'code_operation_agreement',
        'code_consult',
        'code_operation_step',
        'isAgree',
        'doctor_code_of_operation',
        'informers',
        'recipient_of_information',
        'docter_signature_JSON',
        'docter_signature_JPEG',
        'patient_signature_JSON',
        'patient_signature_JPEG',
        'alternatif_dan_resiko',
        'is_done',
        'created_by',
        'updated_date',
        'updated_by',
        'deleted_date',
        'deleted_by',
        'state',
    ];

    public function toOperation(){
        return $this->belongsTo(M_Consult_Operation::class,'code_operation_agreement','code_operation_agreement');
    }
}
