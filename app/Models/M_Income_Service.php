<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class M_Income_Service extends Model
{
    protected $table = 'kmu_ps_income_service';
    protected $primarykey = 'code_ps_income_service';

    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'code_ps_income_service',
        'code_service',
        'code_booking',
        'code_action',
        'quantity',
        'created_by',
        'deleted_at',
        'deleted_by',
        'state',
    ];

    public function toServicePrice(){
        return $this->belongsTo(M_Service_Price::class,'code_service','code_service');
    }
    public function toVisus(){
        return $this->belongsTo(M_Visus::class,'code_action','code_visus');
    }
    public function toConsult(){
        return $this->belongsTo(M_Consult::class,'code_action','code_consult');
    }
}
