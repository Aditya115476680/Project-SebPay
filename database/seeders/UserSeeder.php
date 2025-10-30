<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'username' => 'kasir1',
            'password' => '12345', // otomatis di-hash oleh mutator di model
            'nama_user' => 'Kasir Seblak',
        ]);
    }
}
