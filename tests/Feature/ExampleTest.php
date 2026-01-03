<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_root_redirects_to_login_for_guests(): void
    {
        $this->get('/')->assertRedirect('/login');
    }

    public function test_login_page_is_accessible(): void
    {
        $this->get('/login')
            ->assertOk()
            ->assertSee('Sign in');
    }
}
