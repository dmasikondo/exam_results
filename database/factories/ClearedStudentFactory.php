<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Intake;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ClearedStudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       $letter = fake()->randomElement(range('A', 'Z'));
        $numbers = fake()->numerify('########'); // Generate random 7-digit number
        $numbers = (strlen($numbers) == 6) ? '0' . $numbers : $numbers; // Ensure 7-digit number if needed
        $letter = fake()->lexify('?'); // Generate random letter A-Z
        $digits = fake()->numerify('##'); // Generate random 2-digit number
        // Randomly choose between 6 or 7 digits after the hyphen
        $national_id = fake()->numerify('##-') . $numbers . $letter . $digits;
        $departments = Department::all();
        $departmentsArray = $departments->pluck('name')->toArray();
        $level = ['NC','ND','HND','BTEC'];

        return [
            'intake_id' => fn()=>Intake::factory()->create()->id,
            'national_id_name' =>$national_id.' '.fake()->name,
            'department'=>fake()->randomElement($departmentsArray),
            'level' =>fake()->randomElement($level),
        ];
    }
}
