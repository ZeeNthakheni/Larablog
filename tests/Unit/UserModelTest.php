<?php

namespace Tests\Unit;

use App\User;
use App\Post;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_be_admin()
    {
        $admin = factory(User::class)->create(['is_admin' => true]);
        
        $this->assertTrue($admin->is_admin);
    }

    /** @test */
    public function user_can_be_regular_user()
    {
        $user = factory(User::class)->create(['is_admin' => false]);
        
        $this->assertFalse($user->is_admin);
    }

    /** @test */
    public function user_has_posts_relationship()
    {
        $user = factory(User::class)->create();
        $posts = factory(Post::class, 3)->create(['user_id' => $user->id]);

        $this->assertCount(3, $user->posts);
        $this->assertInstanceOf(Post::class, $user->posts->first());
    }

    /** @test */
    public function user_is_admin_defaults_to_false()
    {
        $user = factory(User::class)->create();
        
        $this->assertFalse($user->is_admin);
    }
}