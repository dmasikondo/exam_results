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
        $intake =Intake::factory()->create(['title'=>'Aug 2024']);
        Result::factory()->count(10)->create([
            'intake_id'=>$intake->id,
            'surname' => 'seeded',
            'names' => 'results',
            'candidate_number' => 'another',
            'discipline' => 'Something',
            'exam_session' => 'Aug 2024'
        ]);
    }
}
