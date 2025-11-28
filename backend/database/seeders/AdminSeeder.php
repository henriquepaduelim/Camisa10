<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@galloclassics.test'],
            [
                'name' => 'Admin Gallo Classics',
                'telefone' => '(11) 90000-0000',
                'role' => 'admin',
                'password' => Hash::make('Admin123!'),
            ]
        );
    }
}
