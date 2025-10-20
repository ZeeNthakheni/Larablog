<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Post;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@larablog.com',
            'password' => Hash::make('admin123'),
            'is_admin' => true,
        ]);

        // Create test user
        User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
        ]);

        echo "Admin user created: admin@larablog.com / admin123\n";
        echo "Test user created: john@example.com / password123\n";
    }
}