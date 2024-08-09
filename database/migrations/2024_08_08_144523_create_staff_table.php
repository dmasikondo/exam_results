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
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        // insert some department names
        DB::table('departments')->insert([
                ['name' => 'administration','created_at'=>now(),'updated_at'=>now()],
                ['name' =>'automotive','created_at'=>now(),'updated_at'=>now()],
                ['name' =>'applied arts','created_at'=>now(),'updated_at'=>now()],
                ['name' =>'civil engineering','created_at'=>now(),'updated_at'=>now()],
                ['name' =>'central maintenance','created_at'=>now(),'updated_at'=>now()],
                ['name' =>'construction engineering','created_at'=>now(),'updated_at'=>now()],
                ['name' =>'commerce','created_at'=>now(),'updated_at'=>now()],
                ['name' =>'electrical engineering','created_at'=>now(),'updated_at'=>now()],
                ['name' =>'information and communication technology','created_at'=>now(),'updated_at'=>now()],
                ['name' =>'IT Unit','created_at'=>now(),'updated_at'=>now()],
                ['name' =>'mass communication','created_at'=>now(),'updated_at'=>now()],
                ['name' =>'mechanical engineering','created_at'=>now(),'updated_at'=>now()],
                ['name' =>'office management', 'created_at'=>now(),'updated_at'=>now()],
                ['name' =>'printing and graphic arts', 'created_at'=>now(),'updated_at'=>now()],
                ['name' =>'science technology', 'created_at'=>now(),'updated_at'=>now()],
                ['name' =>'tourism and hospitality','created_at'=>now(),'updated_at'=>now()]
            ]);


        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('department_id')->constrained();
            $table->string('ec-number')->nullable()->unique();
            $table->string('title')->nullable();
            $table->string('designation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
        Schema::dropIfExists('departments');

    }
};
