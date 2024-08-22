<?php

namespace Tests\Feature;

use App\Models\ClearedStudent;
use App\Models\Fee;
use App\Models\Intake;
use App\Models\Result;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Livewire\ExamResults\ResultCheck;
use Livewire\Volt\Volt;
use Tests\TestCase;

use function PHPUnit\Framework\assertCount;

class ExamResultsTest extends TestCase
{
    public function test_myresults_screen_can_be_rendered_to_registered_user_with_existing_exam_results(): void
    {

        $user = $this->createRegisteredUserWithExistingExamResults(
            surname: 'myresultssurname',
            names: 'myresults firstname',
        );
        $response = $this->actingAs($user)->get('/myresults');

        $response->assertOk();

    }

    public function test_user_on_cleared_student_list_can_see_results_for_cleared_intake()
    {
        $user = $this->createRegisteredUserWithExistingExamResults(
            surname: 'cleared surname',
            names: 'cleared firstname',
        );

        $intakeId = Result::where('users_id', $user->id)->pluck('intake_id')->first();
        $clearedList = ClearedStudent::factory()->create([
            'intake_id'=>$intakeId,
            'national_id_name' => $user->national_id.' '. $user->second_name. ' '.$user->first_name
        ]);

        $response = $this->actingAs($user)->get('/myresults');

        $response->assertOk()
                ->assertDontSee('Exam Results Suppressed!')
                ->assertViewHas('examResults', function ($results){
                    return count($results) > 0;
                })
                ->assertViewHas('leadingResults')
                ->assertViewHas('candidateNumber');
    }

    public function test_cleared_user_on_fees_list_can_view_exam_results(): void{
        $user = $this->createRegisteredUserWithExistingExamResults(
            surname: 'fees surname',
            names: 'fees firstname',
        );
        $intakeId = Result::where('users_id', $user->id)->pluck('intake_id')->first();
        $feesList = $user->fees()->where('intake_id',$intakeId)->update(['is_cleared'=>true]);

        $response = $this->actingAs($user)->get('/myresults');

        $response->assertOk()
                ->assertDontSee('Exam Results Suppressed!')
                ->assertViewHas('examResults', function ($results){
                    return count($results) > 0;
                })
                ->assertViewHas('leadingResults')
                ->assertViewHas('candidateNumber');
    }


    public function test_user_who_is_not_a_student_cannot_access_myresults_page():void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/myresults');

