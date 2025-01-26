<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class M_Income_Medicine_Exclude extends Model
{
    protected $table = 'kmu_ex_ps_income_medicine';
    protected $primarykey = 'code_ex_ps_income_medicine';

    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'code_ex_ps_income_medicine',
        'code_ex_ps_medicine_details',
        'total',
        'price',
        'is_paid',
        'created_by',
        'updated_date',
        'updated_by',
        'deleted_date',
        'deleted_by',
        'state',
    ];

}
