<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class M_Service extends Model
{
    protected $table = 'kmu_ms_service';
    protected $primarykey = 'code_service';

    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'code_service',
        'service_name',
        'service_category',
        'price',
        'created_by',
        'updated_date',
        'updated_by',
        'deleted_date',
        'deleted_by',
        'state',
    ];

    public function toServicePayment(){
        return $this->hasMany(M_Service_Payment::class,'code_service','code_service');
    }
}
