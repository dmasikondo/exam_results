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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('label')->nullable();
            $table->timestamps();
        });

        //insert some role names
        DB::table('roles')->insert([
                ['name' => 'accountant', 'label'=>'financial office','created_at'=>now(),'updated_at'=>now()],
                ['name' => 'exams', 'label'=>'examinations office','created_at'=>now(),'updated_at'=>now()],
                ['name' => 'admin_office', 'label'=>'administration office','created_at'=>now(),'updated_at'=>now()],
                ['name' => 'warden', 'label'=>'wadern office','created_at'=>now(),'updated_at'=>now()],
                ['name' => 'manager', 'label'=>'principal office','created_at'=>now(),'updated_at'=>now()],
                ['name' => 'library', 'label'=>'library office','created_at'=>now(),'updated_at'=>now()],
                ['name' => 'hod', 'label'=>'head of department','created_at'=>now(),'updated_at'=>now()],
                ['name' => 'superadmin', 'label'=>'IT Unit Department','created_at'=>now(),'updated_at'=>now()],
            ]);

        Schema::create('role_user', function (Blueprint $table) {
            $table->primary(['user_id','role_id']);
            $table->foreignId('user_id');
            $table->foreignId('role_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('roles');

    }
};
