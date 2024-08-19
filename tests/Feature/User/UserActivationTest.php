<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserActivationTest extends TestCase
{
    public function test_user_activation_page__for_account_resetting_is_correctly_displayed()
    {
        $user = User::factory()->create();

        Gate::shouldReceive('authorize')->with('activate', User::class)->once(); // Mock the Gate authorization call

        $response = $this->actingAs($user)->get('/users/activate-account');

        $response->assertViewIs('users.activate')
            ->assertViewHas('token', $user->must_reset_password_token);
    }

    public function test_can_activate_user()
    {
        $user = User::factory()->create([
            'must_reset_password_token' => 'test_token',
            'must_reset' => 1,
        ]);

        $response = $this->actingAs($user)
            ->put('/users/activate-account', [
                'first_name' => $user->first_name,
                'second_name' => $user->second_name,
                'token' => 'test_token',
                'password' => 'password123',
                'password_confirmation' => 'password123',
            ]);

        $response->assertRedirect('/login');
        $response->assertSessionHas('message', "Your account was successfully activated. You can now login using your new password");
        $this->assertTrue(Hash::check('password123', $user->fresh()->password)); // Assert that the user's password be updated correctly
    }

    public function test_unauthorised_user_cannot_reset_password_that_is_activate_account()
    {
        $user = User::factory()->create([
            'must_reset_password_token' => 'test_token',
            'must_reset' => 0,
        ]);

        $response = $this->actingAs($user)
            ->put('/users/activate-account');

        $response->assertForbidden();
    }
}
