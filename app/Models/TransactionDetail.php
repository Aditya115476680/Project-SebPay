<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    protected $primaryKey = 'tr_dt_id';
    protected $fillable = ['tr_dtl_tr_id', 'tr_dtl_tp_id', 'tr_dtl_qty', 'tr_dtl_subtotal'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'tr_dtl_tr_id', 'tr_id');
    }

    public function topping()
    {
        return $this->belongsTo(Topping::class, 'tr_dtl_tp_id', 'tp_id');
    }
}

