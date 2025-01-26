<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class M_Consult_Medicine extends Model
{
    protected $table = 'kmu_ps_afct_medicine';
    protected $primarykey = 'code_afct_medicine';

    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'code_afct_medicine',
        'code_consult',
        'code_ex_ps_medicine',
        'is_billed',
        'is_taken',
        'is_paid',
        'is_done',
        'created_by',
        'updated_date',
        'updated_by',
        'deleted_date',
        'deleted_by',
        'state',
    ];

    public function toConsult(){
        return $this->belongsTo(M_Consult::class,'code_consult','code_consult');
    }
    public function toAfctMedicineDetail()
    {
        return $this->hasMany(M_Consult_Medicine_Details::class,'code_afct_medicine','code_afct_medicine');
    }
}
