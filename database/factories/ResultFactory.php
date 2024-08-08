<?php

namespace Database\Factories;

use App\Models\Intake;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Result>
 */
class ResultFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gradeClasses = ['1', '2.1', '2.2', '3', 'F', 'deferred', 'exempted', 'fail'];
        return [
            //'user_id'=> fn()=>User::factory()->create()->id,
            'intake_id' => fn()=>Intake::factory()->create()->id,
            'discipline' =>fake()->word(),
            'course_code' =>fake()->word,
            'candidate_number' =>fake()->numerify('######').fake()->lexify('?'),
            'surname'=>fake()->name(),
            'names'=>fake()->name(),
            'subject_code' =>fake()->numerify('####/').fake()->lexify('???'),
            'subject' =>fake()->words(fake()->numberBetween(1, 3), true),
            'grade' => fake()->randomElement($gradeClasses),
            'exam_session' => fake()->word().' 2024',
            'comment' =>fake()->randomElement($gradeClasses),
        ];
    }
}

