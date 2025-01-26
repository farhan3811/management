<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class M_Exclude_Medicine_Details extends Model
{
    protected $table = 'kmu_ex_ps_medicine_details';
    protected $primarykey = 'code_ex_ps_medicine_details';

    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'code_ex_ps_medicine_details',
        'code_ex_ps_medicine',
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

    public function toExcludeMedicine(){
        return $this->belongsTo(M_Exclude_Medicine::class,'code_ex_ps_medicine','code_ex_ps_medicine');
    }
    public function toDetailMedicine(){
        return $this->belongsTo(M_Master_Medicine_Detail::class,'code_detail_medicine','code_detail_medicine');
    }
    public function toMedicine(){
        return $this->hasMany(M_Master_Medicine_Detail::class,'code_medicine','code_medicine');
    }
}
