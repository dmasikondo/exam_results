<?php

namespace Database\Seeders;

use App\Models\ClearedStudent;
use Database\Factories\ClearedStudentFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClearedStudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ClearedStudent::factory()->create([
            'intake_id'=>2,
            'national_id_name'=>'44-0000000B10 someone cleared'
        ]);

    }
}
