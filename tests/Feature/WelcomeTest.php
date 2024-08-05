<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WelcomeTest extends TestCase
{
    /**
     * testing welcome page
     */
    public function test_welcome_page_returns_a_success(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_top_menu_bar_availability(): void
    {
        $response = $this->get('/');

        $response->assertSee('Log in')
                ->assertSee('Register');
    }

    public function test_footer_menu_bar_availability(): void
    {
        $response = $this->get('/');

        $response->assertSee('Portal')
                ->assertSee('Harare Polytechnic');
    }

    public function test_copyright_message_is_correct_year():void
    {
        $response = $this->get('/');
        $response->assertSee('2024 IT Unit');
    }
}
