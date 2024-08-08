<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       $name = fake()->name;
       $letter = fake()->randomElement(range('A', 'Z'));
        $numbers = fake()->numerify('########'); // Generate random 7-digit number
        $numbers = (strlen($numbers) == 6) ? '0' . $numbers : $numbers; // Ensure 7-digit number if needed
        $letter = fake()->lexify('?'); // Generate random letter A-Z
        $digits = fake()->numerify('##'); // Generate random 2-digit number
        // Randomly choose between 6 or 7 digits after the hyphen
        $national_id = fake()->numerify('##-') . $numbers . $letter . $digits;

        $sex = fake()->randomElement(['male','female']);
        return [
            'second_name' => fake()->name(),
            'first_name' => fake()->name(),
            'slug' =>$name.uniqid(),
            'email' => fake()->unique()->safeEmail(),
             'national_id' => $national_id,
             'sex' =>$sex,
             'phone_number' =>fake()->phoneNumber(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
