<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $users_count = User::count();
        $posts_count = Post::count();
        return view('admin.dashboard', compact('users_count', 'posts_count'));
    }
}