<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topping extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'stock',
    ];

    public function movements()
    {
        return $this->hasMany(ToppingMovement::class);
    }
    
    public function transactionDetails() {
        return $this->hasMany(TransactionDetail::class, 'tr_dtl_tp_id', 'tp_id');
    }
}
