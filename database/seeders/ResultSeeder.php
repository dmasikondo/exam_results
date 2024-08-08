<?php

namespace Database\Seeders;

use App\Models\Intake;
use App\Models\Result;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $intake =Intake::factory()->create();
        Result::factory()->count(10)->create([
            'intake_id'=>$intake->id,
            'surname' => 'vanhu',
            'names' => 'vakuru',
            'candidate_number' => '042023009B',
            'discipline' => 'Jounalism',
            'exam_session' => 'April 2024'
        ]);
    }
}
