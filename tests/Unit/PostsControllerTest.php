<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_guest_cannot_view_posts()
    {
        $response = $this->get(route('posts.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_an_authenticated_user_can_view_posts()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get(route('posts.index'));
        $response->assertStatus(200);
    }

    public function test_an_authenticated_user_can_create_a_post()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $post = Post::factory()->make();
        $response = $this->post(route('posts.store'), $post->toArray());
        $this->assertDatabaseHas('posts', [
            'title' => $post->title,
            'body' => $post->body,
        ]);
        $response->assertRedirect(route('posts.index'));
    }

    public function test_an_authenticated_user_can_edit_their_own_post()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $post = Post::factory()->create(['user_id' => $user->id]);
        $response = $this->get(route('posts.edit', $post));
        $response->assertStatus(200);
    }

    public function test_an_authenticated_user_cannot_edit_another_users_post()
    {
        $user = User::factory()->create();
        $anotherUser = User::factory()->create();
        $this->actingAs($user);
        $post = Post::factory()->create(['user_id' => $anotherUser->id]);
        $response = $this->get(route('posts.edit', $post));
        $response->assertStatus(403);
    }

    public function test_a_post_can_be_updated()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $post = Post::factory()->create(['user_id' => $user->id]);
        $updatedPost = [
            'title' => 'Updated Title',
            'body' => 'Updated Body'
        ];
        $response = $this->put(route('posts.update', $post), $updatedPost);
        $this->assertDatabaseHas('posts', $updatedPost);
        $response->assertRedirect(route('posts.index'));
    }

    public function test_an_authenticated_user_can_delete_their_own_post()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $post = Post::factory()->create(['user_id' => $user->id]);
        $response = $this->delete(route('posts.destroy', $post));
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
        $response->assertRedirect(route('posts.index'));
    }

    public function test_an_authenticated_user_cannot_delete_another_users_post()
    {
        $user = User::factory()->create();
        $anotherUser = User::factory()->create();
        $this->actingAs($user);
        $post = Post::factory()->create(['user_id' => $anotherUser->id]);
        $response = $this->delete(route('posts.destroy', $post));
        $this->assertDatabaseHas('posts', ['id' => $post->id]);
        $response->assertStatus(403);
    }
}