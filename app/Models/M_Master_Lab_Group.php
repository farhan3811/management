<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class M_Master_Lab_Group extends Model
{
    protected $table = 'kmu_ms_lab_group';
    protected $primarykey = 'code_lab_group';

    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'code_lab_group',
        'group_lab',
        'created_by',
        'updated_date',
        'updated_by',
        'deleted_date',
        'deleted_by',
        'state',
    ];

    public function toLab(){
        return $this->hasMany(M_Master_Lab::class,'code_lab_group', 'code_lab_group');
    }
}
