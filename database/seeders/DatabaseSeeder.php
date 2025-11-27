<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            // --- GRUPO 1: CATÁLOGOS (DEBE IR PRIMERO) ---
            // Provee IDs para Roles, Genders, Statuses
            CatalogSeeder::class, 
            
            // --- GRUPO 2: ENTIDADES BASE ---
            // Provee IDs para Usuarios y Pacientes (requiere Catálogos)
            UserSeeder::class,
            PatientSeeder::class,

            // --- GRUPO 3: DATOS OPERACIONALES (OPCIONALES) ---
            // Aquí irían seeders para Turnos, Mediciones, etc.
            // AppointmentSeeder::class,
            // MeasurementSeeder::class,
        ]);

        
    }
}
