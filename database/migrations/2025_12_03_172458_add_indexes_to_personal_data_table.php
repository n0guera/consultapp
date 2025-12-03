<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('personal_data', function (Blueprint $table) {
        $table->index('first_name'); // Acelera búsqueda por nombre
        $table->index('last_name');  // Acelera búsqueda por apellido
        $table->index('dni');        // Acelera búsqueda por DNI (Vital)
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personal_data', function (Blueprint $table) {
            //
        });
    }
};
