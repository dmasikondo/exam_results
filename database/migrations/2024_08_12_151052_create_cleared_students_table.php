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
        Schema::create('cleared_students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('intake_id');
            $table->string('national_id_name');
            $table->string('department')->nullable();
            $table->string('level')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cleared_students');
    }
};
