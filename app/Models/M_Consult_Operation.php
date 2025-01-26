<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class M_Consult_Operation extends Model
{
    protected $table = 'kmu_ps_afct_operation';
    protected $primarykey = 'code_operation';

    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'code_operation',
        'code_operation_agreement',
        'diagnosa_pasca_bedah',
        'tanggal_operasi',
        'mulai_jam_operasi',
        'berhenti_jam_operasi',
        'jenis_operasi',
        'nama_operator',
        'kualifikasi_operator',
        'asisten',
        'scrub_nurse_I',
        'scrub_nurse_II',
        'circulated_nurse',
        'jenis_anestesi',
        'mulai_jam_anestesi',
        'berhenti_jam_anestesi',
        'bahan_anesteticum',
        'nama_anestesist',
        'kualifikasi_anestesist',
        'golongan_operasi',
        'macam_operasi',
        'urgensi_operasi',
        'catatan_operator',
        'catatan_operator',
        'is_done',
        'is_billed',
        'created_by',
        'updated_date',
        'updated_by',
        'deleted_date',
        'deleted_by',
        'state',
    ];

}
