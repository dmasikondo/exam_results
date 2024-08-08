<?php

namespace Tests\Feature\Auth;

use App\Models\Intake;
use App\Models\Result;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response
            ->assertOk()
            ->assertSeeVolt('pages.auth.register');
    }

    public function test_new_users_with_existing_exam_results_can_register(): void
    {
        $surname = 'test';
        $names = 'user';
        $candidate_number = '042024001A';

        $this->createExamResultsWithCandidateAttributes(surname: $surname, names: $names, candidate_number: $candidate_number);

        $registrationComponent = $this->registrationComponent(
            surname: $surname,
            names: $names,
            candidate_number: $candidate_number,
            national_id: '19-192000B14',
            email: 'test@example.com',
        );

        $registrationComponent->call('register');
        $registrationComponent->assertRedirect(route('dashboard', absolute: false));

        $this->assertAuthenticated();
    }

    public function test_a_candidate_without_existing_results_cannot_register(): void
    {
        $surname = 'non extisting';
        $names = 'candidate number';
        $candidate_number = '062024001C';
        $unrealCandidateNumber = '992090001Z';

        $this->createExamResultsWithCandidateAttributes(surname: $surname, names: $names, candidate_number: $candidate_number);

        $registrationComponent = $this->registrationComponent(
            surname: $surname,
            names: $names,
            candidate_number: $unrealCandidateNumber,
            national_id: '19-191919M19',
            email: 'test@example.com',
        );


        $registrationComponent->call('register');

        $registrationComponent
            ->assertHasErrors()
            ->assertNoRedirect();

        $this->assertGuest();
    }

    public function test_existing_user_cannot_register(): void
    {
        $user = User::factory()->create();

        $existingResults = $this->createExamResultsWithCandidateAttributes();

        $registrationComponent = $this->registrationComponent(
            candidate_number: $existingResults->candidate_number,
            national_id: $user->national_id,
            email: $user->email,
            surname:  $existingResults->surname,
            names: $existingResults->names,
        );

        $registrationComponent->call('register');

        $registrationComponent
            ->assertHasErrors()
            ->assertNoRedirect();

        $this->assertGuest();

    }

    private function createExamResultsWithCandidateAttributes(string $surname='mutupo', string $names='zita', string $candidate_number='00000001A'): Result
    {

        $intake =Intake::factory()->create();
        return Result::factory()->create([
            'intake_id'=>$intake->id,
            'surname' => $surname,
            'names' => $names,
            'candidate_number' => $candidate_number,
        ]);


    }

    private function registrationComponent(string $surname ='some', string $names ='user', string $candidate_number='00000001A', string $national_id='99-0000001A01', string $email='myemail.com', string $password = 'password', string $password_confirmation = 'password')
    {
        return Volt::test('pages.auth.register')
            ->set('surname', $surname)
            ->set('names',$names)
            ->set('candidate_number', $candidate_number)
            ->set('national_id', $national_id)
            ->set('email', $email)
            ->set('password', $password)
            ->set('password_confirmation', $password_confirmation);
    }
}
