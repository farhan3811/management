<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class M_Glasses_Sider extends Model
{
    protected $table = 'kmu_ms_glasses_sider';
    protected $primarykey = 'kmu_ms_glasses_sider';

    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'code_sider',
        'sider',
        'created_by',
        'updated_date',
        'updated_by',
        'deleted_date',
        'deleted_by',
        'state',
    ];

    public function toVisusGlasses(){
        return $this->hasMany(M_Visus_Kacamata::class,'code_sider','glasses_sider_code');
    }
}
