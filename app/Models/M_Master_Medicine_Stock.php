<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class M_Master_Medicine_Stock extends Model
{
    protected $table = 'kmu_ms_medicine_stock';
    protected $primarykey = 'id';

    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'code_medicine',
        'harga_beli_satuan',
        'harga_beli_total',
        'stock',
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
}
