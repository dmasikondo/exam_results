<?php

namespace Tests\Feature\User;

use App\Models\Department;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserListTest extends TestCase
{
    public function test_staff_user_index_page_displays_correct_data()
    {

    $user = $this->createAuthorisedUser();

    $response = $this->actingAs($user)->get('/users');

    $response->assertStatus(200)
        ->assertViewIs('users.index')
        ->assertSeeVolt('users.suspend-user')
        ->assertViewHas('roles')
        ->assertViewHas('users', fn($users)=>count($users)>0);  // Ensure default pagination limit

    }

    public function test_in_staff_users_you_can_search_users_by_role()
    {
        $loggedInUser = $this->createAuthorisedUser();
        $userWithRole = $this->createAuthorisedUser();


        $response = $this->actingAs($loggedInUser)->get('/users?role=' . $userWithRole->roles()->first()->name);

        $response->assertSee($userWithRole->roles()->first()->name); // Assert that the role name will be visible in the response
        $response->assertViewIs('users.index')
        ->assertSeeVolt('users.suspend-user')
        ->assertViewHas('roles')
        ->assertViewHas('users');
    }

    public function test_in_staff_users_you_can_search_users_by_first_name()
    {
        $loggedInUser = $this->createAuthorisedUser();
        $user = User::factory()->create();


        $response = $this->actingAs($loggedInUser)->get('/users?first_name=' . $user->first_name);

        $response->assertSee($user->first_name); // Assert that the user's name be visible in the response
        $response->assertViewIs('users.index')
        ->assertSeeVolt('users.suspend-user')
        ->assertViewHas('roles')
        ->assertViewHas('users');
    }

    public function test_in_staff_users_you_can_search_users_by_surname()
    {
        $loggedInUser = $this->createAuthorisedUser();
        $user = User::factory()->create();


        $response = $this->actingAs($loggedInUser)->get('/users?surname=' . $user->second_name);

        $response->assertSee($user->second_name); // Assert that the user's name be visible in the response
        $response->assertViewIs('users.index')
        ->assertSeeVolt('users.suspend-user')
        ->assertViewHas('roles')
        ->assertViewHas('users');
    }

    public function test_in_staff_users_you_can_search_users_by_email()
    {
        $loggedInUser = $this->createAuthorisedUser();
        $user = User::factory()->create();


        $response = $this->actingAs($loggedInUser)->get('/users?email=' . $user->email);

        $response->assertSee($user->email); // Assert that the user's name be visible in the response
        $response->assertViewIs('users.index')
        ->assertSeeVolt('users.suspend-user')
        ->assertViewHas('roles')
        ->assertViewHas('users');
    }


    public function test_unauthorised_cannot_view_the_staff_users_index_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/users');

        $response->assertStatus(403);

    }

    private function createAuthorisedUser(): User
    {
        $user = User::factory()->create();
        $role = Role::where('name','superadmin')->firstOrFail();
        $department = Department::where('name','IT Unit')->firstOrFail();
        $user->staff()->create(['user_id'=>$user->id,'department_id'=>$department->id]);
        $user->roles()->sync($role->id);
        return $user;
    }
}
