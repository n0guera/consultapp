<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Crear Contacto para el Paciente 1 (Juan Pérez)
        $id_contacto_p1 = DB::table('contacts')->insertGetId([
            'phone' => '1199887766',
            'email' => 'juan.perez@test.com',
            'created_at' => now(), 
            'updated_at' => now(),
        ]);

        // 2. Crear Datos Personales para el Paciente 1
        $id_dp_p1 = DB::table('personal_data')->insertGetId([
            'first_name' => 'Juan',
            'last_name' => 'Pérez',
            'contact_id' => $id_contacto_p1,
            'address' => 'Calle Falsa 123',
            'birth_date' => '1995-08-20',
            'gender_id' => 2, // Asumiendo ID 2 = Masculino
            'dni' => '40123456',
            'created_at' => now(), 
            'updated_at' => now(),
        ]);

        // 3. Crear Paciente (Enlazar)
        DB::table('patients')->insert([
            'personal_data_id' => $id_dp_p1,
            'active' => true,
            'created_at' => now(), 
            'updated_at' => now(),
        ]);
        
        // ----------------------------------------------------
        // Paciente 2 (Ana Torres)
        // ----------------------------------------------------
        
        $id_contacto_p2 = DB::table('contacts')->insertGetId([
            'phone' => '1122334455',
            'email' => 'ana.torres@test.com',
        ]);

        $id_dp_p2 = DB::table('personal_data')->insertGetId([
            'first_name' => 'Ana',
            'last_name' => 'Torres',
            'contact_id' => $id_contacto_p2,
            'address' => 'Av. Nutrición 500',
            'birth_date' => '1988-02-10',
            'gender_id' => 1, // Femenino
            'dni' => '35987654',
        ]);
        
        DB::table('patients')->insert([
            'personal_data_id' => $id_dp_p2,
            'active' => true,
        ]);
    }
}