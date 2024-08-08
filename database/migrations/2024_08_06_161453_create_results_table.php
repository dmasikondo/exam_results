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
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')->nullable();
            $table->foreignId('intake_id');
            $table->string('discipline');
            $table->string('course_code');
            $table->string('candidate_number');
            $table->string('surname');
            $table->string('names');
            $table->string('subject_code');
            $table->string('subject');
            $table->string('grade');
            $table->string('exam_session');
            $table->string('comment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};
