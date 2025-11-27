<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Nutricionista
        User::create([
            'name' => 'Maria Fernanda Trinidad',
            'email' => 'nutricionista@consultapp.com',
            'password' => 'password',
            'role_id' => 1,
            'active' => true,
        ]);

        // Secretaria
        User::create([
            'name' => 'Ana Perez',
            'email' => 'secretaria@consultapp.com',
            'password' => 'password',
            'role_id' => 2,
            'active' => true,
        ]);
    }
}