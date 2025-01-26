<?php
//Prototypes Model modul pasien developed by Dani Gunawan
// 31 may 2017

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class M_Consult_Reqlab extends Model
{
    protected $table ='kmu_ps_afct_reqlab';
    protected $primaryKey = 'code_reqlab';
    
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'code_reqlab',
        'code_consult',
        'keterangan',
        'is_done',
        'is_billed',
        'created_by',
        'updated_date',
        'updated_by',
        'deleted_date',
        'deleted_by',
        'state',
    ];

    public function toConsult(){
        return $this->belongsTo(M_Consult::class,'code_consult', 'code_consult');
    }
    public function toConsultReqlabDet(){
        return $this->hasMany(M_Consult_Reqlab_Det::class,'code_reqlab', 'code_reqlab');
    }
    public function toConsultReqlabDetStateY() {
        return $this->toConsultReqlabDet()->where('state', 'Y');
    }

}
