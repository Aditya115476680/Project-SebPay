<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['tr_total_amount', 'tr_payment', 'tr_change', 'tr_date'];
    protected $primaryKey = 'tr_id';
    

   // Transaction.php
    public function details()
{
    return $this->hasMany(TransactionDetail::class, 'tr_dtl_tr_id', 'tr_id');
}

    public function user()
{
    return $this->belongsTo(User::class, 'user_id', 'id');
}

// TransactionDetail.php
    public function topping()
{
    return $this->belongsTo(Topping::class, 'tr_dtl_tp_id', 'tp_id');
}

}
