<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersFirstAdminTableSeeder extends Seeder
{
    public function run()
    {
        $user = new User();
        $user->name = 'admin';
        $user->email = 'admin@admin.com.br';
        $user->is_admin = true;
        $user->email_verified_at = null;
        $user->password = Hash::make('mv123456');
        $user->save();
    }
}
