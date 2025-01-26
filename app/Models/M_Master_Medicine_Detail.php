<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class M_Master_Medicine_Detail extends Model
{
    protected $table = 'kmu_ms_dt_medicine';
    protected $primarykey = 'code_detail_medicine';

    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'code_detail_medicine',
        'code_medicine',
        'harga_jual',
        'created_by',
        'updated_date',
        'updated_by',
        'deleted_date',
        'deleted_by',
        'state',
    ];

    public function toMedicine(){
        return $this->belongsTo(M_Master_Medicine::class,'code_medicine', 'code_medicine');
    }
    public function toConsultMedicine(){
        return $this->hasMany(M_Consult_Medicine::class,'code_detail_medicine', 'code_detail_medicine');
    }
}
