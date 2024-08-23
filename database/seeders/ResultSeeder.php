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
        $intake =Intake::factory()->create(['title'=>'Level 1 Semester 1']);
        Result::factory()->count(10)->create([
            'intake_id'=>$intake->id,
            'surname' => 'surname01',
            'names' => 'names01',
            'candidate_number' => '000000A1',
            'discipline' => 'Something',
            'exam_session' => '2024',
            'is_btec' => 1,
            'programme' => 'b-tech honours degree in mass communication programme',
        ]);
    }
}
