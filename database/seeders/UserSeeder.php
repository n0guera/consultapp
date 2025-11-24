<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ----------------------------------------------------
        // 1. USUARIO: NUTRICIONISTA (ROL ID 1)
        // ----------------------------------------------------

        // 1.1. Contacto
        $id_contacto_nutri = DB::table('contacts')->insertGetId([
            'phone' => '1155551234',
            'email' => 'nutricionista@consultapp.com',
            'created_at' => now(), 
            'updated_at' => now(),
        ]);

        // 1.2. Datos Personales (Generamos DNI ficticio para el personal)
        $id_dp_nutri = DB::table('personal_data')->insertGetId([
            'first_name' => 'Maria Fernanda',
            'last_name' => 'Trinidad',
            'contact_id' => $id_contacto_nutri,
            'address' => 'Av. Nutricionistas 101',
            'birth_date' => '1985-05-15',
            'gender_id' => 1, // Asumiendo ID 1 = Femenino
            'dni' => 'USR-' . Str::random(8), // DNI Ficticio
            'created_at' => now(), 
            'updated_at' => now(),
        ]);
        
        // 1.3. Credenciales
        $id_cred_nutri = DB::table('credentials')->insertGetId([
            'username' => 'nutricionista',
            'password' => Hash::make('password'), // Clave: password
            'active' => true,
            'created_at' => now(), 
            'updated_at' => now(),
        ]);

        // 1.4. Usuario (Enlaza todo)
        DB::table('users')->insert([
            'role_id' => 1, // Rol: Nutricionista
            'credential_id' => $id_cred_nutri,
            'personal_data_id' => $id_dp_nutri,
            'active' => true,
            'created_at' => now(), 
            'updated_at' => now(),
        ]);

        // ----------------------------------------------------
        // 2. USUARIO: SECRETARIA (ROL ID 2)
        // ----------------------------------------------------
        
        // 2.1. Contacto
        $id_contacto_sec = DB::table('contacts')->insertGetId([
            'email' => 'secretaria@consultapp.com',
        ]);
        
        // 2.2. Datos Personales
        $id_dp_sec = DB::table('personal_data')->insertGetId([
            'first_name' => 'Ana',
            'last_name' => 'Perez',
            'contact_id' => $id_contacto_sec,
            'gender_id' => 1, // Femenino
            'dni' => 'USR-' . Str::random(8), // DNI Ficticio
        ]);
        
        // 2.3. Credenciales
        $id_cred_sec = DB::table('credentials')->insertGetId([
            'username' => 'secretaria',
            'password' => Hash::make('password'), // Clave: password
            'active' => true,
        ]);

        // 2.4. Usuario
        DB::table('users')->insert([
            'role_id' => 2, // Rol: Secretaria
            'credential_id' => $id_cred_sec,
            'personal_data_id' => $id_dp_sec,
            'active' => true,
        ]);
    }
}