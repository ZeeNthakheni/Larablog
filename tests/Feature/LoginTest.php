<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function login_page_is_accessible()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Larablog');
        $response->assertSee('Admin Dashboard');
    }

    /** @test */
    public function admin_can_login()
    {
        $admin = factory(User::class)->create([
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'is_admin' => true
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@test.com',
            'password' => 'password'
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($admin);
    }

    /** @test */
    public function user_can_login()
    {
        $user = factory(User::class)->create([
            'email' => 'user@test.com',
            'password' => bcrypt('password'),
            'is_admin' => false
        ]);

        $response = $this->post('/login', [
            'email' => 'user@test.com',
            'password' => 'password'
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function login_fails_with_invalid_credentials()
    {
        $response = $this->post('/login', [
            'email' => 'invalid@test.com',
            'password' => 'wrongpassword'
        ]);

        $response->assertSessionHasErrors();
        $this->assertGuest();
    }

    /** @test */
    public function login_requires_email_and_password()
    {
        $response = $this->post('/login', []);

        $response->assertSessionHasErrors(['email', 'password']);
        $this->assertGuest();
    }
}