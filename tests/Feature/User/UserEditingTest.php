<?php

namespace Tests\Feature\User;

use App\Models\Department;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Volt\Volt;
use Tests\TestCase;

class UserEditingTest extends TestCase
{
    public function test_staff_user_edit_page_displays_correct_data()
    {
        $loggedInUser = $this->createAuthorisedUser();
        $user = User::factory()->create();
        $roleA = Role::factory()->create(['name' => 'Role A']);
        $roleB = Role::factory()->create(['name' => 'Role B']);
        $departmentA = Department::factory()->create(['name' => 'Department A']);
        $departmentB = Department::factory()->create(['name' => 'Department B']);

        $response = $this->actingAs($loggedInUser)->get("/users/{$user->slug}/edit");

        $response->assertStatus(200)
            ->assertViewIs('users.create')
            ->assertViewHas('user', $user)
            ->assertViewHas('roles', function ($roles) use ($roleA, $roleB) {
                return $roles->contains($roleA) && $roles->contains($roleB);
            })
            ->assertViewHas('departments', function ($departments) use ($departmentA, $departmentB) {
                return $departments->contains($departmentA) && $departments->contains($departmentB);
            });
    }

    public function test_staff_user_can_be_updated_successfully()
    {
        $loggedInUser = $this->createAuthorisedUser();
        $user = User::factory()->create();
        $role = Role::factory()->create();
        $department = Department::factory()->create();
        $user->staff()->create(['user_id'=>$user->id,'department_id'=>$department->id]);

        $response = $this->actingAs($loggedInUser)->put("/users/{$user->slug}", [
            'first_name' => 'Updated First Name',
            'last_name' => 'Updated Last Name',
            'role' => "$role->id",
            'department' => "$department->id",
            'email' => 'updated_email08@myexample.com',
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ]);

        $response->assertRedirect('/users/registration')
            ->assertSessionHas('message', 'User was successfully updated');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'first_name' => 'Updated First Name',
            'second_name' => 'Updated Last Name',
            'email' => 'updated_email08@myexample.com',
        ]);

        $this->assertDatabaseHas('role_user', [
            'user_id' => $user->id,
            'role_id' => $role->id,
        ]);

        $this->assertDatabaseHas('staff', [
            'user_id' => $user->id,
            'department_id' => $department->id,
        ]);

    }

    public function test_suspend_user_component_can_toggle_user_suspension()
    {
        $user = User::factory()->create(['is_suspended' => false]); // Create a new user with suspension state as false

        $component = Volt::test('users.suspend-user',['slug' => $user->slug])
            ->assertSet('isSuspended', $user->is_suspended) // Assert that the isSuspended property is set correctly
            ->call('suspension') // Call the suspension method to toggle suspension state
            ->assertDispatched('user-suspension') // Assert that the 'user-suspension' event is emitted
            ->assertSet('isSuspended', !$user->is_suspended); // Assert that the isSuspended property is toggled correctly
    }

    public function test_unauthorised_cannot_view_the_staff_users_edit_page()
    {
        $unauthorisedUser = User::factory()->create();
        $user = User::factory()->create();

        $response = $this->actingAs($unauthorisedUser)->get("/users/{$user->slug}/edit");

        $response->assertStatus(403);

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
