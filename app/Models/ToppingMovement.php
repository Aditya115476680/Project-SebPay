<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToppingMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'topping_id',
        'type', // in/out
        'quantity',
        'description',
    ];

    public function topping()
    {
        return $this->belongsTo(Topping::class);
    }
}

