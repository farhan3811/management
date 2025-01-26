<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class M_Consult_Medicine_Details extends Model
{
    protected $table = 'kmu_ps_afct_medicine_details';
    protected $primarykey = 'code_afct_medicine_details';

    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'code_afct_medicine_details',
        'code_afct_medicine',
        'code_medicine',
        'code_detail_medicine',
        'jumlah',
        'created_by',
        'updated_date',
        'updated_by',
        'deleted_date',
        'deleted_by',
        'state',
    ];

    public function toConsultMedicine(){
        return $this->belongsTo(M_Consult_Medicine::class,'code_afct_medicine','code_afct_medicine');
    }
    public function toDetailMedicine(){
        return $this->belongsTo(M_Master_Medicine_Detail::class,'code_detail_medicine','code_detail_medicine');
    }
    public function toMedicine(){
        return $this->hasMany(M_Master_Medicine_Detail::class,'code_medicine','code_medicine');
    }
}
