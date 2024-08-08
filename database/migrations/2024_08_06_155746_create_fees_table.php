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
        Schema::create('intakes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('label');
            $table->timestamps();
        });
        Schema::create('fees', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->foreignId('user_id');
            $table->timestamp('cleared_at')->default(null)->nullable();
            $table->foreignId('clearer_id')->nullable();
            $table->foreignId('intake_id')->nullable();
            $table->boolean('is_cleared')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fees');
        Schema::dropIfExists('intakes');

    }
};
