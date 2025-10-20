<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function guests_cannot_manage_users()
    {
        $this->get('/users')->assertRedirect('/login');
        $this->get('/users/create')->assertRedirect('/login');
    }

    #[Test]
    public function non_admin_users_cannot_manage_users()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->get('/users')->assertForbidden();
        $this->get('/users/create')->assertForbidden();
    }

    #[Test]
    public function admin_users_can_manage_users()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin);

        $this->get('/users')->assertOk();
        $this->get('/users/create')->assertOk();
    }

    #[Test]
    public function admin_can_create_a_user()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin);

        $this->post('/users', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    #[Test]
    public function admin_can_edit_a_user()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin);
        $user = User::factory()->create();

        $this->put('/users/' . $user->id, [
            'name' => 'Updated Name',
            'email' => $user->email,
        ]);

        $this->assertDatabaseHas('users', ['id' => $user->id, 'name' => 'Updated Name']);
    }

    #[Test]
    public function admin_can_delete_a_user()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin);
        $user = User::factory()->create();

        $this->delete('/users/' . $user->id);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
