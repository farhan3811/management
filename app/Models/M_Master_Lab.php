<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class M_Master_Lab extends Model
{
    protected $table = 'kmu_ms_lab';
    protected $primarykey = 'code_lab';

    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'code_lab',
        'code_lab_group',
        'detail_lab',
        'nilai_normal',
        'satuan',
        'created_by',
        'updated_date',
        'updated_by',
        'deleted_date',
        'deleted_by',
        'state',
    ];

    public function toLabGroup(){
        return $this->belongsTo(M_Master_Medicine_Detail::class,'code_lab_group', 'code_lab_group');
    }
}
