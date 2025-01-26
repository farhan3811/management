<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class M_Exclude_Medicine extends Model
{
    protected $table = 'kmu_ex_ps_medicine';
    protected $primarykey = 'code_ex_ps_medicine';

    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'code_ex_ps_medicine',
        'customer_name',
        'is_billed',
        'is_paid',
        'is_done',
        'is_taken',
        'created_by',
        'updated_date',
        'updated_by',
        'deleted_date',
        'deleted_by',
        'state',
    ];

    public function toMedicineDetails(){
        return $this->hasMany(M_Exclude_Medicine_Details::class,'code_ex_ps_medicine','code_ex_ps_medicine');
    }
}
