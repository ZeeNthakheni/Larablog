<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create 10 users
        User::factory()->count(10)->create()->each(function ($user) {
            // Create 5 posts for each user
            $user->posts()->saveMany(Post::factory()->count(5)->make());
        });
    }
}