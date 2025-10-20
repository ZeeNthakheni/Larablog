<?php

namespace Tests\Feature\Admin;

use App\User;
use App\Post;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $admin;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = factory(User::class)->create(['is_admin' => true]);
        $this->user = factory(User::class)->create(['is_admin' => false]);
    }

    /** @test */
    public function admin_can_access_dashboard()
    {
        $response = $this->actingAs($this->admin)
                         ->get('/admin');

        $response->assertStatus(200);
        $response->assertViewIs('admin.dashboard');
    }

    /** @test */
    public function non_admin_cannot_access_dashboard()
    {
        $response = $this->actingAs($this->user)
                         ->get('/admin');

        $response->assertStatus(403);
    }

    /** @test */
    public function guest_cannot_access_dashboard()
    {
        $response = $this->get('/admin');

        $response->assertRedirect('/login');
    }

    /** @test */
    public function dashboard_displays_correct_statistics()
    {
        // Create some test data
        factory(User::class, 5)->create();
        factory(Post::class, 10)->create();

        $response = $this->actingAs($this->admin)
                         ->get('/admin');

        $response->assertStatus(200);
        $response->assertViewHas('stats');
        
        $stats = $response->viewData('stats');
        $this->assertEquals(6, $stats['users']); // 5 + 1 admin
        $this->assertEquals(10, $stats['posts']);
    }

    /** @test */
    public function dashboard_shows_recent_posts_and_users()
    {
        $posts = factory(Post::class, 3)->create();
        $users = factory(User::class, 3)->create();

        $response = $this->actingAs($this->admin)
                         ->get('/admin');

        $response->assertStatus(200);
        $response->assertViewHas(['recentPosts', 'recentUsers']);
        
        $this->assertCount(3, $response->viewData('recentPosts'));
        $this->assertCount(3, $response->viewData('recentUsers'));
    }
}