        $response->assertStatus(403);
    }

    public function test_unpaid_up_user_cannot_see_results_for_unpaid_intake()
    {
        $user = $this->createRegisteredUserWithExistingExamResults(
            surname: 'unpaid surname3',
            names: 'unpaid firstname3',
        );

        $response = $this->actingAs($user)->get('/myresults');
        $response->assertOk()
                ->assertSee('Exam Results Suppressed!')
                 ->assertViewHas('candidateNumber')
                 ->assertViewHas('examResults', function ($results){
                    return count($results)==0;
                 })
                ->assertViewHas('leadingResults');
    }

    public function test_Livewire_components_exists_on_myresults_page()
    {
        $user = $this->createRegisteredUserWithExistingExamResults(
            surname: 'livewire surname',
            names: 'components firstname',
        );
        $this->actingAs($user)->get('/myresults')
            ->assertSeeLivewire(ResultCheck::class)
            ->assertSeeVolt('examResults.suppressed');
    }

   public function test_student_user_will_search_and_find_correct_results_using_a_different_candidate_number()
    {
        $surname = 'different';
        $firstName = 'candidate number';
        $newCandidateNumber = 'new123';
        $user = $this->createRegisteredUserWithExistingExamResults(surname: $surname, names: $firstName);
        $newIntake = Intake::factory()->create();
        $differentCandidateNumberResults = Result::factory()->create([
            'candidate_number'=>$newCandidateNumber,
            'surname' =>$surname,
            'names' =>$firstName,
            'intake_id'=>$newIntake->id,
        ]);

        $response = $this->actingAs($user)->post('/checkMyresults',[
            'candidate_number'=>$newCandidateNumber,
            'exam_session'=>$newIntake->id,
        ]);

        $response->assertStatus(200);
        $response->assertSessionDoesntHaveErrors();
        $response->assertViewHas(['candidateNumber','leadingResults','examResults']);

    }

    public function test_user_can_view_search_results_of_a_paid_exam_session()
    {
        $surname = 'paid';
        $firstName = 'fees';
        $newCandidateNumber = 'paid';
        $user = $this->createRegisteredUserWithExistingExamResults(surname: $surname, names: $firstName);
        $newIntake = Intake::factory()->create();
        $intakeId = $newIntake->id;
        //$intakeId = Intake::pluck('id')->last();
        $differentCandidateNumberResults = Result::factory()->create([
            'candidate_number'=>$newCandidateNumber,
            'surname' =>$surname,
            'names' =>$firstName,
            'intake_id'=>$intakeId,
            'users_id' => NULL,
        ]);

        //  $feesList = $user->fees()->updateOrCreate(['user_id'=>$user->id,'intake_id'=>$intakeId],
        //  ['is_cleared'=>true, 'user_id'=>$user->id, 'intake_id'=>$intakeId, 'slug'=>uniqid()]);

        $clearedList = ClearedStudent::factory()->create([
            'intake_id'=>$intakeId,
            'national_id_name' => $user->national_id.' '. $user->second_name. ' '.$user->first_name
        ]);

        $response = $this->actingAs($user)->post('/checkMyresults',[
            'candidate_number'=>$newCandidateNumber,
            'exam_session'=>$intakeId
        ]);

        $response->assertStatus(200);
        $response->assertSessionDoesntHaveErrors();
        $response->assertViewHas(['candidateNumber','leadingResults']);
        $response->assertViewHas('examResults', fn($results) => count($results) > 0);
    }


    public function test_user_cannot_view_searched_results_of_an_unpaid_exam_session()
    {
        $surname = 'unpaid';
        $firstName = 'fees';
        $newCandidateNumber = 'unpaid';
        $user = $this->createRegisteredUserWithExistingExamResults(surname: $surname, names: $firstName);
        $newIntake = Intake::factory()->create();
        $differentCandidateNumberResults = Result::factory()->create([
            'candidate_number'=>$newCandidateNumber,
            'surname' =>$surname,
            'names' =>$firstName,
            'intake_id'=>$newIntake->id,
        ]);

        $response = $this->actingAs($user)->post('/checkMyresults',[
            'candidate_number'=>$newCandidateNumber,
            'exam_session'=>$newIntake->id,
        ]);

        $response->assertStatus(200);
        $response->assertSessionDoesntHaveErrors();
        $response->assertViewHas(['candidateNumber','leadingResults']);
        $response->assertViewHas('examResults', fn($results) => count($results) == 0);
    }

   public function test_an_empty_form_for_checking_exam_results_returns_validation_errors()
    {
        $user = $this->createRegisteredUserWithExistingExamResults();
        $intakeId = Result::where('users_id', $user->id)->pluck('intake_id')->first();

        $response = $this->actingAs($user)->post('/checkMyresults',[
            'candidate_number'=>'',
            'exam_session'=>$intakeId,
        ]);


        $response->assertStatus(302);
        $response->assertSessionHasErrors(['candidate_number']);
    }

    public function test_searching_non_existant_results_throws_non_existant_results_validation_error()
    {

        $user = $this->createRegisteredUserWithExistingExamResults();
        $intakeId = Result::where('users_id', $user->id)->pluck('intake_id')->first();

        $response = $this->actingAs($user)->post('/checkMyresults',[
            'candidate_number'=>'nonExist01',
            'exam_session'=>$intakeId,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['candidate_number']);
        $response->assertSessionDoesntHaveErrors(['exam_session']);
    }

    private function createRegisteredUserWithExistingExamResults(
        string $surname  ='myresults name',
        string $names = 'myresults surname',
    ): User
    {
        $surname;
        $names;
        $intake =Intake::factory()->create(['title'=>'myresults2024']);
        //create user
        $user= User::factory()->create([
            'second_name'=> $surname,
            'first_name' => $names,
        ]);
        $user->fees()->create(['intake_id'=>$intake->id,'cleared_at'=>null,'slug'=>uniqid()]);
        $user->students()->create(['user_id'=> $user->id]);

        //create exam results
        $examResult = Result::factory()->count(10)->create([
            'intake_id'=>$intake->id,
            'users_id' => $user->id,
            'surname' => $surname,
            'names' => $names,
        ]);

        return $user;
    }


}
