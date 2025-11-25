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
        Schema::disableForeignKeyConstraints();

        Schema::create('credentials', function (Blueprint $table) {
            $table->id();
            $table->string('username', 50)->unique();
            $table->string('password', 255);
            $table->boolean('active')->nullable()->default(true);
            $table->timestamp('last_login')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credentials');
    }
};
