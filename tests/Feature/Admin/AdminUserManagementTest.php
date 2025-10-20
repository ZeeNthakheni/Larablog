<?php

namespace Tests\Feature\Admin;

use App\User;
use App\Post;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class AdminUserManagementTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = factory(User::class)->create(['is_admin' => true]);
    }

    /** @test */
    public function admin_can_view_users_list()
    {
        factory(User::class, 5)->create();

        $response = $this->actingAs($this->admin)
                         ->get('/admin/users');

        $response->assertStatus(200);
        $response->assertViewIs('admin.users.index');
        $response->assertViewHas('users');
    }

    /** @test */
    public function admin_can_view_user_details()
    {
        $user = factory(User::class)->create();
        factory(Post::class, 3)->create(['user_id' => $user->id]);

        $response = $this->actingAs($this->admin)
                         ->get("/admin/users/{$user->id}");

        $response->assertStatus(200);
        $response->assertViewIs('admin.users.show');
        $response->assertViewHas('user');
    }

    /** @test */
    public function admin_can_delete_user()
    {
        $user = factory(User::class)->create();
        factory(Post::class, 2)->create(['user_id' => $user->id]);

        $response = $this->actingAs($this->admin)
                         ->delete("/admin/users/{$user->id}");

        $response->assertRedirect('/admin/users');
        $response->assertSessionHas('success');
        
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
        $this->assertDatabaseMissing('posts', ['user_id' => $user->id]);
    }

    /** @test */
    public function admin_cannot_delete_themselves()
    {
        $response = $this->actingAs($this->admin)
                         ->delete("/admin/users/{$this->admin->id}");

        $response->assertRedirect();
        $response->assertSessionHas('error');
        
        $this->assertDatabaseHas('users', ['id' => $this->admin->id]);
    }

    /** @test */
    public function non_admin_cannot_access_user_management()
    {
        $user = factory(User::class)->create(['is_admin' => false]);

        $response = $this->actingAs($user)
                         ->get('/admin/users');

        $response->assertStatus(403);
    }
}