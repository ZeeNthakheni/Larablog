<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Post;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class LargeDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        
        // Create 50 users
        $users = [];
        for ($i = 0; $i < 50; $i++) {
            $users[] = User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
                'is_admin' => false,
                'created_at' => $faker->dateTimeBetween('-2 years', 'now'),
                'updated_at' => now(),
            ]);
        }
        
        // Create 200 posts
        $allUsers = User::all();
        for ($i = 0; $i < 200; $i++) {
            Post::create([
                'title' => $faker->sentence(rand(4, 8)),
                'body' => $faker->paragraphs(rand(3, 8), true),
                'user_id' => $allUsers->random()->id,
                'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
                'updated_at' => now(),
            ]);
        }
        
        echo "Created 50 users and 200 posts for testing\n";
    }
}