<?php

namespace Tests\Feature\User;

use App\Models\Department;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserCreationTest extends TestCase
{

    public function test_staff_user_creation_page_can_be_accessed_by_authorized_user()
    {
        $user = $this->createAuthorisedUser();

        Gate::define('create', function ($user) {
            return true; // Simulate authorization to create users
        });

        $roles = Role::factory()->count(3)->create();
        $departments = Department::factory()->count(2)->create();

        $response = $this->actingAs($user)
            ->get(route('staff-user-create'));

        $response->assertStatus(200)
            ->assertViewIs('users.create')
            ->assertViewHas(['roles','departments']);
    }

    public function test_a_staff_user_can_be_registered()
    {
        $user = $this->createAuthorisedUser();
        $role = Role::factory()->create();
        $department = Department::factory()->create();

        $userData = [
            'first_name' => fake()->name(),
            'last_name' => fake()->name(),
            'role' => "$role->id",
            'department' => "$department->id",
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post('/users/registration', $userData);

        $response->assertSessionHas('message', "User was successfully registered");
        $response->assertRedirect('/users/registration');

        $this->assertDatabaseHas('users', [
            'email' => $userData['email'],
        ]);

    }


    public function test_staff_user_creation_page_cannot_be_accessed_by_unauthorized_user()
    {
        $user = User::factory()->create();
        Gate::define('create', function ($user) {
            return false; // Simulate lack of authorization to create users
        });

        $response = $this->actingAs($user)
            ->get(route('staff-user-create'));

        $response->assertStatus(403); // Expecting a 403 Forbidden response
    }

    public function test_staff_user_registration_fails_with_validation_errors()
    {
        $user = $this->createAuthorisedUser();

        $response = $this->post('/users/registration', [
            'first_name' => '', // Empty first name to trigger validation error
            'last_name' => 'Doe',
            'role' => 'Role',
            'department' => 'Department',
            'email' => 'invalid_email', // Invalid email format to trigger validation error
            'password' => 'pass', // Short password to trigger validation error
            'password_confirmation' => 'pass',
        ]);

        $response->assertSessionHasErrors(['first_name', 'email', 'password'])
            ->assertRedirect(); // Expecting a redirect back to the registration form
    }

    private function createAuthorisedUser(): User
    {
        $user = User::factory()->create();
        $department = Department::factory()->create(['name'=>'IT Unit']);
        $role = Role::factory()->create(['name'=>'superadmin', 'label'=>'superadmin']);
        $user->staff()->create(['user_id'=>$user->id,'department_id'=>$department->id]);
        $user->roles()->sync($role->id);
        return $user;
    }

}
