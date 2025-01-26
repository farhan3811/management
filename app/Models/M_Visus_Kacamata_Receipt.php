<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class M_Visus_Kacamata_Receipt extends Model
{
    protected $table = 'kmu_ps_afct_glasses_receipt';
    protected $primarykey = 'code_afct_glasses_receipt';

    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'code_afct_glasses_receipt',
        'code_afct_glasses',
        'glasses_header_code',
        'glasses_sider_code',
        'value',
        'created_by',
        'updated_date',
        'updated_by',
        'deleted_date',
        'deleted_by',
        'state',
    ];

    public function toVisusKacamata(){
        return $this->belongsTo(M_Queue_Kacamata::class,'code_afct_glasses','code_afct_glasses');
    }
    public function toGlassesHeader(){
        return $this->belongsTo(M_Glasses_Header::class,'glasses_header_code','code_header');
    }
    public function toGlassesSider(){
        return $this->belongsTo(M_Glasses_Sider::class,'glasses_sider_code','code_sider');
    }
}
