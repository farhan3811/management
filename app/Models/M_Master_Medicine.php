<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class M_Master_Medicine extends Model
{
    protected $table = 'kmu_ms_medicine';
    protected $primarykey = 'code_medicine';

    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'code_medicine',
        'nama_obat',
        'code_medicine_unit',
        'created_by',
        'updated_date',
        'updated_by',
        'deleted_date',
        'deleted_by',
        'state',
    ];

    public function toDetailMedicine(){
        return $this->hasMany(M_Master_Medicine_Detail::class,'code_medicine', 'code_medicine');
    }
    public function toMedicineUnit(){
        return $this->belongsTo(M_Master_Medicine_Unit::class,'code_medicine_unit', 'code_medicine_unit');
    }
}
