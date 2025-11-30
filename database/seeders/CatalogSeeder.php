<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //1. ROLES
        DB::table('roles')->insert([
            [
                'name' => 'Nutricionista',
                'description' => 'Acceso total a la gestión clínica y dashboard.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Secretaria',
                'description' => 'Acceso limitado a agenda y datos administrativos de pacientes.',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);

        //2. GENDERS
        DB::table('genders')->insert([
            ['name' => 'Femenino', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Masculino', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Otro', 'created_at' => now(), 'updated_at' => now()],
        ]);

        //3. STATUSES 
        DB::table('statuses')->insert([
            [
                'status_name' => 'Agendado',
                'description' => 'Turno reservado, pendiente de confirmación.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'status_name' => 'Confirmado',
                'description' => 'Paciente confirmó asistencia.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'status_name' => 'Atendido',
                'description' => 'Consulta realizada con éxito.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'status_name' => 'Cancelado',
                'description' => 'Anulado por paciente o profesional.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'status_name' => 'Ausente',
                'description' => 'El paciente no se presentó (No-Show).',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
