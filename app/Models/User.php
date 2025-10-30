<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users'; 
    protected $primaryKey = 'id_user'; 

    protected $fillable = [
        'username',
        'password',
        'nama_user',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    
    public function getAuthIdentifierName()
    {
        return 'username';
    }

    
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
