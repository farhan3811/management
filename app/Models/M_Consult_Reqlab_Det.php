<?php
//Prototypes Model modul pasien developed by Dani Gunawan
// 31 may 2017

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class M_Consult_Reqlab_Det extends Model
{
    protected $table ='kmu_ps_afct_reqlab_details';
    protected $primaryKey = 'code_reqlab_detail';
    
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'code_reqlab_detail',
        'code_reqlab',
        'code_lab',
        'value',
        'positif_or_negatif',
        'entered_at',
        'entered_by',
        'created_by',
        'updated_date',
        'updated_by',
        'deleted_date',
        'deleted_by',
        'state',
    ];

    public function toReqLab(){
        return $this->belongsTo(M_Consult_Reqlab::class,'code_reqlab', 'code_reqlab');
    }
    public function toLab(){
        return $this->belongsTo(M_Master_Lab::class,'code_lab', 'code_lab');
    }

}
