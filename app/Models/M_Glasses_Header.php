<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class M_Glasses_Header extends Model
{
    protected $table = 'kmu_ms_glasses_header';
    protected $primarykey = 'kmu_ms_glasses_header';

    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'code_header',
        'header',
        'created_by',
        'updated_date',
        'updated_by',
        'deleted_date',
        'deleted_by',
        'state',
    ];

    public function toVisusGlasses(){
        return $this->hasMany(M_Visus_Kacamata::class,'code_header','glasses_header_code');
    }
}
