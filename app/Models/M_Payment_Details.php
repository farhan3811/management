<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class M_Payment_Details extends Model
{
    protected $table = 'kmu_ps_payment_details';
    protected $primarykey = 'code_ps_payment_details';

    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'code_ps_payment_details',
        'code_ps_payment',
        'code_ps_income',
        'payment_type',
        'created_at',
        'created_by',
        'state',
    ];

    public function toPayment(){
        return $this->belongsTo(M_Payment::class,'code_ps_payment','code_ps_payment');
    }
}
