<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class M_Master_Operation_Type extends Model
{
    protected $table = 'kmu_ms_operation_step';
    protected $primarykey = 'code_operation_step';

    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'code_operation_step',
        'name_operation_step',
        'diagnosis_kerja',
        'diagnosis_banding',
        'tindakan_kedokteran',
        'indikasi_tindakan',
        'tata_cara',
        'tujuan',
        'resiko_tindakan',
        'komplikasi',
        'prognosis',
        'alternatif_dan_resiko',
        'lain_lain',
        'created_by',
        'updated_date',
        'updated_by',
        'deleted_date',
        'deleted_by',
        'state',
    ];

}
