<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'João',
            'email' => 'joao@example.com',
            'password' => Hash::make('123456')
        ]);
        
        User::create([
            'name' => 'Maria',
            'email' => 'maria@example.com',
            'password' => Hash::make('123456')
        ]);
        
        // Adicione quantos usuários desejar...
    }
}