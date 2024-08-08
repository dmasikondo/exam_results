<?php

namespace Database\Seeders;

use App\Models\Intake;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IntakeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Intake::factory()->count(2)->create();
    }
}
