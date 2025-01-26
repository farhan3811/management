<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class M_Payment extends Model
{
    protected $table = 'kmu_ps_payment';
    protected $primarykey = 'code_ps_payment';

    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'code_ps_payment',
        'registered_code',
        'payment_no',
        'payment_method',
        'payment_timestamp',
        'payment_received',
        'keterangan',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'state',
    ];

    public function toBooking(){
        return $this->belongsTo(M_Booking::class,'registered_code','code_booking');
    }
}
