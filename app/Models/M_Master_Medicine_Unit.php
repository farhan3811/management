<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class M_Master_Medicine_Unit extends Model
{
    protected $table = 'kmu_ms_medicine_unit';
    protected $primarykey = 'code_medicine_unit';

    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'code_medicine_unit',
        'satuan',
        'created_at',
        'created_by',
        'updated_date',
        'updated_by',
        'deleted_date',
        'deleted_by',
        'state',
    ];


    public function toMedicine(){
        return $this->hasMany(M_Master_Medicine::class,'code_medicine_unit', 'code_medicine_unit');
    }
}
